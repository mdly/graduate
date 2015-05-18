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
		$this->load->view('/student/student',array('data'=>$course,'courseType'=>$courseType));
	}
	function course_manager(){
		$this->load->model('courseCrud');
		$courseType = $this->courseCrud->read_type_list();
		$course = $this->courseCrud->read_course_list("-1","0");
		//echo $course[0]->File;
		$this->load->view('/student/student',array('data'=>$course,'courseType'=>$courseType));
	}
	function download_file($courseID){
		$filePath = $this->db->select("File")->from("courses")->where("CourseID",$courseID)->get()->result()[0]->File;
		$this->load->helper('download');
		//echo $file;
		$data = file_get_contents($filePath);
		$name = "newfile.doc";
		force_download($name,$data);
	}
	function start_course($courseID){
		//echo "this is start course";
		//从openstack中获取网络列表，获取flavor列表，获取image列表。
		$this->load->model('openstack');
		$userName = 'symol';
		$password = 'God!sMe';
		$token = $this->openstack->authenticate_v2($userName,$password);
		$tokenExpires = $token['access']['token']['expires'];
		$tenantID = $token['access']['token']['tenant']['id'];
		//echo $tenantID;
		$tokenID = $token['access']['token']['id'];
		//echo $tokenID;
		$networks = $this->openstack->get_resources($tokenID,$tenantID,'network')['networks'];
		$flavors = $this->openstack->get_resources($tokenID,$tenantID,'flavor')['flavors'];
		$images = $this->openstack->get_resources($tokenID,$tenantID,'image')['images'];
		$servers = $this->openstack->get_resources($tokenID,$tenantID,'server')['servers'];
		//print_r($servers);

		//echo count($networks);
		//echo count($flavors);
		//echo count($images);
		//show the create vm page

		//$this->load->view('/student/setEnviron');
		//虚拟机的创建涉及：
		//echo "this is start_course function";
		//print_r($network);
		/*
		for ($i=0;$i<count($imageOS);$i++){
			$data=array('ImageName'=>$imageOS[$i]['name'],'ImageID'=>$imageOS[$i]['id'],'ImageURL'=>$imageOS[$i]['self'],'ImageDesc'=>'');
			$this->imageCrud->get_image_from_os($data);
		}
		*/
		//获取网络信息
		//获取虚拟机信息
		//创建虚拟机
		//开启虚拟机
	}

}