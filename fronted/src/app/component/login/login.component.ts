import { Component, OnInit } from '@angular/core';
import { ApiService } from "../../services/api.service";
import * as $ from 'jquery';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styles: []
})
export class LoginComponent implements OnInit {

  constructor(private _apiService:ApiService) { 

  }

  ngOnInit() {
    $(document).ready(function () {
      $('#i-login').focus(function () {
          $('#s-login').addClass('i-seleccionado')
      })
      $('#i-pass').focus(function () {
          $('#s-pass').addClass('i-seleccionado')
      })
      $('#i-pass').focusout(function () {
          $('#s-pass').removeClass('i-seleccionado')
      })
      $('#i-login').focusout(function () {
          $('#s-login').removeClass('i-seleccionado')
      })
  
  
      $('#up-contacto').click(function () {
          $('#seccion-contacto').animate({ top: '0' }, 600, 'swing');
          $("#form-contact")[0].reset();
          $("#form-contacto").removeClass('d-none');
          $("#form-contacto").addClass('d-block');
          $(this).hide();
          $('#down-contacto').show();
      })
  
      $('#down-contacto').click(function () {
          $('#seccion-contacto').animate({ top: '90vh' }, 600, 'swing');
          $('#up-contacto').show();
          $('#down-contacto').hide();
      })
  
  
  
  
  })
   

  }

}
