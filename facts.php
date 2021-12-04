<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Authorization, Accept, Client-Security-Token, Accept-Encoding");
header("Access-Control-Max-Age: 1000");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT");

$request = file_get_contents("php://input");
$data = json_decode($request, true);

//"time" => date("Y-m-d g:i a"), "request" => $data
$output = [
    "time" => date("Y-m-d g:i a")
];

$facts = [];

/*
foreach ($data as $fact) {
    array_push($facts["description"]);
}
*/

$output["facts"] = $data;


// Send the result to the client (print it out)

header("Content-Type: application/json");
echo json_encode($output, JSON_PRETTY_PRINT);