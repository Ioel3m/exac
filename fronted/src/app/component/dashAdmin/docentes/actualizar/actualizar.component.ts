import { Component, OnInit } from '@angular/core';
import { ApiService } from "../../../../services/api.service";
import { ActivatedRoute } from '@angular/router';



@Component({
  selector: 'app-actualizar',
  templateUrl: './actualizar.component.html',
  styleUrls: ['./actualizar.component.css']
})
export class ActualizarComponent implements OnInit {

  cargando: boolean;
  paralelos = [];
  periodos = [];
  area = [];
  data: any;
  success: boolean;
  tick: boolean;
  param: number;
  defaultpa;
  defaultpe;
  defaultRol: number;

  constructor(private _apiService: ApiService, private activatedRouter: ActivatedRoute) {
    this.defaultRol = 1;
  }

  ngOnInit() {
    this.getParams();
    this.getDocente();
    this.getParalelos();
    this.getPeriodos();
    this.getArea();
  }


  getParalelos() {
    let array = [];
    this.success = true;
    this._apiService.getParalelos().subscribe(res => {
      for (let key in res) {
        array = res[key];
      }
      for (let key in array) {
        if (this.data.idparalelo == array[key].id) {
          this.defaultpa = array[key].descripcion
        }
        console.log(array[key].id);
        this.paralelos.push(array[key]);
      }
      this.success = false;
    })
  }

  getPeriodos() {
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

  getParams() {
    this.cargando = true;
    this.success = true;
    this.activatedRouter.params.subscribe(params => {
      this.cargando = false;
      this.success = false;
      this.param = params['id'];
    })
  }


  getDocente() {
    this.data = {};
    this.cargando = true;
    this.success = true;
    this._apiService.getEstudiante(this.param).subscribe(res => {
      this.data = res;
      this.success = false;
      this.cargando = false;
    })
  }

  updateDocente(cedula, nick, nombres, apellidos, email, telefono, direccion, fecha_nacimiento, estado_civil, paralelo, area, periodo, form) {
    // console.log(form);
    console.log(this.param, cedula, nick, nombres, apellidos, estado_civil, email, telefono, fecha_nacimiento, direccion, paralelo, periodo);

    this.cargando = true;
    this._apiService.updateDocente(this.param, cedula, nick, this._apiService.Capitalizar(nombres), this._apiService.Capitalizar(apellidos), email.toLowerCase(), telefono, direccion.toLowerCase(), fecha_nacimiento, estado_civil.toLowerCase(), paralelo, area, periodo).subscribe(res => {
      this.cargando = false;
      this.tick = true;
      this._apiService.setNotification(true, "Docente actualizado correctamente", "Éxito")
      setTimeout(() => {
        form.reset();
        this.tick = false;
        this.getDocente();
        this.getParalelos();
        this.getPeriodos();
        this.getArea();
      }, 3000)
    })
  }

  datas(cedula, nombres, apellidos, email, telefono, direccion, fecha_nacimiento, estado_civil, paralelo, area, periodo) {
    console.log(cedula, nombres, apellidos, email, telefono, direccion, fecha_nacimiento, estado_civil, paralelo, area, periodo);
  }

  getArea() {
    this.success = true;
    let array = [];
    this._apiService.getDominio().subscribe(res => {
      console.log(res);
      for (let key in res) {
        array.push(res[key]);
      }

      for (let key in array) {
        this.area.push(array[key]);
      }

      this.success = false;
    })
  }

}
