import { CommonModule } from '@angular/common';
import { Component, ViewChild} from '@angular/core';
import { FormsModule } from '@angular/forms';
import { RouterOutlet, RouterModule } from '@angular/router';

@Component({
  selector: 'app-reguister',
  standalone: true,
  imports: [RouterOutlet, FormsModule,RouterModule, CommonModule],
  templateUrl: './reguister.component.html',
  styleUrl: './reguister.component.scss'
})

export class ReguisterComponent {
  @ViewChild("Registerform") RF:any;
  title = 'Register Form';
  
  register(){
    if(this.RF.valid){
    console.log("asd")
    let name = this.RF.controls['name'].value;
    let email = this.RF.controls['email'].value;
    let password = this.RF.controls['password'].value;
    let confirm = this.RF.controls['confirm'].value;
    console.log(name, email, password, confirm);
    }
  }
}

