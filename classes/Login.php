<?php
require_once '../config.php';
class Login extends DBConnection {
	private $settings;
	public function __construct(){
		global $_settings;
		$this->settings = $_settings;

		parent::__construct();
		ini_set('display_error', 1);
	}
	public function __destruct(){
		parent::__destruct();
	}
	public function index(){
		echo "<h1>Access Denied</h1> <a href='".base_url."'>Go Back.</a>";
	}
	public function login(){
		extract($_POST);

		$qry = $this->conn->query("SELECT * from users where username = '$username' and password = md5('$password')");
		if($qry->num_rows > 0){
			$res = $qry->fetch_array();
			if($res['status'] != 1){
				return json_encode(array('status'=>'notverified'));
			}
			foreach($res as $k => $v){
				if(!is_numeric($k) && $k != 'password'){
					$this->settings->set_userdata($k,$v);
				}
			}
			$this->settings->set_userdata('login_type',1);
		return json_encode(array('status'=>'success'));
		}else{
		return json_encode(array('status'=>'incorrect','last_qry'=>"SELECT * from users where username = '$username' and password = md5('$password') "));
		}
	}
	public function logout(){
		if($this->settings->sess_des()){
			redirect('admin/login.php');
		}
	}
	function student_login(){
		extract($_POST);
		$qry = $this->conn->query("SELECT *,concat(lastname,', ',firstname,' ',middlename) as fullname from student_list where email = '$email' and password = md5('$password') ");
		if($this->conn->error){
			$resp['status'] = 'failed';
			$resp['msg'] = "An error occurred while fetching data. Error:". $this->conn->error;
		}else{
		if($qry->num_rows > 0){
			$res = $qry->fetch_array();
			if($res['status'] == 1){
				foreach($res as $k => $v){
					$this->settings->set_userdata($k,$v);
				}
				$this->settings->set_userdata('login_type',2);
				$resp['status'] = 'success';
			}else{
				$resp['status'] = 'failed';
				$resp['msg'] = "Your Account is not verified yet.";
			}
			
		}else{
		$resp['status'] = 'failed';
		$resp['msg'] = "Invalid email or password.";
		}
		}
		return json_encode($resp);
	}
	public function student_logout(){
		if($this->settings->sess_des()){
			redirect('./');
		}
	}
	public function forgot_password() {
		extract($_POST);
		$qry = $this->conn->query("SELECT * FROM users WHERE email = '$email'");
		if ($qry->num_rows > 0) {
			// Generate a token
			$token = bin2hex(random_bytes(50)); 
			$exp_time = date('Y-m-d H:i:s', strtotime('+1 hour'));
	
			// Insert or update the token in the database
			$this->conn->query("UPDATE users SET reset_token = '$token', token_expiry = '$exp_time' WHERE email = '$email'");
			if ($this->conn->error) {
				return json_encode(['status' => 'failed', 'msg' => 'Error saving token']);
			}
	
			// Send email with PHPMailer
			$reset_link = base_url . "admin/reset_password.php?token=" . $token;
			require '../vendor/autoload.php'; // Adjust path based on your project
	
			$mail = new PHPMailer();
			$mail->isSMTP();
			$mail->Host = 'smtp.gmail.com'; // Gmail SMTP server
			$mail->SMTPAuth = true;
			$mail->Username = 'your-email@gmail.com'; // Your Gmail address
			$mail->Password = 'your-email-password'; // Your Gmail password or App Password
			$mail->SMTPSecure = 'tls';
			$mail->Port = 587;
	
			$mail->setFrom('your-email@gmail.com', 'MCC Repositories');
			$mail->addAddress($email);
	
			$mail->isHTML(true);
			$mail->Subject = 'Password Reset Request';
			$mail->Body = "Click <a href='$reset_link'>here</a> to reset your password. This link is valid for 1 hour.";
	
			if ($mail->send()) {
				return json_encode(['status' => 'success']);
			} else {
				return json_encode(['status' => 'failed', 'msg' => 'Error sending email']);
			}
		} else {
			return json_encode(['status' => 'failed', 'msg' => 'Email not found']);
		}
	}
	
}
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$auth = new Login();
switch ($action) {
	case 'login':
		echo $auth->login();
		break;
	case 'logout':
		echo $auth->logout();
		break;
	case 'student_login':
		echo $auth->student_login();
		break;
	case 'student_logout':
		echo $auth->student_logout();
		break;
	default:
		echo $auth->index();
		break;
}