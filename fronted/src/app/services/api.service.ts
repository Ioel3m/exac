import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders, HttpResponse, HttpErrorResponse } from "@angular/common/http";
import { CookieService, CookieOptions, CookieOptionsArgs } from "angular2-cookie/core";
import { Router } from "@angular/router";

//INTERFACES
import { User } from "../user.interface";
import { interval } from '../../../node_modules/rxjs';


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
    console.log("lanzado");
    // this.tokenAPI = (this.cookie.get('token')) ? this.cookie.get('token') :false;
    this.getNToken();
    // console.log("cre"+this.cookie.get("credenciales"));
  }


  // SESION
  getSesion(user: User) {
    return this.http.post(`${this.url}/auth`, user, httpOptions)
  }

  //COOKIES
  getCookie(idCookie: string, dato?: string) {
    if(!dato){
      return this.cookie.get('token');
    }else{
      let datos = JSON.parse(this.cookie.get(idCookie));
      return datos[dato] ? datos[dato] : false;
    }
  }

  setCookie(id: string, datos: Object) {
    this.cookie.put(id, JSON.stringify(datos));
  }

  clearCookies() {
    this.cookie.removeAll();
  }

  getLogged() {
    if (this.cookie.get('credenciales')) {
      return true;
    } else {
      return false;
    }
  }

  //TOKEN

  getToken() {
    return this.tokenAPI;
  }

  setToken(token) {
    this.cookie.put('token', token)
  }


  getNToken() {
    setInterval(() => {
      if (this.cookie.get('credenciales')) {
        let user: User = {
          nickname: this.getCookie('credenciales', 'nickname'),
          password: this.getCookie('credenciales', 'password')
        };

        this.getSesion(user).subscribe(data => {
          this.tokenAPI = data[0].token;
          this.cookie.put('token', data[0].token);
          console.log(this.cookie.get('token'));
        })
      }
    }, 600000)
  }



  //ADMIN > Estudiantes
  setNuevoEstudiante(estudiante) {
    return this.http.post(`${this.url}/student?token=${this.cookie.get('token')}`, estudiante, httpOptions)

  }

  setEstado(idEstudiante: string, estado: string) {
    return this.http.put(`${this.url}/student/enable/${idEstudiante}?token=${this.cookie.get('token')}`, { condicion: estado }, httpOptions)
  }

  getParalelos() {
    return this.http.get(`${this.url}/paralelo?token=${this.cookie.get('token')}`, httpOptions)
  }

  getPeriodos() {
    return this.http.get(`${this.url}/periodo?token=${this.cookie.get('token')}`, httpOptions)
  }

  getEstudiantes(periodo: string, paralelo: string, estado: boolean) {
    return this.http.get(`${this.url}/student/all?periodo=${periodo}&paralelo=${paralelo}&condicion=${estado}&token=${this.cookie.get('token')}`, httpOptions)
  }

  
  getEstudiante(id){
    return this.http.get(`${this.url}/student/${id}?token=${this.cookie.get('token')}`, httpOptions)
  }

  updateParaleloPeriodo(idEstudiante, cedula, idparalelo, idperiodo, nickname){
    return this.http.put(`${this.url}/student/edit/${idEstudiante}?token=${this.cookie.get('token')}`, { cedula, idparalelo, idperiodo, nickname }, httpOptions)// this.http.
  }







}