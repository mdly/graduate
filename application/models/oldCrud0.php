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
		$this->load->model('crud');	
		//$arr[0]为查询内容，$arr[1]为查询表名，$arr[2]为查询条件列名，$arr[3]为查询条件值
		//查询用户信息
		$admin = $this->crud->select(array('count(*) AS COUNT','users','Type','0'));
		$teacher = $this->crud->select(array('count(*) AS COUNT','users','Type','1'));
		$student = $this->crud->select(array('count(*) AS COUNT','users','Type','2'));
		//查询课程信息		
		$CourseOff = $this->crud->select(array('count(*) AS COUNT','courses','Type','0'));
		$CourseOn = $this->crud->select(array('count(*) AS COUNT','courses','Type','1'));
		$CourseDone = $this->crud->select(array('count(*) AS COUNT','courses','Type','2s'));
		//查询镜像信息
		$Image = $this->crud->count_nolimit(array('count(*) AS COUNT','images'));
		$data = array('NAdmin' => $admin[0]->COUNT,'NTeacher' => $teacher[0]->COUNT,'NStudent' => $student[0]->COUNT,'NCourseOff' => $CourseOff[0]->COUNT,'NCourseOn' => $CourseOn[0]->COUNT,'NCourseDone' => $CourseDone[0]->COUNT,'NImage' => $Image[0]->COUNT);
		$this->load->view('/admin/admin',$data);
		//$this->load->view('echo');
	}
	function user_list(){
		//获取要求查看的用户类型
		$type = $_POST["userType"];
		$this->load->model('crud');
		$user = $this->crud->select_all("users");
		$this->load->view('/admin/userManager',array('data'=>$user) );
	}
	function user_manager() {
		//获取管理员用户列表//show_admin_list
		$this->load->model('crud');
		$user = $this->crud->select_all("users");
		$this->load->view('/admin/userManager',array('data'=>$user) );
	}
	function show_admin_list(){
		//获取教师用户列表
		$this->load->model('crud');
		$user = $this->crud->select(array('UserNum,UserName,Gender,Email,Section,Type','users','Type','0'));
		$this->load->view('/admin/userManagerAdmin',array('data'=>$user) );
	}	
	function show_teacher_list(){
		//获取教师用户列表		
		$this->load->model('crud');
		$user = $this->crud->select(array('UserNum,UserName,Gender,Email,Section,Type','users','Type','1'));
		$this->load->view('/admin/userManagerTeacher',array('data'=>$user) );
	}	
	function show_student_list(){
		//获取教师用户列表		
		$this->load->model('crud');
		$user = $this->crud->select(array('UserNum,UserName,Gender,Email,Section,Type','users','Type','2'));
		$this->load->view('/admin/userManagerStudent',array('data'=>$user));
	}
	function view_user(){
		//
	}
	function delete_user(){
		//要获取用户选中的用户ID--这里不需要

		$this->load->model('crud');
		$user = $this->crud->select_all("users");
		$this->load->view('/admin/userDelete',array('data'=>$user));
		//$this->load->model('crud');
		//$this->crud->delete_user('userName');
	}
	function delete_user_confirm(){
		//要获取用户选中的用户ID
		$this->load->view('userDelete');
		//$this->load->model('crud');
		//$this->crud->delete_user('userName');
	}
	function create_user(){
		$this->load->view('/admin/userCreate');
	}
	function create_user_action(){
		$this->load->model('crud');
		$newUser = array('UserNum'=>$_POST['userNum'],'UserName'=>$_POST['userName'],'Password'=>md5($_POST['password']),'Gender'=>$_POST['Gender'],'Email'=>$_POST['Email'],'Section'=>$_POST['Section'],'Type'=>$_POST['Type']);
		$this->crud->insert_user($newUser);
		$admin = $this->crud->select(array('UserNum,UserName,Gender,Email,Section,Type','users','Type','0'));
		$this->load->view('/admin/userManagerAdmin',array('data'=>$admin));
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
	function course_manager() {
		$this->load->model("crud");
		//查询课程类别
		$courseType = $this->crud->select_course_type();
		$this->load->view('/admin/courseManager',array('courseType'=>$courseType));
		// 载入CI的session库
	}
	function image_manager() {		
		$this->load->view('/admin/imageManager');
		// 载入CI的session库
	}
}

/* End of file login.php */
/* Location: ./application/controllers/login.php */