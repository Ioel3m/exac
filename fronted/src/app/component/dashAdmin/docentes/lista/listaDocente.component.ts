import { Component, OnInit } from '@angular/core';
import { ApiService } from "../../../../services/api.service";


@Component({
  selector: 'app-lista-docente',
  templateUrl: './lista.component.html',
  styleUrls: ['./lista.component.css']
})

export class ListaDocenteComponent implements OnInit {

  periodos = [];
  sucess: boolean;
  data = [];
  resultados = [];
  private cargando;


  constructor(private _apiService: ApiService) {

  }


  ngOnInit() {
    this.getPeriodos();
    this.getDocentes();
  }


  getPeriodos() {
    this.periodos = [];
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

  getDocentes() {
    this.data = [];
    this.resultados = [];
    this.cargando = true;

    this._apiService.getDocentes().subscribe(res => {
      for (let i in res) {
        this.data.push((res[i]));
      }
      
      this.resultados = this.data;
      console.log(this.resultados);
      this.cargando = false;
    }, err => {
      console.log(err);
    })
  }

  filtro(criterio: string) {
    console.log(criterio);
    this.resultados = [];
    criterio = criterio.toLowerCase();
    this.cargando = true;
    for (let dato of this.data) {
      let cedula = dato.cedula.toLowerCase();
      let nombres = dato.nombres.toLowerCase();
      let apellidos = dato.apellidos.toLowerCase();
      if (cedula.indexOf(criterio) >= 0 || nombres.indexOf(criterio) >= 0 || apellidos.indexOf(criterio) >= 0) {
        console.log(dato);
        this.resultados.push(dato);
      }
    }
    this.cargando = false;
  }

}
