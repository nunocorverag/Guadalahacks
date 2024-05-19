import { Component, ViewChild, viewChild } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { RouterOutlet } from '@angular/router';

@Component({
  selector: 'app-root',
  standalone: true,
  imports: [RouterOutlet, FormsModule],
  templateUrl: './app.component.html',
  styleUrl: './app.component.scss'
})
export class AppComponent {
  @ViewChild("Reguisterform") Reguisterform:any;
  title = 'cookAIClient';
  reguister(){
    let name= this.Reguisterform.controls.name.value;
    let email= this.Reguisterform.controls.email.value;
    let password= this.Reguisterform.controls.password.value;
    let confirm= this.Reguisterform.controls.confirm.value;
    console.log("Sirvo")
  }
}
