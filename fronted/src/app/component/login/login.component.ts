import { Component, OnInit } from '@angular/core';
import { ApiService } from "../../services/api.service";
@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styles: []
})
export class LoginComponent implements OnInit {

  constructor(private _apiService:ApiService) { 

  }

  ngOnInit() {
    this._apiService.getUsuarios('1204392032-EST', '1204392032').subscribe(res=>console.log(res.json()))
  }

}
