import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { FormsModule } from '@angular/forms';
import { FeedbackModule } from './feedback/feedback.module';
import { HttpClientModule } from '@angular/common/http';

import { AppComponent } from './app.component';
import { OrdersComponent } from './orders/orders.component';
import { NavbarComponent } from './navbar/navbar.component';

@NgModule({
  declarations: [
    AppComponent,
    OrdersComponent,
    NavbarComponent
  ],
  imports: [
    BrowserModule,
    FormsModule,
    FeedbackModule,
    HttpClientModule
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }