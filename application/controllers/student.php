<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Student extends CI_Controller {
	public function __construct() {
		parent::__construct();
		//首先检查用户是否已经登录，用户类型是否是学生
		$this->load->library('session');
		$this->load->model('userCrud');	
		$userNum = $this->session->userdata('s_id');
		$userType = $this->userCrud->read_user_type($userNum);
		if ($userType!='2'){
			echo 'not authorized!';
			die();
			$this->load->view("login");
		}
	}
	function is_login(){		
		$this->load->library('session');
		$this->load->model('userCrud');	
		$userNum = $this->session->userdata('s_id');
		$userType = $this->userCrud->read_user_type($userNum);
		$errorMsg = "";
		if(!$userNum){
			$errorMsg = "请登录！";
		}
		if ($userType!='2'){
			$errorMsg = "当前登录账号无此权限！";
		}
		return $errorMsg;
	}
	function index($type="-1"){
		// $this->is_login();
		$this->load->model("courseCrud");
		//read_course_list($type="0",$isAdmin="0")
		$courseType = $this->courseCrud->read_type_list();
		$this->load->library('session');
		$userNum = $this->session->userdata('s_id');
		$course = $this->courseCrud->read_course_list_student($type,$userNum);
		$this->load->view('/student/top');
		$this->load->view('/student/left',array('left'=>"0"));
		$this->load->view("/student/overviewR",
			array('data'=>$course['course'],
				'courseType'=>$courseType,
				'selected'=>$course['selected'],
				'typeName'=>$course['typeName'],
				'teacher'=>$course['teacher'],
				'activeTop'=>$type,
				'selectColumn'=>"0",
				'keyword'=>""));
		$this->load->view('/student/botton');
	}
	function course_manager($finished='0'){
		$this->load->model('courseCrud');
		$this->load->library('session');
		$userNum = $this->session->userdata('s_id');
		// get the selected  course info;
		// $data = $this->courseCrud->
		$this->load->view('/student/top');
		$this->load->view('/student/left',array('left'=>"1"));

		if($finished){
			$course = $this->courseCrud->read_finished_course($userNum);
			$this->load->view("/student/course/courseFinishedR",
				array('data'=>$course,
					'activeTop'=>$finished));
		}else{
			$course = $this->courseCrud->read_selected_course($userNum);
			// print_r($course);
			$this->load->view("/student/course/courseSelectedR",
				array('data'=>$course,'activeTop'=>$finished));
		}
		$this->load->view('/student/botton');
	}
	function search_course(){
		// 
	}

	function get_VM_detail($vmID){
		$this->load->model('openstack');
		$token = $this->openstack->get_tokenID();
		// $tokenID = $token['access']['token']['id'];
		// $urlToken = substr($tokenID, 0,8)."-".substr($tokenID, 8,4)."-".substr($tokenID, 12,4)."-".substr($tokenID, 14,4)."-".substr($tokenID, 18);
		// $this->load->view()
		$this->load->model("userCrud");
		$VMInfo = $this->openstack->get_server_detail($vmID);
		$this->load->model("courseCrud");
		$courseID = $this->courseCrud->read_courseID_by_vmID($vmID);
		$this->load->view('/student/top');
		$this->load->view('/student/left',array('left'=>"1"));
		$this->load->view('/student/course/vmDetailR',
				array('data'=>$VMInfo['basicInfo'],
					'VMURL'=>$VMInfo['url'],
					'courseID'=>$courseID));
		$this->load->view('/student/botton');

	}
	function show_course_detail($courseID){
		$this->load->model("courseCrud");
		$data = $this->courseCrud->read_course_detail_student($courseID);
		$this->load->view('/student/top');
		$this->load->view('/student/left',array('left'=>"0"));
		$this->load->view("/student/course/courseDetailR",array("data"=>$data));
		$this->load->view('/student/botton');
	}
	function show_my_course_detail($courseID){
		$this->load->model("courseCrud");
		$data = $this->courseCrud->read_course_detail_student($courseID);
		$this->load->view('/student/top');
		$this->load->view('/student/left',array('left'=>"1"));
		$this->load->view("/student/course/myCourseDetail",array("data"=>$data));
		$this->load->view('/student/botton');
	}
	function selected_course_manager(){
		$this->load->model("courseCrud");
		$this->load->library("session");
		$userNum = $this->session->userdata('s_id');
		$selectedCourse = $this->courseCrud->read_selected_course($userNum);
		//get file,submit times
		$this->load->view('/student/top');
		$this->load->view('/student/left',array('left'=>'1'));
		$this->load->view('/student/course/courseSelectedR',array('data'=>$selectedCourse));
		$this->load->view('/student/botton');
	}
	function finished_course_manager(){
		$this->load->model("courseCrud");
		$this->load->library("session");
		$userNum = $this->session->userdata('s_id');
		$finishedCourse = $this->courseCrud->read_finished_course($userNum);
		$this->load->view('/student/top');
		$this->load->view('/student/left',array('left'=>'1'));
		$this->load->view('/student/course/courseFinishedR',array('data'=>$finishedCourse));
		$this->load->view('/student/botton');
	}
	function select_course_action($courseID){
		$this->load->model("courseCrud");
		$this->load->library("session");
		$userNum = $this->session->userdata('s_id');
		$this->courseCrud->select_course($userNum,$courseID);
		// $this->courseCrud->read_selected_course($userNum);
		$this->selected_course_manager();
	}
	function upload_report($courseID){
		// show the submilimite and the times already submit.
		$this->load->model("courseCrud");
		$this->load->library('session');
		$userNum = $this->session->userdata('s_id');
		// echo "userNum =";
		// print_r($userNum);
		$submit = $this->courseCrud->read_reportLimit_student($courseID,$userNum);
		$this->load->view('/student/top');
		$this->load->view('/student/left',array('left'=>'1'));
		$this->load->view("/student/course/uploadReportR",
			array("courseID"=>$courseID,
				'submitLimit'=>$submit['submitLimit'],
				'submitTimes'=>$submit['submitTimes'],
				));
		$this->load->view('/student/botton');
	}
	function upload_report_action($courseID){
		$this->load->model('courseCrud');
		$config['upload_path']='./uploads';
		$config['allowed_types']='pdf|doc|docx';
		$config['max_size']='10240000';//10mb
		$config['file_name']  = time();
		$this->load->library('upload',$config);
		$data = $this->upload->do_upload('file');
		if($data){
			$file_info = array('upload_data'=>$this->upload->data());
		}else{
			$error=array('error'=>$this->upload->display_errors());
			$file_info['upload_data']['full_path']="";
			var_dump($error);
		}
		$this->load->library("session");
		$userNum = $this->session->userdata('s_id');
		$this->courseCrud->submit_report($courseID,$userNum,$file_info['upload_data']['full_path']);
		$this->upload_report($courseID);
	}

	function submit_course($courseID){
		$this->load->library("session");
		$userNum = $this->session->userdata('s_id');
		$this->load->model("courseCrud");
		$this->courseCrud->submit_course($userName,$courseID);
	}

	function network_manager(){
		$this->load->model('openstack');
		$token = $this->openstack->authenticate_v2();
		$tenantID = $token['access']['token']['tenant']['id'];
		$tokenID = $token['access']['token']['id'];
		$networks = $this->openstack->get_resources($tokenID,$tenantID,'network')['networks'];
		$subnetName = array();
		for ($i=0; $i < count($networks) ; $i++) {
			//这里只提取了第一个subnet
			$subnetID = $networks[$i]['subnets']['0'];
			$subnetName[] = $this->openstack->get_subnet_detail($tokenID,$subnetID)['name'];
		}
		$this->load->view('/student/top');
		$this->load->view('/student/left',array('left'=>'2'));
		$this->load->view('/student/course/networkR',array('data'=>$networks,'subnet'=>$subnetName));
		$this->load->view('/student/botton');
	}
	function create_network(){
		$this->load->view('/student/top');
		$this->load->view('/student/left',array('left'=>'2'));
		$this->load->view('/student/course/createNetworkR');
		$this->load->view('/student/botton');
	}
	function create_network_action(){
		$name = $_POST['networkName'];
		$this->load->model("openstack");
		$tokenID = $this->openstack->authenticate_v2()['access']['token']['id'];
		$subnetName = $_POST['subnetName'];
		$subnetCIDR = $_POST['subnetCIDR'];
		$this->openstack->create_network($tokenID,$name,$subnetName,$subnetCIDR);
		$this->network_manager();
	}
	function delete_network(){
		//1. check if the ip address is allocated.
		//the operation fails if so
		// delete related router
		// delete subnet
		// then delete network
		echo "we are developing the function ...";
	}
	function create_router(){
		echo "we are developing the function ...";

	}


	function add_VM($isTarget,$courseID){
		//首先创建虚拟机
		$this->load->model('openstack');
		//$userName = 'symol';
		//$password = 'God!sMe';
		$this->load->library('session');
		$token = $this->openstack->authenticate_v2();
		$tenantID = $token['access']['token']['tenant']['id'];
		//echo $tenantID;
		$tokenID = $token['access']['token']['id'];
		//echo $tokenID;
		$keypairs = $this->openstack->get_resources($tokenID,$tenantID,'keypair')['keypairs'];
		//print_r($keypairs);
		//$keypairs = $this->openstack->get_resources($tokenID,$tenantID,'keypair');
		$networks = $this->openstack->get_resources($tokenID,$tenantID,'network')['networks'];
		$flavors = $this->openstack->get_resources($tokenID,$tenantID,'flavor')['flavors'];
		//$images = $this->openstack->get_resources($tokenID,$tenantID,'image')['images'];
		$this->load->model('imageCrud');
		$images = $this->imageCrud->read_courseImage_list($courseID,$isTarget);
		$this->load->view('/student/top');
		$this->load->view('/student/left',array('left'=>"1"));
		$this->load->view('/student/course/createVMR',array('networks'=>$networks,'flavors'=>$flavors,'images'=>$images,'keypairs'=>$keypairs,'courseID'=>$courseID,'isTarget'=>$isTarget));
		$this->load->view('/student/botton');
	}

	function start_course($courseID){
		$this->load->model('openstack');
		$this->load->model('courseCrud');
		$this->load->library('session');
		$userNum = $this->session->userdata('s_id');
		//$attackerVM = $this->openstack->read_attacker_VM($courseID);
		//$targetVM = $this->openstack->read_target_VM($courseID);
		$VMs = $this->courseCrud->read_vm($courseID,$userNum);
		// print_r($VMs);
		$this->load->view('/student/top');
		$this->load->view('/student/left',array('left'=>"1"));
		$this->load->view('/student/course/startCourseR',
			array(
				'attackerVM'=>$VMs["attackerVM"],
				'targetVM'=>$VMs['targetVM'],
				'courseID'=>$courseID));
		$this->load->view('/student/botton');
	}
	function create_VM_action($isTarget,$courseID){
		// echo "this is create_VM_action";
		$this->load->model("courseCrud");
		$this->courseCrud->create_vm($courseID,$isTarget);
		$this->start_course($courseID);
	}
	function delete_VM_action($courseID,$vmID){
		$this->load->model("courseCrud");
		$this->courseCrud->delete_vm($courseID,$vmID);
		$this->start_course($courseID);
	}

}