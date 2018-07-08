import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from "@angular/common/http";

export interface User {
  nickname: string;
  password: string
}

const httpOptions = {
  headers: new HttpHeaders({ 'Content-Type': 'application/json' })
};

@Injectable({
  providedIn: 'root'
})
export class ApiService {


  private url: string = "http://127.0.0.1:8000/api/auth/";


  constructor(public http: HttpClient) {}

  login(user: User) {
    return this.http.post<User>(this.url, user, httpOptions)
  }
}
