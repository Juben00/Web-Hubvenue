<?php
require_once '../classes/account.class.php';
require_once '../sanitize.php';

session_start();
$accountObj = new Account();

$userId = $discount_type = $fullname = $discount_id = $card_image = '';
$userIdErr = $discount_typeErr = $fullnameErr = $discount_idErr = $card_imageErr = '';

$uploadDir = '/mandatory_discount_id/';
$allowedType = ['jpg', 'jpeg', 'png'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = clean_input($_SESSION['user']['id']);
    $discount_type = clean_input($_POST['discountType']);
    $fullname = clean_input($_POST['seniorPwdName']);
    $discount_id = clean_input($_POST['seniorPwdId']);
    $card_image = clean_input($_FILES['seniorPwdIdPhoto']['name']);

    // Validate inputs
    if (empty($discount_type)) {
        $discount_typeErr = 'Discount type is required';
    }
    if (empty($fullname)) {
        $fullnameErr = 'Full name is required';
    }

    $imageErr = [];
    $uploadedImage = null;

    if (empty($_FILES['seniorPwdIdPhoto']['name'])) {
        $imageErr[] = 'Profile image is required.';
    } else {
        $imageFileType = strtolower(pathinfo($_FILES['seniorPwdIdPhoto']['name'], PATHINFO_EXTENSION));

        // Validate the uploaded image
        if (!in_array($imageFileType, $allowedType)) {
            $imageErr[] = "File " . $_FILES['seniorPwdIdPhoto']['name'] . " has an invalid format. Only jpg, jpeg, and png are allowed.";
        } else {
            // Generate a unique target path for the image
            $targetImage = $uploadDir . uniqid() . '.' . $imageFileType;

            // Move the uploaded file to the target directory
            if (move_uploaded_file($_FILES['seniorPwdIdPhoto']['tmp_name'], '..' . $targetImage)) {
                $uploadedImage = $targetImage;
            } else {
                $imageErr[] = "Failed to upload image: " . $_FILES['seniorPwdIdPhoto']['name'];
            }
        }
    }

    if (empty($discount_typeErr) && empty($fullnameErr) && empty($card_imageErr) && empty($imageErr)) {
        $result = $accountObj->discountApplication($userId, $discount_type, $fullname, $discount_id, $uploadedImage);
        // if ($result) {
        //     echo json_encode(['status' => 'success', 'message' => $result['message']]);
        // } else {
        //     echo json_encode(['status' => 'error', 'message' => $result['message']]);
        // }
        echo json_encode($result);
        exit();
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => implode('<br>', array_filter([
                $userIdErr,
                $discount_typeErr,
                $fullnameErr,
                $discount_idErr,
                implode('<br>', $imageErr)
            ]))
        ]);
    }
}
?>