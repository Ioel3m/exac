import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders, HttpResponse, HttpErrorResponse } from "@angular/common/http";
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
  private interval;
  constructor(public http: HttpClient, private _router: Router) {
    this.logged = false;
    this.getNtoken();

  }



  getSesion(user: User) {
    return this.http.post(`${this.url}/auth`, user, httpOptions)
  }


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

  getLogged() {
    if (localStorage.getItem('token')) {
      return true;
    } else {
      return false;
    }
  }



  getToken() {
    return this.tokenAPI;
  }
  getNtoken() {
    setInterval(function () {
      this.checkToken();
    }, 400000)
  }

  setToken(token) {
    localStorage.setItem('token', token)
  }

  checkToken(id): boolean {
    if (localStorage.getItem('token')) {
      console.log(id);
      console.log("actual      " + localStorage.getItem('token'));

      this.http.get(`${this.url}/newtoken?token=${localStorage.getItem('token')}`, httpOptions).subscribe(data => {
        this.setToken(data['token']);
        console.log("nuevo     " + localStorage.getItem('token'));
        this.logged = true;
      }, () => {
        localStorage.removeItem('token');
        this.logged = false;
      })
    }
    return this.logged;
  }





  setNuevoEstudiante(estudiante) {
    return this.http.post(`${this.url}/student?token=${localStorage.getItem('token')}`, estudiante, httpOptions)

  }

  setEstado(idEstudiante: string, estado: string) {
    return this.http.put(`${this.url}/student/enable/${idEstudiante}?token=${localStorage.getItem('token')}`, { condicion: estado }, httpOptions)
  }

  getParalelos() {
    return this.http.get(`${this.url}/paralelo?token=${localStorage.getItem('token')}`, httpOptions)
  }

  getPeriodos() {
    return this.http.get(`${this.url}/periodo?token=${localStorage.getItem('token')}`, httpOptions)
  }


  getEstudiantes(periodo?: string, paralelo?: string, estado?: string) {
    let url: string = this.url + `/student/all?token=${localStorage.getItem('token')}`;

    if (periodo !== null && periodo !== undefined && periodo != "0")
      url = url + `&periodo=${periodo}`;

    if (paralelo !== null && paralelo !== undefined && paralelo != "0")
      url = url + `&paralelo=${paralelo}`;

    if (estado !== null && estado !== undefined && estado != "0")
      url = url + `&condicion=${estado}`;

    return this.http.get(url, httpOptions)
  }



  getEstudiante(id) {
    return this.http.get(`${this.url}/student/${id}?token=${localStorage.getItem('token')}`, httpOptions)
  }

  updateParaleloPeriodo(idEstudiante, cedula, nickname, idparalelo, idperiodo) {
    return this.http.put(`${this.url}/student/edit/${idEstudiante}?token=${localStorage.getItem('token')}`, { cedula, nickname, idparalelo, idperiodo, }, httpOptions)// this.http.
  }

}