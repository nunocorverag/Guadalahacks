import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Constantes } from '../classes/constantes';
import moment from 'moment';
import { CookieService } from 'ngx-cookie-service';

@Injectable({
  providedIn: 'root'
})
export class AccessService {

  token:string = "";
  constructor(private http:HttpClient, private _cookieService:CookieService) {
    this.token=this.getSession();
  }
  public getSession():any {
    let data:string = this._cookieService.get("token");
    return data;
  }
  setSesion(key:string, data: any): any{
    let fecha:any = moment().add(1, 'days').format("YYYY-MM-DD HH:mm:ss");

    return this._cookieService.set(key, JSON.stringify(data));
  }
  removeSesion(){
    return this._cookieService.deleteAll();
  }
  public login(email:string, pass:string){
    let link: string=Constantes.CAKE+"api/login";
    let headers:any={};
    let body = {
      email: email,
      password: pass
    }
    return this.http.post(link, body, {headers});
  }
}
