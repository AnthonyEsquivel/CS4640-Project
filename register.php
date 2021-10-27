<?php
//Authors: Anthony Esquivel and Tyler Clift
//Sources used: https://cs4640.cs.virginia.edu
//Location: https://cs4640.cs.virginia.edu/afe2xd/hw4/

/** DATABASE SETUP **/
//include('../database_connection.php');
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Extra Error Printing
//$mysqli = new mysqli($dbserver, $dbuser, $dbpass, $dbdatabase);
$mysqli = new mysqli("localhost", "root", "", "climbing_team"); // XAMPP Settings

$error_msg = "";


// Join the session or start a new one
session_start();

$experience_string = ""; // used to turn array into string for db storage
// Check if options are selected
if(isset($_POST["experience"])){
    foreach ($_POST["experience"] as $element)
        $experience_string .= $element . " ";
}

if(isset($_POST["name"])){

    $result = preg_match("/^[A-Za-z ]+$/",$_POST["name"]);
    if ($result !== 1) {
        echo("Your name may only contain letters");
    }
    else{

        // user was not found, create an account
        $insert = $mysqli->prepare("update user set name = ?, uid = ?, is_driver = ?, experience = ?, num_pads = ?, num_passengers = ?, has_gear = ? where email = ?;"); //add elements to database
        $insert->bind_param("ssssiiss", $_POST["name"], $_POST["uid"], $_POST["is_driver"], $experience_string, $_POST["num_pads"], $_POST["num_passengers"], $_POST["has_gear"], $_SESSION["email"]);
        if (!$insert->execute()) {
            $error_msg = "Error creating new user";
        } 

        // Save user information into the session to use later
        $_SESSION["name"] = $_POST["name"];
        $_SESSION["uid"] = $_POST["uid"];
        $_SESSION["is_driver"] = $_POST["is_driver"];
        $_SESSION["experience"] = $experience_string;
        $_SESSION["num_pads"] = $_POST["num_pads"];
        $_SESSION["num_passengers"] = $_POST["num_passengers"];
        $_SESSION["has_gear"] = $_POST["has_gear"];

        header("Location: trips.php");
        }
}
// $check = $mysqli->;
// if ($insert){
//     header("Location: trips.php");
//     exit();
// }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" href="styles/main.css">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="author" content="Anthony Esquivel wrote most of the content, Tyler Clift made minor changes">
        <meta name="description" content="Page for the UVA climbing team">
        <meta name="keywords" content="UVA virginia rock climbing team club">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">


        <title>The Virginia Climbing Team</title>
    </head>

    <body>

        <nav class="navbar navbar-expand-sm navbar-dark navbar-custom">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.html">Climbing Team at UVA</a>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item"><a class="nav-link" href="index.html">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="calendar.html">Calendar</a></li>
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="trips.php">Trips</a></li>
                        <li class="nav-item"><a class="nav-link" href="resources.html">Resources</a></li>
                        <li class="nav-item"><a class="nav-link" href="join.html">Join</a></li>
                    </ul>
                </div>
            </div>
        </nav> 

        <div class="container" style="margin-top: 15px;">
            <div class="row justify-content-center">
                <div class="col-4">
                    <?php
                        if (!empty($error_msg)) {
                            echo "<div class='alert alert-danger'>$error_msg</div>";
                        }
                    ?>
                    <form action="register.php" method="post">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="string" class="form-control" id="name" name="name"/>
                        </div>
                    
                        <div class="mb-3">
                            <label for="uid" class="form-label">UID</label>
                            <input type="int" class="form-control" id="uid" name="uid"/>
                        </div>
                        <div class="mb-3">
                            <label for="is_driver" class="form-label">Can you drive?</label>
                            <select type="boolean" class="form-control" id="is_driver" name="is_driver">
                                <option value="yes">yes</option>
                                <option value="no">no</option>
                            </select>
                        </div>
                        <div class="mb-3">
                        <label for ="experience">Please select all of the activities you have experience with</label>
                        <select multiple name="experience[]" class="form-control" id="experience" size = 6>
                            <option value="bouldering">Bouldering</option>
                            <option value="trclimbing">Top Rope Climbing</option>
                            <option value="trbelaying">Top Rope Belaying</option>
                            <option value="leadclimbing">Lead Climbing</option>
                            <option value="leadbelaying">Lead Belaying</option>
                            <option value="cleaning">Cleaning a Route</option>
                        </select>
                        </div>
                        <div class="mb-3">
                            <label for="num_pads" class="form-label">How many pads can you fit in your vehicle?</label>
                            <input type="int" class="form-control" id="num_pads" name="num_pads"/>
                        </div>
                        <div class="mb-3">
                            <label for="num_passengers" class="form-label">How many passengers can you fit?</label>
                            <input type="int" class="form-control" id="num_passengers" name="num_passengers"/>
                        </div>
                        <div class="mb-3">
                            <label for="has_gear" class="form-label">Do you have your own camping gear?</label>
                            <select type="boolean" class="form-control" id="has_gear" name="has_gear">
                                <option value="true">yes</option>
                                <option value="false">no</option>
                            </select>
                        </div>

                        <div class="text-center">                
                            <button type="submit" class="btn btn-primary">Create Account</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!--Footer-->
        <footer class="container foot row col-12">
            <small class=copyright>Copyright 2021 Anthony Esquivel and Tyler Clift. </small>
            <nav>
                <a href=index.html>Home</a>
                <a href=calendar.html>Calendar</a>
                <a href=trips.php>Trips</a>
                <a href=resources.html>Resources</a>
                <a href=join.html>Join</a>
            </nav>
        </footer>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ"
            crossorigin="anonymous"></script>
    </body>
</html>