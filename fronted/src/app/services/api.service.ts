import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders, HttpResponse, HttpErrorResponse } from "@angular/common/http";
import { map, catchError } from 'rxjs/operators'
import { Router } from "@angular/router";


//INTERFACES
import { User } from "../user.interface";
import { observable, Observable } from 'rxjs';
import { ObserveOnSubscriber } from 'rxjs/internal/operators/observeOn';
import { HttpRequest } from 'selenium-webdriver/http';


const httpOptions = {
  headers: new HttpHeaders({ 'Content-Type': 'application/json' })
};

@Injectable({
  providedIn: 'root'
})
export class ApiService {

  url: string = "http://127.0.0.1:8000/api";
  logged: boolean;
  tokenAPI;

  constructor(public http: HttpClient, private _router:Router) { }


  getSesion(user: User) {
    let err = false;
    return this.http.post(`${this.url}/auth`, user, httpOptions)
  }

  setLocalStorage(id: string, datos: Object) {
    localStorage.setItem(id, JSON.stringify(datos))
  }

  getLogged() {
    if(localStorage.getItem('credenciales')){
      return true;
    }else{
      return false;
    }
  }



}