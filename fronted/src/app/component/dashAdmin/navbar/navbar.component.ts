import { Component, OnInit } from '@angular/core';
import { Router } from "@angular/router";
import { ApiService } from "../../../services/api.service";

@Component({
  selector: 'app-navbar',
  templateUrl: './navbar.component.html',
  styleUrls: ['./navbar.component.css']
})
export class NavbarComponent implements OnInit {

  constructor(private _apiService:ApiService, private _router:Router) { }

  ngOnInit() {
  }

  cerrarSesion() {
    this._apiService.cleanStorage();
    this._router.navigate(['./login'])
  }

}
