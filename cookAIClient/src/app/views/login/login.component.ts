import { CommonModule } from '@angular/common';
import { Component, ViewChild } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { Router } from '@angular/router';  // Import Router service
import { UserService } from '../../services/user.service';
import { AccessService } from '../../services/access.service';

@Component({
  selector: 'app-login',
  standalone: true,
  imports: [FormsModule, CommonModule],
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss']  // Note: it's styleUrls, not styleUrl
})
export class LoginComponent {
  @ViewChild("loginForm") loginForm: any;

  constructor(
    private accSrv: AccessService,
    private usrSrv: UserService,
    private router: Router  // Inject Router service
  ) {}

    iniciarSesion() {
      if (this.loginForm.valid) {
        let email = this.loginForm.controls['email'].value;
        let pass = this.loginForm.controls['password'].value;

        this.usrSrv.validateCredentials(email, pass).subscribe({
          next:(response:any)=>{
            console.log('Login successful', response);
            this.setSession("token", response.token);
            this.router.navigate(['/courses']);  // Redirect to the desired route
          },
          error:(error:any)=>{
            
          }
        })
      } 
  }

  setSession(name: string, obj: any) {
    this.accSrv.setSesion(name, obj);
  }
}