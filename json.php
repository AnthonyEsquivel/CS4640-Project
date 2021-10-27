<?php 
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); 
    //$mysqli = new mysqli($dbserver, $dbuser, $dbpass, $dbdatabase);
    $mysqli = new mysqli("localhost", "root", "", "climbing_team"); 

    $res = $mysqli->query("select * from trips");
    if ($res === false) {
        die("MySQL database failed");
    }
    $data = $res->fetch_all(MYSQLI_ASSOC);
    if (!isset($data[0])) {
        die("No trips in the database");
    }
    
    $json = json_encode($data, JSON_PRETTY_PRINT);

    header("Content-Type: application/json");
    echo($json);