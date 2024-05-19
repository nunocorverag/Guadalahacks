import { Injectable } from '@angular/core';
import { Constantes } from '../classes/constantes';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { AccessService } from './access.service';

@Injectable({
  providedIn: 'root'
})
export class CoursesService {
  token:any = "";

  constructor(private http : HttpClient, private authSrv: AccessService) {
  if(this.authSrv.getSession()){
    this.token=JSON.parse(this.authSrv.getSession());
  }
   }
   public obtenerCursos(): any {
    let link: string = Constantes.CAKE + "api/getMyTopics";
    let api_key:any = this.token;
    console.log(this.token)
    let headers = new HttpHeaders().set('Authorization', `Bearer ${api_key}`);
    return this.http.get(link, {headers});
   }
}
