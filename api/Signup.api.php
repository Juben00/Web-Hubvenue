<?php
require_once '../classes/account.class.php';
require_once '../sanitize.php';

$accountObj = new Account();

$firstname = $lastname = $middlename = $gender = $birthdate = $contact_number = $email = $password = '';
$firstnameErr = $lastnameErr = $middlenameErr = $genderErr = $birthdateErr = $contact_numberErr = $emailErr = $passwordErr = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstname = clean_input($_POST['firstname']);
    $lastname = clean_input($_POST['lastname']);
    $middlename = clean_input($_POST['middlename']);
    $gender = clean_input($_POST['gender']);
    $birthdate = clean_input($_POST['birthdate']);
    $contact_number = clean_input($_POST['contact']);
    $email = clean_input($_POST['email']);
    $password = clean_input($_POST['password']);

    if (empty($firstname)) {
        $firstnameErr = 'First name is required';
    } else if (!preg_match('/^[a-zA-Z\s]+$/', $firstname)) {
        $firstnameErr = 'First name must contain letters and spaces only';
    }

    if (empty($lastname)) {
        $lastnameErr = 'Last name is required';
    } else if (!preg_match('/^[a-zA-Z\s]+$/', $lastname)) {
        $lastnameErr = 'Last name must contain letters and spaces only';
    }

    if (empty($middlename)) {
        $middlenameErr = 'Middle name is required';
    }

    if (empty($gender)) {
        $genderErr = "Gender is required";
    }

    if (empty($birthdate)) {
        $birthdateErr = 'Birthdate is required';
    }

    if (empty($contact_number)) {
        $contact_numberErr = 'Contact number is required';
    } else if (!preg_match('/^[0-9]+$/', $contact_number)) {
        $contact_numberErr = 'Contact number must contain numbers only';
    }

    if (empty($email)) {
        $emailErr = 'Email is required';
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = 'Invalid email format';
    }

    if (empty($password)) {
        $passwordErr = 'Password is required';
    } else if (strlen($password) < 8) {
        $passwordErr = 'Password must be at least 8 characters';
    } else if (!preg_match('/[A-Z]/', $password)) {
        $passwordErr = 'Password must contain at least one uppercase letter';
    } else if (!preg_match('/[a-z]/', $password)) {
        $passwordErr = 'Password must contain at least one lowercase letter';
    } else if (!preg_match('/[0-9]/', $password)) {
        $passwordErr = 'Password must contain at least one number';
    }

    if (empty($firstnameErr) && empty($lastnameErr) && empty($middlenameErr) && empty($genderErr) && empty($birthdateErr) && empty($contact_numberErr) && empty($emailErr) && empty($passwordErr)) {
        $accountObj->firstname = $firstname;
        $accountObj->lastname = $lastname;
        $accountObj->middlename = $middlename;
        $accountObj->gender = $gender;
        $accountObj->birthdate = $birthdate;
        $accountObj->contact_number = $contact_number;
        $accountObj->email = $email;
        $accountObj->password = $password;

        $result = $accountObj->signup();

        echo json_encode($result);
        exit();

    } else {

        echo json_encode(['status' => 'error', 'message' => 'Invalid input', 'errors' => ['firstname' => $firstnameErr, 'lastname' => $lastnameErr, 'middlename' => $middlenameErr, 'gender' => $genderErr, 'birthdate' => $birthdateErr, 'contact_number' => $contact_numberErr, 'email' => $emailErr, 'password' => $passwordErr]]);
        exit();

    }
}