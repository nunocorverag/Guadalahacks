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

   public obtenerPreguntas(): any {
    let link: string = Constantes.CAKE + "api/getMyTopics";
    let api_key:any = this.token;
    console.log(this.token)
    let headers = new HttpHeaders().set('Authorization', `Bearer ${api_key}`);
    return this.http.get(link, {headers});
   }

   public getOneTopic(id:any): any {
    let link: string = Constantes.CAKE + "api/getOneTopic/" + id;
    let api_key:any = this.token;
    console.log(this.token)
    let headers = new HttpHeaders().set('Authorization', `Bearer ${api_key}`);
    return this.http.get(link, {headers});
   }

   public getQuestionsTopic(id:any): any {
    let link: string = Constantes.CAKE + "api/getQuestionsTopic/" + id;
    let api_key:any = this.token;
    console.log(this.token)
    let headers = new HttpHeaders().set('Authorization', `Bearer ${api_key}`);
    return this.http.get(link, {headers});
   }

  public realizarConsulta(topic:string){
    let link: string=Constantes.CAKE+"api/sendTopic";
    let api_key:any = this.token;
    let headers = new HttpHeaders().set('Authorization', `Bearer ${api_key}`);
    let body = {
      topic: topic,
    }
    return this.http.post(link, body, {headers});
  }

  public evaluateQuestions(question_ids:any, respuestas:any, topic_id:any){
    let link: string=Constantes.CAKE+"api/evaluateQuestions";
    let api_key:any = this.token;
    let headers = new HttpHeaders().set('Authorization', `Bearer ${api_key}`);
    let body = {
      question_ids: question_ids,
      responses: respuestas,
      topic_id: topic_id
    }
    return this.http.post(link, body, {headers});
  }
}
