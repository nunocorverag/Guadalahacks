import { Component } from '@angular/core';
import { CoursesService } from '../../services/courses.service';
import { Route, Router } from '@angular/router';
import { response } from 'express';
import { error } from 'console';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { QuestionsService } from '../../services/questions.service';

@Component({
  selector: 'app-quiz',
  standalone: true,
  imports: [CommonModule, FormsModule],
  templateUrl: './quiz.component.html',
  styleUrl: './quiz.component.scss'
})
export class QuizComponent {
  ngOnInit() {
    //LLamar a chat GPT y obtener las preguntas
  }

  preguntas: string[] = ['Pregunta 1', 'Pregunta 2', 'Pregunta 3'];
  consultar: { [key: number]: string } = {};

  onSubmit() {
    console.log('Form submitted', this.consultar);
    QuizComponent
  }
}

 