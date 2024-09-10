<?php
require_once 'vendor/autoload.php'; // Composer's autoloader

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true); // If this works, PHPMailer is being autoloaded properly.

echo "PHPMailer is successfully autoloaded.";

?>