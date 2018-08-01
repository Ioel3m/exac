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
    this.nombreUsuario = this._apiService.getStorage("datos", "nombres") +" "+ this._apiService.getStorage("datos","apellidos")
    // this.nombreUsuario = this._apiService.getCookie("datos", "nombres");
    // console.log("ok"+this._apiService.get("datos", "nombres"));
    // this.nombreUsuario = data['nombres'];  
    // this.nombreUsuario = data['nombres'] +" "+ data['apellidos'];  
    this.nombreUsuario =  this.nombreUsuario.toLocaleLowerCase();
  
  }

  cerrarSesion() {
    localStorage.clear();
    this._router.navigate(['./login'])
  }

}
