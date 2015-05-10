<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {
	public function __construct() {
		parent::__construct();
		//首先检查用户是否已经登录，用户类型是否是管理员
		$this->load->library('session');
		$this->load->model('crud');	
		$userNum = $this->session->userdata('s_id');
		$userType = $this->crud->select(array('Type','users','UserNum',$userNum));
		if ($userType[0]->Type!='0'){
			echo 'not authorized!';
			die();
			$this->load->view("login");
		}
		//var_dump($this->session->all_userdata() );
		//die();
	}
	public function index(){
		//admin用户登录进来以后的第一个页面
		$this->load->model('crud');
		//获取overview的信息，包括用户数目，课程数目，镜像数目
		//使用函数为crud中的count_all和count_by_type:
		//function count_all($tableName){}
		//function count_by_type($tableName,$colName,$colValue){}
		$admin = $this->crud->count_by_type("users","Type","0");
		$teacher = $this->crud->count_by_type("users","Type","1");
		$student = $this->crud->count_by_type("users","Type","2");
		//查询课程信息	
		$CourseOff = $this->crud->count_by_type("courses","State","0");
		$CourseOn = $this->crud->count_by_type("courses","State","1");
		$CourseDone = $this->crud->count_by_type("courses","State","2");
		//查询镜像信息
		$Image = $this->crud->count_all('images');
		$data = array('NAdmin' => $admin,'NTeacher' => $teacher,'NStudent' => $student,
			'NCourseOff' => $CourseOff,'NCourseOn' => $CourseOn,'NCourseDone' => $CourseDone,
			'NImage' => $Image);
		$this->load->view('/admin/admin',$data);
	}
	//functions about user management
	//1.get user list by selected type
	/*
	function user_list(){
		//获取要求查看的用户类型
		//use the new function of:
		//function read_some_line($tableName,$colName,$colValue){}
		//function read_all($tableName){}
		if ($_POST["userType"]) $type = $_POST["userType"];
		else $type = "3";
		$this->load->model('crud');
		if($type<="2" && $type>="0"){
			$user = $this->crud->read_some_line("users","Type",$type);}
		else{$user = $this->crud->read_all("users");}		
		//echo "user:".$user[0]->UserNum;
		$this->load->view('/admin/userManager',array('data'=>$user) );
	}*/


	//(1)user manager:

	function user_manager() {
		//和show_user_list一样，为了和course_manager,image_manager区分而设置
		$this->load->model('crud');
		//$user = $this->crud->select_all("users");
		$user = $this->crud->read_user_all();
		$this->load->view('/admin/user/userManager',array("data"=>$user) );
	}
	//1.get user list. list all users by default

	function show_user_list(){
		//获取所有用户列表
		$this->load->model('crud');
		$user = $this->crud->read_user_all();
		//echo $user[0]->Type;
		$this->load->view('/admin/user/userManager',array('data'=>$user) );
	}	
	function show_admin_list(){
		//获取管理员用户列表
		$this->load->model('crud');
		$user = $this->crud->read_user_by_type("0");
		//$this->load->view('/admin/userManager',array('data'=>$user) );

		$this->load->view('/admin/user/userManagerAdmin1',array('data'=>$user) );
	}	
	function show_teacher_list(){
		//获取教师用户列表		
		$this->load->model('crud');
		$user = $this->crud->read_user_by_type("1");
		//$this->load->view('/admin/userManager',array('data'=>$user) );
		$this->load->view('/admin/user/userManagerTeacher1',array('data'=>$user) );
	}	
	function show_student_list(){
		//获取学生用户列表		
		$this->load->model('crud');
		$user = $this->crud->read_user_by_type("2");
		$this->load->view('/admin/user/userManagerStudent1',array('data'=>$user) );
	}

	function search_user(){
		//未用，关键是$type的获取。
		//搜索可以直接从数据库中搜索，或者从搜索到的数组中搜索；
		//两者的区别在于哪个的速度快，
		//另外，对于用户输入的关键字，如何判断在词条中？子串？
		$condition = $_POST["keyword"];
		$column = $_POST["selectColumn"];
		$this->load->model('crud');
		$findUser = $this->crud->search_by_column($column,$condition,$type);
		//模糊查询怎么做function search_by_column($column,$keyword){}

		switch ($type) {
			case '-1':$page = "/admin/user/userManager";break;
			case '0':$page = "/admin/user/userManagerAdmin1";break;
			case '1':$page = "/admin/user/userManagerTeacher1";break;
			case '2':$page = "/admin/user/userManagerStudent1";break;
			default:$page = "/admin/user/userManager";break;
		}
		$this->load->view($page,array('data'=>$findUser) );break;
		
	}

	function search_user_all(){
		//搜索可以直接从数据库中搜索，或者从搜索到的数组中搜索；
		//两者的区别在于哪个的速度快，
		//另外，对于用户输入的关键字，如何判断在词条中？子串？
		$condition = $_POST["keyword"];
		$column = $_POST["selectColumn"];
		$this->load->model('crud');
		$page = "/admin/user/userManager";
		$type = "-1";
		$findUser = $this->crud->search_by_column($column,$condition,$type);
		$this->load->view($page,array('data'=>$findUser) );
	}

	function search_user_admin(){
		$condition = $_POST["keyword"];
		$column = $_POST["selectColumn"];
		$this->load->model('crud');
		$page = "/admin/user/userManagerAdmin1";
		$type = "0";
		$findUser = $this->crud->search_by_column($column,$condition,$type);
		$this->load->view($page,array('data'=>$findUser) );
	}
	function search_user_teacher(){
		$condition = $_POST["keyword"];
		$column = $_POST["selectColumn"];
		$this->load->model('crud');
		$page = "/admin/user/userManagerTeacher1";
		$type = "1";
		$findUser = $this->crud->search_by_column($column,$condition,$type);
		$this->load->view($page,array('data'=>$findUser) );
	}

	function search_user_student(){
		$condition = $_POST["keyword"];
		$column = $_POST["selectColumn"];
		$this->load->model('crud');
		$page = "/admin/user/userManagerStudent1";
		$type = "2";
		$findUser = $this->crud->search_by_column($column,$condition,$type);
		$this->load->view($page,array('data'=>$findUser) );
	}

	//2.create user item

	function create_user(){
		$this->load->view('/admin/user/userCreate');
	}
	function create_user_action(){
		$this->load->model('crud');
		$newUser = array('UserNum'=>$_POST['userNum'],'UserName'=>$_POST['userName'],'Password'=>md5($_POST['password']),'Gender'=>$_POST['Gender'],'Email'=>$_POST['Email'],'Section'=>$_POST['Section'],'Type'=>$_POST['Type']);
		$this->crud->create("users",$newUser);
		$user = $this->crud->read_user_all();
		$this->load->view('/admin/user/userManager',array('data'=>$user) );
	}
	//3.delete user item
	//crud: function delete($tableName,$colName,$colValue){}
	function delete_user(){
		//delete the users in the db
		if(!empty($_POST["deleteUser"])){
			$users = $_POST["deleteUser"];
			for($i=0; $i< count($users); $i++){
				$this->load->model("crud");
				$this->crud->delete("users","UserNum",$users[$i]);
			}
		}

		$user = $this->crud->read_user_all();
		$this->load->view('/admin/user/userManager',array('data'=>$user) );
		//show_user_list()
		//$user = $this->crud->read_user_by_type("0");
		//$this->load->view('/admin/userManager',array('data'=>$user) );
	}
	//4.update user profile
	function view_user(){
		echo "this is view_user";
		//这边就直接进入用户的界面就好了。不过会不会有点过于简单粗暴了。。。。
	}
	function update_user_action(){
		//获取用户post过来的用户名
		//这个目前还没有做
		$this->load->model('crud');
		$newUser = array('UserNum'=>$_POST['userNum'],'UserName'=>$_POST['userName'],'Password'=>md5($_POST['password']),'Gender'=>$_POST['Gender'],'Email'=>$_POST['Email'],'Section'=>$_POST['Section'],'Type'=>$_POST['Type']);
		$this->crud->insert_user($newUser);
		$admin = $this->crud->select(array('UserNum,UserName,Gender,Email,Section,Type','users','Type','0'));
		$this->load->view('/admin/user/userManagerAdmin',array('data'=>$admin));
	}

	//（2）course manager
	//show the index page:
	function course_manager() {
		$this->load->model("courseCrud");
		//read_course_list($type="0",$isAdmin="0")
		$course = $this->courseCrud->read_course_list("0","1");
		$courseType = $this->courseCrud->read_type_list();
		$this->load->view("/admin/course/adminLeft",array('data' =>$course,'courseType'=>$courseType,'activeLeft'=>2,'activeTop'=>0,'selectColumn'=>"0"));
		// 载入CI的session库
	}
	function show_course_list($type="0"){
		$this->load->model("courseCrud");
		//read_course_list($type="0",$isAdmin="0")
		$courseType = $this->courseCrud->read_type_list();
		$course = $this->courseCrud->read_course_list($type,"1");
		$this->load->view("/admin/course/adminLeft",array('data' =>$course,'courseType'=>$courseType,'activeLeft'=>2,'activeTop'=>$type,'selectColumn'=>"0"));
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
		$courseType = $this->courseCrud->read_type();
		$course = $this->courseCrud->search_course_list($type,"1",$column,$keyword);
		$this->load->view("/admin/course/adminLeft",array('data' =>$course,'courseType'=>$courseType,'activeLeft'=>2,'activeTop'=>$type,'selectColumn'=>$column));
	}
	//还需要添加coursetype的添加、删除、编辑操作。
	function create_course(){
		$this->load->model('userCrud');
		$this->load->model('courseCrud');
		$this->load->model('imageCrud');
		//$this->load->model('crud');
		//$usertype = "1";
		//获取教师ID和Name对;
		//获取课程类型ID和Name对;
		//$teacher = $this->crud->
		//$teachers = $this->userCrud->search_by_column($column,$condition,$type);
		//$teachers = $this->userCrud->read_teacher_list();
		$teachers = $this->userCrud->read_teacher_list();
		$types = $this->courseCrud->read_type_list();
		$images = $this->imageCrud->read_image_list();
        if(count($images)==0) {
        	echo "<script>alert('please create image first!')</script>";
        	//$this->load->view('/admin/image/create_image');
        }
		$this->load->view('/admin/course/courseCreate',array('teachers'=>$teachers,'types'=>$types,'images'=>$images));
	}
	function create_course_action(){
		//$this->load->model('crud');
		//处理上传的文件
		$this->load->model('courseCrud');
		//if($_FILES["file"]){

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
			//$file = $this->courseCrud->upload_file()->full_path;
			//echo "this is".$_ES["file"]["type"];
		//}
		$newCourse = array('CourseName'=>$_POST['courseName'],'TeacherID'=>$_POST['teacherID'],
			'TypeID'=>$_POST['typeID'],'Duration'=>$_POST['duration'],
			'SubmitLimit'=>$_POST['submitLimit'],'CourseDesc'=>$_POST['courseDesc'],
			'StartTime'=>$_POST['startTime'],'StopTime'=>$_POST['stopTime'],
			'Location'=>$_POST['location'],'ImageID'=>"12345");
		//$newType = array('TypeName'=>$_POST['typeName'],'TypeDesc'=>$_POST['Description']);
		$this->courseCrud->create_course($newCourse);
		$course = $this->courseCrud->read_course_list();
		$courseType = $this->courseCrud->read_type_list();
		$this->load->view("/admin/course/adminLeft",array('data' =>$course,'courseType'=>$courseType,'activeLeft'=>2,'activeTop'=>"0",'selectColumn'=>$column));
	}
	//course type
	function show_courseType(){
		$this->load->model("crud");
		$courseType = $this->crud->read_all("coursetype");
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
	function delete_courseType(){
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
	/*
	//show course list by type
	function show_course_list(){
		$this->load->model("crud");
		$selectType = $_POST["courseType"];
		$course = $this->crud->read_course_list("$selectType","1");
		$courseType = $this->crud->read_all("coursetype");
		$this->load->view("/admin/course/courseManager",array('data' =>$course,'courseType'=>$courseType));
	}
	*/
	//还需要添加coursetype的添加、删除、编辑操作。

	//delete course
	function delete_course(){
		if(!empty($_POST["deleteCourse"])){
			$courses = $_POST["deleteCourse"];
			for($i=0; $i< count($courses); $i++){
				$this->load->model("crud");
				$this->crud->delete("courses","Num",$courses[$i]);
			}
		}
		$course = $this->crud->read_course_overview("$selectType");
		$this->load->view("/admin/course/courseManager",array('data' =>$course));
	}





















	function profile() {
		if ($this->session->userdata('s_id')){
			$userNum = $this->session->userdata('s_id');
			$this->load->model('crud');
			$admin = $this->crud->select(array('UserID,UserNum,UserName,Gender,Email,Section,Type','users','UserNum',$userNum));
			$this->load->view('/admin/profile',array('data'=>$admin));
			// 载入CI的session库
		}
	}
	function edit_profile(){
		//把用户新编辑的信息更新到数据库
		$this->load->model('crud');
		//$data = array('userName'=>$_POST['userName'],'Gender'=>$_POST['Gender'],'Email'=>$_POST['Email'],'Section'=>$_POST['Section']);
		
		$userNum = $this->session->userdata('s_id');
		try {
			$this->crud->u_update($userNum,array('UserName'=>$_POST['userName'],'Gender'=>$_POST['Gender'],'Email'=>$_POST['Email'],'Section'=>$_POST['Section']));
			$message = "修改成功！";
		}catch(Exception $e){
			$message = $e->getMessage();	
		}
		//if success!
		$userNum = $this->session->userdata('s_id');
		$admin = $this->crud->select(array('UserID,UserNum,UserName,Gender,Email,Section,Type','users','UserNum',$userNum));
		$this->load->view('/admin/profileEditResult',array('data'=>$admin,'message'=>$message));
	}
	function reset_pswd() {		
		$this->load->view('/admin/resetpswd');
	}
	function check_pswd(){
		//获取数据
		$this->load->model('validation');
		//校验数据
		$isValid = $this->validation->is_valid_password(md5($_POST['password1']),md5($_POST['password2']));
		if ($isValid){
			//重置成功
			$this->load->model('crud');
			$userNum = $this->session->userdata('s_id');
			$this->crud->u_update($userNum,array('Password'=>md5($_POST['password1'])));
			//重新登录
			$this->session->unset_userdata('s_id');
			$this->load->view('login');
		}else{
			//重置失败
			$message = "failed to reset password";
			$this->load->view('/admin/resetPswdFailed',array('message'=>$message));
		}
		// 载入CI的session库
	}
	function image_manager() {
		$this->load->view('/admin/image/imageManager');
		// 载入CI的session库
	}
}

/* End of file login.php */
/* Location: ./application/controllers/login.php */