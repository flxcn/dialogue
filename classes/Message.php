<?php
require_once "DatabaseConnection.php";

class Message {
    protected $pdo = null;
    private $message_id;
    private $delegate_id;
    private $name;
    private $email;
    private $password;
    // private $profile;
    private $is_enabled;
    private $created_on;
    private $verification_code;
    private $is_logged_in;

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


    public function setName($name) {
        $this->name = $name;
    }
    public function getName() {
        return $this->name;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function getPassword() {
        return $this->password;
    }
   
   
    public function setIsEnabled(bool $is_enabled) {
        $this->is_enabled = $is_enabled;
    }

    public function getIsEnabled() {
        return $this->is_enabled;
    }
    
    public function setCreatedOn($created_on) {
        $this->created_on = $created_on;
    }
    
    public function getCreatedOn() {
        return $this->created_on;
    }
    
    public function setIsLoggedIn(bool $is_logged_in) {
        $this->is_logged_in = $is_logged_in;
    }
    
    public function getIsLoggedIn() {
        return $this->is_logged_in;
    }
   
    

    public function getDelegateByEmail() {
		$sql = "SELECT * FROM delegates WHERE email = :email";
		$stmt = $this->pdo->prepare($sql);
		$status = $stmt->execute(['email' => $this->email]);
		$delegate = $stmt->fetch();

		if($status) {
  			return $delegate;
		}
		else {
			return null;
		}

    }

    public function addDelegate() {
        $sql = "INSERT INTO delegates (name, email, password, is_enabled, created_on)
			VALUES (:name, :email, :password, :is_enabled, :created_on)";
		$stmt = $this->pdo->prepare($sql);
		$status = $stmt->execute(
			[
				'name' => $this->name,
				'email' => $this->email,
				'password' => $this->password,
				'is_enabled' => $this->is_enabled,
				'created_on' => $this->created_on
			]);

		return $status;
    }

    public function enableDelegateAccount() {
        $sql = "UPDATE delegates SET is_enabled = :is_enabled WHERE verification_code = :verification_code";
        $stmt = $this->pdo->prepare($sql);
        $status = $stmt->execute(
            [
                'is_enabled' => $this->is_enabled,
                'verification_code' => $this->verification_code
            ]);

        return $status;
    }

    public function updateLoginStatus() {
        $sql = "UPDATE delegates SET is_logged_in = :is_logged_in WHERE delegate_id = :delegate_id";
        $stmt = $this->pdo->prepare($sql);
        $status = $stmt->execute(
            [
                'is_logged_in' => $this->is_logged_in,
                'delegate_id' => $this->delegate_id
            ]);

        return $status;
    }

    public function getDelegateById() {
        $sql = "SELECT * FROM delegates WHERE delegate_id = :delegate_id";
		$stmt = $this->pdo->prepare($sql);
		$status = $stmt->execute(['delegate_id' => $this->delegate_id]);
		$delegate = $stmt->fetch();

        if($status) {
            return $delegate;
        }
        else
        {
            return null;
        }
    }

    public function updateDelegate() {
        $sql = 
            "UPDATE delegates 
            SET name = :name,
                email = :email,
                password = :password
            WHERE delegate_id = :delegate_id";
        $stmt = $this->pdo->prepare($sql);
        $status = $stmt->execute(
            [
                'name' => $this->name,
                'email' => $this->email,
                'password' => $this->password,
                'delegate_id' => $this->delegate_id
            ]);

        return $status;
    }

    public function getAllDelegates() {
        $sql = "SELECT * FROM delegates";
		$stmt = $this->pdo->prepare($sql);
		$status = $stmt->execute();
		$delegates = $stmt->fetchAll();

        if($status) {
            return $delegates;
        }
        else
        {
            return null;
        }
    }
}
?>