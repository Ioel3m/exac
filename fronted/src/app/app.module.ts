import { BrowserModule } from '@angular/platform-browser';
import { FormsModule } from "@angular/forms";
import { NgModule } from '@angular/core';
import { HttpModule } from "@angular/http";
import { HttpClientModule } from "@angular/common/http";

//NOTIFICACIONES
import {  ToastrModule} from "ng6-toastr-notifications";
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';

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
import { ResolveService } from './services/resolve.service';

import { ListaComponent } from './component/dashAdmin/estudiantes/lista/lista.component';
import { ListaDocenteComponent } from "./component/dashAdmin/docentes/lista/listaDocente.component";
import { CapitalizarPipe } from './pipes/capitalizar.pipe';
import { LoadComponent } from './decorates/load/load.component';
import { EditarComponent } from './component/dashAdmin/estudiantes/editar/editar.component';
import { DocentesComponent } from './component/dashAdmin/docentes/docentes.component';
import { NuevoDocenteComponent } from './component/dashAdmin/docentes/nuevo-docente/nuevo-docente.component';
import { ActualizarComponent } from './component/dashAdmin/docentes/actualizar/actualizar.component';
import { BuzonComponent } from './component/dashAdmin/buzon/buzon.component';
import { ErrorComponent } from './decorates/error/error.component';



@NgModule({
  declarations: [
    AppComponent,
    LoginComponent,
    DashAdminComponent,
    NavbarComponent,
    NuevoEstudianteComponent,
    EstudiantesComponent,
    ListaComponent,
    ListaDocenteComponent,
    CapitalizarPipe,
    LoadComponent,
    EditarComponent,
    DocentesComponent,
    NuevoDocenteComponent,
    ActualizarComponent,
    BuzonComponent,
    ErrorComponent,
  ],
  imports: [
    BrowserModule,
    HttpModule,
    HttpClientModule,
    RUTAS,
    FormsModule,
    ToastrModule.forRoot(),
    BrowserAnimationsModule

  ],
  providers: [
    ApiService,
    GuardService,
    ResolveService
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
