import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders, HttpResponse, HttpErrorResponse } from "@angular/common/http";
import { Router } from "@angular/router";
import { Observable, Subject, } from 'rxjs';
import { flatMap } from 'rxjs/operators';

//INTERFACES
import { User } from "../user.interface";


const httpOptions = {
  headers: new HttpHeaders({ 'Content-Type': 'application/json' })
};

@Injectable({
  providedIn: 'root'
})
export class ApiService {

  private token$ = new Subject<string>();
  private token;
  private url: string = "http://127.0.0.1:8000/api";
  private logged: boolean;
  private tokenAPI;
  private interval;
  private rol;

  constructor(public http: HttpClient, private _router: Router) {
    this.logged = true;
  }

  getSesion(user: User) {
    return this.http.post(`${this.url}/auth`, user, httpOptions)
  }

  //STORAGE

  getStorage(idStorage: string, dato?: string) {
    if (!dato) {
      return localStorage.getItem('token');
    } else {
      let datos = JSON.parse(localStorage.getItem(idStorage));
      return datos[dato] ? datos[dato] : false;
    }
  }

  setStorage(id: string, datos: Object) {
    localStorage.setItem(id, JSON.stringify(datos));
  }

  clearStorage() {
    localStorage.clear();
  }

  //---------------------------------------------------------

  getLogged() {
    if (!localStorage.getItem('token')) {
      return false;
    } else {
      if (localStorage.getItem('token')){
        return true;
      } else {
        return false;
      }
    }
  }


  getNtoken() {
    setInterval(function () {
      this.checkToken();
    }, 400000)
  }

  setToken(token) {
    localStorage.setItem('token', token);
    this.token = localStorage.getItem('token');
    this.token$.next(localStorage.getItem('token'));
  }

  getToken(): Observable<string> {
    return this.token$.asObservable();
  }


  check(token) {
    this.http.get(`${this.url}/validatetoken?token=${token}`, httpOptions).subscribe(token => {
      this.logged = true;
      this.rol = token['rol'];
    }, () => {
      this.logged = false;
    })
    return this.logged;
  }



  getRol() {
    return this.rol;
  }

  setNuevoEstudiante(estudiante) {
    return this.http.post(`${this.url}/student?token=${this.getStorage('token')}`, estudiante, httpOptions)
  }

  setNuevoDocente(docente) {
    return this.http.post(`${this.url}/teacher?token=${this.getStorage('token')}`, docente, httpOptions)
  }


  setEstado(idEstudiante: string, estado: string) {
    return this.http.put(`${this.url}/student/enable/${idEstudiante}?token=${this.getStorage('token')}`, { condicion: estado }, httpOptions)
  }


  getParalelos(token?) {
      return this.http.get(`${this.url}/paralelo?token=${this.getStorage('token')}`, httpOptions)
    }


  getPeriodos(token?) {
    return this.http.get(`${this.url}/periodo?token=${this.getStorage('token')}`, httpOptions)
  }


  getEstudiantes(periodo?: string, paralelo?: string, estado?: string) {
    // this.checkToken(this);

    let url: string = this.url + `/student/all?token=${this.getStorage('token')}`;

    if (periodo !== null && periodo !== undefined && periodo != "0")
      url = url + `&periodo=${periodo}`;

    if (paralelo !== null && paralelo !== undefined && paralelo != "0")
      url = url + `&paralelo=${paralelo}`;

    if (estado !== null && estado !== undefined && estado != "0")
      url = url + `&condicion=${estado}`;
    return this.http.get(url, httpOptions)


  }

  getEstudiante(id) {
    return this.http.get(`${this.url}/student/${id}?token=${this.getStorage('token')}`, httpOptions)
  }

  updateParaleloPeriodo(idEstudiante, cedula, nickname, idparalelo, idperiodo) {
    return this.http.put(`${this.url}/student/edit/${idEstudiante}?token=${this.getStorage('token')}`, { cedula, nickname, idparalelo, idperiodo, }, httpOptions)// this.http.
  }

}