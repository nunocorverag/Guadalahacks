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
    // let api_key:any = this.token.token;
    let headers = new HttpHeaders().set('Authorization', `Bearer ${"eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJzdWIiOjIsImV4cCI6MTcxNjE2OTQ2N30.JIuaN6I80Atc71JfkNX4h1YEH_fdf0wScwRxMVGDF7elq9aG6NJaqy9affi93GzEqWf8ekRfxqBq8R6CNTvmH34XRtLP5WYr7VWO1oseQaQeK_wmeMge60-lv-K-jr0vtEm654rBEtw09aCZ2a51fks7o7bggcphx-bQ_seHYv4"}`);
    return this.http.get(link, {headers});
   }
}
