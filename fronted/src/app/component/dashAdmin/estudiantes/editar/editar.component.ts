import { Component, OnInit } from '@angular/core';
import { ApiService } from "../../../../services/api.service";
import { ActivatedRoute } from '@angular/router';
import * as $ from 'jquery';



@Component({
  selector: 'app-editar',
  templateUrl: './editar.component.html',
  styleUrls: ['./editar.component.css']
})
export class EditarComponent implements OnInit {

  cargando: boolean;
  paralelos = [];
  periodos = [];
  data: any;
  success: boolean;
  tick: boolean;
  param: number;
  defaultpa: string;
  defaultpe: string;
  defaultEstadoCivil: string;

  constructor(private _apiService: ApiService, private activatedRouter: ActivatedRoute) {
    this.success = true;
    this.tick = false;
    this.cargando = false;
    this.defaultEstadoCivil = "";
    this.data = {};
  }
  ngOnInit() {
    this.getParams();
    this.getEstudiante();
    this.getParalelos();
    this.getPeriodos();
  }

  getParalelos() {
    this.paralelos = [];
    let array = [];
    this.success = true;
    this._apiService.getParalelos().subscribe(res => {
      console.log(res);
      for (let key in res) {
        array = res[key];
      }

      for (let key in array) {
        if (this.data.idparalelo == array[key].id) {
          this.defaultpa = array[key].descripcion
        }
        this.paralelos.push(array[key]);
      }
      this.success = false;
    })
  }

  getPeriodos() {
    this.periodos = [];
    this.success = true;
    let array = [];
    this._apiService.getPeriodos().subscribe(res => {
      for (let key in res) {
        array = res[key];
      }
      for (let key in array) {

        if (this.data.idperiodo == array[key].id) {
          this.defaultpe = array[key].fecha_inicio + " a " + array[key].fecha_fin;
        }
        this.periodos.push(array[key]);

      }
      this.success = false;
    })
  }

  updateParaleloPeriodo(idparalelo, idperiodo, cedula, nickname, nombres, apellidos, estado_civil, email, telefono, fecha_nacimiento, direccion, formulario) {
    // console.log(form);
    console.log("id" + this.param, "cedula" + cedula, "nick" + nickname, "nombres" + nombres, "apellidos" + apellidos, "estado_civil" + estado_civil, "email" + email, "telefono" + telefono, fecha_nacimiento, direccion, idparalelo, idperiodo);
    console.log(this.param, cedula, nickname, nombres, apellidos, estado_civil, email, telefono, fecha_nacimiento, direccion, idparalelo, idperiodo);
    this.cargando = true;
    this._apiService.updateEstudiante(this.param, cedula, nickname, nombres, apellidos, estado_civil, email, telefono, fecha_nacimiento, direccion, idparalelo, idperiodo).subscribe(res => {
      this.cargando = false;
      this.tick = true;
      this._apiService.setNotification(true, "Estudiante actualizado correctamente", "Éxito");
      setTimeout(() => {
        this.tick = false;
        formulario.reset();
        this.getEstudiante();
        this.getParalelos();
        this.getPeriodos();
      }, 3000)
    }, Error => {
      this._apiService.setNotification(false, "Error al intentar actualizar el estudiante", Error);
    })
  }


  getParams() {
    this.cargando = true;
    this.success = true;
    this.activatedRouter.params.subscribe(params => {
      this.cargando = false;
      this.success = false;
      this.param = params['id'];
    })
  }

  getEstudiante() {
    this.data = {};
    this.cargando = true;
    this.success = true;
    this._apiService.getEstudiante(this.param).subscribe(res => {
      console.log(res);
      this.data = res;
      this.defaultEstadoCivil = "";
      this.defaultEstadoCivil = this.data.estado_civil.toLowerCase();
      console.log(this.defaultEstadoCivil);
      this.success = false;
      this.cargando = false;
    })
  }

}


