import { Routes } from '@angular/router';
import { CoursesComponent } from './views/courses/courses.component';
import { ReguisterComponent } from './reguister/reguister.component';

export const routes: Routes = [
    { path: 'courses', component: CoursesComponent},
    {path: 'reguister', component: ReguisterComponent}
];
