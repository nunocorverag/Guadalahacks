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
  constructor(private http: HttpClient, private authSrv: AccessService) { }
  
  validateCredentials(email: string, password: string) {
      return this.http.post<any>('/api/validate', { email, password });
  }
}
