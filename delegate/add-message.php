<?php

session_start(); // TODO: may or may not be necessary, if I'm posting the data

if(!isset($_SESSION["delegate_signed_in"]) || $_SESSION["delegate_signed_in"] !== true){
    header("location: sign-in.php");
    exit;
}

require_once "../classes/DelegateDashboard.php";

$obj = new DelegateDashboard();

if($_SERVER["REQUEST_METHOD"] == "POST") {

    $committee_id = $_POST["committee_id"];
    $sender_id = $_POST["sender_id"]; 
    $receiver_id = $_POST["receiver_id"];
    $message_content = $_POST["message_content"];

    if($obj->addMessage($committee_id, $sender_id, $receiver_id, $message_content)) {
        exit;
    } 
    else {
        echo "Message failed to send.";
    }

}
?>