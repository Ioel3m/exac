import { Component, OnInit } from '@angular/core';
import { Router } from "@angular/router";
import { ApiService } from "../../../services/api.service";

@Component({
  selector: 'app-navbar',
  templateUrl: './navbar.component.html',
  styleUrls: ['./navbar.component.css']
})
export class NavbarComponent implements OnInit {
  
  nombreUsuario: string;
  
  constructor(private _apiService: ApiService, private _router: Router) { }

  ngOnInit() {
    let data = JSON.parse(localStorage.getItem("credenciales"));
    this.nombreUsuario = data['nombres'] +" "+ data['apellidos'];  
    this.nombreUsuario =  this.nombreUsuario.toLocaleLowerCase();
    console.log(this.nombreUsuario);
    // this.nombreUsuario = localStorage
  }

  cerrarSesion() {
    this._apiService.cleanStorage();
    this._router.navigate(['./login'])
  }

}
