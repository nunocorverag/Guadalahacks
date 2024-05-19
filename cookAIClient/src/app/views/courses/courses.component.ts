import { Component } from '@angular/core';
import { CoursesService } from '../../services/courses.service';
import { Route, Router } from '@angular/router';
import { FormsModule } from '@angular/forms';
import { response } from 'express';
import { error } from 'console';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-courses',
  standalone: true,
  imports: [CommonModule, FormsModule],
  templateUrl: './courses.component.html',
  styleUrl: './courses.component.scss'
})
export class CoursesComponent {


  constructor(
    private crsSrv:CoursesService,
    private router:Router
  ){}
  consultar: any;

  courses:Array<any> = []
  ngOnInit() {
    this.obtenerCursos();
  }
  obtenerCursos(){
    this.crsSrv.obtenerCursos().subscribe(
      {
        next: (response:any)=>{
          this.courses = response.courses
          console.log(response)
        },
        error: (error:any)=>{
          console.log(error);
        }
      }
    );
  }
}

 