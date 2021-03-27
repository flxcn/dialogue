<?php

session_start(); // TODO: may or may not be necessary, if I'm posting the data

if(!isset($_SESSION["delegate_signed_in"]) || $_SESSION["delegate_signed_in"] !== true){
    header("location: sign-in.php");
    exit;
}

require_once "../classes/DelegateDashboard.php";

$obj = new DelegateDashboard();

if($_SERVER["REQUEST_METHOD"] == "POST") {

    $session_id = $_POST["session_id"]; 
    
    if($obj->updateLastActiveOn($session_id)) {
        // header('Content-type: application/json');
        // echo json_encode($response_array);
        exit;
    } 
    else {
        echo null;
    }

}
?>