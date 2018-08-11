import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from "@angular/common/http";
import { Router } from "@angular/router";
import { Observable, Subject } from 'rxjs';
import { ToastrManager } from 'ng6-toastr-notifications';
import { User } from "../user.interface";


const httpOptions = {
  headers: new HttpHeaders({ 'Content-Type': 'application/json' })
};

@Injectable({
  providedIn: 'root'
})

export class ApiService {

  private token$ = new Subject<string>();
  private rol$ = new Subject<string>();
  private url: string = "http://127.0.0.1:8000/api";
  private rol: string;
  private logged: boolean;

  constructor(public http: HttpClient, private notify: ToastrManager) {
    this.logged = true;
    this.rol = "";
  }


  //SESION
  getSesion(user: User) {
    return this.http.post(`${this.url}/auth`, user, httpOptions)
  }
  //--------------------------------------------------------------------


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


  //MANEJO DE TOKEN
  getNtoken() {
    setInterval(function () {
      this.checkToken();
    }, 400000)
  }

  setToken(token) {
    localStorage.setItem('token', token);
    this.token$.next(localStorage.getItem('token'));
  }

  getToken(): Observable<string> {
    return this.token$.asObservable();
  }


  check(token) {
    this.http.get(`${this.url}/validatetoken?token=${token}`, httpOptions).subscribe(token => {
      this.setRol(token['rol']);
      this.logged = true;
    }, () => {
      this.logged = false;
    })
    return this.logged;
  }
  //-----------------------------------------------------


  //ROL
  setRol(rol) {
    this.rol = rol;
    this.rol$.next(this.rol);
  }

  getObserverRol() {
    return this.rol$.asObservable();
  }

  getRol() {
    this.http.get(`${this.url}/validatetoken?token=${this.getStorage('token')}`, httpOptions).subscribe(token => {
      this.setRol(token['rol']);
    })

  }
  //---------------------------------------------


  //SET API
  setComentarios(nombres, telefono, correo, mensaje) {
    return this.http.post(`${this.url}/contact?token=${this.getStorage('token')}`, { nombres, telefono, correo, mensaje }, httpOptions)
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
  //----------------------------------------------------------------

  //GET API
  getParalelos(token?) {
    return this.http.get(`${this.url}/paralelo?token=${this.getStorage('token')}`, httpOptions)
  }

  getPeriodos(token?) {
    return this.http.get(`${this.url}/periodo?token=${this.getStorage('token')}`, httpOptions)
  }

  getEstudiantes(periodo?: string, paralelo?: string, estado?: string) {

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

  getDocentes() {
    return this.http.get(`${this.url}/teachers?token=${this.getStorage('token')}`, httpOptions)
  }

  getDocente(id) {
    return this.http.get(`${this.url}/teacher/${id}?token=${this.getStorage('token')}`, httpOptions)
  }

  getDominio() {
    return this.http.get(`${this.url}/dominio?token=${this.getStorage('token')}`, httpOptions)

  }

  getComentarios() {
    return this.http.get(`${this.url}/contact?token=${this.getStorage('token')}`, httpOptions)
  }
  //--------------------------------------------------------------------

  //UPDATE API

  updateEstudiante(idEstudiante, cedula, nickname, nombres, apellidos, estado_civil, email, telefono, fecha_nacimiento, direccion, idparalelo, idperiodo) {
    return this.http.put(`${this.url}/student/edit/${idEstudiante}?token=${this.getStorage('token')}`, {cedula, nickname, nombres, apellidos, estado_civil, email, telefono, fecha_nacimiento, direccion, idparalelo, idperiodo }, httpOptions)// this.http.
  }

  updateDocente(id, cedula, nickname, nombres, apellidos, email, telefono, direccion, fecha_nacimiento, estado_civil, idparalelo, idarea, idperiodo) {

    return this.http.put(`${this.url}/teacher/${id}?token=${this.getStorage('token')}`, { id, cedula, nickname, nombres, apellidos, email, telefono, direccion, fecha_nacimiento, estado_civil, idparalelo, idarea, idperiodo }, httpOptions)// this.http.
  }

  resetPassword(id) {
    return this.http.put(`${this.url}/teacher/reset/${id}?token=${this.getStorage('token')}`, {}, httpOptions)// this.http.
  }

  //---------------------------------------------------------------------------





  setNotification(tipo: boolean, mensaje: string, titulo: string, position = 'bottom-right') {
    switch (tipo) {
      case true:
        this.notify.successToastr(mensaje, titulo, { position: position });
        break;
      case false:
        this.notify.errorToastr(mensaje, titulo, { position: position })
        break;
    }
  }

  validarCI(cedula) {
    let total = 0;
    let longitud = cedula.length;
    let longcheck = longitud - 1;

    if (cedula !== "" && longitud === 10) {
      for (let i = 0; i < longcheck; i++) {
        if (i % 2 === 0) {
          var aux = cedula.charAt(i) * 2;
          if (aux > 9) aux -= 9;
          total += aux;
        } else {
          total += parseInt(cedula.charAt(i));
        }
      }

      total = total % 10 ? 10 - total % 10 : 0;

      if (cedula.charAt(longitud - 1) == total) {
        return true;
      } else {
        return false;
      }
    }
  }

  Capitalizar(value) {
    if (value) {
      return value.replace(/^([a-z\u00E0-\u00FC])|\s+([a-z\u00E0-\u00FC])/g, function ($1) {
        return $1.toUpperCase();
      })
    }
  }



}



