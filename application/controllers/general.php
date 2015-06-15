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
		$this->load->view('login',array('message'=>""));
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
		$failed = 1;
		if ($isValid){
			$this->load->model('userCrud');
			$userNum = $this->session->userdata('s_id');
			$this->userCrud->update_user_info(array('Password'=>md5($_POST['password1'])),$userNum);
			// $this->load->model('openstack');
			// $result = $this->openstack->reset_password($userNum,$password);
			// if (!$result['failed']) $failed = 0;
			$this->session->unset_userdata('s_id');
			$this->load->view('login',array('message'=>""));
		}else{
			$message = "failed to reset password";
			$this->load->view('/'.$role.'/top');
			$this->load->view('/'.$role.'/left',array('left'=>"5"));
			$this->load->view('/resetPswdFailedR',array('message'=>$message));
			$this->load->view('/'.$role.'/botton');
		}
	}



	function download_file($courseID){
		$course = $this->db->select("File,CourseName")
		->from("courses")
		->where("CourseID",$courseID)
		->get()->result()[0];
		$filePath = $course->File;
		$fileName = $course->CourseName;
		$this->load->helper('download');
		$data = file_get_contents($filePath);
		$format = explode(".", $filePath);
		$format = $format[count($format)-1];
		echo "alert(".$format.")";
		$name = $fileName."指导书.".$format;
		force_download($name,$data);
	}
	function download_report($selectionID){		
		$report = $this->db->select("ReportPath,StudenID")
		->from("selectcourse")
		->where("SelectionID",$selectionID)
		->get()->result()[0];
		$filePath = $report->ReportPath;
		$fileName = $report->StudenID;
		$this->load->helper('download');
		$data = file_get_contents($filePath);
		$format = explode(".", $filePath);
		$format = $format[count($format)-1];
		echo "alert(".$format.")";
		$name = $fileName."报告.".$format;
		force_download($name,$data);
	}
	function get_VM_detail($vmID){
		$this->load->model('openstack');
		$token = $this->openstack->get_tokenID();
		// $tokenID = $token['access']['token']['id'];
		// $urlToken = substr($tokenID, 0,8)."-".substr($tokenID, 8,4)."-".substr($tokenID, 12,4)."-".substr($tokenID, 14,4)."-".substr($tokenID, 18);
		// $this->load->view()
		$this->load->model("userCrud");
		$VMInfo = $this->openstack->get_server_detail($vmID);
		$this->load->library("session");
		$userID = $this->session->userdata("s_id");
		$userType = $this->userCrud->read_user_login_info($userID)->Type;
		switch ($userType) {
			case '0':$role="admin";break;
			case '1':$role="teacher";break;
			case '2':$role="student";break;
			default:$role="admin";break;
		}
		$this->load->view('/'.$role.'/top');
		$this->load->view('/'.$role.'/left',array('left'=>"1"));
		$this->load->view('/VM',array('data'=>$VMInfo['basicInfo'],'VMURL'=>$VMInfo['url']));
		$this->load->view('/'.$role.'/botton');

	}
}
?>