import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { AccessService } from './access.service'; 


@Injectable({
  providedIn: 'root'
})
export class UserService {
  constructor(private http: HttpClient, private authSrv: AccessService) { }
  
  validateCredentials(email: string, password: string) {
      return this.http.post<any>('/api/validate', { email, password });
  }
}
