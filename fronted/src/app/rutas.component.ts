import { Routes, RouterModule } from '@angular/router';
import { LoginComponent } from "./component/login/login.component";

//DASHADMIN
import { DashAdminComponent } from "./component/dashAdmin/dash-admin.component";
import { NuevoEstudianteComponent } from "./component/dashAdmin/estudiantes/nuevo-estudiante/nuevo-estudiante.component";
import { EstudiantesComponent } from "./component/dashAdmin/estudiantes/estudiantes.component";
import { ListaComponent } from "./component/dashAdmin/estudiantes/lista/lista.component";
import { EditarComponent } from "./component/dashAdmin/estudiantes/editar/editar.component";
import { DocentesComponent } from "./component/dashAdmin/docentes/docentes.component";
import { NuevoDocenteComponent } from "./component/dashAdmin/docentes/nuevo-docente/nuevo-docente.component";
import { ListaDocenteComponent } from "./component/dashAdmin/docentes/lista/listaDocente.component";

import { GuardService } from "./services/guard.service";


const routes: Routes = [

  { path: '', redirectTo: 'login', pathMatch: 'full' },
  { path: 'login', component: LoginComponent },
  {
    path: 'admin', component: DashAdminComponent, children: [
      {
        path: 'estudiantes', component: EstudiantesComponent, children: [
          { path: 'nuevo-estudiante', component: NuevoEstudianteComponent, canActivate: [GuardService] },
          { path: 'todos', component: ListaComponent, canActivate: [GuardService] },
          { path: 'editar/:id', component: EditarComponent, canActivate: [GuardService],  }
        ], canActivate: [GuardService]
      },
      { path: 'docentes', component: DocentesComponent, children:[
        { path: 'nuevo-docente', component: NuevoDocenteComponent, canActivate: [GuardService] },
        { path: 'lista-docente', component: ListaDocenteComponent, canActivate: [GuardService] },

      ], canActivate: [GuardService] }


    ], canActivate: [GuardService]
  },




  { path: '**', redirectTo: 'login' },
  // { path: '404', component: ErrorNotFoundComponent },
  // { path: 'errorResultados', component: ErrorResultadosComponent },

];


export const RUTAS = RouterModule.forRoot(routes, {useHash: true});
