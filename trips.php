<?php
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); 
    //$mysqli = new mysqli($dbserver, $dbuser, $dbpass, $dbdatabase);
    $mysqli = new mysqli("localhost", "root", "", "climbing_team"); 
    
    $user = null;
    
    session_start();
    
    if (!isset($_SESSION["email"])) {
        header("Location: login.php");
        exit();
    }

    $res = $mysqli->query("select * from trips");
    if ($res === false) {
        die("MySQL database failed");
    }
    $data = $res->fetch_all(MYSQLI_ASSOC);
    if (!isset($data[0])) {
        die("No trips in the database");
    }
    
    if (isset($_POST["userid"])) {
        echo($_POST["userid"]);
        //TODO: add to join table here
    }
    
    // set user information for the page
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

    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="styles/main.css">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="author" content="Tyler Clift wrote most of the content, Anthony Esquivel made minor changes">
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
            <a href="login.php" class="btn btn-danger">Log out</a>
            <?php foreach ($data as $trip) : ?>
                <div class="card-body">
                    <h3 class="card-title"><?= $trip['name'] ?></h3>
                    <h5>Location: <?= $trip['location'] ?></h5>
                    <h5>Dates: <?= $trip['dates'] ?></h5>
                    <p><?= $trip['description'] ?></p>
                    <form action="trips.php" method="post">
                        <input type="hidden" name="userid" value="<?=$user["id"]?>"/>
                        <button type="submit" class="btn btn-responsive">Sign Up</button>
                    </form>
                </div>
            <?php endforeach ?>

        </div>
    </div>

    
    <!--Footer-->
    <footer class="container foot row col-12">
        <small class=copyright>Copyright 2021 Anthony Esquivel and Tyler Clift. </small>
        <nav>
            <a href=index.html>Home</a>
            <a href=calendar.html>Calendar</a>
            <a href=trips.html>Trips</a>
            <a href=resources.html>Resources</a>
            <a href=join.html>Join</a>
        </nav>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ"
        crossorigin="anonymous"></script>
</body>

</html>