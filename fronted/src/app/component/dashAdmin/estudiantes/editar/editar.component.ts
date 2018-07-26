import { Component, OnInit } from '@angular/core';
import { ApiService } from "../../../../services/api.service";

@Component({
  selector: 'app-editar',
  templateUrl: './editar.component.html',
  styleUrls: ['./editar.component.css']
})
export class EditarComponent implements OnInit {

  cargando: boolean;
  paralelos = [];
  periodos = [];
  data = [];
  sucess: boolean;

  constructor(private _apiService: ApiService) {
    this.sucess = false;
  }
  ngOnInit() {
    this.getParalelos();
    this.getPeriodos();
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
