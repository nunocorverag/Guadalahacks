import { Component } from '@angular/core';
import { CoursesService } from '../../services/courses.service';
import { Route, Router } from '@angular/router';
import { response } from 'express';
import { error } from 'console';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { QuestionsService } from '../../services/questions.service';


@Component({
  selector: 'app-study',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './study.component.html',
  styleUrl: './study.component.scss'
})
export class StudyComponent {
  ngOnInit() {
    //LLamar a chat GPT y obtener las preguntas
  }
  subtemas: any[][] = [];
}

