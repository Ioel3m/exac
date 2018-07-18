import { Component, OnInit } from '@angular/core';

import { ApiService } from "../../../../services/api.service";
@Component({
  selector: 'app-nuevo-estudiante',
  templateUrl: './nuevo-estudiante.component.html',
  styleUrls: ['./nuevo-estudiante.component.css']
})
export class NuevoEstudianteComponent implements OnInit {


  paralelos = [];
  periodos = [];

  constructor(private _apiService: ApiService) { }

  ngOnInit() {
    this.getPeriodos();
    this.getParalelos();

  }

  setNuevoEstudiante(cedula, idparalelo, idperiodo, condicion) {
    let estudiante = {
      cedula, idparalelo, idperiodo, condicion
    }

    this._apiService.setNuevoEstudiante(estudiante).subscribe(res=>{

    },error=>{
      console.log(error)
    })
  }

  form(form) {
    console.log(form);
  }

  getParalelos() {
    let array = [];
    this._apiService.getParalelos().subscribe(res => {
      for (let key in res) {
        array = res[key];
      }
      for (let key in array) {
        this.paralelos.push(array[key]);
      }
    })
  }

  getPeriodos() {
    let array = [];
    this._apiService.getPeriodos().subscribe(res => {
      for (let key in res) {
        array = res[key];
      }
      for (let key in array) {
        this.periodos.push(array[key]);
      }
    })
  }
}
