<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Student extends CI_Controller {
	public function __construct() {
		parent::__construct();
		//首先检查用户是否已经登录，用户类型是否是管理员
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
	function index(){
		$this->load->model('courseCrud');
		//$unselectedCourse = $this->courseCrud->read;
		$courseType = $this->courseCrud->read_type_list();
		$course = $this->courseCrud->read_course_list("-1","0");
		//echo $course[0]->File;
		//$all = $this->courseCrud->count_course();
		$this->load->library('session');
		$userNum = $this->session->userdata('s_id');
		$unselectedCourse = $this->courseCrud->read_unselected_course($userNum);
		$selectedCourse = $this->courseCrud->read_selected_course($userNum);
		$finishedCourse = $this->courseCrud->read_finished_course($userNum);
		$this->load->view('/student/top');
		$this->load->view('/student/left',array('left'=>"0"));
		$this->load->view('/student/overviewR',
			array("unselectedCourse"=>count($unselectedCourse),
				"selectedCourse"=>count($selectedCourse),
				"finishedCourse"=>count($finishedCourse))
			);
		// $this->load->view('/student/studentR',array('data'=>$course,'courseType'=>$courseType));
		$this->load->view('/student/botton');
	}
	function course_manager(){
		$this->load->model('courseCrud');
		$this->load->library("session");
		$userNum = $this->session->userdata('s_id');
		$courseType = $this->courseCrud->read_type_list();
		$course = $this->courseCrud->read_course_list("-1","0");
		$unselectedCourse = $this->courseCrud->read_unselected_course($userNum);
		//echo $course[0]->File;
		$this->load->view('/student/top');
		$this->load->view('/student/left',array('left'=>"1"));
		$this->load->view('/student/course/courseManagerR',array('data'=>$unselectedCourse,'courseType'=>$courseType));
		$this->load->view('/student/botton');
	}
	function selected_course_manager(){
		$this->load->model("courseCrud");
		$this->load->library("session");
		$userNum = $this->session->userdata('s_id');
		$selectedCourse = $this->courseCrud->read_selected_course($userNum);
		//
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
		//get userNum
		//get filepath;
		
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