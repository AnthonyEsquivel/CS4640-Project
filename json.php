<?php 
    include('database_connection.php');
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); 
    $mysqli = new mysqli($dbserver, $dbuser, $dbpass, $dbdatabase);

    $res = $mysqli->query("select * from trips");
    if ($res === false) {
        die("MySQL database failed");
    }
    $data = $res->fetch_all(MYSQLI_ASSOC);
    if (!isset($data[0])) {
        die("No trips in the database");
    }

    $fp = fopen('data.json', 'w');
    fwrite($fp, json_encode($data));
    fclose($fp);
    
    $json = json_encode($data, JSON_PRETTY_PRINT);

    header("Content-Type: application/json");
    echo($json);