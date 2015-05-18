<?php
class Teacher extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->load->library('session');
		$this->load->database();
	}
	function course_manager($type){
		$this->load->library('session');
		$userNum = $this->session->userdata('s_id');
		//$this->load->model("courseCrud");
		$courseType = $this->courseCrud->read_type_list();
		$course = $this->courseCrud->read_course_list_by_teacher($userNum,$type);
		//$this->load->model('selectCourse');
		$Nstudent = array();
		$typeName = array();
		for ($i=0; $i < count($course); $i++) {
			$courseID=$course[$i]->CourseID;
			$Nstudent[] = $this->selectCourse->count_student_by_course($courseID);
			if (!$Nstudent[$i])$Nstudent[$i]=0;
			$typeName[] = $this->courseCrud->read_typeName_by_ID($courseID);
		}
		$this->load->view("/teacher/course/courseManager",array('data'=>$course,'NStudent'=>$Nstudent,'TypeName'=>$typeName,'courseType'=>$courseType,'activeTop'=>$type,'selectColumn'=>"0",'keyword'=>""));
	}
	function show_course_detail($courseID){
		echo "this is course_detail function ";
		//teacher can only read, but not edit except starting or stopping
		/*
		$this->load->model("courseCrud");
		$this->load->model("userCrud");
		$this->load->model("imageCrud");
		$courseInfo = $this->courseCrud->read_course_Detail($courseID);
		$TypeName = $this->courseCrud->read_typeName_by_ID($courseInfo->TypeID);
		$students = $this->selectCourse->read_user_list_by_course($courseID);
		$studentName = array();
		for ($i=0; $i < count($students); $i++) {
			$studentName[]=$this->userCrud->read_userName_by_ID($students[$i]);
		}
		$imageName = $this->imageCrud->read_imageName_by_ID($courseInfo->ImageID);



		$this->load->view('/admin/top');
		$this->load->view('/admin/left',array('left'=>"2"));
		$this->load->view("/admin/course/courseDetailR",array('data'=>$courseInfo,'teachers'=>$teachers,'types'=>$types,'images'=>$images));
		$this->load->view('/admin/botton');
		//$this->load->view("/admin/course/courseDetail",array('data'=>$courseInfo,'teachers'=>$teachers,'types'=>$types,'images'=>$images));
	*/}
	function course_start($courseID){

	}
	function search_course(){

	}
}
?>