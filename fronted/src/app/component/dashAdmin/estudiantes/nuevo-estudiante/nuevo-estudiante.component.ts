import { Component, OnInit } from '@angular/core';

import { ApiService } from "../../../../services/api.service";
@Component({
  selector: 'app-nuevo-estudiante',
  templateUrl: './nuevo-estudiante.component.html',
  styleUrls: ['./nuevo-estudiante.component.css']
})
export class NuevoEstudianteComponent implements OnInit {

  constructor(private _apiService:ApiService) { }

  ngOnInit() {
    let n = {
      
    }


  }

  setNuevoEstudiante(ci, paralelo, i_periodo, f_periodo, estado){
    let user = {
      ci, paralelo, i_periodo, f_periodo, estado
    }
    this._apiService.setNuevoEstudiante(user);
  }

  form(form){
    console.log(form);
  }
}
