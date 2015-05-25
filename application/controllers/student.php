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
		$this->load->view('/student/top');
		$this->load->view('/student/left',array('left'=>"0"));
		//$this->load->view('/student/overviewR',array("Nall"=$all,"Nselected"=>$select,"Nundergo"=>$undergo,"Nfinishe"=>$finish));
		//$this->load->view('/student/studentR',array('data'=>$course,'courseType'=>$courseType));
		$this->load->view('/student/botton');
	}
	function course_manager(){
		$this->load->model('courseCrud');
		$courseType = $this->courseCrud->read_type_list();
		$course = $this->courseCrud->read_course_list("-1","0");
		//echo $course[0]->File;
		$this->load->view('/student/top');
		$this->load->view('/student/left',array('left'=>"1"));
		$this->load->view('/student/studentR',array('data'=>$course,'courseType'=>$courseType));
		$this->load->view('/student/botton');
	}
	function download_file($courseID){
		$filePath = $this->db->select("File")->from("courses")->where("CourseID",$courseID)->get()->result()[0]->File;
		$this->load->helper('download');
		//echo $file;
		$data = file_get_contents($filePath);
		$name = "newfile.doc";
		force_download($name,$data);
	}
	function create_vm($courseID){
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

		$this->load->view('/student/top');
		$this->load->view('/student/left',array('left'=>"1"));
		$this->load->view('/student/course/startCourseR',array('newtworks'=>$networks,'flavors'=>$flavors,'images'=>$images));
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
		$this->load->view('/student/top');
		$this->load->view('/student/left',array('left'=>"1"));
		$this->load->view('/student/course/startCourseR',array('attackerVM'=>$VMs["attackerVM"],'targetVM'=>$VMs['targetVM'],'courseID'=>$courseID));
		$this->load->view('/student/botton');
		//echo "this is start course";
		//从openstack中获取网络列表，获取flavor列表，获取image列表。
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
	function add_VM($isTarget,$courseID){
		//首先创建虚拟机
		$this->load->model('openstack');
		$userName="admin";
		$password="xuexihao";
		//$userName = 'symol';
		//$password = 'God!sMe';
		$token = $this->openstack->authenticate_v2($userName,$password);
		$tokenExpires = $token['access']['token']['expires'];
		$tenantID = $token['access']['token']['tenant']['id'];
		//echo $tenantID;
		$tokenID = $token['access']['token']['id'];
		//echo $tokenID;
		$keypairs = $this->openstack->get_resources($tokenID,$tenantID,'keypair')['keypairs'];
		//$keypairs = $this->openstack->get_resources($tokenID,$tenantID,'keypair');
		$networks = $this->openstack->get_resources($tokenID,$tenantID,'network')['networks'];
		$flavors = $this->openstack->get_resources($tokenID,$tenantID,'flavor')['flavors'];
		//$images = $this->openstack->get_resources($tokenID,$tenantID,'image')['images'];
		$this->load->model('imageCrud');
		$images = $this->imageCrud->read_courseImage_list($courseID,$isTarget);
		//print_r($images);
		//$servers = $this->openstack->get_resources($tokenID,$tenantID,'server')['servers']
		//echo "keypairs:";print_r($keypairs);echo "<br>";echo "<br>";
		//echo "newtworks:";print_r($networks);echo "<br>";echo "<br>";
		//echo "flavors:";print_r($flavors);echo "<br>";echo "<br>";
		//echo "images:";print_r($images);echo "<br>";echo "<br>";

		$this->load->view('/student/top');
		$this->load->view('/student/left',array('left'=>"1"));
		$this->load->view('/student/course/createVMR',array('networks'=>$networks,'flavors'=>$flavors,'images'=>$images,'keypairs'=>$keypairs,'courseID'=>$courseID));
		$this->load->view('/student/botton');

		//获取创建虚拟机所需要的信息：
		//images
		//flavors
		//networks
		//创建完成后添加到数据库中

	}
	function create_VM_action($courseID){
		echo "this is create_VM_action";
		$this->load->model('openstack');
		$userName = "testDemo";
		$password = "xuexihao";
		$tenantName = "test";
		//$userName = 'symol';
		//$password = 'God!sMe';
		$token = $this->openstack->authenticate_v2($userName,$password,$tenantName);
		$tokenExpires = $token['access']['token']['expires'];
		$tenantID = $token['access']['token']['tenant']['id'];
		//echo $tenantID;
		$tokenID = $token['access']['token']['id'];
		$name = $_POST['vmName'];
		$imageRef = $_POST['image'];
		$network = $_POST['network'];
		echo "network=";
		print_r($network);
		$key = $_POST['keypair'];
		$flavorRef = $_POST['flavor'];
		//$this->load->model('imageCrud');
		//$imageURL = "http://202.120.58.110:8774".$this->imageCrud->read_imageName_by_imageID($imageID);
		$serverInfo = $this->openstack->create_server($tokenID,$tenantID,$name,$imageRef,$key,$flavorRef,$network);
		print_r($serverInfo);
	}
	function get_VM_console($courseID,$serverID){

	}

}