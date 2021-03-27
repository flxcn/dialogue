<?php

session_start(); // TODO: may or may not be necessary, if I'm posting the data

if(!isset($_SESSION["delegate_signed_in"]) || $_SESSION["delegate_signed_in"] !== true){
    header("location: sign-in.php");
    exit;
}

require_once "../classes/DelegateDashboard.php";

$obj = new DelegateDashboard();

if($_SERVER["REQUEST_METHOD"] == "POST") {

    $this_delegate_id = $_POST["this_delegate_id"]; 
    $other_delegate_id = $_POST["other_delegate_id"];
    
    $result = $obj->getMessagesByConversation($this_delegate_id, $other_delegate_id);
    
    if($result) {

        $messages = array();
        foreach($result as $row) {
            $messages[] = array(
                "sender_id" => $row['sender_id'],
                "receiver_id" => $row['receiver_id'],
                "message_content" => $row['message_content']
            );
        }
		
        $obj->resetUnreadMessageCount($this_delegate_id, $other_delegate_id);

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