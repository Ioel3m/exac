import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { DashAdminComponent } from './dash-admin.component';

describe('DashAdminComponent', () => {
  let component: DashAdminComponent;
  let fixture: ComponentFixture<DashAdminComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ DashAdminComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(DashAdminComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
