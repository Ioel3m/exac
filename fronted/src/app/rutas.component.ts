import { Routes, RouterModule } from '@angular/router';
import { LoginComponent } from "./component/login/login.component";
import { DashAdminComponent } from "./dash-admin/dash-admin.component";
import { GuardService } from "./services/guard.service";


const routes: Routes = [



  // { path: 'inicio', redirectTo: 'mejores', pathMatch: 'full' },
  { path: '', component: LoginComponent, pathMatch: 'full' },
  { path: ' ', redirectTo: 'login' },
  { path: 'login', component: LoginComponent},
  { path: 'admin', component: DashAdminComponent, canActivate: [GuardService] },


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
