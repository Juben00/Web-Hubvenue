<?php
require_once '../sanitize.php';
require_once '../classes/account.class.php';
require_once './coorAddressVerify.api.php';

session_start();

$accountObj = new Account();

$userId = $_SESSION['user'];
$firstname = $lastname = $middlename = $bio = $sex = $birthdate = $address = $email = $contact = $profile_img = "";
$firstnameErr = $lastnameErr = $middlenameErr = $bioErr = $sexErr = $birthdateErr = $addressErr = $emailErr = $contactErr = $profile_imgErr = "";

$uploadDir = '/profile_image_uploads/';
$allowedType = ['jpg', 'jpeg', 'png'];

$accountObj = new Account();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $firstname = clean_input($_POST['firstname']);
    $lastname = clean_input($_POST['lastname']);
    $middlename = clean_input($_POST['middlename']);
    $bio = clean_input($_POST['bio']);
    $sex = clean_input($_POST['sex']);
    $birthdate = clean_input($_POST['birthdate']);
    $address = clean_input($_POST['address']);
    $coor = clean_input($_POST['addressCoor']);
    $email = clean_input($_POST['email']);
    $contact = clean_input($_POST['contact']);

    // Verify the address
    $addressData = coorAddressVerify($address, $coor);
    if (!$addressData) {
        $addressErr = 'Invalid address and coordinates. Please try again.';
    }

    if (empty($firstname))
        $firstnameErr = "First name is required";
    if (empty($lastname))
        $lastnameErr = "Last name is required";
    if (empty($middlename))
        $middlenameErr = "Middle name is required";
    if (empty($sex)) {
        $sexErr = "Sex is required";
    } else if ($sex == "Male") {
        $sex = 1;
    } else if ($sex == "Female") {
        $sex = 2;
    }
    if (empty($birthdate))
        $birthdateErr = "Birthdate is required";
    if (empty($address))
        $addressErr = "Address is required";
    if (empty($email))
        $emailErr = "Email is required";
    if (empty($contact))
        $contactErr = "Contact is required";

    $imageErr = [];
    $uploadedImage = null;

    if (empty($_FILES['profilePicture']['name'])) {
        $imageErr[] = 'Profile image is required.';
    } else {
        $imageFileType = strtolower(pathinfo($_FILES['profilePicture']['name'], PATHINFO_EXTENSION));

        // Validate the uploaded image
        if (!in_array($imageFileType, $allowedType)) {
            $imageErr[] = "File " . $_FILES['profilePicture']['name'] . " has an invalid format. Only jpg, jpeg, and png are allowed.";
        } else {
            // Generate a unique target path for the image
            $targetImage = $uploadDir . uniqid() . '.' . $imageFileType;

            // Move the uploaded file to the target directory
            if (move_uploaded_file($_FILES['profilePicture']['tmp_name'], '..' . $targetImage)) {
                $uploadedImage = $targetImage;
            } else {
                $imageErr[] = "Failed to upload image: " . $_FILES['profilePicture']['name'];
            }
        }
    }

    if (empty($firstnameErr) && empty($lastnameErr) && empty($middlenameErr) && empty($sexErr) && empty($birthdateErr) && empty($addressErr) && empty($emailErr) && empty($contactErr)) {
        // Use the uploaded image if available
        $profileImage = $uploadedImage;

        // Update user info
        $result = $accountObj->updateUserInfo($userId, $firstname, $lastname, $middlename, $bio ?? null, $sex, $birthdate, $coor, $email, $contact, $profileImage ?? null);

        // if ($result['status'] === 'success') {
        //     echo json_encode(['status' => 'success', 'message' => $result['message']]);
        // } else {
        //     echo json_encode(['status' => 'error', 'message' => $result['message']]);
        // }
        echo json_encode($result);
        exit();
    } else {
        // Return validation errors as JSON
        echo json_encode([
            'status' => 'error',
            'errors' => implode('<br>', array_filter([
                $firstnameErr,
                $lastnameErr,
                $middlenameErr,
                $sexErr,
                $birthdateErr,
                $addressErr,
                $emailErr,
                $contactErr,
                implode('<br>', $imageErr)
            ]))
        ]);
    }
}