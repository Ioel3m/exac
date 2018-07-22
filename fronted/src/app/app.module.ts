import { BrowserModule } from '@angular/platform-browser';
import { FormsModule } from "@angular/forms";
import { NgModule } from '@angular/core';
import { HttpModule } from "@angular/http";
import { HttpClientModule } from "@angular/common/http";
import { CookieService } from "ngx-cookie-service";

import { AppComponent } from './app.component';
import { LoginComponent } from './component/login/login.component';
import { NavbarComponent } from './component/dashAdmin/navbar/navbar.component';

import { DashAdminComponent } from './component/dashAdmin/dash-admin.component';
import { EstudiantesComponent } from './component/dashAdmin/estudiantes/estudiantes.component';
import { NuevoEstudianteComponent } from './component/dashAdmin/estudiantes/nuevo-estudiante/nuevo-estudiante.component';


//RUTAS
import { RUTAS } from "./rutas.component";

//SERVICIOS
import { ApiService } from './services/api.service';
import { GuardService } from './services/guard.service';
import { ListaComponent } from './component/dashAdmin/estudiantes/lista/lista.component';
import { CapitalizarPipe } from './pipes/capitalizar.pipe';
import { LoadComponent } from './decorates/load/load.component';


@NgModule({
  declarations: [
    AppComponent,
    LoginComponent,
    DashAdminComponent,
    NavbarComponent,
    NuevoEstudianteComponent,
    EstudiantesComponent,
    ListaComponent,
    CapitalizarPipe,
    LoadComponent
  ],
  imports: [
    BrowserModule,
    HttpModule,
    HttpClientModule,
    RUTAS,
    FormsModule
  ],
  providers: [
    ApiService,
    GuardService,
    CookieService
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
