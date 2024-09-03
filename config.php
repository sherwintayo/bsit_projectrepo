<?php
ob_start();
ini_set('date.timezone','Asia/Manila');
date_default_timezone_set('Asia/Manila');
session_start();

// Set secure session parameters
ini_set('session.cookie_httponly', 1); // Prevent JavaScript access to session cookies
ini_set('session.cookie_secure', isset($_SERVER['HTTPS'])); // Ensure cookies are sent over HTTPS
ini_set('session.use_strict_mode', 1); // Use strict session mode

require_once('initialize.php');
require_once('classes/DBConnection.php');
require_once('classes/SystemSettings.php');
// require_once('vendor/autoload.php');

$db = new DBConnection;
$conn = $db->conn;

// Function to redirect with proper escaping
function redirect($url=''){
    if(!empty($url))
        echo '<script>location.href="'.htmlspecialchars(base_url . $url, ENT_QUOTES, 'UTF-8').'";</script>';
}

// Function to validate images securely
function validate_image($file){
    if(!empty($file)){
        $ex = explode('?',$file);
        $file = $ex[0];
        $param =  isset($ex[1]) ? '?'.$ex[1]  : '';
        if(is_file(base_app.$file)){
            return base_url.htmlspecialchars($file, ENT_QUOTES, 'UTF-8').$param;
        } else {
            return base_url.'dist/img/no-image-available.png';
        }
    } else {
        return base_url.'dist/img/no-image-available.png';
    }
}

// Function to detect mobile devices
function isMobileDevice(){
    $aMobileUA = array(
        '/iphone/i' => 'iPhone', 
        '/ipod/i' => 'iPod', 
        '/ipad/i' => 'iPad', 
        '/android/i' => 'Android', 
        '/blackberry/i' => 'BlackBerry', 
        '/webos/i' => 'Mobile'
    );

    // Return true if Mobile User Agent is detected
    foreach($aMobileUA as $sMobileKey => $sMobileOS){
        if(preg_match($sMobileKey, $_SERVER['HTTP_USER_AGENT'])){
            return true;
        }
    }
    // Otherwise return false..  
    return false;
}

// CSRF Token Generation
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Implement login attempts tracking
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
}
if (!isset($_SESSION['last_login_attempt'])) {
    $_SESSION['last_login_attempt'] = time();
}

// Secure session ID regeneration
if (empty($_SESSION['session_regenerated'])) {
    session_regenerate_id(true);
    $_SESSION['session_regenerated'] = time();
} elseif (time() - $_SESSION['session_regenerated'] > 300) { // Regenerate session ID every 5 minutes
    session_regenerate_id(true);
    $_SESSION['session_regenerated'] = time();
}

ob_end_flush();
?>
