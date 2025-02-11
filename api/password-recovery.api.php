<?php
require_once(__DIR__ . '/../classes/account.class.php');
require_once(__DIR__ . '/../vendor/autoload.php');

$accountObj = new Account();

$email = $emailErr = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['recoveryEmail'];

    if (empty($email)) {
        $emailErr = "Email is required";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format";
    }

    if (empty($emailErr)) {
        try {
            $token = bin2hex(random_bytes(32));
            $expiry = date("Y-m-d H:i:s", strtotime("+1 hour"));

            $verify = $accountObj->createPasswordRecoveryToken($email, $token, $expiry);

            // Always return a generic message
            if ($verify['status'] === 'success') {
                try {
                    sendPasswordRecoveryEmail($email, $token);
                } catch (Exception $e) {
                    error_log($e->getMessage());
                }
            }
            echo json_encode(['status' => 'success', 'message' => 'If the email exists, a recovery link has been sent.']);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => 'An error occurred. Please try again later.']);
        }
    } else {
        echo json_encode(['error' => $emailErr]);
    }
}

function sendPasswordRecoveryEmail($email, $token)
{
    $mail = new PHPMailer\PHPMailer\PHPMailer();

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = "hubvenue2@gmail.com";
        $mail->Password = "qnir vrmg knrc hhzh";
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('hubvenue2@gmail.com', 'HubVenue');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Account Recovery';
        $mail->Body = "
        <html>
        <head>
            <style>
                .verify-link {
                    display: inline-block;
                    padding: 10px 20px;
                    font-size: 16px;
                    color: white;
                    background-color: #007BFF;
                    text-decoration: none;
                    border-radius: 5px;
                    transition: background-color 0.3s;
                }
                .verify-link:hover {
                    background-color: #0056b3;
                }
            </style>
        </head>
        <body>
            <p>Click the button below to verify your email address:</p>
            <a class='verify-link' href='http://localhost/hubvenue/reset-password.php?token=$token'>Recover Account</a>
        </body>
        </html>
        ";

        if (!$mail->send()) {
            throw new Exception($mail->ErrorInfo);
        }

        return ['status' => 'success', 'message' => 'Passwrord recovery email sent.'];
    } catch (Exception $e) {
        throw new Exception("Failed to send email: " . $e->getMessage());
    }
}
?>