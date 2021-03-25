<?php

// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to dashboard
if(isset($_SESSION["delegate_signed_in"]) && $_SESSION["delegate_signed_in"] === true){
    header("location: dashboard.php");
    exit;
}

// Include config file
require_once "../classes/Delegate.php";
require_once "../classes/Session.php";

// Define variables and initialize with empty values
$username = "";
$password = "";
$username_error = "";
$password_error = "";
$error = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {

    // Instatiate SponsorLogin object
    $delegateObj = new Delegate();
    
    // Set username
    $username = trim($_POST["username"]);
    $username_error = $delegateObj->setUsernameForSignIn($username);

    // Set password
    $password = trim($_POST["password"]);
    $password_error = $delegateObj->setPassword($password);

    if(empty($username_error) && empty($password_error)){
        if($delegateObj->signIn()) {
            $sessionObj = new Session();
            $sessionObj->setDelegateId($delegateObj->getDelegateId());
            if($sessionObj->addSession()) {
                // Start a new session
                if(session_status() !== PHP_SESSION_ACTIVE) session_start();

                // Set session variables
                $_SESSION["delegate_signed_in"] = true;
                $_SESSION["representation"] = $delegateObj->getRepresentation();
                $_SESSION["delegate_id"] = $delegateObj->getDelegateId();
                $_SESSION["committee_id"] = $delegateObj->getCommitteeId();

                $_SESSION["session_id"] = $sessionObj->getSessionId();
                // Redirect user to dashboard
                header("location: dashboard.php");
            }
        }
        else {
            $password_error = "The password you entered was not valid.";
            $error = $password_error;   
        }
    }
    else {
        $error = $username_error . "<br>" . $password_error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Delegate Sign in</title>
    
    <link rel="icon" href="../assets/images/icon.png">

    <!-- Bootstrap core CSS -->
    <!-- <link href="assets/bootstrap/bootstrap.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <!-- Custom styles for this template -->
    <link href="../assets/css/sign-in.css" rel="stylesheet">
</head>

<body class="text-center">
    <form class="form-signin" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" novalidate>
        <img class="mb-4" src="../assets/images/icon.png" alt="" width="72" height="72">
        
        <h1 class="h3 mb-3 font-weight-normal">Delegate Sign-in</h1>
        <label for="username" class="sr-only">Username</label>
        <input type="email" id="username" name="username" class="form-control" value="<?php echo $username; ?>" placeholder="Email address" required="" autofocus="">
        <div class="text-danger invalid-feedback"><?php echo $username_error; ?></div>
        <label for="password" class="sr-only">Password</label>
        <input type="password" id="password" name="password" class="form-control" placeholder="Password" required="">
        <div class="text-danger invalid-feedback"><?php echo $password_error; ?></div>
        <p class="text-danger"><?php echo $error; ?></p>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
        <p class="mt-5 mb-3 text-muted">&copy; Felix Chen 2021</p>
    </form>
</body>
</html>