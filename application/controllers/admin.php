<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {
	public function __construct() {
		parent::__construct();
		//首先检查用户是否已经登录，用户类型是否是管理员
		$this->load->library('session');
		$this->load->model('userCrud');	
		$userNum = $this->session->userdata('s_id');
		$userType = $this->userCrud->read_user_type($userNum);
		if ($userType!='0'){
			echo 'not authorized!';
			die();
			$this->load->view("login");
		}
	}
	public function index(){
		//admin用户登录进来以后的第一个页面
		$this->load->model('openstack');
		$token = $this->openstack->authenticate_v2();
		//$tokenID = $token['access']['token']['id'];
		//$tenantID = $token['access']['token']['tenant']['id'];
		$this->load->model('imageCrud');
		$this->imageCrud->syc_openstack();
		$image=$this->imageCrud->count_image();
		$this->load->model('userCrud');
		$user = $this->userCrud->count_user();
		$this->load->model('courseCrud');
		$course = $this->courseCrud->count_course();
		$data = array('NAdmin' => $user[0],
			'NTeacher' => $user[1],
			'NStudent' => $user[2],
			'NCourseOff' => $course[0],
			'NCourseOn' => $course[1],
			'NCourseDone' => $course[2],
			//'NImage' => $imageOSCount);
			'NImage' => $image);
		$this->load->view('/admin/top');
		$this->load->view('/admin/left',array('left'=>"0"));
		$this->load->view('/admin/overviewR',$data);
		$this->load->view('/admin/botton');
	}

	//(1)user manager:
	function user_manager($type="-1") {
		//和show_user_list一样，为了和course_manager,image_manager区分而设置
		$this->load->model('userCrud');
		$user = $this->userCrud->read_user_list($type);		
		$this->load->view('/admin/top');
		$this->load->view('/admin/left',array('left'=>"1"));
		$this->load->view('/admin/user/userManagerR',
			array("data"=>$user,
				"activeTop"=>$type,
				"selectColumn"=>"0",
				'keyword'=>"",
				'result'=>array()));
		$this->load->view('/admin/botton');

		//$this->load->view('/admin/user/userManager',array("data"=>$user,"activeTop"=>$type,"selectColumn"=>"0",'keyword'=>""));
	}
	function search_user($type="-1"){
		$this->load->model('userCrud');
		$keyword = $_POST["keyword"];
		$column = $_POST["selectColumn"];
		// print_r($column);
		//function search_user($columnName,$keyword,$type="-1")
		$user = $this->userCrud->search_user($column,$keyword,$type);
		$this->load->view('/admin/top');
		$this->load->view('/admin/left',array('left'=>"1"));
		$this->load->view('/admin/user/userManagerR',
			array("data"=>$user,
				"activeTop"=>$type,
				"selectColumn"=>$column,
				'keyword'=>$keyword,
				'result'=>array()));
		$this->load->view('/admin/botton');

		//$this->load->view('/admin/user/userManager',array('data'=>$user,'activeTop'=>$type,'selectColumn'=>$column,'keyword'=>$keyword));	
	}
	//2.create user item
	function create_user(){
		$this->load->view('/admin/top');
		$this->load->view('/admin/left',array('left'=>"1"));
		$this->load->view('/admin/user/userCreateR');
		$this->load->view('/admin/botton');
	}
	function create_user_action(){
		$this->load->model('userCrud');
		$newUser = array(
			'UserNum'=>trim($_POST['userNum']),
			'UserName'=>trim($_POST['userName']),
			'Password'=>md5(trim($_POST['password'])),
			'Gender'=>trim($_POST['Gender']),
			'Email'=>trim($_POST['Email']),
			'Section'=>trim($_POST['Section']),
			'Type'=>trim($_POST['Type']));
		$result=$this->userCrud->create_user($newUser);
		$user = $this->userCrud->read_user_list();
		$this->load->view('/admin/top');
		$this->load->view('/admin/left',array('left'=>"1"));
		$this->load->view('/admin/user/userManagerR',
			array('data'=>$user,
				'activeTop'=>"-1",
				'selectColumn'=>"0",
				'keyword'=>"",
				'result'=>$result));
		$this->load->view('/admin/botton');
		//$this->load->view('/admin/user/userManager',array('data'=>$user,'activeTop'=>"-1",'selectColumn'=>"0",'keyword'=>""));
	}
	//3.delete user item
	//crud: function delete($tableName,$colName,$colValue){}
	function delete_user(){
		$this->load->model("userCrud");
		if(!empty($_POST["deleteUser"])){
			$users = $_POST["deleteUser"];
			$result = $this->userCrud->delete_user($users);
		}
		//$user = $this->userCrud->read_user_all()
		$type = "-1";
		$user = $this->userCrud->read_user_list($type);		

		$this->load->view('/admin/top');
		$this->load->view('/admin/left',array('left'=>"1"));
		$this->load->view('/admin/user/userManagerR',
			array('data'=>$user,
				'activeTop'=>"0",
				'selectColumn'=>"0",
				'keyword'=>"",
				'result'=>$result));
		$this->load->view('/admin/botton');
		//$this->load->view('/admin/user/userManager',array('data'=>$user,'activeTop'=>"0",'selectColumn'=>"0",'keyword'=>"") );
		//show_user_list()
		//$user = $this->crud->read_user_by_type("0");
		//$this->load->view('/admin/userManager',array('data'=>$user) );
	}
	//4.update other user's profile
	function show_user_detail($userNum){
		$this->load->model('userCrud');
		$userData = $this->userCrud->read_user_info($userNum);
		// print_r($userData);

		$this->load->view('/admin/top');
		$this->load->view('/admin/left',array('left'=>"1"));
		$this->load->view('/admin/user/userProfileR',array('data'=>$userData[0],'message'=>""));
		$this->load->view('/admin/botton');
		// echo "this is view_user:".$userNum;
		//这边就直接进入用户的界面就好了。不过会不会有点过于简单粗暴了。。。。
	}
	function update_user_action($userNum){
		//获取用户post过来的用户名
		//这个目前还没有做
		//这边不能修改用户的角色类型，否则在openstack中的用户结构也要发生变化，会非常复杂

		$this->load->model('userCrud');	
		// $userNum = $this->session->userdata('s_id');
		try {
			$this->userCrud->update_user_info(
				array('UserName'=>trim($_POST['userName']),
					'Gender'=>trim($_POST['Gender']),
					'Email'=>trim($_POST['Email']),
					'Section'=>trim($_POST['Section'])),
				$userNum);
			$message = "修改成功！";
		}catch(Exception $e){
			$message = $e->getMessage();
		}
		//if success!
		// $userNum = $this->session->userdata('s_id');
		$user = $this->userCrud->read_user_info($userNum)[0];
		// print_r($user);
		$this->load->view('/admin/top');
		$this->load->view('/admin/left',array('left'=>"1"));
		$this->load->view('/admin/user/userProfileR',array('data'=>$user,'message'=>$message));
		$this->load->view('/admin/botton');
	}

	//（2）course manager
	//show the index page:
	function course_manager($type="-1") {
		$this->load->model("courseCrud");
		//read_course_list($type="0",$isAdmin="0")
		$courseType = $this->courseCrud->read_type_list();
		$course = $this->courseCrud->read_course_list($type,"1");
		$this->load->view('/admin/top');
		$this->load->view('/admin/left',array('left'=>"2"));
		$this->load->view("/admin/course/courseManagerR",
			array('data'=>$course,
				'courseType'=>$courseType,
				'activeTop'=>$type,
				'selectColumn'=>"0",
				'keyword'=>""));
		$this->load->view('/admin/botton');
		//$this->load->view("/admin/course/courseManager",array('data'=>$course,'courseType'=>$courseType,'activeTop'=>$type,'selectColumn'=>"0",'keyword'=>""));
	}
	function show_course_detail($courseID){
		$this->load->model("courseCrud");
		$this->load->model("userCrud");
		$this->load->model("imageCrud");
		$teachers = $this->userCrud->read_teacher_list();
		$types = $this->courseCrud->read_type_list();
		$images = $this->imageCrud->read_courseImage_list($courseID);
		//$attackerImage = $this->imageCrud->get_attacker_image($courseID);
		//$targetImage = $this->imageCrud->get_target_image($courseID);
		$courseInfo = $this->courseCrud->read_course_Detail($courseID);
		$this->load->view('/admin/top');
		$this->load->view('/admin/left',array('left'=>"2"));
		//$this->load->view("/admin/course/courseDetailR",array('data'=>$courseInfo,'teachers'=>$teachers,'types'=>$types,'attackerImage'=>$attackerImage,'targetImage'=>$targetImage));
		$this->load->view("/admin/course/courseDetailR",
			array('data'=>$courseInfo,
				'teachers'=>$teachers,
				'types'=>$types,
				'attackerImage'=>$images['attackerImage'],
				'targetImage'=>$images['targetImage']));
		$this->load->view('/admin/botton');
		//$this->load->view("/admin/course/courseDetail",array('data'=>$courseInfo,'teachers'=>$teachers,'types'=>$types,'images'=>$images));
	}

	function course_add_image($isTarget,$courseID){
		$this->load->model('imageCrud');
		$images = $this->imageCrud->read_image_list();
		$this->load->view("/admin/top");
		$this->load->view("/admin/left",array('left'=>"2"));
		$this->load->view("/admin/course/courseImageR",
			array('data'=>$images,
				'obj'=>$isTarget,
				'courseID'=>$courseID));//'obj'=0 ==>attacker,'obj'=1 ==>target
		$this->load->view("/admin/botton");
	}
	function course_add_image_action($isTarget,$courseID){
		$this->load->model('imageCrud');
		if(!empty($_POST['imageList'])){
			$images = $_POST['imageList'];
			//print_r($images);
			for ($i=0; $i < count($images); $i++) {
				$this->imageCrud->add_courseImage($isTarget,$courseID,$images[$i]);
			}
		}
		//显示课程信息
		$this->load->model("courseCrud");
		$this->load->model("userCrud");
		$this->load->model("imageCrud");
		$teachers = $this->userCrud->read_teacher_list();
		$types = $this->courseCrud->read_type_list();
		$images = $this->imageCrud->read_courseImage_list($courseID);
		$courseInfo = $this->courseCrud->read_course_Detail($courseID);
		$this->load->view('/admin/top');
		$this->load->view('/admin/left',array('left'=>"2"));
		$this->load->view("/admin/course/courseDetailR",
			array('data'=>$courseInfo,
				'teachers'=>$teachers,
				'types'=>$types,
				'attackerImage'=>$images['attackerImage'],
				'targetImage'=>$images['targetImage']));
		$this->load->view('/admin/botton');

	}
	function course_delete_image($isTarget,$courseID,$imageID){
		$this->load->model("imageCrud");
		$this->imageCrud->delete_courseImage($isTarget,$courseID,$imageID);
		$this->load->model("courseCrud");
		$this->load->model("userCrud");
		$this->load->model("imageCrud");
		$teachers = $this->userCrud->read_teacher_list();
		$types = $this->courseCrud->read_type_list();
		$images = $this->imageCrud->read_courseImage_list($courseID);
		$courseInfo = $this->courseCrud->read_course_Detail($courseID);
		$this->load->view('/admin/top');
		$this->load->view('/admin/left',array('left'=>"2"));
		$this->load->view("/admin/course/courseDetailR",
			array('data'=>$courseInfo,
				'teachers'=>$teachers,
				'types'=>$types,
				'attackerImage'=>$images['attackerImage'],
				'targetImage'=>$images['targetImage']));
		$this->load->view('/admin/botton');
	}

	function search_course($type){
		$this->load->model("courseCrud");
		$column = $_POST["selectColumn"];
		$keyword = $_POST["keyword"];		
		$courseType = $this->courseCrud->read_type_list();
		$course = $this->courseCrud->search_course_list($type,"1",$column,$keyword);
		$this->load->view('/admin/top');
		$this->load->view('/admin/left',array('left'=>"2"));
		$this->load->view("/admin/course/courseManagerR",
			array('data' =>$course,'courseType'=>$courseType,'activeTop'=>$type,'selectColumn'=>$column));
		$this->load->view('/admin/botton');
		//$this->load->view("/admin/course/courseManager",array('data' =>$course,'courseType'=>$courseType,'activeTop'=>$type,'selectColumn'=>$column));
	}
	function create_course(){
		$this->load->model('userCrud');
		$this->load->model('courseCrud');
		$this->load->model('imageCrud');
		$teachers = $this->userCrud->read_teacher_list();
		$types = $this->courseCrud->read_type_list();
		$images = $this->imageCrud->read_image_list();
		// print_r($images);
		//$token = $this->openstack->authenticate_v2($userName,$password);
		//$imagesOS = $this->imageCrud->get_image_list_os();
        if(count($images)==0) {
        	echo "<script>alert('please create image first!')</script>";
			$this->load->view('/admin/top');
			$this->load->view('/admin/left',array('left'=>"2"));
        	$this->load->view('/admin/image/imageCreateR');
			$this->load->view('/admin/botton');
        }
        if(count($teachers)==0){
        	echo "<script>alert('please create teacher first!')</script>";
			$this->load->view('/admin/top');
			$this->load->view('/admin/left',array('left'=>"1"));
        	$this->load->view('/admin/user/userCreateR');
			$this->load->view('/admin/botton');
        }
		$this->load->view('/admin/top');
		$this->load->view('/admin/left',array('left'=>"2"));        
		$this->load->view('/admin/course/courseCreateR',array('teachers'=>$teachers,'types'=>$types,'images'=>$images));
		$this->load->view('/admin/botton');		
	}
	function course_push($courseID){
		$this->load->model("courseCrud");
		$this->courseCrud->push_course($courseID);
		$this->load->model("userCrud");
		$this->load->model("imageCrud");
		//$teachers = $this->userCrud->read_teacher_list();
		//$types = $this->courseCrud->read_type_list();
		//$attackerImage = $this->imageCrud->get_attacker_image($courseID);
		//$targetImage = $this->imageCrud->get_target_image($courseID);
		//$courseInfo = $this->courseCrud->read_course_Detail($courseID);
		$type="-1";
		$courseType = $this->courseCrud->read_type_list();
		$course = $this->courseCrud->read_course_list($type,"1");
		$this->load->view('/admin/top');
		$this->load->view('/admin/left',array('left'=>"2"));
		$this->load->view("/admin/course/courseManagerR",array('data'=>$course,'courseType'=>$courseType,'activeTop'=>$type,'selectColumn'=>"0",'keyword'=>""));
		$this->load->view('/admin/botton');
		/*
		$this->load->view('/admin/top');
		$this->load->view('/admin/left',array('left'=>"2"));
		$this->load->view("/admin/course/courseManagerR",array('data'=>$courseInfo,'teachers'=>$teachers,'types'=>$types,'attackerImage'=>$attackerImage,'targetImage'=>$targetImage));
		$this->load->view('/admin/botton');*/

	}
	function course_pull($courseID){
		$this->load->model("courseCrud");
		$this->courseCrud->pull_course($courseID);
		$this->load->model("userCrud");
		$this->load->model("imageCrud");
		$type="-1";
		$courseType = $this->courseCrud->read_type_list();
		$course = $this->courseCrud->read_course_list($type,"1");
		$this->load->view('/admin/top');
		$this->load->view('/admin/left',array('left'=>"2"));
		$this->load->view("/admin/course/courseManagerR",array('data'=>$course,'courseType'=>$courseType,'activeTop'=>$type,'selectColumn'=>"0",'keyword'=>""));
		$this->load->view('/admin/botton');

	}
	function update_course_action($courseID){
		$this->load->model('courseCrud');
		$config['upload_path']='./uploads';
		$config['allowed_types']='pdf|doc|docx';
		$config['max_size']='10240000';//10mb
		$config['file_name']  = time();
		$this->load->library('upload',$config);
		$data = $this->upload->do_upload('file');
		if($data){
			$file_info = array('upload_data'=>$this->upload->data());
			$newCourse = array('CourseName'=>$_POST['courseName'],'TeacherID'=>$_POST['teacherID'],
			'TypeID'=>$_POST['typeID'],'Duration'=>$_POST['duration'],'File'=>$file_info['upload_data']['full_path'],
			'SubmitLimit'=>$_POST['submitLimit'],'CourseDesc'=>$_POST['courseDesc'],
			'StartTime'=>$_POST['startTime'],'StopTime'=>$_POST['stopTime'],'Location'=>$_POST['location']);
			//$newType = array('TypeName'=>$_POST['typeName'],'TypeDesc'=>$_POST['Description']);
		}else{
			//$error=array('error'=>$this->upload->display_errors());
			//$file_info['upload_data']['full_path']="";
			//var_dump($error);
			$newCourse = array('CourseName'=>$_POST['courseName'],'TeacherID'=>$_POST['teacherID'],
			'TypeID'=>$_POST['typeID'],'Duration'=>$_POST['duration'],
			'SubmitLimit'=>$_POST['submitLimit'],'CourseDesc'=>$_POST['courseDesc'],
			'StartTime'=>$_POST['startTime'],'StopTime'=>$_POST['stopTime'],'Location'=>$_POST['location']);
		}
		$this->courseCrud->update_course_detail($newCourse,$courseID);	
		$course = $this->courseCrud->read_course_list("-1","1");
		$courseType = $this->courseCrud->read_type_list();
		$this->load->view('/admin/top');
		$this->load->view('/admin/left',array('left'=>"2"));
		$this->load->view("/admin/course/courseManagerR",array('data'=>$course,'courseType'=>$courseType,'activeTop'=>-1,'selectColumn'=>"0",'keyword'=>""));
		$this->load->view('/admin/botton');
	}
	function create_course_action(){
		$this->load->model('courseCrud');
		$config['upload_path']='./uploads';
		$config['allowed_types']='pdf|doc|docx';
		$config['max_size']='10240000';//10mb
		$config['file_name']  = time();
		$this->load->library('upload',$config);
		$data = $this->upload->do_upload('file');
		if($data){
			$file_info = array('upload_data'=>$this->upload->data());
			$newCourse = array('CourseName'=>$_POST['courseName'],'TeacherID'=>$_POST['teacherID'],
				'TypeID'=>$_POST['typeID'],'Duration'=>$_POST['duration'],'File'=>$file_info['upload_data']['full_path'],
				'SubmitLimit'=>$_POST['submitLimit'],'CourseDesc'=>$_POST['courseDesc'],
				'StartTime'=>$_POST['startTime'],'StopTime'=>$_POST['stopTime'],'Location'=>$_POST['location']);
			//$newType = array('TypeName'=>$_POST['typeName'],'TypeDesc'=>$_POST['Description']);
			$this->courseCrud->create_course($newCourse);

			//add courseVM

			$courseID = $this->courseCrud->get_lately_added_courseID();
			$this->load->model("imageCrud");
			$attackerImage = ($_POST['attackerImage']);
			if(!$attackerImage){
				$isTarget = "0";
				$this->imageCrud->add_courseImage($isTarget,$courseID,$attackerImage);
			}
			$targetImage = $_POST['targetImage'];
			if(!$targetImage){
				$isTarget = "1";
				$this->imageCrud->add_courseImage($isTarget,$courseID,$targetImage);
			}

			$course = $this->courseCrud->read_course_list("-1","1");
			$courseType = $this->courseCrud->read_type_list();
			$this->load->view('/admin/top');
			$this->load->view('/admin/left',array('left'=>"2"));
			$this->load->view("/admin/course/courseManagerR",array('data'=>$course,'courseType'=>$courseType,'activeTop'=>-1,'selectColumn'=>"0",'keyword'=>""));
			$this->load->view('/admin/botton');

		}else{
			$error=array('error'=>$this->upload->display_errors());
			$file_info['upload_data']['full_path']="";
			var_dump($error);
		}
		
		// $this->load->model('courseCrud');
		// $this->load->model('imageCrud');
		// $courseID = $this->courseCrud->get_lately_added_courseID();
		// $isTarget = '1';
		// $imageID = '6ba6c84b-0646-4b4a-ac0d-c8ce1d95f697';
		// $this->imageCrud->add_courseImage($isTarget,$courseID,$imageID);
		//$this->load->view("/admin/course/courseManager",array('data'=>$course,'courseType'=>$courseType,'activeTop'=>-1,'selectColumn'=>"0",'keyword'=>""));
	
	}

	function delete_course_action($type){
		$this->load->model("courseCrud");
		if(!empty($_POST["deleteCourse"])){
			$courses = $_POST["deleteCourse"];
			for($i=0; $i< count($courses); $i++){
				$this->courseCrud->delete_course($courses[$i]);
			}
		}
		$courseType = $this->courseCrud->read_type_list();
		$course = $this->courseCrud->read_course_list($type,"1");
		$this->load->view('/admin/top');
		$this->load->view('/admin/left',array('left'=>"2"));
		$this->load->view("/admin/course/courseManagerR",array('data'=>$course,'courseType'=>$courseType,'activeTop'=>$type,'selectColumn'=>"0",'keyword'=>""));
		$this->load->view('/admin/botton');
		//$this->load->view("/admin/course/courseManager",array('data'=>$course,'courseType'=>$courseType,'activeTop'=>$type,'selectColumn'=>"0",'keyword'=>""));
	}
	//course type
	function show_courseType_list(){
		$this->load->model("courseCrud");
		$courseType = $this->courseCrud->read_type_list();
		$this->load->view('/admin/top');
		$this->load->view('/admin/left',array('left'=>"2"));
		$this->load->view("/admin/course/courseTypeR",array('data'=>$courseType));	
		$this->load->view('/admin/botton');
	}
	function create_courseType(){
		$this->load->view('/admin/top');
		$this->load->view('/admin/left',array('left'=>"2"));
		$this->load->view('/admin/course/courseTypeCreateR');
		$this->load->view('/admin/botton');
	}
	function create_courseType_action(){
		$this->load->model('courseCrud');
		$newType = array('TypeName'=>$_POST['typeName'],'TypeDesc'=>$_POST['Description']);
		$this->courseCrud->create_type($newType);
		$courseType = $this->courseCrud->read_type_list("coursetype");
		$this->load->view('/admin/top');
		$this->load->view('/admin/left',array('left'=>"2"));
		$this->load->view("/admin/course/courseTypeR",array('data' =>$courseType));
		$this->load->view('/admin/botton');
	}
	function delete_courseType_action(){
		$this->load->model("courseCrud");
		if(!empty($_POST["deleteCourseType"])){
			$type = $_POST["deleteCourseType"];
			for($i=0; $i< count($type); $i++){
				$this->courseCrud->delete_type($type[$i]);
			}
		}
		$courseType = $this->courseCrud->read_type_list("coursetype");
		$this->load->view('/admin/top');
		$this->load->view('/admin/left',array('left'=>"2"));
		$this->load->view("/admin/course/courseTypeR",array('data' =>$courseType));
		$this->load->view('/admin/botton');
	}

	function image_manager() {		
		//$this->load->model('openstack');
		$this->load->model('imageCrud');
		$this->imageCrud->syc_openstack();
		$images = $this->imageCrud->read_image_list();
		//print_r($images);
		$this->load->view('/admin/top');
		$this->load->view('/admin/left',array('left'=>"3"));
		$this->load->view('/admin/image/imageManagerR',array('data'=>$images));
		$this->load->view('/admin/botton');
	}
	function image_create(){
		$this->load->model("imageCrud");
		$this->imageCrud->create_image();
		$this->load->view('/admin/top');
		$this->load->view('/admin/left',array('left'=>"3"));
		$this->load->view('/admin/image/imageCreateR');
		$this->load->view('/admin/botton');
	}
	function image_create_action(){
		$this->load->model('imageCrud');
		//$request = ....
		//$ImageID = create_image_os($request);
		$ImageID = "1111111111111111111";
		$data = array('ImageName'=>$_POST['imageName'],'ImageID'=>$ImageID,'ImageDesc'=>$_POST['imageDesc']);
		$this->imageCrud->create_image($data);
		$images = $this->imageCrud->read_image_list();
		$this->load->view('/admin/top');
		$this->load->view('/admin/left',array('left'=>"3"));
		$this->load->view('/admin/image/imageManagerR',array('data'=>$images));
		$this->load->view('/admin/botton');
	}
	function upload_image(){
		$this->load->model("imageCrud");
		$config['upload_path']='upload';
		//$config['allowed_types']='iso';
		$config['max_size']='1024000000';
		$config['max_width']='1024';
		$config['max_height']='768';
		$this->load->library('upload',$config);
		$this->upload->do_upload();
		$data = $this->upload->data();

		if($this->upload->do_upload('imageFile')){
			$data = array('upload_data'=>$this->upload->data());
			var_dump($data);
		}else{
			$error=array('error'=>$this->upload->display_errors());
			var_dump($error);
		}
		$images = $this->imageCrud->read_image_list();
		$this->load->view('/admin/top');
		$this->load->view('/admin/left',array('left'=>"3"));
		$this->load->view("/admin/image/imageManagerR",array("data"=>$data));
		$this->load->view('/admin/botton');
	}

/*
	function profile() {
		if ($this->session->userdata('s_id')){
			$userNum = $this->session->userdata('s_id');
			$this->load->model('userCrud');
			$user = $this->userCrud->read_user_info($userNum);
			//$admin = $this->crud->select(array('UserID,UserNum,UserName,Gender,Email,Section,Type','users','UserNum',$userNum));
			$this->load->view('/admin/profile',array('data'=>$user));
		}
	}
	function edit_profile(){
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
		$this->load->view('/admin/profileEditResult',array('data'=>$user,'message'=>$message));
	}
	function reset_pswd() {		
		$this->load->view('/admin/resetpswd');
	}
	function check_pswd(){
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
			$this->load->view('/admin/resetPswdFailed',array('message'=>$message));
		}
	}*/
}

/* End of file login.php */
/* Location: ./application/controllers/login.php */