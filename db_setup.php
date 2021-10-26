<?php
    
    /** SETUP **/
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $db = new mysqli("localhost", "root", "", "climbing_team"); // XAMPP Settings
    
    $db->query("drop table if exists user;");
    $db->query("create table user (
        id int not null auto_increment,
        email text not null,
        password text not null,
        name text,
        uid int,
        is_driver text,
        experience text,
        num_pads int,
        num_passengers int,
        has_gear text,
        primary key (id));");   
    

    $db->query("drop table if exists trips;");
    $db->query("create table trips (
        id int not null auto_increment,
        name text not null, 
        location text not null,
        type text not null,
        description text not null,
        dates text not null,
        primary key (id));");   

    $db->query("drop table if exists user_trips;");
    $db->query("create table user_trips (
        user_id int not null,
        trip_id int not null);");


    $stmt1 = $db->prepare("insert into trips (name, location, type, description, dates) values ('The New River Gorge trip','Fayettville, Wv','lead/toprope/boulder','Week longao giaghoahpgapudfhasdfh','9/10-9/13');");
    if (!$stmt1->execute()) {
        echo "Could not add trip";
    }

    $stmt2 = $db->prepare("insert into trips (name, location, type, description, dates) values ('Crimpers Comp (USAC)','Christiansburg, VA','boulder','come to the new with us!','9/10-9/13');");
    if (!$stmt2->execute()) {
        echo "Could not add trip";
    }
    
