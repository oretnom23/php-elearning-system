<?php
require_once('../config.php');
Class Master extends DBConnection {
	private $settings;
	public function __construct(){
		global $_settings;
		$this->settings = $_settings;
		parent::__construct();
	}
	public function __destruct(){
		parent::__destruct();
	}
	public function save_academic(){
		extract($_POST);
		
		$data="";
		foreach ($_POST as $key => $value) {
			if(!in_array($key, array('id')) && !is_numeric($key)){
				if(!empty($data)) $data .= ", ";
				$data .= " {$key} = '{$value}' ";
			}
		}
		$chk = $this->conn->query("SELECT * FROM academic_year where sy = '$sy' ".((!empty($id))? " and id != {$id}" : ''));
		if($chk->num_rows > 0){
			return 2; 
			exit;
		}
		if(empty($id)){
			$sql = "INSERT INTO academic_year set $data";
		}else{
			$sql = "UPDATE academic_year set $data where id = $id";
		}
		$save = $this->conn->query($sql);
		if($save){
			if($status == 1){
				$id = empty($id) ? $this->conn->insert_id : $id;
				$this->conn->query("UPDATE academic_year set status = 0 where id != $id");
				$this->settings->set_userdata('academic_id',$id);
				$this->settings->set_userdata('academic_sy',$sy);
			}
			$this->settings->set_flashdata('success'," Academic Year Successfully saved.");
			return 1;
		}else{
			$resp['err']= "error saving data";
			$resp['sql']=$sql;
			return json_encode($resp);
		}
	}
	public function delete_academic(){
		extract($_POST);

		$delete = $this->conn->query("DELETE FROM academic_year where id = $id");
		if($delete)
			return 1;
	}

	public function save_department(){
		extract($_POST);
		
		$data="";
		foreach ($_POST as $key => $value) {
			if(!in_array($key, array('id')) && !is_numeric($key)){
				if(!empty($data)) $data .= ", ";
				$data .= " {$key} = '{$value}' ";
			}
		}
		$chk = $this->conn->query("SELECT * FROM department where department = '$department' ".((!empty($id))? " and id != {$id}" : ''));
		if($chk->num_rows > 0){
			return 2; 
			exit;
		}
		if(empty($id)){
			$sql = "INSERT INTO department set $data";
		}else{
			$sql = "UPDATE department set $data where id = $id";
		}
		$save = $this->conn->query($sql);
		if($save){
			$this->settings->set_flashdata('success'," Department Successfully saved.");
			return 1;
		}else{
			$resp['err']= "error saving data";
			$resp['sql']=$sql;
			return json_encode($resp);
		}
	}
	public function delete_department(){
		extract($_POST);

		$delete = $this->conn->query("DELETE FROM department where id = $id");
		if($delete)
			return 1;
	}
	
	public function save_course(){
		extract($_POST);
		
		$data="";
		foreach ($_POST as $key => $value) {
			if(!in_array($key, array('id')) && !is_numeric($key)){
				if(!empty($data)) $data .= ", ";
				$data .= " {$key} = '{$value}' ";
			}
		}
		$chk = $this->conn->query("SELECT * FROM course where course = '$course' ".((!empty($id))? " and id != {$id}" : ''));
		if($chk->num_rows > 0){
			return "SELECT * FROM course ".((!empty($id))? " where id != {$id}" : ''); 
			exit;
		}
		if(empty($id)){
			$sql = "INSERT INTO course set $data";
		}else{
			$sql = "UPDATE course set $data where id = $id";
		}
		$save = $this->conn->query($sql);
		if($save){
			$this->settings->set_flashdata('success'," Course Successfully saved.");
			return 1;
		}else{
			$resp['err']= "error saving data";
			$resp['sql']=$sql;
			return json_encode($resp);
		}
	}
	public function delete_course(){
		extract($_POST);

		$delete = $this->conn->query("DELETE FROM course where id = $id");
		if($delete)
			return 1;
	}

	public function save_subject(){
		extract($_POST);
		
		$data="";
		foreach ($_POST as $key => $value) {
			if(!in_array($key, array('id')) && !is_numeric($key)){
				if(!empty($data)) $data .= ", ";
				$data .= " {$key} = '{$value}' ";
			}
		}
		$chk = $this->conn->query("SELECT * FROM subjects where subject_code = '$subject_code' ".((!empty($id))? " and id != {$id}" : ''));
		if($chk->num_rows > 0){
			return 2; 
			exit;
		}

		if(empty($id)){
			$sql = "INSERT INTO subjects set $data";
		}else{
			$sql = "UPDATE subjects set $data where id = $id";
		}
		$save = $this->conn->query($sql);
		if($save){
			$this->settings->set_flashdata('success'," Subject Successfully saved.");
			return 1;
		}else{
			$resp['err']= "error saving data";
			$resp['sql']=$sql;
			return json_encode($resp);
		}
	}
	public function delete_subject(){
		extract($_POST);

		$delete = $this->conn->query("DELETE FROM subjects where id = $id");
		if($delete)
			return 1;
	}
	public function save_student(){
		extract($_POST);
		$data="";
		foreach ($_POST as $key => $value) {
			if(!in_array($key, array('id')) && !is_numeric($key)){
				if(!empty($data)) $data .= ", ";
				$data .= " {$key} = '{$value}' ";
			}
		}
		$chk = $this->conn->query("SELECT * FROM students where student_id = '$student_id' ".((!empty($id))? " and id != {$id}" : ''));
		if($chk->num_rows > 0){
			return 2; 
			exit;
		}

		if(empty($id)){
			$data .= ", `password` = '".md5($student_id)."' ";
			$sql = "INSERT INTO students set $data";
		}else{
			if(isset($preset) && $preset == 'on')
			$data .= ", `password` = '".md5($student_id)."' ";
			$sql = "UPDATE students set $data where id = $id";
		}

		$save = $this->conn->query($sql);
		if($save){
			if(isset($_FILES['img']) && $_FILES['img']['tmp_name'] != ''){
					$ext = explode('.', $_FILES['img']['name']);
					$fname = 'uploads/uvatar_'.$id.'.'.$ext[1];
					if(is_file('../'.$fname))
						unlink('../'.$fname);
					$move = move_uploaded_file($_FILES['img']['tmp_name'],'../'. $fname);
					if($move){
						$this->conn->query("UPDATE students set avatar = '$fname' where id = $id ");
					}
			}
			$this->settings->set_flashdata('success'," Subject Successfully saved.");
			return 1;
		}else{
			$resp['err']= "error saving data";
			$resp['sql']=$sql;
			return json_encode($resp);
		}

	}

	public function delete_student(){
		extract($_POST);

		$delete = $this->conn->query("DELETE FROM students where id = $id");
		if($delete)
			return 1;
	}
	public function save_class(){
		extract($_POST);
		
		$data="";
		$data2="";
		foreach ($_POST as $key => $value) {
			if(!in_array($key, array('id')) && !is_numeric($key)){
				if(!empty($data)) $data .= ", ";
				$data .= " {$key} = '{$value}' ";
				if(!empty($data2)) $data2 .= "and ";
				$data2 .= " {$key} = '{$value}' ";
			}
		}
		$chk = $this->conn->query("SELECT * FROM class where $data2 ".((!empty($id))? " and id != {$id}" : ''));
		if($chk->num_rows > 0){
			return 2; 
			exit;
		}

		if(empty($id)){
			$sql = "INSERT INTO class set $data";
		}else{
			$sql = "UPDATE class set $data where id = $id";
		}
		$save = $this->conn->query($sql);
		if($save){
			$this->settings->set_flashdata('success'," Class Successfully saved.");
			return 1;
		}else{
			$resp['err']= "error saving data";
			$resp['sql']=$sql;
			return json_encode($resp);
		}
	}
	public function delete_class(){
		extract($_POST);

		$delete = $this->conn->query("DELETE FROM class where id = $id");
		if($delete)
			return 1;
	}
	public function student_class(){
		extract($_POST);

		$data="";
		foreach ($_POST as $key => $value) {
			if(!in_array($key, array('id')) && !is_numeric($key)){
				if(!empty($data)) $data .= ", ";
				$data .= " {$key} = '{$value}' ";
			}
		}

		if(empty($id)){
			$sql = "INSERT INTO student_class set $data";
		}else{
			$sql = "UPDATE student_class set $data where id = $id";
		}

		$save = $this->conn->query($sql);
		if($save){
			$this->settings->set_flashdata('success'," Student's Class Successfully updated.");
			return 1;
		}else{
			$resp['err']= "error saving data";
			$resp['sql']=$sql;
			return json_encode($resp);
		}

	}
	public function load_class_subject(){
		extract($_POST);
		$delete = $this->conn->query("DELETE FROM class_subjects where class_id = '$class_id' and academic_year_id = '$academic_year_id' ");
		$data = "";
		foreach ($subject_id as $key => $valuu) {
			if(!empty($data)) $data .= ", ";
			$data .= " ('$class_id','$academic_year_id','{$subject_id[$key]}') ";
		}
		$sql = "INSERT INTO class_subjects (class_id,academic_year_id,subject_id) VALUES $data ";
		// echo $sql;exit;
		$save = $this->conn->query($sql);
		if($save){
			$this->settings->set_flashdata('success'," Class Subject Loads Successfully saved.");
			return 1;
		}else{
			$resp['err']= "error saving data";
			$resp['sql']=$sql;
			return json_encode($resp);
		}
	}

	public function save_faculty(){
		extract($_POST);
		$data="";
		foreach ($_POST as $key => $value) {
			if(!in_array($key, array('id')) && !is_numeric($key)){
				if(!empty($data)) $data .= ", ";
				$data .= " {$key} = '{$value}' ";
			}
		}
		$chk = $this->conn->query("SELECT * FROM faculty where faculty_id = '$faculty_id' ".((!empty($id))? " and id != {$id}" : ''));
		if($chk->num_rows > 0){
			return 2; 
			exit;
		}

		if(empty($id)){
			$data .= ", `password` = '".md5($faculty_id)."' ";
			$sql = "INSERT INTO faculty set $data";
		}else{
			if(isset($preset) && $preset == 'on')
			$data .= ", `password` = '".md5($faculty_id)."' ";
			$sql = "UPDATE faculty set $data where id = $id";
			$ofid = $this->conn->query("SELECT * FROM faculty where id = $id ")->fetch_array()['faculty_id'];
		}

		$save = $this->conn->query($sql);
		if($save){
			$id= empty($id) ? $this->conn->insert_id : $id;
			if(isset($_FILES['img']) && $_FILES['img']['tmp_name'] != ''){
					$ext = explode('.', $_FILES['img']['name']);
					$fname = 'uploads/Favatar_'.$id.'.'.$ext[1];
					if(is_file('../'.$fname))
						unlink('../'.$fname);
					$move = move_uploaded_file($_FILES['img']['tmp_name'],'../'. $fname);
					if($move){
						$this->conn->query("UPDATE faculty set avatar = '$fname' where id = $id ");
					}
			}
			if(isset($ofid)){
				$this->conn->query("UPDATE class_subjects_faculty set faculty_id = '$faculty_id' where faculty_id = $ofid ");
				$this->conn->query("UPDATE lessons set faculty_id = '$faculty_id' where faculty_id = $ofid ");

			}
			$this->settings->set_flashdata('success'," Subject Successfully saved.");
			return 1;
		}else{
			$resp['err']= "error saving data";
			$resp['sql']=$sql;
			return json_encode($resp);
		}

	}

	public function delete_faculty(){
		extract($_POST);

		$delete = $this->conn->query("DELETE FROM faculty where id = $id");
		if($delete)
			return 1;
	}
	public function load_faculty_subj(){
		extract($_POST);
		$delete = $this->conn->query("DELETE FROM class_subjects_faculty where faculty_id = '$faculty_id' and academic_year_id = '$academic_year_id' ");
		$data = "";
		foreach ($class_subj as $key => $valuu) {
			$ex = explode("_", $class_subj[$key]);
			$class_id = $ex[0];
			$subject_id = $ex[1];
			if(!empty($data)) $data .= ", ";
			$data .= " ('$academic_year_id','$faculty_id','$class_id','$subject_id') ";
		}
		$sql = "INSERT INTO class_subjects_faculty (academic_year_id,faculty_id,class_id,subject_id) VALUES $data ";
		// echo $sql;exit;
		$save = $this->conn->query($sql);
		if($save){
			$this->settings->set_flashdata('success'," Faculty Class Loads Successfully saved.");
			return 1;
		}else{
			$resp['err']= "error saving data";
			$resp['sql']=$sql;
			return json_encode($resp);
		}
	}

	public function save_lesson(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			if(!in_array($k, array('id','class_ids'))){
				if(!empty($data)) $data .= ", ";
				if($k == 'description') $v = addslashes(htmlentities($v));
				$data .= " `{$k}` = '{$v}' ";
			}
		}

		if(empty($id)){
			$sql = "INSERT INTO lessons set $data";
		}else{
			$sql = "UPDATE lessons set $data where id = $id";
		}
		$save = $this->conn->query($sql);
		if($save){
			$id = (empty($id)) ? $this->conn->insert_id : $id;
			$data="";
			foreach ($class_ids as $key => $value) {
				$this->conn->query("DELETE lesson_class where lesson_id = $id");
				if(!empty($data)) $data .= ", ";
				$data .= " ('$id','{$class_ids[$key]}') ";
			}
			$sql2 = $this->conn->query("INSERT INTO lesson_class (lesson_id,class_id) values $data");
			if(isset($_FILES['ppt_slide']) && count($_FILES['ppt_slide']) > 0){
				if(!is_dir('../uploads/slides')){
					mkdir('../uploads/slides');
				}
				if(!is_dir('../uploads/slides/lesson_'.$id)){
					mkdir('../uploads/slides/lesson_'.$id);
				}else{
					$files = scandir('../uploads/slides/lesson_'.$id);
					foreach ($files as $key => $value) {
						if(!in_array($files[$key],array('.','..'))){
							unlink('../uploads/slides/lesson_'.$id.'/'.$files[$key]);
						}
					}
				}

				$path = 'uploads/slides/lesson_'.$id;
				$this->conn->query("UPDATE lessons set ppt_path = '{$path}' where id = '$id' ");
				$path = '../'.$path;
				foreach ($_FILES['ppt_slide']['tmp_name'] as $k => $value) {
					if(isset($_FILES['ppt_slide']['tmp_name'][$k]) && !empty($_FILES['ppt_slide']['tmp_name'][$k])){
						$move = move_uploaded_file($_FILES['ppt_slide']['tmp_name'][$k], $path.'/'.$_FILES['ppt_slide']['name'][$k]);
					}
				}
			}
			
			$this->settings->set_flashdata('success'," Lesson Successfully saved.");
			return $id;
		}else{
			$resp['sql1'] = $sql;
			$resp['sql2'] = $sql2;
			return json_encode($resp);
		}
	}
}

$Master = new Master();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$sysset = new SystemSettings();
switch ($action) {
	case 'save_academic':
		echo $Master->save_academic();
	break;
	case 'delete_academic':
		echo $Master->delete_academic();
	break;
	case 'save_department':
		echo $Master->save_department();
	break;
	case 'delete_department':
		echo $Master->delete_department();
	break;

	case 'save_course':
		echo $Master->save_course();
	break;
	case 'delete_course':
		echo $Master->delete_course();
	break;

	case 'save_subject':
		echo $Master->save_subject();
	break;
	case 'delete_subject':
		echo $Master->delete_subject();
	break;
	case 'save_student':
		echo $Master->save_student();
	break;
	case 'delete_student':
		echo $Master->delete_student();
	break;
	case 'save_class':
		echo $Master->save_class();
	break;
	case 'delete_class':
		echo $Master->delete_class();
	break;
	case 'student_class':
		echo $Master->student_class();
	break;	
	case 'load_class_subject':
		echo $Master->load_class_subject();
	break;		
	case 'save_faculty':
		echo $Master->save_faculty();
	break;
	case 'delete_faculty':
		echo $Master->delete_faculty();
	break;
	case 'faculty_class':
		echo $Master->load_faculty_subj();
	break;	
	case 'save_lesson':
		echo $Master->save_lesson();
	break;
	default:
		// echo $sysset->index();
		break;
}