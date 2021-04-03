<?php

session_start();

if(!isset($_SESSION["moderator_signed_in"]) || $_SESSION["moderator_signed_in"] !== true){
    header("location: sign-in.php");
    exit;
}

require_once "../classes/ModeratorDashboard.php";

$obj = new ModeratorDashboard();

if($_SERVER["REQUEST_METHOD"] == "POST") {

    $committee_id = $_POST["committee_id"]; 
    
    $result = $obj->getVerifiedMessages($committee_id);
    
    if($result) {

        $messages = array();
        foreach($result as $row) {
            $created_on = date_create($row['created_on']);
            $formatted_created_on = date_format($created_on, "D, M j\\t\h g:i A");
            $messages[] = array(
                "message_id" => $row['message_id'],
                "message_content" => $row['message_content'],
                "is_verified" => $row["is_verified"],
                "sender_representation" => $row['sender_representation'],
                "receiver_representation" => $row['receiver_representation'],
                "created_on" => $formatted_created_on
            );
        }
		
        // Send back data in JSON format
        header('Content-Type: application/json');
        echo json_encode($messages);
        exit;
    } 
    else {
        echo null;
    }

}
?>