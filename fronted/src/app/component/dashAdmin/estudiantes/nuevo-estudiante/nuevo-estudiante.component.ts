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
  cargando: boolean;
  tick: boolean;
  sucess: boolean;
  token;
  private notificacion: string;

  constructor(private _apiService: ApiService) {
    this.tick = false;
    this.sucess = false;
  }

  ngOnInit() {
    this.getParalelos();
    this.getPeriodos();
  }

  validarCI(ci) {
    return this._apiService.validarCI(ci);
  }

  setNuevoEstudiante(cedula, idparalelo, idperiodo, condicion, form) {
    let estudiante = {
      cedula, idparalelo, idperiodo, condicion
    }
    this.cargando = true;
    this._apiService.setNuevoEstudiante(estudiante).subscribe(res => {
      this.cargando = false;
      this.tick = true;

      setTimeout(() => {
        this.tick = false;
        form.reset();
      }, 3000)



    }, error => {
      console.log(error)
    })
  }



  getParalelos() {
    let array = [];
    this.sucess = true;
    this._apiService.getParalelos().subscribe(res => {

      for (let key in res) {
        array = res[key];
      }
      for (let key in array) {
        this.paralelos.push(array[key]);
      }
      this.sucess = false;
    })
  }

  getPeriodos() {
    this.sucess = true;
    let array = [];
    this._apiService.getPeriodos().subscribe(res => {

      for (let key in res) {
        array = res[key];
      }
      for (let key in array) {
        this.periodos.push(array[key]);
      }
      this.sucess = false;
    })
  }

}
