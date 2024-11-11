<?php
require_once(__DIR__ . '/../dbconnection.php');

class Account
{
    public $id;
    public $firstname;
    public $lastname;
    public $middlename;
    public $sex;
    public $usertype = 2;
    public $birthdate;
    public $address;
    public $contact_number;
    public $email;
    public $password;

    //host account table variables

    public $userId;
    public $fullname;
    public $status_id = 1;
    public $idOne_type;
    public $idOne_url;
    public $idTwo_type;
    public $idTwo_url;

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
            $sql = 'INSERT INTO users (firstname, lastname, middlename, sex_id, user_type_id, birthdate, contact_number, address ,email, password) VALUES (:firstname, :lastname, :middlename, :sex_id, :user_type_id, :birthdate, :contact_number,:address, :email, :password)';
            $stmt = $this->db->connect()->prepare($sql);

            $stmt->bindParam(':firstname', $this->firstname);
            $stmt->bindParam(':lastname', $this->lastname);
            $stmt->bindParam(':middlename', $this->middlename);

            // Determine sex_id based on sex value
            $sex_id = 3; // Default value for unspecified sex
            if ($this->sex == "Male") {
                $sex_id = 1;
            } else if ($this->sex == "Female") {
                $sex_id = 2;
            }
            $stmt->bindParam(':sex_id', $sex_id);
            $stmt->bindParam(':user_type_id', $this->usertype);
            $stmt->bindParam(':birthdate', $this->birthdate);
            $stmt->bindParam(':contact_number', $this->contact_number);
            $stmt->bindParam(':address', $this->address);
            $stmt->bindParam(':email', $this->email);

            // Hash the password before saving to the database
            $this->password = password_hash($this->password, PASSWORD_DEFAULT);

            $stmt->bindParam(':password', $this->password);

            if ($stmt->execute()) {
                return ['status' => 'success', 'message' => 'Account created successfully'];
            } else {
                return ['status' => 'error', 'message' => 'Failed to create account'];
            }
        }
    }
    public function login()
    {
        $sql = 'SELECT * FROM users WHERE email = :email';
        $stmt = $this->db->connect()->prepare($sql);
        $stmt->bindParam(':email', $this->email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($this->password, $user['password'])) {

                session_start();
                session_regenerate_id(delete_old_session: true);
                $_SESSION['user'] = $user;

                return ['status' => 'success', 'message' => 'Login successful', 'user' => $user];
            } else {
                return ['status' => 'error', 'message' => 'Invalid email or password'];
            }
        } else {
            return ['status' => 'error', 'message' => 'Invalid email or password'];
        }
    }
    public function getUser($user_id = '', $user_type = '')
    {
        // Add wildcards to user_id and user_type for LIKE search
        $user_id = "%" . $user_id . "%";
        $user_type = "%" . $user_type . "%";

        // SQL query to fetch user data along with their sex and user type
        $sql = 'SELECT u.*, ss.name AS sex, ust.name AS user_type 
            FROM users u 
            JOIN sex_sub ss ON u.sex_id = ss.id 
            JOIN user_types_sub ust ON ust.id = u.user_type_id 
            WHERE u.id LIKE :user_id AND u.user_type_id LIKE :user_type';

        // Prepare the SQL statement
        $stmt = $this->db->connect()->prepare($sql);

        // Bind the parameters with wildcards for LIKE clause
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':user_type', $user_type);

        // Execute the SQL query
        $stmt->execute();

        // Fetch the user data as an associative array
        $user = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Return the user data
        return $user;
    }

    public function upgradeUser()
    {
        // SQL query to update the user type to admin
        try {

            $conn = $this->db->connect();

            // Begin transaction
            $conn->beginTransaction();

            $sql = "INSERT INTO host_application (userId, fullname, address, birthdate, status_id) VALUES (:userId, :fullname, :address, :birthdate, :status_id)";
            $stmt = $conn->prepare($sql);

            $stmt->bindParam(':userId', $this->userId);
            $stmt->bindParam('fullname', $this->fullname);
            $stmt->bindParam(':address', $this->address);
            $stmt->bindParam(':birthdate', $this->birthdate);
            $stmt->bindParam('status_id', $this->status_id);

            if ($stmt->execute()) {
                // Get the last inserted ID for the venue
                $lastInsertedhostId = $conn->lastInsertId();

                $imgOne = $this->idOne_url;
                $imgTwo = $this->idTwo_url;

                if ($imgOne && $imgTwo) {
                    $imageSql = "INSERT INTO host_id_images (id, idOne_type, idOne_image_url, idTwo_type, idTwo_image_url) VALUES (:id, :idOne_type, :idOne_image_url, :idTwo_type, :idTwo_image_url)";
                    $imageStmt = $conn->prepare($imageSql);
                    $imageStmt->bindParam(':id', $lastInsertedhostId);
                    $imageStmt->bindParam(':idOne_type', $this->idOne_type);
                    $imageStmt->bindParam(':idOne_image_url', $imgOne);
                    $imageStmt->bindParam(':idTwo_type', $this->idTwo_type);
                    $imageStmt->bindParam(':idTwo_image_url', $imgTwo);

                    if (!$imageStmt->execute()) {
                        // If any image fails to insert, return error
                        return ['status' => 'error', 'message' => 'Failed to add images for the venue'];
                    }
                }
                $conn->commit();
                return ['status' => 'success', 'message' => 'Host Application sent succesfully'];
            } else {
                $conn->rollBack();
                return ['status' => 'error', 'message' => 'Failed to send Host Application'];
            }

        } catch (PDOException $e) {
            $conn->rollBack();
            $errmess = "Database error: " . $e->getMessage();
            error_log($errmess);  // Log the error message
            return ['status' => 'error', 'message' => $errmess];  // Return the error message
        }

    }


}

// session_start();


$accountObj = new Account();


// var_dump($accountObj->getUser($_SESSION['user']['id']));