import { Component } from '@angular/core';
import { CoursesService } from '../../services/courses.service';
import { ActivatedRoute, Route, Router } from '@angular/router';
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

  course_id:any;
  subtemas: Array<any> = [];

  ngOnInit() {
    this.route.url.subscribe(urlSegments => {
      const lastSegment = urlSegments[urlSegments.length - 1].path;
      this.course_id = lastSegment;
    });  
    this.getSubTopics();
  }

  constructor(private corSrv:CoursesService, private route:ActivatedRoute){}

  getSubTopics(){
    this.corSrv.getSubTopics(this.course_id).subscribe({
      next:(response:any)=>{
        console.log(response)
        this.subtemas = response.subTopics;
        console.log(this.subtemas)
      },
      error:(err:any)=>{
        console.log(err.error)
      }
    })
  }
}

