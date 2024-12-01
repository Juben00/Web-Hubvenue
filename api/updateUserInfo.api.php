<?php
require_once '../sanitize.php';
require_once '../classes/account.class.php';

session_start();

$accountObj = new Account();

$userId = $_SESSION['user']['id'];
$firstname = $lastname = $middlename = $bio = $sex = $birthdate = $address = $email = $contact = $profile_img = "";
$firstnameErr = $lastnameErr = $middlenameErr = $bioErr = $sexErr = $birthdateErr = $addressErr = $emailErr = $contactErr = $profile_imgErr = "";

$uploadDir = '/profile_image_uploads/';
$allowedType = ['jpg', 'jpeg', 'png'];

$accountObj = new Account();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user']['id'];

    $firstname = clean_input($_POST['firstname']);
    $lastname = clean_input($_POST['lastname']);
    $middlename = clean_input($_POST['middlename']);
    $bio = clean_input($_POST['bio']);
    $sex = clean_input($_POST['sex']);
    $birthdate = clean_input($_POST['birthdate']);
    $address = clean_input($_POST['address']);
    $email = clean_input($_POST['email']);
    $contact = clean_input($_POST['contact']);

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
    $uploadedImages = [];

    if (empty($_FILES['profile_image']['name'][0])) {
        $profile_imgErr = "Profile image is required";
    } else {
        foreach ($_FILES['profile_image']['name'] as $key => $image) {
            $imageFileType = strtolower(pathinfo($image, PATHINFO_EXTENSION));

            // Validate each image
            if (!in_array($imageFileType, $allowedType)) {
                $imageErr[] = "File " . $_FILES['profile_image']['name'][$key] . " has an invalid format. Only jpg, jpeg, and png are allowed.";
            } else {
                // Generate a unique target path for each image
                $targetImage = $uploadDir . uniqid() . '.' . $imageFileType;

                // Move the uploaded file to the target directory
                if (move_uploaded_file($_FILES['profile_image']['tmp_name'][$key], '..' . $targetImage)) {
                    $uploadedImages[] = $targetImage;
                } else {
                    $imageErr[] = "Failed to upload image: " . $_FILES['venue_images']['name'][$key];
                }
            }
        }
    }

    if (empty($firstnameErr) && empty($lastnameErr) && empty($middlenameErr) && empty($sexErr) && empty($birthdateErr) && empty($addressErr) && empty($emailErr) && empty($contactErr)) {
        // Use the first uploaded image if available, otherwise set a default or null
        $profileImage = !empty($uploadedImages) ? $uploadedImages[0] : null;

        // Update user info
        $result = $accountObj->updateUserInfo($userId, $firstname, $lastname, $middlename, $bio, $sex, $birthdate, $address, $email, $contact, $profileImage);

        if ($result['status'] === 'success') {
            echo json_encode(['status' => 'success', 'message' => $result['message']]);
        } else {
            echo json_encode(['status' => 'error', 'message' => $result['message']]);
        }
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
                $contactErr
            ]))
        ]);
    }
}
?>