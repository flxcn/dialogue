<?php
require_once "DatabaseConnection.php";

class Moderator {
    protected $pdo = null;
    private $moderator_id;
    private $first_name;
    private $last_name;
    private $conference_id;
    private $committee_id;
    
    private $username;
    private $password;
    
    private $is_enabled;
    private $created_on;
    //private $verification_code;
    private $last_active_on;

    public function __construct() {
        $this->pdo = DatabaseConnection::instance();
        $this->conference_id = 1;
        $this->is_enabled = true;
	}

    // getters and setters

    public function setModeratorId($moderator_id) {
        $this->moderator_id = $moderator_id;
    }

    public function getModeratorId() {
        return $this->moderator_id;
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
   
    // Create a new delegate, used in delegate/register.php
    public function addModerator() {
        $sql = "INSERT INTO moderators (first_name, last_name, conference_id, committee_id, username, password, is_enabled)
			VALUES (:first_name, :last_name, :conference_id, :committee_id, :username, :password, :is_enabled)";
		$stmt = $this->pdo->prepare($sql);
		$status = $stmt->execute(
			[
				'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'conference_id' => $this->conference_id,
                'committee_id' => $this->committee_id,
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
        $sql = "SELECT moderator_id, first_name, last_name, committee_id, username, password FROM moderators WHERE username = :username";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['username' => $this->username]);
        $moderator = $stmt->fetch();

        if ($moderator && password_verify($this->password, $moderator['password']))
        {
            $this->first_name = $moderator["first_name"];
            $this->last_name = $moderator["last_name"];
            $this->committee_id = $moderator["committee_id"];
            $this->moderator_id = $moderator["moderator_id"];
            return true;
        } else {
        return false;
        }
    }

}
?>