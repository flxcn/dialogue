<?php

session_start(); // TODO: may or may not be necessary, if I'm posting the data

if(!isset($_SESSION["moderator_signed_in"]) || $_SESSION["moderator_signed_in"] !== true){
    header("location: sign-in.php");
    exit;
}

require_once "../classes/ModeratorDashboard.php";

$obj = new ModeratorDashboard();

if($_SERVER["REQUEST_METHOD"] == "POST") {

    $message_id = $_POST["message_id"]; 
    $is_verified = $_POST["is_verified"];
    
    if($obj->updateIsVerified($message_id, $is_verified)) {
        exit;
    } 
    else {
        echo null;
    }

}
?>