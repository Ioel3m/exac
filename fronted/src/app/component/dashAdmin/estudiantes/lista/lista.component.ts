import { Component, OnInit } from '@angular/core';
import { ApiService } from "../../../../services/api.service";
// import { CookieService } from "ngx-cookie-service";


@Component({
  selector: 'app-lista',
  templateUrl: './lista.component.html',
  styleUrls: ['./lista.component.css']
})

export class ListaComponent implements OnInit {

  cargando: boolean;
  paralelos = [];
  periodos = [];
  data = [];
  sucess: boolean;
  resultados = [];
  token;

  constructor(private _apiService: ApiService) {
    this.sucess = false;
  }
  
  ngOnInit() {
      this.getParalelos();
      this.getPeriodos();
      this.getEstudiantes();

 
  }


  getParalelos() {
    console.log("ejecutado con"+this.token);
    
    let array = [];
    this.sucess = true;
    this._apiService.getParalelos().subscribe(res => {
      console.log("ejecutado con"+res);
      
      for (let key in res) {
        array = res[key];
      }
      for (let key in array) {
        console.log("ejecutado con"+key);
        this.paralelos.push(array[key]);
      }
      this.sucess = false;
    })
    
    console.log("ejecutado con"+this.paralelos);
  }

  getPeriodos() {
    console.log("ejecutado con"+this.token);

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



  setEstado(id, estado) {
    console.log(id)
    console.log(estado)
    this._apiService.setEstado(id, estado).subscribe(res => {
      console.log(res)
    }, err => {
      console.log(err)
    })
  }

  filtro(criterio: string) {
    console.log(criterio);
    this.resultados = [];
    criterio = criterio.toLowerCase();
    this.cargando = true;
    for (let dato of this.data) {
      let cedula = dato.cedula.toLowerCase();
      let nick = dato.nickname.toLowerCase();
      if (cedula.indexOf(criterio) >= 0 || nick.indexOf(criterio) >= 0) {
        console.log(dato);
        this.resultados.push(dato);
      }
    }
    this.cargando = false;
  }

  getEstudiantes(periodo?, paralelo?, condicion?) {
    console.log(paralelo);
    console.log(periodo);
    console.log(condicion);

    this.data = [];
    this.resultados = [];
    this.cargando = true;

    this._apiService.getEstudiantes(periodo, paralelo, condicion).subscribe(res => {
      console.log("RES" + res);

      for (let i in res) {
        this.data.push((res[i]));
      }
      this.resultados = this.data;
      this.cargando = false;
      console.log(this.data);
    }, err => {
      console.log(err);
    })

  }


}
