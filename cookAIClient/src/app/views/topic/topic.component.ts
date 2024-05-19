import { Component, ViewChild } from '@angular/core';
import { CoursesService } from '../../services/courses.service';
import { ActivatedRoute } from '@angular/router';
import { FormsModule } from '@angular/forms';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-topic',
  standalone: true,
  imports: [FormsModule, CommonModule],
  templateUrl: './topic.component.html',
  styleUrl: './topic.component.scss'
})
export class TopicComponent {
  @ViewChild("answersForm") answersForm:any;
  loading:boolean = false;
  course:any;
  questions:Array<any> = [];
  respuestas:Array<any> = [];
  course_id:string = "-1";
  question_ids:Array<any> = [];
  constructor(private corSrv:CoursesService, private route:ActivatedRoute){

  }

  ngOnInit(){
    this.route.url.subscribe(urlSegments => {
      const lastSegment = urlSegments[urlSegments.length - 1].path;
      this.course_id = lastSegment;
      console.log('Last URL segment:', lastSegment);
      // Aquí puedes usar lastSegment como necesites
    });
    this.getOneTopic();
    this.getQuestionsTopic();
    
  }

  getOneTopic(){
    this.corSrv.getOneTopic(this.course_id).subscribe({
      next:(response:any)=>{
        console.log(response)
      },
      error:(err:any)=>{
        console.log(err.error)
      }
    })
  }

  getQuestionsTopic(){
    this.corSrv.getQuestionsTopic(this.course_id).subscribe({
      next:(response:any)=>{
        console.log(response)
        this.questions = response.questions;
      },
      error:(err:any)=>{
        console.log(err.error)
      }
    })
  }
  submitAnswers() {
    this.loading = true;
    this.respuestas = []; // Asegúrate de inicializar el array de respuestas
  
    for (let i = 0; i < this.questions.length; i++) {
      let element = document.getElementById('input' + i); // Cambia aquí para que coincida con el ID en el HTML
      if (element) {
        let value = (element as HTMLInputElement).value; // Cast a HTMLInputElement para acceder a la propiedad value
        // Muestra el valor del elemento en lugar del elemento mismo
        this.respuestas[i] = value; // Guarda el valor en el array de respuestas

        this.question_ids[i] = this.questions[i].id.toString();
      }
      let pregunta = this.questions[i];
      // Aquí puedes trabajar con cada pregunta, por ejemplo:
      // Envía la respuesta para cada pregunta o realiza alguna acción
    }
    this.corSrv.evaluateQuestions(this.question_ids, this.respuestas, this.course_id).subscribe({
      next:(response:any)=>{
        console.log(response);
        this.loading = false;
      },
      error:(err:any)=>{
        console.log(err.error)
        this.loading = false;
      }
    })
    console.log(this.respuestas);
  }


}
