<?php
include 'config.php';
require 'vendor/autoload.php'; // pastikan sudah download PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name     = $_POST['name'];
    $email    = $_POST['email'];
    $address  = $_POST['address'];
    $phone    = $_POST['phone'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $code     = rand(100000, 999999);

    $stmt = $conn->prepare("INSERT INTO users (name, email, address, phone, username, password, verification_code) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $name, $email, $address, $phone, $username, $password, $code);

    if ($stmt->execute()) {
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'aldikeyfa@gmail.com';
        $mail->Password = 'xbdt lucc jxcp jsnb';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('yourgmail@gmail.com', 'Verification System');
        $mail->addAddress($email);
        $mail->Subject = 'Email Verification Code';
        $mail->Body    = 'Your verification code is: ' . $code;

        if ($mail->send()) {
            echo "Verification email sent. Please <a href='verify.php?email=$email'>verify your account</a>";
        } else {
            echo "Failed to send verification email.";
        }
    } else {
        echo "Registration failed.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Auth System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
        }
        .form-container {
            max-width: 500px;
            margin: 40px auto;
        }
    </style>
</head>
<body>

<div class="container">

    <!-- Register Form -->
    <div class="form-container">
        <div class="card shadow-sm">
            <div class="card-body">
                <h4 class="card-title text-center mb-4">Register</h4>
                <form method="post" action="register.php">
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Full Name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <textarea name="address" class="form-control" placeholder="Address" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" placeholder="Phone" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" placeholder="Username" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Register</button>
                    <p class="mt-2">
                        <small>Jika sudah memiliki akun, silahkan <a href="login.php">Login</a>.</small>
                    </p>
                </form>
            </div>
        </div>
    </div>

</div>

</body>
</html>
