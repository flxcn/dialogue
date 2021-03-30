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

    public function setPassword(string $password): string {
        if(empty($password)) {
            return "Please enter a password.";
        }
        else {
            $this->password = $password;
            return "";
        }
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

    // SIGN-IN METHODS

    // Set username
    public function setUsernameForSignIn(string $username): string {
        if(empty($username)) {
            return "Please enter your email address.";
        }
		if($this->checkUsernameExists(strtolower($username))) {
            $this->username = strtolower($username);
            return "";
		}
        else
        {
            return "No account found with that email.";
        }
    }

    // Check username exists
    private function checkUsernameExists($username): bool {
        $stmt = $this->pdo->prepare("SELECT 1 FROM delegates WHERE username = :username");
        $stmt->execute(['username' => $username]);
        return (bool)$stmt->fetch();
    }

    // sign-in with username and password
    public function signIn(): bool
    {
        $sql = "SELECT delegate_id, representation, committee_id, username, password FROM delegates WHERE username = :username";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['username' => $this->username]);
        $delegate = $stmt->fetch();

        if ($delegate && password_verify($this->password, $delegate['password']))
        {
            $this->delegate_id = $delegate["delegate_id"];
            $this->representation = $delegate["representation"];
            $this->committee_id = $delegate["committee_id"];
            return true;
        } else {
        return false;
        }
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
}
?>