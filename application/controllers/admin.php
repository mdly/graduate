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
		$this->load->model('userCrud');
		$user = $this->userCrud->count_user();
		$this->load->model('courseCrud');
		$course = $this->courseCrud->count_course();
		$this->load->model('imageCrud');
		$image = $this->imageCrud->count_image();
		$data = array('NAdmin' => $user[0],'NTeacher' => $user[1],'NStudent' => $user[2],
			'NCourseOff' => $course[0],'NCourseOn' => $course[1],'NCourseDone' => $course[2],
			'NImage' => $image);
		$this->load->view('/admin/admin',$data);
	}

	//(1)user manager:

	function user_manager($type="-1") {
		//和show_user_list一样，为了和course_manager,image_manager区分而设置
		$this->load->model('userCrud');
		$user = $this->userCrud->read_user_list($type);
		$this->load->view('/admin/user/userManager',array("data"=>$user,"activeTop"=>$type,"selectColumn"=>"0",'keyword'=>""));
	}
	function search_user($type="-1"){
		$this->load->model('userCrud');
		$keyword = $_POST["keyword"];
		$column = $_POST["selectColumn"];
		//function search_user($columnName,$keyword,$type="-1")
		$user = $this->userCrud->search_user($column,$keyword,$type);
		$this->load->view('/admin/user/userManager',array('data'=>$user,'activeTop'=>$type,'selectColumn'=>$column,'keyword'=>$keyword));	
	}
	//2.create user item
	function create_user(){
		$this->load->view('/admin/user/userCreate');
	}
	function create_user_action(){
		$this->load->model('userCrud');
		$newUser = array('UserNum'=>$_POST['userNum'],'UserName'=>$_POST['userName'],'Password'=>md5($_POST['password']),'Gender'=>$_POST['Gender'],'Email'=>$_POST['Email'],'Section'=>$_POST['Section'],'Type'=>$_POST['Type']);
		$this->userCrud->create_user($newUser);
		$user = $this->userCrud->read_user_list();
		$this->load->view('/admin/user/userManager',array('data'=>$user,'activeTop'=>"-1",'selectColumn'=>"0",'keyword'=>""));
	}
	//3.delete user item
	//crud: function delete($tableName,$colName,$colValue){}
	function delete_user(){
		$this->load->model("userCrud");
		if(!empty($_POST["deleteUser"])){
			$users = $_POST["deleteUser"];
			for($i=0; $i< count($users); $i++){
				$this->userCrud->delete_user($users[$i]);
			}
		}
		$user = $this->userCrud->read_user_all();
		$this->load->view('/admin/user/userManager',array('data'=>$user,'activeTop'=>"0",'selectColumn'=>"0",'keyword'=>"") );
		//show_user_list()
		//$user = $this->crud->read_user_by_type("0");
		//$this->load->view('/admin/userManager',array('data'=>$user) );
	}
	//4.update other user's profile
	function show_user_detail($userNum){
		echo "this is view_user:".$userNum;
		//这边就直接进入用户的界面就好了。不过会不会有点过于简单粗暴了。。。。
	}
	function update_user_action($userNum){
		//获取用户post过来的用户名
		//这个目前还没有做
		$this->load->model('userCrud');
		$user = array('UserNum'=>$_POST['userNum'],'UserName'=>$_POST['userName'],'Password'=>md5($_POST['password']),'Gender'=>$_POST['Gender'],'Email'=>$_POST['Email'],'Section'=>$_POST['Section'],'Type'=>$_POST['Type']);
		$this->userCrud->insert_user($user);
		$admin = $this->userCrud->update_user_info($user,$userNum);
		$this->load->view('/admin/user/userManagerAdmin',array('data'=>$admin));
	}

	//（2）course manager
	//show the index page:
	function course_manager($type="-1") {
		$this->load->model("courseCrud");
		//read_course_list($type="0",$isAdmin="0")
		$courseType = $this->courseCrud->read_type_list();
		$course = $this->courseCrud->read_course_list($type,"1");
		$this->load->view("/admin/course/courseManager",array('data'=>$course,'courseType'=>$courseType,'activeTop'=>$type,'selectColumn'=>"0",'keyword'=>""));
		// 载入CI的session库
	}
	function show_course_detail($courseID){
		$this->load->model("courseCrud");
		$this->load->model("userCrud");
		$this->load->model("imageCrud");
		$teachers = $this->userCrud->read_teacher_list();
		$types = $this->courseCrud->read_type_list();
		$images = $this->imageCrud->read_image_list();
		$courseInfo = $this->courseCrud->read_course_Detail($courseID);
		$this->load->view("/admin/course/courseDetail",array('data'=>$courseInfo,'teachers'=>$teachers,'types'=>$types,'images'=>$images));
	}
	function search_course($type){
		$this->load->model("courseCrud");
		//function search_course_list($type="0",$isAdmin="0",$column,$keyword){
		$column = $_POST["selectColumn"];
		$keyword = $_POST["keyword"];		
		$courseType = $this->courseCrud->read_type_list();
		$course = $this->courseCrud->search_course_list($type,"1",$column,$keyword);
		echo count($course);
		$this->load->view("/admin/course/courseManager",array('data' =>$course,'courseType'=>$courseType,'activeTop'=>$type,'selectColumn'=>$column));
	}
	function create_course(){
		$this->load->model('userCrud');
		$this->load->model('courseCrud');
		$this->load->model('imageCrud');
		$teachers = $this->userCrud->read_teacher_list();
		$types = $this->courseCrud->read_type_list();
		$images = $this->imageCrud->read_image_list();
        if(count($images)==0) {
        	echo "<script>alert('please create image first!')</script>";
        	$this->load->view('/admin/image/imageCreate');
        }
		$this->load->view('/admin/course/courseCreate',array('teachers'=>$teachers,'types'=>$types,'images'=>$images));
	}
	function create_course_action(){
		//$this->load->model('crud');
		//处理上传的文件
		$this->load->model('courseCrud');
		$config['upload_path']='uploads';
		$config['allowed_types']='pdf|doc|docx';
		$config['max_size']='10240000';//10mb
		$this->load->library('upload',$config);
		$this->upload->do_upload('file');
		if($this->upload->do_upload('file')){
			$data = array('upload_data'=>$this->upload->data());
			var_dump($data);
		}else{
			$error=array('error'=>$this->upload->display_errors());
			var_dump($error);
		}
		$newCourse = array('CourseName'=>$_POST['courseName'],'TeacherID'=>$_POST['teacherID'],
			'TypeID'=>$_POST['typeID'],'Duration'=>$_POST['duration'],
			'SubmitLimit'=>$_POST['submitLimit'],'CourseDesc'=>$_POST['courseDesc'],
			'StartTime'=>$_POST['startTime'],'StopTime'=>$_POST['stopTime'],
			'Location'=>$_POST['location'],'ImageID'=>"12345");
		//$newType = array('TypeName'=>$_POST['typeName'],'TypeDesc'=>$_POST['Description']);
		$this->courseCrud->create_course($newCourse);
		$course = $this->courseCrud->read_course_list();
		$courseType = $this->courseCrud->read_type_list();
		$this->load->view("/admin/course/courseManager",array('data' =>$course,'courseType'=>$courseType,'activeTop'=>"0",'selectColumn'=>"0"));

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
		$this->load->view("/admin/course/courseManager",array('data'=>$course,'courseType'=>$courseType,'activeTop'=>$type,'selectColumn'=>"0",'keyword'=>""));

	}
	//course type
	function show_courseType_list(){
		$this->load->model("courseCrud");
		$courseType = $this->courseCrud->read_type_list();
		$this->load->view("/admin/course/courseType",array('data' =>$courseType));	
	}
	function create_courseType(){
		$this->load->view('/admin/course/courseTypeCreate');
	}
	function create_courseType_action(){
		$this->load->model('crud');
		$newType = array('TypeName'=>$_POST['typeName'],'TypeDesc'=>$_POST['Description']);
		$this->crud->create("courseType",$newType);
		$courseType = $this->crud->read_all("coursetype");
		$this->load->view("/admin/course/courseType",array('data' =>$courseType));
	}
	function delete_courseType_action(){
		$this->load->model("crud");
		if(!empty($_POST["deleteCourseType"])){
			$type = $_POST["deleteCourseType"];
			for($i=0; $i< count($type); $i++){
				$this->load->model("crud");
				$this->crud->delete("coursetype","TypeID",$type[$i]);
			}
		}
		$courseType = $this->crud->read_all("coursetype");
		$this->load->view("/admin/course/courseType",array('data'=>$courseType));
	}

	function image_manager() {
		$this->load->model('imageCrud');
		$images = $this->imageCrud->read_image_list();
		$this->load->view('/admin/image/imageManager',array('data'=>$images));
	}
	function image_create(){
		$this->load->view('/admin/image/imageCreate');
	}
	function image_create_action(){
		$this->load->model('imageCrud');
		//$request = ....
		//$ImageID = create_image_os($request);
		$ImageID = "1111111111111111111";
		$data = array('ImageName'=>$_POST['imageName'],'ImageID'=>$ImageID,'ImageDesc'=>$_POST['imageDesc']);
		$this->imageCrud->create_image($data);
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
		$this->load->view("/admin/image/imageManager",array("data"=>$data));
	}


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
	}
}

/* End of file login.php */
/* Location: ./application/controllers/login.php */