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

		$qry = $this->conn->query("SELECT * from users where username = '$username' and password = md5('$password') ");
		if($qry->num_rows > 0){
			foreach($qry->fetch_array() as $k => $v){
				if(!is_numeric($k) && $k != 'password'){
					$this->settings->set_userdata($k,$v);
				}

			}
			$this->settings->set_userdata('login_type',1);
		$sy = $this->conn->query("SELECT * FROM academic_year where status = 1");
		foreach($sy->fetch_array() as $k =>$v){
			if(!is_numeric($k)){
			$this->settings->set_userdata('academic_'.$k,$v);
			}
		}
		return json_encode(array('status'=>'success'));
		}else{
		return json_encode(array('status'=>'incorrect','last_qry'=>"SELECT * from users where username = '$username' and password = md5('$password') "));
		}
	}
	public function flogin(){
		extract($_POST);

		$qry = $this->conn->query("SELECT * from faculty where  faculty_id = '$faculty_id' and `password` = '".md5($password)."' ");
		if($qry->num_rows > 0){
			foreach($qry->fetch_array() as $k => $v){
				if(!is_numeric($k)){
					$this->settings->set_userdata($k,$v);
				}

			}
			$this->settings->set_userdata('login_type',2);
			$sy = $this->conn->query("SELECT * FROM academic_year where status = 1");
		foreach($sy->fetch_array() as $k =>$v){
			if(!is_numeric($k)){
			$this->settings->set_userdata('academic_'.$k,$v);
			}
		}
			return json_encode(array('status'=>'success'));
		}else{
		return json_encode(array('status'=>'incorrect'));
		}
	}
	public function slogin(){
		extract($_POST);

		$qry = $this->conn->query("SELECT * from students where  student_id = '$student_id' and `password` = '".md5($password)."' ");
		if($qry->num_rows > 0){
			foreach($qry->fetch_array() as $k => $v){
				if(!is_numeric($k)){
					$this->settings->set_userdata($k,$v);
				}

			}
			$this->settings->set_userdata('login_type',3);
			$sy = $this->conn->query("SELECT * FROM academic_year where status = 1");
		foreach($sy->fetch_array() as $k =>$v){
			if(!is_numeric($k)){
			$this->settings->set_userdata('academic_'.$k,$v);
			}
		}
			return json_encode(array('status'=>'success'));
		}else{
		return json_encode(array('status'=>'incorrect'));
		}
	}
	public function logout(){
		if($this->settings->sess_des()){
			redirect('admin/login.php');
		}
	}
	public function flogout(){
		if($this->settings->sess_des()){
			redirect('faculty/login.php');
		}
	}
	public function slogout(){
		if($this->settings->sess_des()){
			redirect('student/login.php');
		}
	}
}
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$auth = new Login();
switch ($action) {
	case 'login':
		echo $auth->login();
		break;
	case 'flogin':
		echo $auth->flogin();
		break;
	case 'slogin':
		echo $auth->slogin();
		break;
	case 'logout':
		echo $auth->logout();
		break;
	case 'flogout':
		echo $auth->flogout();
		break;
	case 'slogout':
		echo $auth->slogout();
		break;
	default:
		echo $auth->index();
		break;
}

