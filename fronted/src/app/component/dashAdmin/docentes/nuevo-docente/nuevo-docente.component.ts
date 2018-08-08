import { Component, OnInit } from '@angular/core';
import { ApiService } from "../../../../services/api.service";


@Component({
  selector: 'app-nuevo-docente',
  templateUrl: './nuevo-docente.component.html',
  styleUrls: ['./nuevo-docente.component.css']
})
export class NuevoDocenteComponent implements OnInit {
  cargando: boolean;
  paralelos = [];
  periodos = [];
  tick: boolean;
  sucess: boolean;

  constructor(private _apiService: ApiService) {
    this.tick = false;
    this.sucess = false;
  }

  ngOnInit() {
    this.getParalelos();
    this.getPeriodos();
  }

  setNuevoDocente(cedula, idparalelo, idperiodo, idarea, nombres, apellidos, telefono, direccion, email, fecha_nacimiento, form) {
    let docente = {
      cedula, idparalelo, idperiodo, idarea, nombres, apellidos, telefono, direccion, email, fecha_nacimiento
    }

    this.cargando = true;
    this._apiService.setNuevoDocente(docente).subscribe(res => {
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


