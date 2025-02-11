<?php
require_once(__DIR__ . '/classes/account.class.php');

$accountObj = new Account();

$user = $accountObj->getUserByToken($_GET['token']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Recovery</title>
    <link rel="icon" href="./images/black_ico.png">
    <link rel="stylesheet" href="./output.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            width: 100%;
            background-image: url('images/serviceimages/pass-recovery-bg.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
    </style>
</head>

<body>

    <?php

    include_once './components/feedback.modal.html';
    include_once './components/confirm.feedback.modal.html';

    ?>
    <div class="bg-white rounded-lg p-8 max-w-lg w-full mx-4 relative shadow-2xl">
        <!-- Logo -->
        <div class="text-center flex justify-center">
            <img src="./images/black_ico.png" alt="HubVenue_Logo" class="h-[120px]" />
        </div>
        <div class="w-full">
            <form id="passResetForm" class="space-y-4">
                <div class="flex-1 py-2 px-4 text-center text-gray-500 font-semibold relative z-10 text-lg">
                    <h1>Reset Password</h1>
                </div>
                <div class="flex-1 py-2 mt-2 px-4 text-center text-gray-800 font-semibold relative z-10 text-xl">
                    <h1>Welcome back, <?php echo htmlspecialchars($user['firstname']) ?>!</h1>
                </div>
                <div>
                    <label for="newpass" class="block text-md font-medium text-gray-700">New Password</label>
                    <input type="hidden" name="token" id="token" value="<?php echo $_GET['token'] ?>">
                    <input type="password" name="newpass" id="newpass"
                        class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>
                <button type="submit"
                    class="w-full py-2 px-4 duration-150 border border-transparent rounded-md shadow-sm text-md font-medium text-white bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Reset Password
                </button>
            </form>
        </div>
    </div>

    <script src="./vendor/jQuery-3.7.1/jquery-3.7.1.min.js"></script>
    <script src="./js/user.jquery.js"></script>
</body>

</html>