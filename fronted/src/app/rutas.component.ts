import { Routes, RouterModule } from '@angular/router';
import { LoginComponent } from "./component/login/login.component";


//DASHADMIN
import { DashAdminComponent } from "./component/dashAdmin/dash-admin.component";
import { NuevoEstudianteComponent } from "./component/dashAdmin/estudiantes/nuevo-estudiante/nuevo-estudiante.component";
import { EstudiantesComponent } from "./component/dashAdmin/estudiantes/estudiantes.component";
import { ListaComponent } from "./component/dashAdmin/estudiantes/lista/lista.component";
import { EditarComponent } from "./component/dashAdmin/estudiantes/editar/editar.component";
import { ActualizarComponent } from "./component/dashAdmin/docentes/actualizar/actualizar.component";
import { DocentesComponent } from "./component/dashAdmin/docentes/docentes.component";
import { NuevoDocenteComponent } from "./component/dashAdmin/docentes/nuevo-docente/nuevo-docente.component";
import { ListaDocenteComponent } from "./component/dashAdmin/docentes/lista/listaDocente.component";
import { BuzonComponent } from "./component/dashAdmin/buzon/buzon.component";
//-------------------------------

import { GuardService } from "./services/guard.service";
import { ErrorComponent } from "./decorates/error/error.component";

const routes: Routes = [
  { path: '', redirectTo: 'login', pathMatch: 'full' },
  { path: 'login', component: LoginComponent },
  { path: 'error', component: ErrorComponent },
  {
    path: 'admin', component: DashAdminComponent, children: [
      {
        path: 'estudiantes', component: EstudiantesComponent, children: [
          { path: '', redirectTo: 'nuevo-estudiante', pathMatch: 'full', canActivate: [GuardService], data: { rol: "1" } },
          { path: 'nuevo-estudiante', component: NuevoEstudianteComponent, canActivate: [GuardService], data: { rol: "1" } },
          { path: 'todos', component: ListaComponent, canActivate: [GuardService], data: { rol: "1" } },
          { path: 'editar/:id', component: EditarComponent, canActivate: [GuardService], data: { rol: "1" } }
        ], canActivate: [GuardService], data: { rol: '1' }
      },
      {
        path: 'docentes', component: DocentesComponent, children: [
          { path: '', redirectTo: 'nuevo-docente', pathMatch: 'full', canActivate: [GuardService], data: { rol: "1" } },
          { path: 'nuevo-docente', component: NuevoDocenteComponent, canActivate: [GuardService], data: { rol: "1" } },
          { path: 'lista-docente', component: ListaDocenteComponent, canActivate: [GuardService], data: { rol: "1" } },
          { path: 'editar/:id', component: ActualizarComponent, canActivate: [GuardService], data: { rol: "1" } }
        ], canActivate: [GuardService], data: { rol: "1" }
      },
      { path: 'buzon', component: BuzonComponent, canActivate: [GuardService], data: { rol: "2" } },
    ], canActivate: [GuardService], data: { rol: "1" }
  },


  { path: '**', redirectTo: 'login' },
  // { path: '404', component: ErrorNotFoundComponent },
  // { path: 'errorResultados', component: ErrorResultadosComponent },
];


export const RUTAS = RouterModule.forRoot(routes, { useHash: true });


