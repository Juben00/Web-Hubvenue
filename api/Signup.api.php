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
    $gender = clean_input($_POST['firstname']);
    $birthdate = clean_input($_POST['lastname']);
    $contact_number = clean_input($_POST['middlename']);
    $email = clean_input($_POST['lastname']);
    $password = clean_input($_POST['middlename']);
}