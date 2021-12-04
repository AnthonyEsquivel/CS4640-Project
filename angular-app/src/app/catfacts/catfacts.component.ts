import { Component, OnInit } from '@angular/core';
import { HttpClient, HttpErrorResponse, HttpParams } from '@angular/common/http';
import { Catfact } from '../catfact';

@Component({
  selector: 'app-catfacts',
  templateUrl: './catfacts.component.html',
  styleUrls: ['./catfacts.component.css']
})
export class CatfactsComponent implements OnInit {

  constructor(private http:HttpClient) { }

  allFacts: string[] = []

  facts: Array<Catfact> = [];


  addFact(fact: string){
    this.allFacts.push(fact);
    let cf = new Catfact(fact);
    this.facts.push(cf);
  }

  response: any;
  sendOrder(): void {
    let json:string = JSON.stringify(this.facts)
    this.http.post("http://localhost/CS4640-project/facts.php", json).subscribe(
        (respData) =>  { this.response = respData; },
        (error) => { console.log("Error: ", error); }
    );
  }

  ngOnInit(): void {
  }

}
