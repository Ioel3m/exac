import { Component, OnInit } from '@angular/core';
import { ApiService } from "../../../../services/api.service";


@Component({
  selector: 'app-lista',
  templateUrl: './lista.component.html',
  styles: []
})

export class ListaComponent implements OnInit {
  
  cargando: boolean;
  paralelos = [];
  periodos = [];
  data = [];

  constructor(private _apiService: ApiService) { }
  vari = false;

  ngOnInit() {
    this.getParalelos();
    this.getPeriodos();
  }

  getParalelos() {
    let array = [];
    this.cargando = true;
    this._apiService.getParalelos().subscribe(res => {
      for (let key in res) {
        array = res[key];
      }
      for (let key in array) {
        this.paralelos.push(array[key]);
      }
      this.cargando = false;
    })
  }

  getPeriodos() {
    this.cargando = true;
    let array = [];
    this._apiService.getPeriodos().subscribe(res => {
      for (let key in res) {
        array = res[key];
      }
      for (let key in array) {
        this.periodos.push(array[key]);
     
      }
      this.cargando = false;
    })
  }



  setEstado(id, estado){
    console.log(id)
    console.log(estado)
    this._apiService.setEstado(id, estado).subscribe(res=>{
      console.log(res)
    },err=>{
      console.log(err)
    })
  }

  getEstudiantes(periodo, paralelo, condicion){
    this.data = [];
    this.cargando = true;
    this._apiService.getEstudiantes(periodo, paralelo, condicion).subscribe(res=>{
      for(let i in res){
        this.data.push((res[i]));
      }
      this.cargando = false;
    }, err=>{
      console.log(err);
    })
  }
}
