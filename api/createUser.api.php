<?php
require_once(__DIR__ . '/../classes/account.class.php');
require_once(__DIR__ . '/../config/database.php');

header('Content-Type: application/json');

// Get the raw POST data
$data = json_decode(file_get_contents('php://input'), true);

// Validate required fields
$requiredFields = ['firstname', 'lastname', 'email', 'password', 'user_type_id'];
$missingFields = [];

foreach ($requiredFields as $field) {
    if (!isset($data[$field]) || empty($data[$field])) {
        $missingFields[] = $field;
    }
}

if (!empty($missingFields)) {
    echo json_encode([
        'success' => false,
        'message' => 'Missing required fields: ' . implode(', ', $missingFields)
    ]);
    exit;
}

try {
    $account = new Account();
    
    // Set account properties
    $account->firstname = $data['firstname'];
    $account->lastname = $data['lastname'];
    $account->middlename = $data['middlename'] ?? '';
    $account->sex = $data['sex_id'] ?? '1'; // Default to male if not specified
    $account->usertype = $data['user_type_id'];
    $account->birthdate = $data['birthdate'] ?? date('Y-m-d'); // Default to current date if not specified
    $account->contact_number = $data['contact_number'] ?? '';
    $account->address = $data['address'] ?? '';
    $account->email = $data['email'];
    $account->password = $data['password'];

    // Create the account using adminSignup
    $result = $account->adminSignup();

    if ($result['status'] === 'success') {
        echo json_encode([
            'success' => true,
            'message' => $result['message']
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => $result['message']
        ]);
    }
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?> 