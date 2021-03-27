<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["delegate_signed_in"]) || $_SESSION["delegate_signed_in"] !== true){
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
    <!-- <link href="assets/bootstrap/bootstrap.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <link rel="icon" href="../assets/images/icon.png">

    
    <!-- Custom styles for this template -->
    <link href="../assets/css/dashboard.css" rel="stylesheet">

    <style>
    .delegate {
        border:none;
        background-color:transparent;
        outline:none;
        padding: 0px;
    }

    /* hover and active need to be more specific. Not just li, but specifically the cards on the right hand side */
    /* li:hover {
        background-color: #eee;
    } */

    /* li:active {
        background-color: white;
        color:black;
    } */

    </style>
</head>

<body class="bg-light">
    <header>
        <?php include "navbar.php"; ?>
    </header>
    
    <div class="container">
        <div class="pt-4 text-center">
            <!-- <img class="d-block mx-auto mb-4" src="../assets/images/icon.png" alt="" width="72" height="72"> -->
            <h2>Delegate Dashboard</h2>
            <p class="lead">Welcome, <?php echo $_SESSION["representation"]; ?></p>
        </div>

        <div class="row">
            <div class="col-md-4 order-md-2 mb-4">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span>Committee Delegates</span>
                    <span class="badge badge-secondary badge-pill" id="committeeDelegatesCount"></span> 
                    <!-- write a function to call the number of delegates, one time only -->
                    <!-- order the list of delegates by putting the active ones first -->
                    <!-- need to keep in mind to find a way to disable a button after they've clicked it, so server isn't spammed with multiple SELECT queries -->
                </h4>
                <ul class="list-group mb-3" id="committeeDelegates">
                  <p>No delegates present in committee.</p> 
                </ul>
            </div>

            <!-- maybe do @media stuff with CSS in order to make the text easily readable on xs screens. So set text-right -->
            <div class="col-md-8 order-md-1">
                <h4 class="mb-2">Messages</h4>
                <div class="card p-2" style="height:500px;">
                    <div class="card-header border bg-white text-black"><b>To: </b><strong id="otherDelegateRepresentation">Joe Biden</strong></div>
                    <div class="card-body overflow-auto" id="messagesArea">
                    </div>
                    <form class="card p-1 footer">
                        <div class="input-group">
                        <textarea type="text" id="compositionArea" class="form-control" placeholder="Message"></textarea>
                        <div class="input-group-append">
                            <button type="button" class="btn btn-primary send-message">Send!</button>
                        </div>
                        </div>
                    </form>
                    
                    
                </div>
            </div>
        </div>

        <footer class="my-5 pt-5 text-muted text-center text-small">
            <p class="mb-1">© 2021 Felix Chen</p>
            <ul class="list-inline">
            <li class="list-inline-item"><a href="#">Privacy</a></li>
            <li class="list-inline-item"><a href="#">Terms</a></li>
            <li class="list-inline-item"><a href="#">Support</a></li>
            </ul>
        </footer>
    </div>

    <!-- 
    <script src="../assets/js/jquery-3.3.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="/docs/4.6/assets/js/vendor/jquery.slim.min.js"><\/script>')</script><script src="./Checkout example · Bootstrap v4.6_files/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
    -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

    <!-- Custom JS for this page -->
    <!-- Define JS variables to hold PHP session variables -->
    <script type="text/javascript">
        var session_id   = <?php echo $_SESSION['session_id'];  ?>;
        var delegate_id  = <?php echo $_SESSION['delegate_id']; ?>;
        var committee_id = <?php echo $_SESSION['committee_id'];?>;
        var other_delegate_id = '';
    </script>

    <!-- Script for JQuery Functions -->
    <script src="../assets/js/dashboard.js"></script>

</body>
</html>