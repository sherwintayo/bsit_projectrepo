<?php

require_once('./config.php'); // Include config for DB connection

$email = $_POST["email"];

// Generate token and hash it
$token = bin2hex(random_bytes(16));
$token_hash = hash("sha256", $token);
$expiry = date("Y-m-d H:i:s", time() + 60 * 30); // Token expires in 30 minutes

// Update the user's reset token hash and expiry in the database
$sql = "UPDATE student_list
        SET reset_token_hash = ?,
            reset_token_expires_at = ?
        WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $token_hash, $expiry, $email);
$stmt->execute();

// Check if any rows were affected (i.e., email was found and updated)
if ($conn->affected_rows) {

    // Include the mailer and get the initialized mail object
    $mail = base_url . "/mailer.php";

    // Set mail properties
    $mail->setFrom("noreply@example.com", "Your App Name"); // Update this as needed
    $mail->addAddress($email);
    $mail->Subject = "Password Reset";

    // Use double quotes to parse the token in the message
    $mail->Body = <<<END
    Click <a href="<?php echo base_url ?>/reset-password.php?token=$token">here</a> to reset your password.
    END;

    try {
        // Attempt to send the email
        $mail->send();
        echo "Password reset email sent. Please check your inbox.";
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer error: {$mail->ErrorInfo}";
    }

} else {
    echo "No account found with that email.";
}

?>
