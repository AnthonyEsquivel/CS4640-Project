import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-catfacts',
  templateUrl: './catfacts.component.html',
  styleUrls: ['./catfacts.component.css']
})
export class CatfactsComponent implements OnInit {

  constructor() { }

  allFacts: string[] = []

  addFact(fact: string){
    this.allFacts.push(fact)
  }

  ngOnInit(): void {
  }

}
