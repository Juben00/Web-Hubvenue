<?php

require_once(__DIR__ . '/../vendor/autoload.php');
function sendEmail($email, $context, $content)
{
    $mail = new PHPMailer\PHPMailer\PHPMailer();

    try {
        switch ($context) {
            case 'Email Verification':
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
                    <a class='verify-link' href='$content'>Verify Email</a>
                </body>
                </html>
                ";
                break;
            case 'Booking Confirmation':
                $mail->Body = "
                <html>
                <head>
                    <style>
                        .booking-details {
                            display: inline-block;
                            padding: 10px 20px;
                            font-size: 16px;
                            color: white;
                            background-color: #007BFF;
                            text-decoration: none;
                            border-radius: 5px;
                            transition: background-color 0.3s;
                        }
                        .booking-details:hover {
                            background-color: #0056b3;
                        }
                    </style>
                </head>
                <body>
                    <p>Your booking has been confirmed. Click the button below to view the details:</p>
                    <a class='booking-details' href='$content'>View Booking</a>
                </body>
                </html>
                ";
                break;
            case "Booking Rejection":
                $mail->Body = "
                <html>
                <head>
                    <style>
                        .booking-rejection {
                            display: inline-block;
                            padding: 10px 20px;
                            font-size: 16px;
                            color: white;
                            background-color: #007BFF;
                            text-decoration: none;
                            border-radius: 5px;
                            transition: background-color 0.3s;
                        }
                        .booking-rejection:hover {
                            background-color: #0056b3;
                        }
                    </style>
                </head>
                    <body>
                        <p>Your booking has been rejected. Click the button below to view the details:</p>
                        <a class='booking-rejection' href='$content'>View Booking</a>
                    </body>
                </html>
                ";
                break;
            case "Payment Confirmation":
                $mail->Body = "
                <html>
                <head>
                    <style>
                        .payment-details {
                            display: inline-block;
                            padding: 10px 20px;
                            font-size: 16px;
                            color: white;
                            background-color: #007BFF;
                            text-decoration: none;
                            border-radius: 5px;
                            transition: background-color 0.3s;
                        }
                        .payment-details:hover {
                            background-color: #0056b3;
                        }
                    </style>
                </head>
                <body>
                    <p>Your payment has been confirmed. Click the button below to view the details:</p>
                    <a class='payment-details' href='$content'>View Payment</a>
                </body>
                </html>
                ";
                break;
        }

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


        if (!$mail->send()) {
            throw new Exception($mail->ErrorInfo);
        }

        return true;
    } catch (Exception $e) {
        throw new Exception("Failed to send email: " . $e->getMessage());
    }
}
?>