import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders, HttpResponse, HttpErrorResponse } from "@angular/common/http";
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
  constructor(public http: HttpClient, private _router: Router) {
  }



  

  // SESION
  getSesion(user: User) {
    let err = false;
    return this.http.post(`${this.url}/auth`, user, httpOptions)
  }

  // STORAGE
  setLocalStorage(id: string, datos: Object) {
    localStorage.setItem(id, JSON.stringify(datos));
    // localStorage.setItem('data', datos['token']);
    this.tokenAPI = datos['token'];
    console.log("Token de acceso" + this.tokenAPI);
  }

  getLocalStorage(idStorage:string, dato:string){
    let credenciales =  JSON.parse(localStorage.getItem(idStorage));
    return credenciales[dato] ? credenciales[dato]: false;
  }


  getLogged() {
    if (localStorage.getItem('credenciales')) {
      return true;
    } else {
      return false;
    }
  }

  cleanStorage() {
    localStorage.clear();
  }

  getToken() {
    return this.tokenAPI;
  }


  //Admin > Estudiantes
  setNuevoEstudiante(estudiante) {
    // console.log(estudiante)
    // return this.http.post(`${this.url}/student?token=${localStorage.getItem("data")}`, estudiante, httpOptions)
    return this.http.post(`${this.url}/student?token=${this.getLocalStorage("credenciales","token")}`, estudiante, httpOptions)

  }

  setEstado(idEstudiante:string, estado:string){
    return this.http.put(`${this.url}/student/enable/${idEstudiante}?token=${this.getLocalStorage("credenciales","token")}`, {condicion: estado}, httpOptions)
  }

  getParalelos() {
    let err = false;
    console.log(localStorage.getItem('credenciales'));
    return this.http.get(`${this.url}/paralelo?token=${this.getLocalStorage("credenciales","token")}`, httpOptions)
    // return this.http.get(`${this.url}/paralelo?token=${localStorage.getItem('data')}`, httpOptions)
  }

  getPeriodos() {
    let err = false;
    // return this.http.post(`${this.url}/paralelo?token="${this.tokenAPI}"`, httpOptions)
    return this.http.get(`${this.url}/periodo?token=${this.getLocalStorage("credenciales","token")}`, httpOptions)
  }
  
  getEstudiantes(periodo:string, paralelo:string, estado:boolean) {
    let err = false;
    // console.log(`${this.url}/student/all?periodo=${periodo}&${paralelo}&token=${this.getLocalStorage("credenciales","token")}`);
    return this.http.get(`${this.url}/student/all?periodo=${periodo}&paralelo=${paralelo}&condicion=${estado}&token=${this.getLocalStorage("credenciales","token")}`, httpOptions)
  }







}