import { CommonModule } from '@angular/common';
import { Component, ViewChild} from '@angular/core';
import { FormsModule } from '@angular/forms';
import { UserService } from '../../services/user.service';
import { AccessService } from '../../services/access.service';

@Component({
  selector: 'app-login',
  standalone: true,
  imports: [FormsModule, CommonModule],
  templateUrl: './login.component.html',
  styleUrl: './login.component.scss'
})

export class LoginComponent {
  @ViewChild("loginForm") loginForm:any;

  constructor(private UserService: UserService, private accSrv:AccessService) {}

  Login(){
    if(this.loginForm.valid){
      let email=this.loginForm.controls['email'].value;
      let pass=this.loginForm.controls['password'].value;

      this.UserService.validateCredentials(email, pass).subscribe(
        response => {
          // Handle successful login
          console.log('Login successful', response);
          this.setSession("token", response.token)
          //this.router.navigate(['/dashboard']);  // Redirect to the dashboard or another route
        },
        error => {
          // Handle login error
          console.error('Login failed', error);
          //this.errorMessage = 'Invalid credentials. Please try again.';
        }
      );
    } else {
      //this.errorMessage = 'Please enter your email and password.';
    }
  }

  setSession(name:string, obj:any){
    this.accSrv.setSesion(name, obj);
  }
}
