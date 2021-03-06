<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="styles/main.css">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="author" content="Tyler Clift, Anthony Esquivel">
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
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="trips.html">Trips</a></li>
                    <li class="nav-item"><a class="nav-link" href="resources.html">Resources</a></li>
                    <li class="nav-item"><a class="nav-link" href="join.html">Join</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="card container col-12">
        <div class="card-body">
            <h2 class="card-title"></h2>
            <p class="card-text">
                Hi <?php echo htmlspecialchars($_POST['name']); ?>.
                Thank you for your response!
            </p>
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