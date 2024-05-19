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
    private userService: UserService,
    private accSrv: AccessService,
    private router: Router  // Inject Router service
  ) {}

  Login() {
    if (this.loginForm.valid) {
      let email = this.loginForm.controls['email'].value;
      let pass = this.loginForm.controls['password'].value;

      this.userService.validateCredentials(email, pass).subscribe(
        response => {
          // Handle successful login
          console.log('Login successful', response);
          this.setSession("token", response.token);
          this.router.navigate(['/courses']);  // Redirect to the desired route
        },
        error => {
          // Handle login error
          console.error('Login failed', error);
          // this.errorMessage = 'Invalid credentials. Please try again.';
        }
      );
    } else {
      // this.errorMessage = 'Please enter your email and password.';
    }
  }

  setSession(name: string, obj: any) {
    this.accSrv.setSesion(name, obj);
  }
}