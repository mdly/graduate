<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class General extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->library('session');
		$this->load->database();
	}


	function profile($role) {
		if ($this->session->userdata('s_id')){
			$userNum = $this->session->userdata('s_id');
			$this->load->model('userCrud');
			$user = $this->userCrud->read_user_info($userNum);
			//$admin = $this->crud->select(array('UserID,UserNum,UserName,Gender,Email,Section,Type','users','UserNum',$userNum));
			$this->load->view('/'.$role.'/top');
			$this->load->view('/'.$role.'/left',array('left'=>"4"));
			$this->load->view('/profileR',array('data'=>$user));
			$this->load->view('/'.$role.'/botton');
		}
	}
	function logout() {
		$this->session->unset_userdata('s_id');
		$this->load->view('login');
	}


	function edit_profile($role){
		$this->load->model('userCrud');	
		$userNum = $this->session->userdata('s_id');
		try {
			$this->userCrud->update_user_info(array('UserName'=>$_POST['userName'],'Gender'=>$_POST['Gender'],'Email'=>$_POST['Email'],'Section'=>$_POST['Section']),$userNum);
			$message = "修改成功！";
		}catch(Exception $e){
			$message = $e->getMessage();	
		}
		//if success!
		$userNum = $this->session->userdata('s_id');
		$user = $this->userCrud->read_user_info($userNum);
		$this->load->view('/'.$role.'/top');
		$this->load->view('/'.$role.'/left',array('left'=>"4"));
		$this->load->view('/profileEditResultR',array('data'=>$user,'message'=>$message));
		$this->load->view('/'.$role.'/botton');
		//$this->load->view('/'.$role.'/profileEditResult',array('data'=>$user,'message'=>$message));
	}



	function reset_pswd($role) {
		$this->load->view('/'.$role.'/top');
		$this->load->view('/'.$role.'/left',array('left'=>"4"));
		$this->load->view('/resetpswdR');
		$this->load->view('/'.$role.'/botton');
		//$this->load->view('/'.$role.'/resetpswd');
	}
	function check_pswd($role){
		$this->load->model('validation');
		$isValid = $this->validation->is_valid_password(md5($_POST['password1']),md5($_POST['password2']));
		if ($isValid){
			$this->load->model('userCrud');
			$userNum = $this->session->userdata('s_id');
			$this->userCrud->update_user_info(array('Password'=>md5($_POST['password1'])),$userNum);
			$this->session->unset_userdata('s_id');
			$this->load->view('login');
		}else{
			$message = "failed to reset password";
			$this->load->view('/'.$role.'/top');
			$this->load->view('/'.$role.'/left',array('left'=>"5"));
			$this->load->view('/resetPswdFailedR',array('message'=>$message));
			$this->load->view('/'.$role.'/botton');
		}
	}



	function download_file($courseID){
		$course = $this->db->select("File,CourseName")->from("courses")->where("CourseID",$courseID)->get()->result()[0];
		$filePath = $course->File;
		$fileName = $course->CourseName;
		$this->load->helper('download');
		$data = file_get_contents($filePath);
		$name = $fileName."指导书.doc";
		force_download($name,$data);
	}
}
?>