import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { HttpModule } from "@angular/http";
import { HttpClientModule } from "@angular/common/http";

import { AppComponent } from './app.component';
import { LoginComponent } from './component/login/login.component';
import { DashAdminComponent } from './dash-admin/dash-admin.component';


//RUTAS
import { RUTAS } from "./rutas.component";

//SERVICIOS
import { ApiService } from './services/api.service';
import { GuardService } from './services/guard.service';

@NgModule({
  declarations: [
    AppComponent,
    LoginComponent,
    DashAdminComponent
  ],
  imports: [
    BrowserModule,
    HttpModule,
    HttpClientModule,
    RUTAS
  ],
  providers: [
    ApiService,
    GuardService
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
