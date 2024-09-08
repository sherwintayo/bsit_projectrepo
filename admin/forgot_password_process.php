<?php
// Include config and necessary libraries
require_once '../config.php';
require_once '../vendor/phpmailer/src/PHPMailer.php';
require_once '../vendor/phpmailer/src/SMTP.php';
require_once '../vendor/phpmailer/src/Exception.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    // Check if the email exists
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        // Generate reset token and expiry
        $token = bin2hex(random_bytes(16));
        $token_hash = hash("sha256", $token);
        $expiry = date("Y-m-d H:i:s", time() + 60 * 30); // 30-minute expiry

        // Update user record with the token and expiry
        $sql = "UPDATE users SET reset_token_hash = ?, reset_token_expires_at = ? WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $token_hash, $expiry, $email);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            // Send reset email
            $reset_link = base_url . "reset_password.php?token=$token";
            
            $mail = new PHPMailer\PHPMailer\PHPMailer();
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com'; // Your SMTP host
                $mail->SMTPAuth = true;
                $mail->Username = 'your-email@gmail.com'; // Your email
                $mail->Password = 'your-password'; // Your email password
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                $mail->setFrom('noreply@mccbsitrepositories.com', 'MCC IT Repository');
                $mail->addAddress($email);

                $mail->isHTML(true);
                $mail->Subject = 'Password Reset';
                $mail->Body = "Click <a href='$reset_link'>here</a> to reset your password. The link will expire in 30 minutes.";

                $mail->send();
                echo json_encode(['status' => 'success', 'msg' => 'Reset link sent to your email']);
            } catch (Exception $e) {
                echo json_encode(['status' => 'error', 'msg' => 'Email could not be sent.']);
            }
        }
    } else {
        echo json_encode(['status' => 'error', 'msg' => 'Email not found']);
    }
}
?>
