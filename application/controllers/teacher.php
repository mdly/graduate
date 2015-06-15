<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Teacher extends CI_Controller{	
	function __construct() {
		parent::__construct();
		//首先检查用户是否已经登录，用户类型是否是管理员
		$this->load->library('session');
		$this->load->model('userCrud');	
		$this->load->model('courseCrud');	
		$this->load->model('selectCourse');	
		$userNum = $this->session->userdata('s_id');
		$userType = $this->userCrud->read_user_type($userNum);
		if ($userType!='1'){
			echo "<script type='text/javascript'>alert('请登陆！');</script>";
			$this->load->view("login");
			// die();
		}
	}
	function index(){
		$userNum = $this->session->userdata('s_id');
		$course = $this->courseCrud->count_course($userNum);
		$user = $this->userCrud->count_user();
		$student = 0;
		for ($i=0; $i < count($course); $i++) {
			$student= $student + $this->selectCourse->count_student_by_course($course[$i]);
		}
		$this->load->view('/teacher/top');
		$this->load->view('/teacher/left',array('left'=>"0"));
		$this->load->view('/teacher/overviewR',
			array('NCourseOff'=>$course[0],'NCourseOn'=>$course[1],'NCourseDone'=>$course[2],
				'NStudentAll'=>$user[2],'NStudentSelected'=>$student));
		$this->load->view('/teacher/botton');

	}
	function course_manager($type="-1"){
		$userNum = $this->session->userdata('s_id');
		$courseType = $this->courseCrud->read_type_list();
		$course = $this->courseCrud->read_course_list_by_teacher($userNum,$type);
		$Nstudent = array();
		$typeName = array();
		for ($i=0; $i < count($course); $i++) {
			$Nstudent[] = $this->selectCourse->count_student_by_course($course[$i]->CourseID);
			if (!$Nstudent[$i])$Nstudent[$i]=0;
			$typeName[] = $this->courseCrud->read_typeName_by_ID($course[$i]->CourseID);
		}
		$this->load->view('/teacher/top');
		$this->load->view('/teacher/left',array('left'=>"1"));
		$this->load->view("/teacher/course/courseManagerR",array('data'=>$course,'NStudent'=>$Nstudent,'typeName'=>$typeName,'courseType'=>$courseType,'activeTop'=>$type,'selectColumn'=>"0",'keyword'=>""));
		$this->load->view('/teacher/botton');
	}
	function show_course_detail($courseID){
		//teacher cannot edit course info except stopping or starting a course,
		//so just show the info, but not in form section.
		//show the student list, get info from selectcourse table
		//show image name 
		//show type name
		//show student name,
		//first should decide if the course in done or on,
		//if on, the student link redirect to the student drill page;
		//if done, the link redirect to page showing the student score info;
		$this->load->model("courseCrud");
		$this->load->model("userCrud");
		$this->load->model("imageCrud");
		$typeName = $this->courseCrud->read_typeName_by_ID($courseID);
		$courseInfo = $this->courseCrud->read_course_Detail($courseID);
		$attackerImage = $this->imageCrud->get_attacker_image($courseID);
		$targetImage = $this->imageCrud->get_target_image($courseID);
		$this->load->view('/teacher/top');
		$this->load->view('/teacher/left',array('left'=>"1"));
		$this->load->view("/teacher/course/courseDetailR",array('data'=>$courseInfo,'typeName'=>$typeName,'attackerImage'=>$attackerImage,'targetImage'=>$targetImage));
		$this->load->view('/teacher/botton');
	}
	function start_course($courseID){
		$this->load->model('courseCrud');
		$this->courseCrud->start_course($courseID);
		$type="-1";
		$userNum = $this->session->userdata('s_id');
		$courseType = $this->courseCrud->read_type_list();
		$course = $this->courseCrud->read_course_list_by_teacher($userNum,$type);
		$Nstudent = array();
		$typeName = array();
		for ($i=0; $i < count($course); $i++) {
			$Nstudent[] = $this->selectCourse->count_student_by_course($course[$i]->CourseID);
			if (!$Nstudent[$i])$Nstudent[$i]=0;
			$typeName[] = $this->courseCrud->read_typeName_by_ID($course[$i]->CourseID);
		}
		$this->load->view('/teacher/top');
		$this->load->view('/teacher/left',array('left'=>"1"));
		$this->load->view("/teacher/course/courseManagerR",array('data'=>$course,'NStudent'=>$Nstudent,'typeName'=>$typeName,'courseType'=>$courseType,'activeTop'=>$type,'selectColumn'=>"0",'keyword'=>""));
		$this->load->view('/teacher/botton');

	}
	function read_student_list($courseID){
		$this->load->model('courseCrud');
		$students = $this->courseCrud->read_student_list($courseID);
		// $this->load->view('')
		$this->load->view('/teacher/top');
		$this->load->view('/teacher/left',array('left'=>"1"));
		$this->load->view("/teacher/course/studentListR",array('data'=>$students,'activeTop'=>$type,'selectColumn'=>"0",'keyword'=>""));
		$this->load->view('/teacher/botton');

	}
	function show_drill_detail($courseID,$studentID){
		$this->load->model('openstack');
		$this->load->model('courseCrud');
		$this->load->library('session');
		// $userNum = $this->session->userdata('s_id');
		//$attackerVM = $this->openstack->read_attacker_VM($courseID);
		//$targetVM = $this->openstack->read_target_VM($courseID);
		$VMs = $this->courseCrud->read_vm($courseID,$studentID);
		// print_r($VMs);
		$this->load->view('/teacher/top');
		$this->load->view('/teacher/left',array('left'=>"1"));
		$this->load->view('/student/course/startCourseR',
			array(
				'attackerVM'=>$VMs["attackerVM"],
				'targetVM'=>$VMs['targetVM'],
				'courseID'=>$courseID));
		$this->load->view('/teacher/botton');

	}


}