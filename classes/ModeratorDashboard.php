<?php
require_once "DatabaseConnection.php";

class ModeratorDashboard {
    protected $pdo = null;

    public function __construct() {
        $this->pdo = DatabaseConnection::instance();
	}

    public function getMessagesByCommitteeId($committee_id) {
        $sql = "SELECT      messages.message_id AS message_id,
                            messages.message_content AS message_content,
                            senders.representation AS sender_representation,
                            receivers.representation AS receiver_representation,
                            messages.created_on AS created_on
                FROM        messages 
                            INNER JOIN delegates AS senders
                                ON messages.sender_id = senders.delegate_id
                            INNER JOIN delegates AS receivers 
                                ON messages.receiver_id = receivers.delegate_id
                WHERE       messages.committee_id = :committee_id
                            AND is_verified IS NULL
                ORDER BY    created_on ASC LIMIT 4";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['committee_id' => $committee_id]);
        $messages = $stmt->fetchAll();
        return $messages;
    }

    public function updateIsVerified($message_id, $is_verified): string {
        $sql = "UPDATE messages SET is_verified = :is_verified WHERE message_id = :message_id";
        $stmt = $this->pdo->prepare($sql);
        $status = $stmt->execute(['is_verified' => $is_verified, 'message_id' => $message_id]);
        return $status;
    }
}
?>