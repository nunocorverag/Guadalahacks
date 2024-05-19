import { Component, ViewChild, viewChild } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { RouterModule,RouterOutlet } from '@angular/router';

@Component({
  selector: 'app-root',
  standalone: true,
  imports: [RouterOutlet, RouterModule, FormsModule],
  templateUrl: './app.component.html',
  styleUrl: './app.component.scss'
})
export class AppComponent {
  @ViewChild("Reguisterform") Reguisterform:any;
  title = 'cookAIClient';
  reguister(){
    console.log(this.Reguisterform)
    let name= this.Reguisterform.controls.name.value;
    let email= this.Reguisterform.controls.email.value;
    let password= this.Reguisterform.controls.password.value;
    let confirm= this.Reguisterform.controls.confirm.value;
    console.log("Sirvo")
  }
}
