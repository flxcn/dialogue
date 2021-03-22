<?php
require_once "DatabaseConnection.php";

class Committee {
    protected $pdo = null;
    private $committee_id;
    private $name;
    private $created_on;

    public function __construct() {
        $this->pdo = DatabaseConnection::instance();
	}

    // getters and setters

    public function setName($name) {
        $this->name = $name;
    }
    public function getName() {
        return $this->name;
    }
}
?>