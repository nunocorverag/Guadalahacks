import { Component, ViewChild } from '@angular/core';
import { CoursesService } from '../../services/courses.service';
import { Route, Router, RouterLink, RouterOutlet } from '@angular/router';
import { FormsModule } from '@angular/forms';
import { response } from 'express';
import { error } from 'console';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-courses',
  standalone: true,
  imports: [CommonModule, FormsModule, RouterOutlet, RouterLink],
  templateUrl: './courses.component.html',
  styleUrl: './courses.component.scss'
})
export class CoursesComponent {
  @ViewChild("consultaForm") consultaForm: any;
  @ViewChild("closeQueryModal") closeQueryModal: any;

  constructor(
    private crsSrv:CoursesService,
    private router:Router
  ){}
  consultar: any;
  loading:boolean = false;

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
  realizarConsulta(){
    console.log("Realizar consulta")
    this.loading = true;
    if(this.consultaForm.valid){
      let consulta = this.consultaForm.controls.topic.value;
      this.crsSrv.realizarConsulta(consulta).subscribe({
        next:(response:any)=>{
          this.loading = false;
          this.closeQueryModal.nativeElement.click();
          console.log("Response: ", response)
          this.router.navigate(["topic",response.info.id]);
        },
        error:(err:any)=>{
          console.log(err.error)
          this.loading = false;
        }
      })
    }
  }
}

 