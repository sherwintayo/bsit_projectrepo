<?php
require_once('../config.php');
require 'vendor/autoload.php'; // Include PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

Class Users extends DBConnection {
	private $settings;
	public function __construct(){
		global $_settings;
		$this->settings = $_settings;
		parent::__construct();
	}
	public function __destruct(){
		parent::__destruct();
	}
	public function save_users(){
		if(!isset($_POST['status']) && $this->settings->userdata('login_type') == 1){
			$_POST['status'] = 1;
			$_POST['type'] = 2;
		}
		extract($_POST);
		$oid = $id;
		$data = '';
		if(isset($oldpassword)){
			if(md5($oldpassword) != $this->settings->userdata('password')){
				return 4;
			}
		}
		$chk = $this->conn->query("SELECT * FROM `users` where username ='{$username}' ".($id>0? " and id!= '{$id}' " : ""))->num_rows;
		if($chk > 0){
			return 3;
			exit;
		}
		foreach($_POST as $k => $v){
			if(in_array($k,array('firstname','middlename','lastname','username','type'))){
				if(!empty($data)) $data .=" , ";
				$data .= " {$k} = '{$v}' ";
			}
		}
		if(!empty($password)){
			$password = md5($password);
			if(!empty($data)) $data .=" , ";
			$data .= " `password` = '{$password}' ";
		}

		if(empty($id)){
			$qry = $this->conn->query("INSERT INTO users set {$data}");
			if($qry){
				$id = $this->conn->insert_id;
				$this->settings->set_flashdata('success','User Details successfully saved.');
				$resp['status'] = 1;
			}else{
				$resp['status'] = 2;
			}

		}else{
			$qry = $this->conn->query("UPDATE users set $data where id = {$id}");
			if($qry){
				$this->settings->set_flashdata('success','User Details successfully updated.');
				if($id == $this->settings->userdata('id')){
					foreach($_POST as $k => $v){
						if($k != 'id'){
							if(!empty($data)) $data .=" , ";
							$this->settings->set_userdata($k,$v);
						}
					}
					
				}
				$resp['status'] = 1;
			}else{
				$resp['status'] = 2;
			}
			
		}
		
		if(isset($_FILES['img']) && $_FILES['img']['tmp_name'] != ''){
			$fname = 'uploads/avatar-'.$id.'.png';
			$dir_path =base_app. $fname;
			$upload = $_FILES['img']['tmp_name'];
			$type = mime_content_type($upload);
			$allowed = array('image/png','image/jpeg');
			if(!in_array($type,$allowed)){
				$resp['msg'].=" But Image failed to upload due to invalid file type.";
			}else{
				$new_height = 200; 
				$new_width = 200; 
		
				list($width, $height) = getimagesize($upload);
				$t_image = imagecreatetruecolor($new_width, $new_height);
				imagealphablending( $t_image, false );
				imagesavealpha( $t_image, true );
				$gdImg = ($type == 'image/png')? imagecreatefrompng($upload) : imagecreatefromjpeg($upload);
				imagecopyresampled($t_image, $gdImg, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
				if($gdImg){
						if(is_file($dir_path))
						unlink($dir_path);
						$uploaded_img = imagepng($t_image,$dir_path);
						imagedestroy($gdImg);
						imagedestroy($t_image);
				}else{
				$resp['msg'].=" But Image failed to upload due to unkown reason.";
				}
			}
			if(isset($uploaded_img)){
				$this->conn->query("UPDATE users set `avatar` = CONCAT('{$fname}','?v=',unix_timestamp(CURRENT_TIMESTAMP)) where id = '{$id}' ");
				if($id == $this->settings->userdata('id')){
						$this->settings->set_userdata('avatar',$fname);
				}
			}
		}
		if(isset($resp['msg']))
		$this->settings->set_flashdata('success',$resp['msg']);
		return  $resp['status'];
	}
	public function delete_users(){
		extract($_POST);
		$avatar = $this->conn->query("SELECT avatar FROM users where id = '{$id}'")->fetch_array()['avatar'];
		$qry = $this->conn->query("DELETE FROM users where id = $id");
		if($qry){
			$avatar = explode("?",$avatar)[0];
			$this->settings->set_flashdata('success','User Details successfully deleted.');
			if(is_file(base_app.$avatar))
				unlink(base_app.$avatar);
			$resp['status'] = 'success';
		}else{
			$resp['status'] = 'failed';
		}
		return json_encode($resp);
	}
	public function save_student(){
		extract($_POST);
		$data = '';
		if(isset($oldpassword)){
			if(md5($oldpassword) != $this->settings->userdata('password')){
				return json_encode(array("status"=>'failed',
										 "msg"=>'Old Password is Incorrect'));
			}
		}
		$chk = $this->conn->query("SELECT * FROM `student_list` where email ='{$email}' ".($id>0? " and id!= '{$id}' " : ""))->num_rows;
		if($chk > 0){
			return 3;
			exit;
		}
		foreach($_POST as $k => $v){
			if(!in_array($k,array('id','oldpassword','cpassword','password'))){
				if(!empty($data)) $data .=" , ";
				$data .= " {$k} = '{$v}' ";
			}
		}
		if(!empty($password)){
			$password = md5($password);
			if(!empty($data)) $data .=" , ";
			$data .= " `password` = '{$password}' ";
		}
		
		if(empty($id)){
			$qry = $this->conn->query("INSERT INTO student_list set {$data}");
			if($qry){
				$id = $this->conn->insert_id;
				$this->settings->set_flashdata('success','Student User Details successfully saved.');
				$resp['status'] = "success";
			}else{
				$resp['status'] = "failed";
				$resp['msg'] = "An error occurred while saving the data. Error: ". $this->conn->error;
			}

		}else{
			$qry = $this->conn->query("UPDATE student_list set $data where id = {$id}");
			if($qry){
				$this->settings->set_flashdata('success','Student User Details successfully updated.');
				if($id == $this->settings->userdata('id')){
					foreach($_POST as $k => $v){
						if($k != 'id'){
							if(!empty($data)) $data .=" , ";
							$this->settings->set_userdata($k,$v);
						}
					}
					
				}
				$resp['status'] = "success";
			}else{
				$resp['status'] = "failed";
				$resp['msg'] = "An error occurred while saving the data. Error: ". $this->conn->error;
			}
			
		}
		
		if(isset($_FILES['img']) && $_FILES['img']['tmp_name'] != ''){
			$fname = 'uploads/student-'.$id.'.png';
			$dir_path =base_app. $fname;
			$upload = $_FILES['img']['tmp_name'];
			$type = mime_content_type($upload);
			$allowed = array('image/png','image/jpeg');
			if(!in_array($type,$allowed)){
				$resp['msg'].=" But Image failed to upload due to invalid file type.";
			}else{
				$new_height = 200; 
				$new_width = 200; 
		
				list($width, $height) = getimagesize($upload);
				$t_image = imagecreatetruecolor($new_width, $new_height);
				imagealphablending( $t_image, false );
				imagesavealpha( $t_image, true );
				$gdImg = ($type == 'image/png')? imagecreatefrompng($upload) : imagecreatefromjpeg($upload);
				imagecopyresampled($t_image, $gdImg, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
				if($gdImg){
						if(is_file($dir_path))
						unlink($dir_path);
						$uploaded_img = imagepng($t_image,$dir_path);
						imagedestroy($gdImg);
						imagedestroy($t_image);
				}else{
				$resp['msg'].=" But Image failed to upload due to unkown reason.";
				}
			}
			if(isset($uploaded_img)){
				$this->conn->query("UPDATE student_list set `avatar` = CONCAT('{$fname}','?v=',unix_timestamp(CURRENT_TIMESTAMP)) where id = '{$id}' ");
				if($id == $this->settings->userdata('id')){
						$this->settings->set_userdata('avatar',$fname);
				}
			}
		}
		
		return  json_encode($resp);
	}
	public function delete_student(){
		extract($_POST);
		$avatar = $this->conn->query("SELECT avatar FROM student_list where id = '{$id}'")->fetch_array()['avatar'];
		$qry = $this->conn->query("DELETE FROM student_list where id = $id");
		if($qry){
			$avatar = explode("?",$avatar)[0];
			$this->settings->set_flashdata('success','Student User Details successfully deleted.');
			if(is_file(base_app.$avatar))
				unlink(base_app.$avatar);
			$resp['status'] = 'success';
		}else{
			$resp['status'] = 'failed';
		}
		return json_encode($resp);
	}
	public function verify_student(){
		extract($_POST);
		$update = $this->conn->query("UPDATE `student_list` set `status` = 1 where id = $id");
		if($update){
			$this->settings->set_flashdata('success','Student Account has verified successfully.');
			$resp['status'] = 'success';
		}else{
			$resp['status'] = 'failed';
		}
		return json_encode($resp);
	}

	public function forgot_password() {
        // Extract email from the POST data
        $email = isset($_POST['email']) ? $_POST['email'] : '';

        // Check if the email is not empty
        if (empty($email)) {
            return json_encode(['status' => 'error', 'msg' => 'Email address is required']);
        }

        // Check if the email exists in the database
        $qry = $this->conn->query("SELECT * FROM `student_list` WHERE email = '{$email}'");
        if ($qry->num_rows > 0) {
            $user = $qry->fetch_assoc();
            $token = bin2hex(random_bytes(50));
            $expires = date("U") + 1800; // 30 minutes

            // Delete any existing reset requests for this email
            $this->conn->query("DELETE FROM `password_resets` WHERE email = '{$email}'");
            // Insert the new reset request
            $this->conn->query("INSERT INTO `password_resets` (`email`, `token`, `expires_at`) VALUES ('{$email}', '{$token}', '{$expires}')");

            // Create the reset URL
            $url = base_url . "reset_password.php?token=" . $token;

            // Send the email using PHPMailer
            $mail = new PHPMailer(true);
            try {
                //Server settings
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com'; // Set the SMTP server to send through
                $mail->SMTPAuth = true;
                $mail->Username = 'your-email@gmail.com'; // Your Gmail address
                $mail->Password = 'your-email-password'; // Your Gmail password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                //Recipients
                $mail->setFrom('your-email@gmail.com', 'Mailer');
                $mail->addAddress($email); // Add a recipient

                // Content
                $mail->isHTML(true);
                $mail->Subject = 'Password Reset Request';
                $mail->Body    = "We received a password reset request. The link to reset your password is below. If you did not make this request, you can ignore this email.<br><br>Here is your password reset link:<br><a href='$url'>$url</a>";
                $mail->AltBody = "We received a password reset request. The link to reset your password is below. If you did not make this request, you can ignore this email.\n\nHere is your password reset link:\n$url";

                $mail->send();
                return json_encode(['status' => 'success']);
            } catch (Exception $e) {
                return json_encode(['status' => 'error', 'msg' => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"]);
            }
        } else {
            return json_encode(['status' => 'error', 'msg' => 'No account found with that email']);
        }
    }


	public function reset_password() {
		extract($_POST);
	
		$qry = $this->conn->query("SELECT * FROM `password_resets` WHERE token = '{$token}'");
		if ($qry->num_rows > 0) {
			$reset = $qry->fetch_assoc();
			$email = $reset['email'];
			$expires = $reset['expires_at'];
	
			if (time() > $expires) {
				return json_encode(['status' => 'error', 'msg' => 'The reset link has expired']);
			}
	
			$password = md5($password);
			$this->conn->query("UPDATE `student_list` SET password = '{$password}' WHERE email = '{$email}'");
			$this->conn->query("DELETE FROM `password_resets` WHERE email = '{$email}'");
	
			return json_encode(['status' => 'success']);
		} else {
			return json_encode(['status' => 'error', 'msg' => 'Invalid reset token']);
		}
	}
	
	
}

$users = new users();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
switch ($action) {
    case 'save':
        echo $users->save_users();
    break;
    case 'delete':
        echo $users->delete_users();
    break;
    case 'save_student':
        echo $users->save_student();
    break;
    case 'delete_student':
        echo $users->delete_student();
    break;
    case 'verify_student':
        echo $users->verify_student();
    break;
    case 'forgot_password':
        echo $users->forgot_password();
    break;
    default:
        // echo $sysset->index();
    break;
}
?>