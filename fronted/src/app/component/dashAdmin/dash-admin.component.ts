import { Component, OnInit } from '@angular/core';
import { Router } from "@angular/router";
import { ApiService } from "../../services/api.service";
@Component({
  selector: 'app-dashAdmin',
  templateUrl: './dashAdmin.component.html',
  styles: []
})
export class DashAdminComponent implements OnInit {
  

  constructor(private _apiService: ApiService, private _router: Router) { }
  
  ngOnInit() {
  }

}
