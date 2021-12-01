import { Component, OnInit } from '@angular/core';
import { Drink } from '../drink';
import { OrderService } from '../order.service';

@Component({
  selector: 'app-orders',
  templateUrl: './orders.component.html',
  styleUrls: ['./orders.component.css']
})
export class OrdersComponent implements OnInit {

  coffee: string;
  
  drink: Drink;
  
  sizes: Array<string> = ["small", "medium", "large"];
  temps: Array<string> = ["hot", "cold"];
  
  orders: Array<Drink> = [];
  
  placeMsg: string;

  constructor( private orderService: OrderService ) {
    this.coffee = "Peppermint Mocha";
    this.placeMsg = "";
    this.drink = new Drink("", "", "", "", "");
                            
  }
  
  placeOrder(): void {
    this.placeMsg = "Thank you, " + this.drink.name + ".";
    this.placeMsg += "You ordered a " + this.drink.description + ", size"
                        + this.drink.size + ".";
  }
  
  submitForm(data: any):void {
     let dr = new Drink(data.description, data.size, data.temp,
                        data.name, data.email);
     this.orders.push(dr);
  }
  
  response: any;
  orderTime: string = "";
  sendOrder(): void {
    this.orderService.processOrder(this.orders).subscribe(
        (respData) =>  { 
            this.response = respData; 
            this.orderTime = respData.time; 
            },
        (error) => { console.log("Error: ", error); }
    );
  }

  ngOnInit(): void {
  }
}