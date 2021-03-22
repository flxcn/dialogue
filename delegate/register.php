<?php

session_start();

require_once "../classes/Delegate.php";

$first_name = "";
$last_name = "";
$school = "";
$committee = ""; // perhaps committee_id instead? would save some work
$representation = "";

$username = "";
$password = "";
$confirm_password = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $obj = new Delegate();

    // Set sponsor_name
    $sponsor_name = trim($_POST["sponsor_name"]);
    $sponsor_name_error = $obj->setDelegateName($sponsor_name);

    // Set username
    $username = trim($_POST["username"]);
    $username_error = $obj->setUsername($username);

    // Set password
    $password = trim($_POST["password"]);
    $password_error = $obj->setPassword($password);

    // Set confirm_password
    $confirm_password = trim($_POST["confirm_password"]);
    $confirm_password_error = $obj->setConfirmPassword($confirm_password);

    // Set contribution_type
    $contribution_type = trim($_POST["contribution_type"]);
    $contribution_type_error = $obj->setContributionType($contribution_type);

    // Set advisor1 information
    $advisor1_name = trim($_POST["advisor1_name"]);
    $advisor1_email = trim($_POST["advisor1_email"]);
    $advisor1_phone = trim($_POST["advisor1_phone"]);
    $obj->addAdvisor($advisor1_name, $advisor1_email, $advisor1_phone);

    // Set advisor2 information
    $advisor2_name = trim($_POST["advisor2_name"]);
    $advisor2_email = trim($_POST["advisor2_email"]);
    $advisor2_phone = trim($_POST["advisor2_phone"]);
    $obj->addAdvisor($advisor2_name, $advisor2_email, $advisor2_phone);

  // Set advisor3 information
  $advisor3_name = trim($_POST["advisor3_name"]);
  $advisor3_email = trim($_POST["advisor3_email"]);
  $advisor3_phone = trim($_POST["advisor3_phone"]);
  $obj->addAdvisor($advisor3_name, $advisor3_email, $advisor3_phone);

  if(empty($username_error) && empty($password_error) && empty($confirm_password_error) && empty($contribution_type_error) && empty($sponsor_name_error)  && empty($advisor1_name_error) && empty($advisor1_email_error) && empty($advisor1_phone_error))
  {
    if($obj->addDelegate()) {
      header("location: login.php");
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
                        <label for="committee">Committee</label>
                        <select class="custom-select d-block w-100" id="committee" required="">
                            <option value="">Choose...</option>
                            <option>ITU</option>
                            <option>UNICEF</option>
                            <option>Crisis</option>
                            <option>ECOSOC (MiddleMUN)</option> 
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
                        <label for="password">Email (Username)</label>
                        <input type="email" class="form-control" id="email" placeholder="you@example.com" required="">
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