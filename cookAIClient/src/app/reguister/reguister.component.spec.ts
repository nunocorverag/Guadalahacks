import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ReguisterComponent } from './reguister.component';

describe('ReguisterComponent', () => {
  let component: ReguisterComponent;
  let fixture: ComponentFixture<ReguisterComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [ReguisterComponent]
    })
    .compileComponents();
    
    fixture = TestBed.createComponent(ReguisterComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
