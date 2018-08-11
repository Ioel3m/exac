import { Injectable } from '@angular/core';
import { Resolve, ActivatedRouteSnapshot, RouterStateSnapshot } from "@angular/router";
import { Observable } from '../../../node_modules/rxjs';
import { promise } from '../../../node_modules/protractor';
import {  ApiService} from "./api.service";

@Injectable({
  providedIn: 'root'
})
export class ResolveService implements Resolve<any>{

  constructor(private _Apiservice:ApiService) { }

  resolve(route: ActivatedRouteSnapshot,state: RouterStateSnapshot):Observable<any>{
    return this._Apiservice.getObserverRol();
  }
}
