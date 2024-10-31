<?php
require_once '../dbconnection.php';

class Account
{
    public $id;
    public $firstname;
    public $lastname;
    public $middlename;
    public $gender;
    public $usertype = 1;
    public $birthdate;
    public $contact_number;
    public $email;
    public $password;

    protected $db;

    function __construct()
    {
        $this->db = new Database();
    }

    public function signup()
    {
        // Check if the email already exists
        $sql = 'SELECT * FROM users WHERE email = :email';
        $chkstmt = $this->db->connect()->prepare($sql);
        $chkstmt->bindParam(':email', $this->email);
        $chkstmt->execute();

        if ($chkstmt->rowCount() > 0) {
            return ['status' => 'error', 'message' => 'Account already exists'];
        } else {
            // Insert new account if email does not exist
            $sql = 'INSERT INTO users (firstname, lastname, middlename, gender_id, user_type_id, birthdate, contact_number, email, password) VALUES (:firstname, :lastname, :middlename, :gender_id, :user_type_id, :birthdate, :contact_number, :email, :password)';
            $stmt = $this->db->connect()->prepare($sql);

            $stmt->bindParam(':firstname', $this->firstname);
            $stmt->bindParam(':lastname', $this->lastname);
            $stmt->bindParam(':middlename', $this->middlename);

            // Determine gender_id based on gender value
            $gender_id = 3; // Default value for unspecified gender
            if ($this->gender == "Male") {
                $gender_id = 1;
            } else if ($this->gender == "Female") {
                $gender_id = 2;
            }
            $stmt->bindParam(':gender_id', $gender_id);
            $stmt->bindParam(':user_type_id', $this->usertype);
            $stmt->bindParam(':birthdate', $this->birthdate);
            $stmt->bindParam(':contact_number', $this->contact_number);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':password', $this->password);

            if ($stmt->execute()) {
                return ['status' => 'success', 'message' => 'Account created successfully'];
            } else {
                return ['status' => 'error', 'message' => 'Failed to create account'];
            }
        }
    }

}