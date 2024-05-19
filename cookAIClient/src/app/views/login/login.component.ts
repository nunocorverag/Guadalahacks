import { CommonModule } from '@angular/common';
import { Component, ViewChild} from '@angular/core';
import { FormsModule } from '@angular/forms';

@Component({
  selector: 'app-login',
  standalone: true,
  imports: [FormsModule, CommonModule],
  templateUrl: './login.component.html',
  styleUrl: './login.component.scss'
})

export class LoginComponent {
  @ViewChild("loginForm") loginForm:any;

  Login(){
    if(this.loginForm.valid){
      let email=this.loginForm.controls['email'].value;
      let pass=this.loginForm.controls['password'].value;
      console.log(email);
      console.log(pass);
    }
  }
}
