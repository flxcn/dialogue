<?php
require_once "DatabaseConnection.php";

class Delegate {
    protected $pdo = null;
    private $delegate_id;
    private $first_name;
    private $last_name;
    private $school;
    private $conference_id;
    private $committee_id;
    private $representation;
    
    private $username;
    private $password;
    
    private $is_enabled;
    private $created_on;
    //private $verification_code;
    private $last_active_on;

    public function __construct() {
        $this->pdo = DatabaseConnection::instance();
        $this->conference_id = 1;
        $this->is_logged_in = false;
        $this->is_enabled = true;
	}

    // getters and setters

    public function setDelegateId($delegate_id) {
        $this->delegate_id = $delegate_id;
    }

    public function getDelegateId() {
        return $this->delegate_id;
    }

    public function setFirstName($first_name) {
        $this->first_name = $first_name;
    }
    public function getFirstName() {
        return $this->first_name;
    }

    public function setLastName($last_name) {
        $this->last_name = $last_name;
    }
    public function getLastName() {
        return $this->last_name;
    }
   
    public function setSchool($school) {
        $this->school = $school;
    }
    public function getSchool() {
        return $this->school;
    }

    public function setConferenceId($conference_id) {
        $this->conference_id = $conference_id;
    }
    public function getConferenceId() {
        return $this->conference_id;
    }

    public function setCommitteeId($committee_id) {
        $this->committee_id = $committee_id;
    }
    public function getCommitteeId() {
        return $this->committee_id;
    }

    public function setRepresentation($representation) {
        $this->representation = $representation;
    }
    public function getRepresentation() {
        return $this->representation;
    }


    public function setUsername(string $username): string
    {
        $stmt = $this->pdo->prepare('SELECT count(*) FROM delegates WHERE username = :username');
        $stmt->execute(['username' => strtolower($username)]);
        $same_usernames = $stmt->fetchColumn();
        if($same_usernames > 0){
            return "This username is already taken.";
        }
        if(!filter_var($username, FILTER_VALIDATE_EMAIL))
        {
            return "This email address is not valid";
        } else {
            $this->username = strtolower($username);
            return "";
        }
    }

    public function getUsername() {
        return $this->username;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setConfirmPassword(string $confirm_password): string
    {
        if(empty($confirm_password)) {
            return "Please confirm password.";
        }

        if(strcmp($this->password,$confirm_password) != 0){
            return "Password did not match.";
        }

        $this->confirm_password = $confirm_password;
        return "";
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
   
    // Create a new delegate, used in delegate/register.php
    public function addDelegate() {
        $sql = "INSERT INTO delegates (first_name, last_name, school, conference_id, committee_id, representation, username, password, is_enabled)
			VALUES (:first_name, :last_name, :school, :conference_id, :committee_id, :representation, :username, :password, :is_enabled)";
		$stmt = $this->pdo->prepare($sql);
		$status = $stmt->execute(
			[
				'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'school' => $this->school,
                'conference_id' => $this->conference_id,
                'committee_id' => $this->committee_id,
                'representation' => $this->representation,
				'username' => $this->username,
				'password' => password_hash($this->password, PASSWORD_DEFAULT),
				'is_enabled' => $this->is_enabled
			]);

		return $status;
    }

    // Get Delegate by their email address (username)
    public function getDelegateByUsername() {
		$sql = "SELECT * FROM delegates WHERE username = :username";
		$stmt = $this->pdo->prepare($sql);
		$status = $stmt->execute(['username' => $this->username]);
		$delegate = $stmt->fetch();

		if($status) {
  			return $delegate;
		}
		else {
			return null;
		}

    }

    // public function isEmailVerificationCodeValid() {
    //    // check if user_verification code matches one in the database exist already
    //    // use COUNT(*), and see if it's greater than zero 
    // }

    // public function enableDelegateAccount() {
    //     $sql = "UPDATE delegates SET is_enabled = :is_enabled WHERE verification_code = :verification_code";
    //     $stmt = $this->pdo->prepare($sql);
    //     $status = $stmt->execute(
    //         [
    //             'is_enabled' => $this->is_enabled,
    //             'verification_code' => $this->verification_code
    //         ]);

    //     return $status;
    // }

    // public function updateLoginStatus() {
    //     $sql = "UPDATE delegates SET is_logged_in = :is_logged_in WHERE delegate_id = :delegate_id";
    //     $stmt = $this->pdo->prepare($sql);
    //     $status = $stmt->execute(
    //         [
    //             'is_logged_in' => $this->is_logged_in,
    //             'delegate_id' => $this->delegate_id
    //         ]);

    //     return $status;
    // }

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