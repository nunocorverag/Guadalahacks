import { Routes,RouterModule } from '@angular/router';
import { LoginComponent } from './views/login/login.component';
import { CoursesComponent } from './views/courses/courses.component';
import { ReguisterComponent } from './reguister/reguister.component';
import { QuizComponent } from './views/quiz/quiz.component';
import { TopicComponent } from './views/topic/topic.component';
import { StudyComponent } from './views/study/study.component';

export const routes: Routes = [
    {path: 'login', component: LoginComponent },
    {path: 'courses', component: CoursesComponent},
    {path: '', pathMatch: 'full', redirectTo: 'login'},
    {path: 'reguister', component: ReguisterComponent},
    {path: 'quiz', component: QuizComponent},
    {path: 'topic/:id', component: TopicComponent},
    {path: 'study/:id', component: StudyComponent}
];

