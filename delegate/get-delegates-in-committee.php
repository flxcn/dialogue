<?php

session_start(); // TODO: may or may not be necessary, if I'm posting the data

if(!isset($_SESSION["delegate_signed_in"]) || $_SESSION["delegate_signed_in"] !== true){
    header("location: sign-in.php");
    exit;
}

require_once "../classes/DelegateDashboard.php";

$obj = new DelegateDashboard();

if($_SERVER["REQUEST_METHOD"] == "POST") {

    $delegate_id = $_POST["delegate_id"]; 
    $committee_id = $_POST["committee_id"];
    
    $result = $obj->getDelegatesInCommittee($delegate_id, $committee_id);
    
    if($result) {

        $delegates = array();
        foreach($result as $row) {

            // Establish whether the this other delegate in committee is online or offline
            $current_timestamp = strtotime(date("Y-m-d H:i:s") . '- 15 second');
            $current_timestamp = date('Y-m-d H:i:s', $current_timestamp);
            $last_active_on = $obj->getLastActiveOnByDelegateId($row['delegate_id']);
            $activity_status = "Offline";
            if($last_active_on > $current_timestamp) {
                $activity_status = "Online";
            }

            // Count number of unread messages from this other delegate
            $unread_message_count = 5;
            //$unread_message_count = $obj->countUnreadMessages($row['delegate_id'], $delegate_id);

            $delegates[] = array(
                "delegate_id" => $row['delegate_id'],
                "representation" => $row['representation'],
                "activity_status" => $activity_status,
                "unread_message_count" => $unread_message_count
            );
        }
		
        // Send back data in JSON format
        header('Content-Type: application/json');
        echo json_encode($delegates);
        exit;
    } 
    else {
        echo null;
    }

}
?>