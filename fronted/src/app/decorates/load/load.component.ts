import { Component, OnInit, Input } from '@angular/core';

@Component({
  selector: 'app-load',
  templateUrl: './load.component.html'
})

export class LoadComponent implements OnInit {
  @Input('estado') estado:boolean;

  constructor() { }

  ngOnInit() {
  }

}
