import { Routes, RouterModule } from '@angular/router';
import { LoginComponent } from "./component/login/login.component";

//DASHADMIN
import { DashAdminComponent } from "./component/dashAdmin/dash-admin.component";
import { NuevoEstudianteComponent } from "../app/component/dashAdmin/estudiantes/nuevo-estudiante/nuevo-estudiante.component";
import { EstudiantesComponent } from "../app/component/dashAdmin/estudiantes/estudiantes.component";
import { ListaComponent } from "../app/component/dashAdmin/estudiantes/lista/lista.component";

import { GuardService } from "./services/guard.service";


const routes: Routes = [



  // { path: 'inicio', redirectTo: 'mejores', pathMatch: 'full' },
  { path: '', component: LoginComponent, pathMatch: 'full' },
  { path: ' ', redirectTo: 'login' },
  { path: 'login', component: LoginComponent},
  { path: 'admin', component: DashAdminComponent, children: [
    { path: 'estudiantes', component: EstudiantesComponent, children:[
      { path: 'nuevo-estudiante', component: NuevoEstudianteComponent, canActivate: [GuardService]},
      { path: 'todos', component: ListaComponent, canActivate: [GuardService]}
      
    ]},

  ],canActivate: [GuardService] },


  // { path: 'info/:id', component: InfoComponent, children: [
  //   { path: '', component: UbicacionComponent, pathMatch: 'full' },
  //   { path: 'precios', component: PreciosComponent},
  //   { path: 'puntuacion', component: PuntuacionComponent},
  //   { path: 'ubicacion', component: UbicacionComponent},
  //   { path: 'galeria', component: GaleriaComponent},

  //   { path: 'tempPuntaje', redirectTo: 'puntuacion' }
  // ]},

  // temp



  { path: '**', redirectTo: 'login' },
  // { path: '404', component: ErrorNotFoundComponent },
  // { path: 'errorResultados', component: ErrorResultadosComponent },

];


export const RUTAS = RouterModule.forRoot(routes);
