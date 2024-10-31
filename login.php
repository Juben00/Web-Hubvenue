<?php
// Database connection parameters
$host = 'localhost';
$dbname = 'login_system';
$username = 'root';
$password = '';

// Establish database connection
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Function to handle login
function handleLogin($email, $password)
{
    global $pdo;

    // Prepare the SQL query
    $query = "SELECT id, email, password_hash FROM users WHERE email = :email";

    try {
        $stmt = $pdo->prepare($query);
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password_hash'])) {
            return ['success' => true, 'message' => 'Login successful', 'user_id' => $user['id']];
        } else {
            return ['success' => false, 'message' => 'Invalid email or password'];
        }
    } catch (PDOException $e) {
        return ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
    }
}

// Handle POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $result = handleLogin($email, $password);

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($result);
    exit;
}
