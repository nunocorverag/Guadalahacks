import { Routes,RouterModule } from '@angular/router';
import { LoginComponent } from './views/login/login.component';
import { CoursesComponent } from './views/courses/courses.component';
import { ReguisterComponent } from './reguister/reguister.component';

export const routes: Routes = [
    { path: 'login', component: LoginComponent },
    { path: 'courses', component: CoursesComponent},
    { path: '', pathMatch: 'full', redirectTo: ''},
    {path: 'reguister', component: ReguisterComponent}
];

