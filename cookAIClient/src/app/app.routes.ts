import { Routes,RouterModule } from '@angular/router';
import { LoginComponent } from './views/login/login.component';

export const routes: Routes = [
    { path: 'login', component: LoginComponent },
    { path: '', pathMatch: 'full', redirectTo: ''},
];

