import { Component, OnInit } from '@angular/core';
import { ApiService } from "../../services/api.service";
import { Router } from "@angular/router";
import * as $ from 'jquery';
import { map, catchError } from 'rxjs/operators'
import { Observable } from 'rxjs';
import { HttpClient, HttpHeaders, HttpResponse, HttpErrorResponse } from "@angular/common/http";

//INTERFACES
import { User } from "../../user.interface";

@Component({
    selector: 'app-login',
    templateUrl: './login.component.html',
    styles: []
})
export class LoginComponent implements OnInit {
    errorCre = false;

    constructor(private _apiService: ApiService, private _router: Router) {

    }

    ngOnInit() {
        this.efect();
        if (localStorage.getItem('credenciales')) {
            this._router.navigate(['./admin'])
        } else {
            console.log("falso");
        }
    }


    efect() {
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

    sesionStart(nickname, password) {
        
        let user: User = {
            nickname,
            password
        };

        this._apiService.getSesion(user).subscribe(data => {
            
            console.log(data)
            this.errorCre = false;

            let credenciales = {
                token: data[0].token,
                paralelo: data['user'].idparalelo,
                area: data['user'].idarea,
                id: data['user'].id,
                rol: data['user'].idrol,
                nombres: data['user'].nombres,
                apellidos: data['user'].apellidos,
                periodo: data['user'].idperiodo,
                cedula: data['user'].cedula
            }

            this._apiService.setLocalStorage('credenciales', credenciales);
            this._router.navigate(['./admin'])

        }, error => {
            this.errorCre = true;
            this._router.navigate(['./login'])
        })

    }





}




