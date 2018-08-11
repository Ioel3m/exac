import { Injectable } from '@angular/core';
import { Router, ActivatedRouteSnapshot, RouterStateSnapshot, CanActivate, CanLoad, ActivatedRoute } from "@angular/router";
import { ApiService } from "./api.service";
import { flatMap } from "rxjs/operators";

@Injectable({
  providedIn: 'root'
})



export class GuardService implements CanActivate {

  private logged: boolean;
  private rol: string;

  constructor(private apiSerive: ApiService, private _router: Router) {
    this.rol = "";
    this.logged = false;
  }
  
  
  canActivate(activate: ActivatedRouteSnapshot, router: RouterStateSnapshot) {

    let path = router.url;
    let data = activate.data['rol'];


    if (localStorage.getItem('token')) {
      if (!this.rol) {
        this.apiSerive.check(localStorage.getItem('token'))
      } else {
        if (this.rol == data) {
          this._router.navigate[(path)];
          return true;
        } else {
          this._router.navigate(['./error']);
          this.logged = false;
          return false;
        }
      }

      this.apiSerive.getObserverRol().subscribe(rol => {
        this.rol = rol;
        if (rol == data) {
          this._router.navigate([path]);
          this.logged = true;
        } else {
          this.logged = false;
        }
      })


      return this.logged;

    } else {
      localStorage.clear();
      this._router.navigate(['./login'])
    }
  }
}









