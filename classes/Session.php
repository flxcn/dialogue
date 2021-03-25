<?php
require_once "DatabaseConnection.php";

class Session {
    protected $pdo = null;
    private $session_id;
    private $delegate_id;
    private $last_active_on;

    public function __construct() {
        $this->pdo = DatabaseConnection::instance();
	}

    // getters and setters

    public function setDelegateId($delegate_id) {
        $this->delegate_id = $delegate_id;
    }

    public function getDelegateId() {
        return $this->delegate_id;
    }

    public function setSessionId($session_id) {
        $this->session_id = $session_id;
    }
    public function getSessionId() {
        return $this->session_id;
    }

    public function setCreatedOn($created_on) {
        $this->created_on = $created_on;
    }
    
    public function getCreatedOn() {
        return $this->created_on;
    }

    public function setLastActiveOn($last_active_on) {
        $this->last_active_on = $last_active_on;
    }
    
    public function getLastActiveOn() {
        return $this->last_active_on;
    }
    
    public function addSession() {
        $sql = "INSERT INTO sessions (delegate_id)
			VALUES (:delegate_id)";
		$stmt = $this->pdo->prepare($sql);
		$status = $stmt->execute(
			[
				'delegate_id' => $this->delegate_id
			]);
        
        // get lastInsertId and set $this->session_id to that value
        // this might actually belong in a different function
        if($status) {
            $this->setSessionId($this->pdo->lastInsertId());
        }
		return $status;
    }

    public function updateLastActiveOn($session_id) {
        $sql = "UPDATE delegates SET last_active_on = NOW() WHERE session_id = :session_id";
        $stmt = $this->pdo->prepare($sql);
        $status = $stmt->execute(
            [
                'session_id' => $session_id,
            ]);

        return $status;
    }

    public function isDelegateActive() {
        $sql = "SELECT last_active_on FROM delegates WHERE session_id = :session_id";
        $stmt = $this->pdo->prepare($sql);
        $status = $stmt->execute(['session_id' => $this->session_id]);
        $delegate = $stmt->fetch();
    
        if($status) {
            return true;
        }
        else
        {
            return false;
        }
    }
}
?>