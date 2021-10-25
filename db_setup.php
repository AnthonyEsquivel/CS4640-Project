<?php
    
    /** SETUP **/
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $db = new mysqli("localhost", "root", "", "climbing_team"); // XAMPP Settings
    
    $db->query("drop table if exists user;");
    $db->query("create table user (
        id int not null auto_increment,
        email text not null,
        name text not null,
        password text not null,
        uid int not null,
        is_driver boolean not null,
        experience text not null,
        num_pads int not null,
        num_passengers int not null,
        has_gear boolean not null,
        primary key (id));");   
    

    $db->query("drop table if exists trips;");
    $db->query("create table trips (
        id int not null auto_increment,
        name text not null, 
        location text not null,
        type text not null,
        description text not null,
        datestext not null,
        primary key (id));");   


    // $stmt1 = $db->prepare("insert into general_knowledge_question (question, answer, points) values (?,?,?);");
    // foreach($general_knowledge["results"] as $qn) {
    //     $stmt1->bind_param("ssi", $qn["question"], $qn["correct_answer"], $points);
    //     if (!$stmt1->execute()) {
    //         echo "Could not add question: {$qn["question"]}\n";
    //     }
    // }
