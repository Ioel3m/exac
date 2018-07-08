import { Injectable } from '@angular/core';
import { Jsonp, Http } from '@angular/http';
import { HttpClient, HttpHeaders, HttpParams } from "@angular/common/http";

import { map } from 'rxjs/operators/'

@Injectable({
  providedIn: 'root'
})
export class ApiService {


  private url: string = "http://localhost:8000/auth/";


  constructor(private _http:Http) {

   }


   getUsuarios(nickname, password) {
    let url = `${this.url}nickname=${nickname}&password=${password}`;
    let httpOptions = {
      headers: new HttpHeaders({
        'Content-Type':'application/x-www-form-urlencoded',

      })}

    return this._http.post(url, httpOptions).pipe(map(res => res.json()))
  }
}
