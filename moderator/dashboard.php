<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["moderator_signed_in"]) || $_SESSION["moderator_signed_in"] !== true){
    header("location: sign-in.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <title>Dashboard</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <link rel="icon" href="../assets/images/icon.png">
</head>

<body class="bg-light">
    <header>
        <?php include "navbar.php"; ?>
    </header>
    
    <div class="container">
        <div class="pt-4 text-center">
            <h2>Moderator Dashboard</h2>
            <p class="lead">Welcome, <?php echo $_SESSION["first_name"]; ?></p>
        </div>

        <hr>

        <div class="row">
            <div class="col-md-12 order-md-1">
                <h4 class="mb-2">Pending Messages</h4>
                <div id="messagesArea">
                </div>
            </div>
        </div>

        <footer class="my-5 pt-5 text-muted text-center text-small">
            <p class="mb-1">© 2021 Felix Chen</p>
            <!-- <ul class="list-inline">
            <li class="list-inline-item"><a href="#">Privacy</a></li>
            <li class="list-inline-item"><a href="#">Terms</a></li>
            <li class="list-inline-item"><a href="#">Support</a></li>
            </ul> -->
        </footer>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

    <!-- Custom JS for this page -->
    <!-- Define JS variables to hold PHP session variables -->
    <script type="text/javascript">
        var moderator_id = <?php echo $_SESSION['moderator_id']; ?>;
        var committee_id = <?php echo $_SESSION['committee_id'];?>;
    </script>

    <!-- Script for JQuery Functions -->
    <script src="../assets/js/moderator-dashboard.js"></script>
</body>
</html>