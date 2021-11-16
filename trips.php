<?php
    include('database_connection.php');
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); 
    $mysqli = new mysqli($dbserver, $dbuser, $dbpass, $dbdatabase);
    //$mysqli = new mysqli("localhost", "root", "", "climbing_team"); 
    
    $user = null;
    $user_trips_array = [];
    
    session_start();
    
    //Checks if user is logged in
    if (!isset($_SESSION["email"])) {
        header("Location: login.php");
        exit();
    }

    // See if user is registered
    $stmt5 = $mysqli->prepare("select name from user where email = ?;");
    $stmt5->bind_param("s", $_SESSION["email"]);
    $stmt5->execute();      
    $name_res = $stmt5->get_result();      
    if ($name_res === false) {
        die("MySQL database failed");
    }
    $name_data = $name_res->fetch_all(MYSQLI_ASSOC);
    if ($name_data[0]["name"] == NULL) {
        header("Location: register.php");
    }

    $res = $mysqli->query("select * from trips");
    if ($res === false) {
        die("MySQL database failed");
    }
    $data = $res->fetch_all(MYSQLI_ASSOC);
    if (!isset($data[0])) {
        die("No trips in the database");
    }
    
    //Signs user up for trip
    if (isset($_GET["trip_id"])) {
        $stmt2 = $mysqli->prepare("insert into user_trips (user_id, trip_id) values (?,?);");
        $stmt2->bind_param("ii", $_GET["user_id"], $_GET["trip_id"]);
        if (!$stmt2->execute()) {
            echo "Could not add ids to user_trips";
        }
        add_trips_to_user();
        //array_push($user_trips_array, $_GET["trip_id"]);
    }

    //Removes user from trip
    if (isset($_GET["delete_trip_id"])) {
        $stmt3 = $mysqli->prepare("delete from user_trips where (user_id, trip_id) = (?,?);");
        $stmt3->bind_param("ii", $_GET["delete_user_id"], $_GET["delete_trip_id"]);
        if (!$stmt3->execute()) {
            echo "Could not delete from user_trips";
        }
        add_trips_to_user();
    }
    
    // Set user information for the page
    $stmt = $mysqli->prepare("select id from user where email = ?;");
    $stmt->bind_param("s", $_SESSION["email"]);
    $stmt->execute();      
    $id_res = $stmt->get_result();      
    if ($id_res === false) {
        die("MySQL database failed");
    }
    $id_data = $id_res->fetch_all(MYSQLI_ASSOC);
    if (!isset($id_data[0])) {
        die("No id found");
    }
    foreach ($id_data[0] as $val){
        $user = [
            "name" => $_SESSION["name"],
            "email" => $_SESSION["email"],
            "id" => $val
            ];
            
        break;
    }

    //Puts all the trips that a user is signed up for into an array
    function add_trips_to_user(){
        global $mysqli, $user_trips_array, $user;
        $user_trips_array = [];
        $stmt4 = $mysqli->prepare("select * from user_trips where user_id = ?;");
        $stmt4->bind_param("i", $user["id"]);
        $stmt4->execute();      
        $trip_res = $stmt4->get_result();      
        if ($trip_res === false) {
            die("MySQL database failed");
        }
        $trip_data = $trip_res->fetch_all(MYSQLI_ASSOC);
        if (isset($trip_data[0])) {
            foreach($trip_data as $user_trip){
                array_push($user_trips_array, $user_trip["trip_id"]);
            }
        }
    }

    add_trips_to_user();

    function convert_trips_to_JSON(){
        global $data;
        $json = json_encode($data, JSON_PRETTY_PRINT);
        return $json;
    }
    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="styles/main.css">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="author" content="Tyler Clift and Anthony Esquivel both contributed">
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

    <div class="card container col-12">
        <div class="card-body">
            <h2 class="card-title">Trip Signup</h2>
            <h5>Signed in as <?= $user["name"] ?> </h5>
            <a href="login.php" class="btn btn-danger">Log out</a>
            <?php foreach ($data as $trip): ?>
                <div class="card-body">
                    <h3 class="card-title"><?= $trip['name'] ?></h3>
                    <h5>Location: <?= $trip['location'] ?></h5>
                    <h5>Dates: <?= $trip['dates'] ?></h5>
                    <p><?= $trip['description'] ?></p>
                    <?php if (in_array($trip['id'], $user_trips_array)): ?>
                        <form action="trips.php" method="get">
                            <input type="hidden" name="delete_user_id" value="<?=$user["id"]?>"/>
                            <input type="hidden" name="delete_trip_id" value="<?=$trip["id"]?>"/>
                            <button type="submit" class="btn btn-responsive">Leave Trip</button>
                        </form>
                    <?php else: ?>
                        <form action="trips.php" method="get">
                            <input type="hidden" name="user_id" value="<?=$user["id"]?>"/>
                            <input type="hidden" name="trip_id" value="<?=$trip["id"]?>"/>
                            <button type="submit" class="btn btn-responsive">Sign Up</button>
                        </form>
                    <?php endif ?>
                </div>
            <?php endforeach ?>
            <a href="json.php" class="btn btn-primary">Print Trips as JSON</a>
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