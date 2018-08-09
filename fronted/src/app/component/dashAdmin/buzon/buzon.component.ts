import { Component, OnInit } from '@angular/core';
import { ApiService } from "../../../services/api.service";

@Component({
  selector: 'app-buzon',
  templateUrl: './buzon.component.html',
  styleUrls: ['./buzon.component.css']
})
export class BuzonComponent implements OnInit {

  comentarios: any[];
  success;

  constructor(private _apiService: ApiService) {
    this.comentarios = [];
  }
  ngOnInit() {
    this.getComentarios();
    console.log(this.comentarios);
  }


  getComentarios() {
    let array = [];
    this.success = true;
    this._apiService.getComentarios().subscribe(res => {

      // for (let key in res) {
      //   array = res[key];
      // }
      console.log(array)

      for (let key in res) {
        this.comentarios.push(res[key]);
      }
      this.success = false;
    })
  }

}
