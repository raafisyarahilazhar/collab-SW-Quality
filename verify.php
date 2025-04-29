<?php
include 'config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $code = $_POST['code'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email=? AND verification_code=?");
    $stmt->bind_param("ss", $email, $code);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $conn->query("UPDATE users SET is_verified = 1 WHERE email='$email'");
        echo "Account verified. You can now <a href='login.php'>Login</a>";
    } else {
        echo "Invalid code or email.";
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

    <!-- Verification Form -->
    <div class="form-container">
        <div class="card shadow-sm">
            <div class="card-body">
                <h4 class="card-title text-center mb-4">Email Verification</h4>
                <form method="post" action="verify.php">
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Your Email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Verification Code</label>
                        <input type="text" name="code" class="form-control" placeholder="Verification Code" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Verify</button>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>
