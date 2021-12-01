<?php
// REQUIRED HEADERS FOR CORS
// Allow access to our development server, localhost:4200
header("Access-Control-Allow-Origin: http://localhost:4200");
header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Authorization, Accept, Client-Security-Token, Accept-Encoding");
header("Access-Control-Max-Age: 1000");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT");

$request = file_get_contents("php://input");
$data = json_decode($request, true);

// Do processing of the data

$output = [
    "time" => date("Y-m-d g:i a"),
    "request" => $data
];

$drinks = [];

foreach ($data as $drink) {
    array_push($drinks, "{$drink["description"]} for {$drink["name"]}");
}

$output["drinks"] = $drinks;

// Send the result to the client (print it out)

header("Content-Type: application/json");
echo json_encode($output, JSON_PRETTY_PRINT);