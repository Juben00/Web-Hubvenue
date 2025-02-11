<?php

require_once(__DIR__ . '/../vendor/autoload.php');
function sendVerificationEmail($email, $token)
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
        $mail->Subject = 'Email Verification';
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
            <a class='verify-link' href='http://localhost/hubvenue/api/VerifyEmail.api.php?token=$token'>Verify Email</a>
        </body>
        </html>
        ";

        if (!$mail->send()) {
            throw new Exception($mail->ErrorInfo);
        }

        return true;
    } catch (Exception $e) {
        throw new Exception("Failed to send email: " . $e->getMessage());
    }
}
?>