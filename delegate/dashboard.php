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
                    <span class="badge badge-secondary badge-pill">3</span> 
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
                    <div class="card-header border bg-white text-black"><b>To: Joe Biden</b></div>
                    <div class="card-body overflow-auto">
                        <div class="card col-sm-8 mb-3 float-left bg-light">
                           <div class="card-body text-left">Hi! How are you doing?</div>
                        </div>
                        <div class="card col-sm-8 mb-3 float-right bg-primary">
                           <div class="card-body text-left text-white">Good Joe, I'm doing swell.</div>
                        </div>
                        <div class="card col-sm-8 mb-3 float-left">
                           <div class="card-body text-left">That's great, that's great... listen, do you think we could find a solution on trade policy?</div>
                        </div>
                        <div class="card col-sm-8 mb-3 float-right">
                           <div class="card-body text-left">Listen, I'm not sure that's going to be possible... my country is closely aligned with North Korea.</div>
                        </div>
                        <div class="card col-sm-8 mb-3 float-left">
                           <div class="card-body text-left">That's okay, champ. I understand. Have a good day then.</div>
                        </div>
                        <div class="card col-sm-8 mb-3 float-right">
                           <div class="card-body text-left">Alright, thanks anyways. See ya</div>
                        </div>
                        <div class="card col-sm-8 mb-3 float-left">
                           <div class="card-body text-left">See ya.</div>
                        </div>
                    </div>
                    <form class="card p-1 footer">
                        <div class="input-group">
                        <textarea type="text" class="form-control" placeholder="Message"></textarea>
                        <div class="input-group-append">
                            <button class="btn btn-primary">Send!</button>
                        </div>
                        </div>
                    </form>
                    
                    
                </div>
                    

                <!-- <form class="needs-validation" novalidate="">
                    

                    <div class="mb-3">
                    <label for="username">Username</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                        <span class="input-group-text">@</span>
                        </div>
                        <input type="text" class="form-control" id="username" placeholder="Username" required="">
                        <div class="invalid-feedback" style="width: 100%;">
                        Your username is required.
                        </div>
                    </div>
                    </div>

                    <div class="mb-3">
                    <label for="email">Email <span class="text-muted">(Optional)</span></label>
                    <input type="email" class="form-control" id="email" placeholder="you@example.com">
                    <div class="invalid-feedback">
                        Please enter a valid email address for shipping updates.
                    </div>
                    </div>

                    <div class="mb-3">
                    <label for="address">Address</label>
                    <input type="text" class="form-control" id="address" placeholder="1234 Main St" required="">
                    <div class="invalid-feedback">
                        Please enter your shipping address.
                    </div>
                    </div>

                    <div class="mb-3">
                    <label for="address2">Address 2 <span class="text-muted">(Optional)</span></label>
                    <input type="text" class="form-control" id="address2" placeholder="Apartment or suite">
                    </div>

                    <div class="row">
                    <div class="col-md-5 mb-3">
                        <label for="country">Country</label>
                        <select class="custom-select d-block w-100" id="country" required="">
                        <option value="">Choose...</option>
                        <option>United States</option>
                        </select>
                        <div class="invalid-feedback">
                        Please select a valid country.
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="state">State</label>
                        <select class="custom-select d-block w-100" id="state" required="">
                        <option value="">Choose...</option>
                        <option>California</option>
                        </select>
                        <div class="invalid-feedback">
                        Please provide a valid state.
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="zip">Zip</label>
                        <input type="text" class="form-control" id="zip" placeholder="" required="">
                        <div class="invalid-feedback">
                        Zip code required.
                        </div>
                    </div>
                    </div>
                    <hr class="mb-4">
                    <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="same-address">
                    <label class="custom-control-label" for="same-address">Shipping address is the same as my billing address</label>
                    </div>
                    <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="save-info">
                    <label class="custom-control-label" for="save-info">Save this information for next time</label>
                    </div>
                    <hr class="mb-4">

                    <h4 class="mb-3">Payment</h4>

                    <div class="d-block my-3">
                    <div class="custom-control custom-radio">
                        <input id="credit" name="paymentMethod" type="radio" class="custom-control-input" checked="" required="">
                        <label class="custom-control-label" for="credit">Credit card</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input id="debit" name="paymentMethod" type="radio" class="custom-control-input" required="">
                        <label class="custom-control-label" for="debit">Debit card</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input id="paypal" name="paymentMethod" type="radio" class="custom-control-input" required="">
                        <label class="custom-control-label" for="paypal">PayPal</label>
                    </div>
                    </div>
                    <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="cc-name">Name on card</label>
                        <input type="text" class="form-control" id="cc-name" placeholder="" required="">
                        <small class="text-muted">Full name as displayed on card</small>
                        <div class="invalid-feedback">
                        Name on card is required
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="cc-number">Credit card number</label>
                        <input type="text" class="form-control" id="cc-number" placeholder="" required="">
                        <div class="invalid-feedback">
                        Credit card number is required
                        </div>
                    </div>
                    </div>
                    <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="cc-expiration">Expiration</label>
                        <input type="text" class="form-control" id="cc-expiration" placeholder="" required="">
                        <div class="invalid-feedback">
                        Expiration date required
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="cc-cvv">CVV</label>
                        <input type="text" class="form-control" id="cc-cvv" placeholder="" required="">
                        <div class="invalid-feedback">
                        Security code required
                        </div>
                    </div>
                    </div>
                    <hr class="mb-4">
                    <button class="btn btn-primary btn-lg btn-block" type="submit">Continue to checkout</button>
                </form> -->
            </div>
        </div>

        <footer class="my-5 pt-5 text-muted text-center text-small">
            <p class="mb-1">© 2021 Felix Chen</p>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

    <!-- Custom JS for this page -->
    <!-- Define JS variables to hold PHP session variables -->
    <script type="text/javascript">
        var delegate_id = <?php echo $_SESSION['delegate_id'];?>;
        var committee_id = <?php echo $_SESSION['committee_id'];?>;
    </script>

    <!-- Script for JQuery Functions -->
    <script src="../assets/js/dashboard.js"></script>

</body>
</html>