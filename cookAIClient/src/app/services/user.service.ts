import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { AccessService } from './access.service'; 
import { Constantes } from '../classes/constantes';
import moment from 'moment';
import { CookieService } from 'ngx-cookie-service';

@Injectable({
  providedIn: 'root'
})

export class UserService {
  token:any="";

  constructor(private http: HttpClient, private authSrv: AccessService) { 
    if(this.authSrv.getSession()){
      this.token=JSON.parse(this.authSrv.getSession());
    }
  }

  validateCredentials(email: string, pass: string){

    let link: string=Constantes.CAKE+"api/login";
    let headers = new HttpHeaders({
      'Content-Type':'application/json'
    });
    const body = { 
      email:email, 
      pass:pass
    };

    return this.http.post<any>(link, body, {headers});
  }
}
