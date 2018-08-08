import { Injectable } from '@angular/core';
import { Router, ActivatedRouteSnapshot, RouterStateSnapshot, CanActivate } from "@angular/router";
import { ApiService } from "./api.service";

@Injectable({
  providedIn: 'root'
})



export class GuardService implements CanActivate {

  constructor(private apiSerive: ApiService, private _router:Router) {
  }
  
  canActivate() {
    if (this.apiSerive.getLogged()) {
      return true;
    } else {
      this._router.navigate(['/login']);
      return false;
    }
  }
}
