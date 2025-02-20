<?php
require_once(__DIR__ . '/../classes/account.class.php');
require_once(__DIR__ . '/../config/database.php');

header('Content-Type: application/json');

try {
    $account = new Account();
    $users = $account->getAllUsers();

    // Transform the data to ensure all required fields are present
    $transformedUsers = array_map(function($user) {
        return [
            'id' => $user['id'] ?? '',
            'firstname' => $user['firstname'] ?? '',
            'lastname' => $user['lastname'] ?? '',
            'middlename' => $user['middlename'] ?? '',
            'sex_id' => $user['sex_id'] ?? '',
            'user_type_id' => $user['user_type_id'] ?? '',
            'birthdate' => $user['birthdate'] ?? '',
            'contact_number' => $user['contact_number'] ?? '',
            'address' => $user['address'] ?? '',
            'profile_pic' => $user['profile_pic'] ?? '',
            'email' => $user['email'] ?? '',
            'is_Verified' => $user['is_Verified'] ?? 'Not Verified'
        ];
    }, $users);

    echo json_encode([
        'success' => true,
        'users' => $transformedUsers
    ]);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?> 