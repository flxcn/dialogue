<?php
require_once "DatabaseConnection.php";

class DelegateDashboard {
    protected $pdo = null;

    public function __construct() {
        $this->pdo = DatabaseConnection::instance();
	}

    public function getLastActiveOnByDelegateId($delegate_id): string {
        $sql = "SELECT last_active_on FROM sessions WHERE delegate_id = :delegate_id ORDER BY last_active_on DESC LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['delegate_id' => $delegate_id]);
        $last_active_on = $stmt->fetchColumn();
        return $last_active_on;
    }

    public function updateLastActiveOn($session_id): string {
        $sql = "UPDATE sessions SET last_active_on = NOW() WHERE session_id = :session_id";
        $stmt = $this->pdo->prepare($sql);
        $status = $stmt->execute(['session_id' => $session_id]);
        return $status;
    }

    public function getMessagesByConversation($this_delegate_id, $other_delegate_id) {
        $sql =
            "SELECT sender_id, receiver_id, message_content 
            FROM    messages
            WHERE   (sender_id = :this_delegate_id_1
                    AND receiver_id = :other_delegate_id_1)
                    OR 
                    (sender_id = :other_delegate_id_2 
                    AND receiver_id = :this_delegate_id_2)
            ORDER BY created_on DESC";
        
        $stmt = $this->pdo->prepare($sql);
        // the suffix number is only there due to PDO's requirement of unique parameters
		$status = $stmt->execute(
            [
                'this_delegate_id_1' => $this_delegate_id,
                'other_delegate_id_1' => $other_delegate_id,
                'this_delegate_id_2' => $this_delegate_id,
                'other_delegate_id_2' => $other_delegate_id
            ]);
		if(!$status) {
			return null;
		}
		else {
			$messages = $stmt->fetchAll();
            return $messages;
		}

    }

    public function resetUnreadMessageCount($this_delegate_id, $other_delegate_id) {
        $sql = "UPDATE messages SET is_read = true WHERE sender_id = :sender_id AND receiver_id = :receiver_id AND is_read = false";
        $stmt = $this->pdo->prepare($sql);
		$status = $stmt->execute(
            [
                'sender_id' => $other_delegate_id,
                'receiver_id' => $this_delegate_id
            ]);
        return $status;
    }

    public function countUnreadMessages($sender_id, $receiver_id) {
        $sql =
            "SELECT 
                COUNT(*) 
            FROM 
                messages
            WHERE sender_id = :sender_id
            AND receiver_id = :receiver_id
            AND is_read = FALSE";
        
        $stmt = $this->pdo->prepare($sql);
		$status = $stmt->execute(
            [
                'sender_id' => $sender_id,
                'receiver_id' => $receiver_id
            
            ]);

        $count = $stmt->fetchColumn();
        return $count;
    }

    public function getDelegatesInCommittee($delegate_id, $committee_id) {
        $sql = 
			"SELECT 
				delegate_id,
                representation
			FROM 
				delegates 
			WHERE 
				delegate_id != :delegate_id
                AND committee_id = :committee_id
			ORDER BY 
				representation 
				ASC";
		
		$stmt = $this->pdo->prepare($sql);
		$status = $stmt->execute(
            [
                'delegate_id' => $delegate_id, 
                'committee_id' => $committee_id
            ]);
		if(!$status) {
			return null;
		}
		else {
			$delegates = $stmt->fetchAll();
            return $delegates;
		}
    }

    public function getVolunteers(): ?string
	{
		$sql = 
			"SELECT DISTINCT 
				volunteers.volunteer_id AS volunteer_id, 
				volunteers.last_name AS last_name, 
				volunteers.first_name AS first_name
			FROM 
				volunteers
				INNER JOIN 
				affiliations 
				ON affiliations.volunteer_id = volunteers.volunteer_id
			WHERE 
				affiliations.sponsor_id = :sponsor_id
			ORDER BY 
				volunteers.last_name 
				ASC";
		
		$stmt = $this->pdo->prepare($sql);
		$status = $stmt->execute(['sponsor_id' => $this->sponsor_id]);
		if(!$status) {
			return null;
		}
		else {
			$volunteers = array();
			$volunteers[] = array("volunteer_name" => 'Select Name', "volunteer_id" => '');
			foreach ($stmt as $row)
			{
				$full_name = $row['last_name'] . ", " . $row['first_name'];
				$volunteers[] = array("volunteer_name" => $full_name, "volunteer_id" => $row['volunteer_id']);
			}
			$jsonVolunteers = json_encode($volunteers);
			return $jsonVolunteers;
		}
	}
}