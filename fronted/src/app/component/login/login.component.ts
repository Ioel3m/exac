import { Component, OnInit } from '@angular/core';
import { User, ApiService } from "../../services/api.service";
@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styles: []
})
export class LoginComponent implements OnInit {

  constructor(private _apiService:ApiService) {}

  ngOnInit() {
    let user: User= {
      nickname: '1201215621-DOC',
      password: '1201215621'
    };
    this._apiService.login(user).subscribe(res => {
        console.log(res)
    })
  }

}
