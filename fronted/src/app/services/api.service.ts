import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders, HttpResponse, HttpErrorResponse } from "@angular/common/http";
import { CookieService } from "ngx-cookie-service";

// import { map, catchError } from 'rxjs/operators'
import { Router } from "@angular/router";


//INTERFACES
import { User } from "../user.interface";
// import { observable, Observable } from 'rxjs';
// import { ObserveOnSubscriber } from 'rxjs/internal/operators/observeOn';
// import { HttpRequest } from 'selenium-webdriver/http';
// import { identifierModuleUrl } from '../../../node_modules/@angular/compiler';


const httpOptions = {
  headers: new HttpHeaders({ 'Content-Type': 'application/json' })
};

@Injectable({
  providedIn: 'root'
})
export class ApiService {

  url: string = "http://127.0.0.1:8000/api";
  logged: boolean;
  private tokenAPI;
  constructor(public http: HttpClient, private _router: Router, private cookie: CookieService) {
    this.tokenAPI = (this.cookie.get("datos")) ? this.getCookie('datos', 'token') : false;
    this.getNToken();
  }


  // SESION
  getSesion(user: User) {
    this.tokenAPI = this.getCookie("datos", "token");
    return this.http.post(`${this.url}/auth`, user, httpOptions)
  }

  //COOKIES
  getCookie(idCookie: string, dato: string) {
    let datos = JSON.parse(this.cookie.get(idCookie));
    return datos[dato] ? datos[dato] : false;
  }

  setCookie(id: string, datos: Object) {
    this.cookie.set(id, JSON.stringify(datos));
  }

  clearCookies() {
    this.cookie.deleteAll();
  }

  getLogged() {
    if (this.tokenAPI) {
      return true;
    } else {
      return false;
    }
  }

  //TOKEN

  getToken() {
    return this.tokenAPI;
  }

  getNToken() {
    if (this.cookie.get('credenciales')) {
      let user: User = {
        nickname: this.getCookie('credenciales', 'nickname'),
        password: this.getCookie('credenciales', 'password')
      };


      setInterval(() => {
        this.getSesion(user).subscribe(data => {
          this.tokenAPI = data[0].token;
        })
      }, 10000);
      // }, 600000);
    } else {
      return false;
    }

  }



  //ADMIN > Estudiantes
  setNuevoEstudiante(estudiante) {
    return this.http.post(`${this.url}/student?token=${this.tokenAPI}`, estudiante, httpOptions)

  }

  setEstado(idEstudiante: string, estado: string) {
    return this.http.put(`${this.url}/student/enable/${idEstudiante}?token=${this.tokenAPI}`, { condicion: estado }, httpOptions)
  }

  getParalelos() {
    return this.http.get(`${this.url}/paralelo?token=${this.tokenAPI}`, httpOptions)
  }

  getPeriodos() {
    let err = false;
    return this.http.get(`${this.url}/periodo?token=${this.tokenAPI}`, httpOptions)
  }

  getEstudiantes(periodo: string, paralelo: string, estado: boolean) {
    let err = false;
    return this.http.get(`${this.url}/student/all?periodo=${periodo}&paralelo=${paralelo}&condicion=${estado}&token=${this.tokenAPI}`, httpOptions)
  }







}