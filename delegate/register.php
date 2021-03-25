<?php

session_start();

if(isset($_SESSION["delegate_signed_in"]) && $_SESSION["delegate_signed_in"] === true){
    header("location: dashboard.php");
    exit;
}

require_once "../classes/Delegate.php";

$first_name = "";
$last_name = "";
$school = "";
$conference_id = 1;
$committee_id = ""; 
$representation = "";

$username = "";
$password = "";
$confirm_password = "";

$error = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $obj = new Delegate();

    // Set first_name
    $first_name = trim($_POST["first_name"]);
    $error .= $obj->setFirstName($first_name);

    // Set last_name
    $last_name = trim($_POST["last_name"]);
    $error .= $obj->setLastName($last_name);

    // Set school
    $school = trim($_POST["school"]);
    $error .= $obj->setSchool($school);

    // Set conference_id
    // $conference_id = trim($_POST["conference_id"]);
    // $error .= $obj->setConferenceId($conference_id);

    // Set committee_id
    $committee_id = trim($_POST["committee_id"]);
    $error .= $obj->setCommitteeId($committee_id);

    // Set representation
    $representation = trim($_POST["representation"]);
    $error .= $obj->setRepresentation($representation);

    // Set username
    $username = trim($_POST["username"]);
    $error .= $obj->setUsername($username);

    // Set password
    $password = trim($_POST["password"]);
    $error .= $obj->setPassword($password);

    // Set confirm_password
    $confirm_password = trim($_POST["confirm_password"]);
    $error .= $obj->setConfirmPassword($confirm_password);

    if(empty($error))
    {
        if($obj->addDelegate()) {
        header("location: sign-in.php");
        }
        else {
            echo "Something went wrong. Please try again later.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <title>Delegate Registration</title>

    <!-- Bootstrap core CSS -->
    <!-- <link href="assets/bootstrap/bootstrap.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    
    <link rel="icon" href="../assets/images/icon.png">
    
    <!-- Custom styles for this template -->
    <link href="../assets/css/register.css" rel="stylesheet">
</head>

<body class="bg-light">
    
    <div class="container">
        <div class="py-5 text-center">
            <img class="d-block mx-auto mb-4" src="../assets/images/icon.png" alt="" width="72" height="72">
            <h2>Delegate Registration</h2>
            <p class="lead">Fill out this form to create your <i><b>Dialogue</b></i> account.</p>
        </div>

        <p class="text-danger text-center"><?php echo $error; ?></p>

        <div class="row">
            <div class="col-md-12 d-flex justify-content-center order-md-1">
                <form class="needs-validation" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" novalidate="" oninput='confirm_password.setCustomValidity(confirm_password.value != password.value ? "Passwords do not match." : "")'>
                
                <h4 class="mb-3">Delegate details</h4>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="first_name">First name</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" placeholder="" value="" required="">
                            <div class="invalid-feedback">
                            Valid first name is required.
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="last_name">Last name</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" placeholder="" value="" required="">
                            <div class="invalid-feedback">
                            Valid last name is required.
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="school">School</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="school" name="school" placeholder="School" required="">
                            <div class="invalid-feedback" style="width: 100%;">
                            Your school is required.
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="conference_id">Conference</label>
                        <div class="input-group">
                            <input type="text" class="form-control" value="LakeMUN" id="conference_id" name="conference_id" readonly>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="committee_id">Committee</label>
                        <select class="custom-select d-block w-100" id="committee_id" name="committee_id" required="">
                            <option value="">Choose...</option>
                            <option value="1">ITU</option>
                            <option value="2">UNICEF</option>
                            <option value="3">Crisis</option>
                            <option value="4">ECOSOC (MiddleMUN)</option> 
                        </select>
                        <div class="invalid-feedback">
                        Please select a committee.
                        </div> 
                    </div>

                    <div class="mb-3">
                        <label for="representation">Country/Character Represented</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="representation" name="representation" placeholder="Country/Character" required="">
                            <div class="invalid-feedback" style="width: 100%;">
                            Your country/character is required.
                            </div>
                        </div>
                    </div>

                    <hr class="mb-4">

                    <h4 class="mb-3">Sign-in details</h4>

                    <div class="mb-3">
                        <label for="username">Email (Username)</label>
                        <input type="email" class="form-control" id="username" name="username" placeholder="you@example.com" required="">
                        <div class="invalid-feedback">
                            Please enter a valid email address for your username.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" required="">
                        <div class="invalid-feedback">
                            Please enter a password for your email username.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="confirm_password">Confirm password</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm password" required="">
                        <div class="invalid-feedback">
                            Passwords do not match.
                        </div>
                    </div>

                    <hr class="mb-4">

                    <button class="btn btn-primary btn-lg btn-block" type="submit">Register!</button>
                </form>
            </div>
        </div>

        <footer class="my-5 pt-5 text-muted text-center text-small">
            <p class="mb-1">&copy; 2021 Felix Chen</p>
            <ul class="list-inline">
            <li class="list-inline-item"><a href="https://getbootstrap.com/docs/4.6/examples/checkout/#">Privacy</a></li>
            <li class="list-inline-item"><a href="https://getbootstrap.com/docs/4.6/examples/checkout/#">Terms</a></li>
            <li class="list-inline-item"><a href="https://getbootstrap.com/docs/4.6/examples/checkout/#">Support</a></li>
            </ul>
        </footer>
    </div>

    <!-- 
    <script src="../assets/js/jquery-3.3.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="/docs/4.6/assets/js/vendor/jquery.slim.min.js"><\/script>')</script><script src="./Checkout example · Bootstrap v4.6_files/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
    -->

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

    <!-- Custom js for this page -->
    <script src="../assets/js/register.js"></script>
</body>
</html>