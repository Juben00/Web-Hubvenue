<?php
require_once '../classes/account.class.php';
require_once '../sanitize.php';

$accountObj = new Account();

session_start();

$fullname = $address = $birthdate = $idOne_type = $idOne_url = $idTwo_type = $idTwo_url = "";
$fullnameErr = $addressErr = $birthdateErr = $idOne_typeErr = $idOne_urlErr = $idTwo_typeErr = $idTwo_urlErr = "";
$uploadDir = '/host_id_image/';
$allowedType = ['jpg', 'jpeg', 'png'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullname = clean_input($_POST['fullName']);
    $address = clean_input($_POST['address']);
    $birthdate = clean_input($_POST['birthdate']);
    // Check if idType and idType2 are set before trying to access them
    $idOne_type = isset($_POST['idType']) ? clean_input($_POST['idType']) : '';
    $idTwo_type = isset($_POST['idType2']) ? clean_input($_POST['idType2']) : '';

    // Validate Full Name
    if (empty($fullname)) {
        $fullnameErr = 'Full name is required';
    }

    // Validate Address
    if (empty($address)) {
        $addressErr = 'Address is required';
    }

    // Validate Birthdate
    if (empty($birthdate)) {
        $birthdateErr = 'Birthdate is required';
    }
    // Validate ID Types
    if (empty($idOne_type)) {
        $idOne_typeErr = 'ID type is required';
    }
    if (empty($idTwo_type)) {
        $idTwo_typeErr = 'ID type is required';
    }

    // Validate and Upload ID Image 1
    if (empty($_FILES['idImage']['name'])) {
        $idOne_urlErr = 'Please provide an image for ID card 1.';
    } else {
        $imgOne = $_FILES['idImage']['name'];
        $imageFileType = strtolower(pathinfo($imgOne, PATHINFO_EXTENSION));

        if (!in_array($imageFileType, $allowedType)) {
            $idOne_urlErr = "File " . $imgOne . " has an invalid format. Only jpg, jpeg, and png are allowed.";
        } else {
            $targetImage = $uploadDir . uniqid() . '.' . $imageFileType;
            if (move_uploaded_file($_FILES['idImage']['tmp_name'], '..' . $targetImage)) {
                $idOne_url = $targetImage;
            } else {
                $idOne_urlErr = "Failed to upload image: " . $imgOne;
            }
        }
    }

    // Validate and Upload ID Image 2
    if (empty($_FILES['idImage2']['name'])) {
        $idTwo_urlErr = 'Please provide an image for ID card 2.';
    } else {
        $imgTwo = $_FILES['idImage2']['name'];
        $imageFileType = strtolower(pathinfo($imgTwo, PATHINFO_EXTENSION));

        if (!in_array($imageFileType, $allowedType)) {
            $idTwo_urlErr = "File " . $imgTwo . " has an invalid format. Only jpg, jpeg, and png are allowed.";
        } else {
            $targetImage = $uploadDir . uniqid() . '.' . $imageFileType;
            if (move_uploaded_file($_FILES['idImage2']['tmp_name'], '..' . $targetImage)) {
                $idTwo_url = $targetImage;
            } else {
                $idTwo_urlErr = "Failed to upload image: " . $imgTwo;
            }
        }
    }


    // Check for errors and proceed with upgrading user
    if (empty($fullnameErr) && empty($addressErr) && empty($birthdateErr) && empty($idOne_typeErr) && empty($idOne_urlErr) && empty($idTwo_typeErr) && empty($idTwo_urlErr)) {
        $accountObj->userId = $_SESSION['user']['id'];
        $accountObj->fullname = $fullname;
        $accountObj->address = $address;
        $accountObj->birthdate = $birthdate;
        $accountObj->idOne_type = $idOne_type;
        $accountObj->idOne_url = $idOne_url;
        $accountObj->idTwo_type = $idTwo_type;
        $accountObj->idTwo_url = $idTwo_url;

        $result = $accountObj->upgradeUser();

        if ($result['status'] == 'success') {
            echo json_encode(['status' => 'success', 'message' => $result['message']]);
        } else {
            echo json_encode(['status' => 'error', 'message' => $result['message']]);
        }
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => implode('<br>', array_filter([
                $fullnameErr,
                $addressErr,
                $birthdateErr,
                $idOne_typeErr,
                $idOne_urlErr,
                $idTwo_typeErr,
                $idTwo_urlErr
            ]))
        ]);
    }

}