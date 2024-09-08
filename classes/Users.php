<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('../config.php');

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
			$_POST['type'] = 1;
		}
		extract($_POST);
		$oid = $id;
		$data = '';
	
		// Get the current type from the database if an ID is provided
		if(isset($id) && $id > 0){
			$current_user = $this->conn->query("SELECT `type` FROM `users` WHERE `id` = '{$id}'");
			if($current_user->num_rows > 0){
				$current_type = $current_user->fetch_assoc()['type'];
			}
		}
	
		if(isset($oldpassword)){
			if(md5($oldpassword) != $this->settings->userdata('password')){
				return 4;
			}
		}
		$chk = $this->conn->query("SELECT * FROM `users` WHERE username ='{$username}' ".($id>0? " AND id!= '{$id}' " : ""))->num_rows;
		if($chk > 0){
			return 3;
			exit;
		}
	
		foreach($_POST as $k => $v){
			if(in_array($k, array('firstname','middlename','lastname','username','type'))){
				// Only update the type if it was changed in the form
				if($k == 'type' && isset($current_type) && $current_type == $v){
					continue; // Skip updating the type if it hasn't changed
				}
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
			$qry = $this->conn->query("INSERT INTO users SET {$data}");
			if($qry){
				$id = $this->conn->insert_id;
				$this->settings->set_flashdata('success','User Details successfully saved.');
				$resp['status'] = 1;
			} else {
				$resp['status'] = 2;
			}
		} else {
			$qry = $this->conn->query("UPDATE users SET $data WHERE id = {$id}");
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
			} else {
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
			} else {
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
				} else {
					$resp['msg'].=" But Image failed to upload due to unknown reason.";
				}
			}
			if(isset($uploaded_img)){
				$this->conn->query("UPDATE users SET `avatar` = CONCAT('{$fname}','?v=',unix_timestamp(CURRENT_TIMESTAMP)) WHERE id = '{$id}' ");
				if($id == $this->settings->userdata('id')){
					$this->settings->set_userdata('avatar',$fname);
				}
			}
		}
	
		if(isset($resp['msg']))
			$this->settings->set_flashdata('success',$resp['msg']);
		return $resp['status'];
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

	public function forgot_password_users() {
        if (!isset($_POST['email'])) {
            return json_encode(['status' => 'failed', 'msg' => 'Email is required']);
        }

        $email = trim($_POST['email']);

        // Prepare the SQL statement to prevent SQL injection
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = ?");
        if (!$stmt) {
            return json_encode(['status' => 'failed', 'msg' => 'Database error: ' . $this->conn->error]);
        }
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $qry = $stmt->get_result();

        if ($qry->num_rows > 0) {
            // Generate a token
            try {
                $token = bin2hex(random_bytes(50));
            } catch (Exception $e) {
                return json_encode(['status' => 'failed', 'msg' => 'Token generation failed']);
            }
            $exp_time = date('Y-m-d H:i:s', strtotime('+1 hour'));

            // Prepare the update statement
            $update_stmt = $this->conn->prepare("UPDATE users SET reset_token = ?, token_expiry = ? WHERE username = ?");
            if (!$update_stmt) {
                return json_encode(['status' => 'failed', 'msg' => 'Database error: ' . $this->conn->error]);
            }
            $update_stmt->bind_param("sss", $token, $exp_time, $email);
            $update_stmt->execute();

            if ($update_stmt->error) {
                return json_encode(['status' => 'failed', 'msg' => 'Error saving token: ' . $update_stmt->error]);
            }

            // Send email with PHPMailer
            $reset_link = base_url . "admin/reset_password.php?token=" . $token;
            require '../vendor/autoload.php'; // Adjust path based on your project

            $mail = new PHPMailer(true); // Enable exceptions

            try {
                // Server settings
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com'; // Gmail SMTP server
                $mail->SMTPAuth   = true;
                $mail->Username   = 'your-email@gmail.com'; // Your Gmail address
                $mail->Password   = 'your-app-password'; // Your Gmail App Password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = 587;

                // Recipients
                $mail->setFrom('your-email@gmail.com', 'MCC Repositories');
                $mail->addAddress($email);

                // Content
                $mail->isHTML(true);
                $mail->Subject = 'Password Reset Request';
                $mail->Body    = "Click <a href='$reset_link'>here</a> to reset your password. This link is valid for 1 hour.";

                $mail->send();
                return json_encode(['status' => 'success']);
            } catch (Exception $e) {
                return json_encode(['status' => 'failed', 'msg' => 'Mailer Error: ' . $mail->ErrorInfo]);
            }
        } else {
            return json_encode(['status' => 'failed', 'msg' => 'Email not found']);
        }
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
	case 'forgot_password_users': // Added case
        echo $users->forgot_password_users();
    break;
	default:
		// echo $sysset->index();
		break;
}