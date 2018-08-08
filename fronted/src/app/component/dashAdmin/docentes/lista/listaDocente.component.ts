import { Component, OnInit } from '@angular/core';
import { ApiService } from "../../../../services/api.service";

@Component({
  selector: 'app-lista-docente',
  templateUrl: './lista.component.html',
  styleUrls: ['./lista.component.css']
})
export class ListaDocenteComponent implements OnInit {

  constructor(private _apiService: ApiService) {
    
  }


  ngOnInit() {
  }

}
