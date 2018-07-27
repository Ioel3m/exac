import { Component, OnInit } from '@angular/core';
import { ApiService } from "../../../../services/api.service";
import { ActivatedRoute } from '@angular/router';

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
  param:number;
  defaultpa;
  defaultpe;

  constructor(private _apiService: ApiService, private activatedRouter: ActivatedRoute) {
    this.success = true;
    this.tick = false;
    this.cargando = false;
    this.data = {};    
  }
  ngOnInit() {
    this.getParams();
    this.getEstudiante();
    this.getParalelos();
    this.getPeriodos();

  }

  getParalelos() {
    let array = [];
    this.success = true;
    this._apiService.getParalelos().subscribe(res => {
      for (let key in res) {
        array = res[key];
      }
      for (let key in array) {
        if(this.data.idparalelo == array[key].id){
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
        if(this.data.idperiodo == array[key].id){
          this.defaultpe = array[key].fecha_inicio+" a "+array[key].fecha_fin;
        } 
        this.periodos.push(array[key]);

      }
      console.log(this.defaultpe);

      this.success = false;
    })
  }

  updateParaleloPeriodo(idparalelo, idperiodo, form) {
    console.log(form);
    this.cargando = true;
      this._apiService.updateParaleloPeriodo(this.param, idparalelo, idperiodo).subscribe(res => {
        console.log("actualizado");
        this.cargando = false;
        this.tick = true;
        setTimeout(() => {
          this.tick = false;
        }, 3000)
      })

}


getParams(){
  this.cargando = true;
  this.success = true;
  this.activatedRouter.params.subscribe(params => {
    this.cargando = false;
    this.success = false;
    this.param = params['id'];
  })
}
  
  getEstudiante(){
    this.data = {};
    this.cargando = true;
    this.success = true;
    this._apiService.getEstudiante(this.param).subscribe(res => {
      this.data = res;    
      this.success = false;
      this.cargando = false;
    })
    }

  }


