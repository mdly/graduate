<?php
class CourseCrud extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->load->database();
	}
	//this is functions about courses and coursetypes
	//first part is the coursetype functions
	//insert function should be called after the validation
	function create_type($data){
		$this->db->insert("coursetype",$data);
	}
	function read_type_list(){
		//read all the courseType info: TypeID, TypeName, TypeDesc
		$query = $this->db->select("*")->from("coursetype")->get();
		return $query->result();
	}
	function update_type($typeID,$newRecord){
		//update course type info
		$this->db->update("coursetype",$newRecord)->where("TypeID",$typeID);
	}
	function delete_type($typeID){
		$this->db->where("TypeID",$typeID)->delete("coursetype");
	}
	function create_course($data){
		$this->db->insert("courses",$data);
	}
	function read_course_list($type="-1",$isAdmin="0"){
		//can read course overview according to the type if the type is set 
		//or can read all coures' overview if type is not set
		//if the caller is admin user, the course list should include those not created successfully.
		//if the caller is teacher or student, the course list should include only those created successfully. 
		$this->db->select("CourseID,CourseName,TeacherID,TypeID,State,SubmitLimit,CourseDesc,Created,File")->from("courses");
		if($type!="-1"){$this->db->where("TypeID",$type);}
		if(!$isAdmin){$this->db->where("Created","1");}
		$query = $this->db->get();
		return $query->result();
	}
	function read_course_list_student($type="-1",$studentNum){
		$data = $this->read_course_list($type);
		$selected = array();
		$courseType = array();
		$teacherName = array();
		for ($i=0; $i < count($data); $i++) { 
			$finished = $this->db->select("Finished")
				->from("selectcourse")
				->where("StudentID",$studentNum)
				->where("CourseID",$data[$i]->CourseID)
				->get()->result();
			if($finished){
				//student selected this course
				$selected[] = $finished[0]->Finished;
			}else{
				//student has not select this course
				$selected[] = "-1";
			}
			$courseType[]= $this->db->select("TypeName")
				->from("coursetype")
				->where("TypeID",$data[$i]->TypeID)
				->get()->result()[0]->TypeName;
			$teacherID = $this->db->select("TeacherID")
				->from("courses")
				->where("CourseID",$data[$i]->CourseID)
				->get()->result()[0]->TeacherID;
			$teacherName[] = $this->db->select("UserName")
				->from("users")
				->where("UserNum",$teacherID)
				->get()->result()[0]->UserName;
		}
		return array("course"=>$data,"selected"=>$selected,'typeName'=>$courseType,'teacher'=>$teacherName);

	}
	function search_course_list($type="-1",$isAdmin="0",$column,$keyword){
		$this->db->select("CourseID,CourseName,TeacherID,TypeID,State,SubmitLimit,CourseDesc,Created");
		if($type){$this->db->where("TypeID",$type);}
		if(!$isAdmin){$this->db->where("Created","1");}
		$query = $this->db->like($column,$keyword)->from("courses")->get();
		return $query->result();
	}
	function read_course_detail_student($courseID){
		$basicInfo = $this->db->select("*")
			->where("CourseID",$courseID)
			->from("courses")
			->get()->result()[0];
		$typeName = $this->db->select("TypeName")
			->where("TypeID",$basicInfo->TypeID)
			->from("coursetype")
			->get()->result()[0]->TypeName;
		$teacherName = $this->db->select("UserName")
			->where("UserNum",$basicInfo->TeacherID)
			->from("users")
			->get()->result()[0]->UserName;
		$duration = $basicInfo->Duration;

		$this->load->model("imageCrud");
		$image = $this->imageCrud->read_courseImage_list($courseID);
		$data = array("courseName" => $basicInfo->CourseName,
			"courseID"=>$basicInfo->CourseID,
			"typeName" => $typeName,
			"teacherName" => $teacherName,
			"duration"=>($basicInfo->Duration)?$basicInfo->Duration:"未定",
			"submitLimit"=>($basicInfo->SubmitLimit)?$basicInfo->SubmitLimit:"未定",
			"startTime"=>($basicInfo->StartTime)?$basicInfo->StartTime:"未定",
			"stopTime"=>($basicInfo->StopTime)?$basicInfo->StopTime:"未定",
			"location"=>($basicInfo->Location)?$basicInfo->Location:"未定",
			"courseDesc"=>($basicInfo->CourseDesc)?$basicInfo->CourseDesc:"暂无描述",
			"attackerImage" => $image['attackerImage'],
			"targetImage"=>$image['targetImage']);
		return $data;
	}
	function read_reportLimit_student($courseID,$studentID){
		$submitLimit = $this->db->select("SubmitLimit")
						->from("courses")
						->where("CourseID",$courseID)
						->get()->result()[0]->SubmitLimit;
		$submitTimes = $this->db->select("SubmitTimes")
						->from("selectcourse")
						->where("CourseID",$courseID)
						->where("StudentID",$studentID)
						->get()->result()[0]->SubmitTimes;
		return array("submitLimit"=>$submitLimit,"submitTimes"=>$submitTimes);
	}
	function read_courseID_by_vmID($vmID){
		$courseID = $this->db->select("CourseID")
					->from("coursevm")
					->where("VMID",$vmID)
					->get()->result()[0]->CourseID;
		return $courseID;
	}
	function read_course_detail($courseID){
		$this->db->select("*")->where("courseID",$courseID)->from("courses");
		$query = $this->db->get();
		return $query->result()[0];
	}
	function update_course_detail($data,$courseID){
		$this->db->where("courseID",$courseID)->update("courses",$data);
	}
	function delete_course($courseID){
		$this->db->where("courseID",$courseID)->delete("courses");
	}

	//file function

	function upload_file($file){
		$config['upload_path']='./uploads';
		$config['allowed_types']='pdf|doc|docx';
		$config['max_size']='10240000';//10mb
		$this->load->library('upload',$config);
		$this->upload->do_upload('file');
		if($this->upload->do_upload($file)){
			$data = array('upload_data'=>$this->upload->data());
			var_dump($data);
		}else{
			$error=array('error'=>$this->upload->display_errors());
			var_dump($error);
		}
		//return $this->upload->data();
		return $data['upload_data']['full_path'];
	}
	function submit_report($courseID,$studentID,$filePath){
// C:/wamp/www/ADplatform/uploads/1434297695.doc
		// $this->db->where("CourseID",$courseID)->update("courses",array("Created"=>1));
		$submitTimes = $this->db->select("SubmitTimes")
			->from("selectcourse")
			->where("CourseID",$courseID)
			->where("StudentID",$studentID)
			->get()->result()[0]->SubmitTimes;
		$this->db->where('CourseID',$courseID)->where('StudentID',$studentID)
		->update("selectcourse",array('ReportPath'=>$filePath,'SubmitTimes'=>$submitTimes+1));
	}
	function count_course($userNum="-1"){
		$data = array();
		if($userNum=="-1")
		for($i=0;$i<3;$i++){
			$data[] = $this->db->select("count(*) AS COUNT")->from("courses")->where("State",$i)->get()->result()[0]->COUNT;
		}
		else{
			for ($i=0; $i<3; $i++) {
				$this->db->select("count(*) AS COUNT")->from("courses")->where("State",$i);
				$this->db->where("Created",1)->where("TeacherID",$userNum);
				$data[] = $this->db->get()->result()[0]->COUNT;
			}
		}
			
		return $data;
	}
	function count_course_student($studentID){
		$all = $this->db->select("count(*) AS COUNT")->from("courses")->where("State","");
	}
	function read_course_list_by_teacher($teacherID,$type){
		$this->db->select("CourseID,CourseName,TypeID,State,SubmitLimit,File")->from('courses')->where('TeacherID',$teacherID);
		$this->db->where("Created",1);
		if($type!="-1")$this->db->where("TypeID",$type);
		return $this->db->get()->result();
	}
	function read_typeName_by_ID($courseID){
		$typeID = $this->db->select("TypeID")->from("courses")->where("CourseID",$courseID)->get()->result()[0]->TypeID;
		$typeName = $this->db->select("TypeName")->from("coursetype")->where("TypeID",$typeID)->get()->result()[0]->TypeName;
		return $typeName;
	}
	function push_course($courseID){
		$this->db->where("CourseID",$courseID)->update("courses",array("Created"=>1));
	}
	function pull_course($courseID){
		//要检测教师是否已经开启课程，若开启了该课程，并且学生已经选择了该课程，则向每个学生以及教师发送邮件通知该课程已经撤回
		//然后将课程State改为0,(off)
		//课程Created选项改为1
		$State = $this->db->select("State")->from("courses")->where("CourseID",$courseID)->get()->result()[0]->State;
		if($State=="1"){
			//发送邮件
			$this->db->where("CourseID",$courseID)->update("courses",array("State"=>0));
		}
		$this->db->where("CourseID",$courseID)->update("courses",array("Created"=>0));
	}
	function start_course($courseID){
		$this->db->where("CourseID",$courseID)->update("courses",array("State"=>1));
	}
	function stop_course($courseID){
		//every vm in coursevm should be removed, the same with openstacks
		$this->db->where("CourseID",$courseID)->update("courses",array("State"=>0));
		$this->load->model("openstack");
		// function delete_server($tokenID,$tenantID,$tenantName,$vmID){
		$token = $this->openstack->authenticate_v2();
		$tenantID = $token['access']['token']['tenant']['id'];
		$tenantName = $token['access']['token']['tenant']['name'];
		$tokenID = $token['access']['token']['id'];
		$vms = $this->db->select("VMID")->from("coursevm")->where("CourseID",$courseID)->get()->result();
		for ($i=0; $i < count($vms); $i++){ 
			//delete vms which are for the course
			$this->openstack->delete_server($tokenID,$tenantID,$tenantName,$vmID);
		}
	}
	function finish_course($courseID){
		$this->db->where("CourseID",$courseID)->update("courses",array("State"=>2));
	}
	function submit_course($userNum,$courseID){
		$this->db->where("CourseID",$courseID)->where('StudentID',$userNum)->update('selectcourse',array("Finished",'1'));
	}
	function select_course($userNum,$courseID){
		$data = array("CourseID"=>$courseID,"StudentID"=>$userNum);
		$this->db->insert("selectcourse",$data);
	}
	function read_selected_course($userNum){
		//课程名	课程类型	教师	提交限制	已提交次数
		//selected_course means those undergoing
		$selectCourse=$this->db->select("*")->from('selectcourse')->where("StudentID",$userNum)->where("Finished","0")->get()->result();
		// $data = array();
		$data = array();
		for ($i=0; $i < count($selectCourse); $i++) {
			$courseInfo = $this->db->select("TypeID,CourseName,TeacherID,SubmitLimit")
				->from("courses")
				->where("CourseID",$selectCourse[$i]->CourseID)
				->get()->result()[0];
			$TypeName = $this->db->select("TypeName")
				->from("coursetype")			
				->where("TypeID",$courseInfo->TypeID)
				->get()->result()[0]->TypeName;
			$teacherName = $this->db->select("UserName")
				->from("users")
				->where("UserNum",$courseInfo->TeacherID)
				->get()->result()[0]->UserName;
			$data[] = array("courseID"=>$selectCourse[$i]->CourseID,
				"courseName"=>$courseInfo->CourseName,
				"teacherName"=>$teacherName,
				"typeName"=>$TypeName,
				"submitLimit"=>$courseInfo->SubmitLimit,
				"submitTimes"=>$selectCourse[$i]->SubmitTimes);
		}
		return $data;
	}
	function read_unselected_course($userNum){
		// only pushed course can be read(created=1)
		// $selectCourse = $this->db->select("CourseID")->where("StudentID",$userNum)->from("selectcourse")->get()->result();
		$selectCourse = $this->read_selected_course($userNum);
		// print_r($selectCourse);
		$this->db->select("*")->from("courses")->where("Created",'1');
		for ($i=0; $i < count($selectCourse); $i++) { 
			$this->db->where_not_in("CourseID",array($selectCourse[$i]->CourseID));
		}
		$unselectedCourse = $this->db->get()->result();
		return $unselectedCourse;
	}
	function read_finished_course($userNum){
		// 课程名	教师	课程类型   成绩
		$finishedCourse=$this->db->select("*")->from('selectcourse')
		->where("StudentID",$userNum)
		->where("Finished","1")->get()->result();
		$data = array();
		for ($i=0; $i < count($finishedCourse); $i++) { 
			$course = $this->select("CourseName,TeacherID,TypeID")
				->from("courses")
				->where("CourseID",$finishedCourse[$i]->CourseID)
				->get()->result()[0];
			$teacherName = $this->db->select("UserName")
				->from("users")
				->where("UserNum",$course->TeacherID)
				->get()->result()[0]->UserName;
			$typeName = $this->db->select("TypeName")
				->from("coursetype")
				->where("TypeID",$course->TypeID)
				->get()->result()[0]->TypeName;
			$data[0]=array('courseName'=>$course->CourseName,
				'teacherName'=>$teacherName,
				'typeName'=>$typeName,
				'score'=>$finishedCourse[$i]->Score);
		}
		return $data;
		// return array("course"=>$data,"typeName"=>$courseType);
	}
	function read_user_vm($userNum){
		$data = $this->db->select("*")->from("coursevm")->where('userNum',$userNum)->get()->result();
		return $data;
	}
	function read_vm($courseID,$userNum){
		// echo "courseID=".$courseID."<br>";
		// echo "userNum=".$userNum."<br>";
		$targetVM = $this->db->select("*")->where("CourseID",$courseID)->where("UserNum",$userNum)->where("isTarget",1)->from("coursevm")->get()->result();
		$attackerVM = $this->db->select("*")->where("CourseID",$courseID)->where("UserNum",$userNum)->where("isTarget",0)->from("coursevm")->get()->result();
		$data = array('targetVM' => $targetVM, 'attackerVM'=>$attackerVM);
		return $data;
	}
	function create_vm($courseID,$isTarget){
		$this->load->model('openstack');
		$this->load->library('session');
		$tenantName = $this->session->userdata('s_id');
		$token = $this->openstack->authenticate_v2();
		$tenantID = $token['access']['token']['tenant']['id'];
		$tokenID = $token['access']['token']['id'];
		$name = $_POST['vmName'];
		$imageRef = $_POST['image'];
		$network = $_POST['network'];
		$flavorRef = $_POST['flavor'];
		$serverInfo = $this->openstack->create_server($tokenID,$tenantName,$tenantID,$name,$imageRef,$flavorRef,$network);
		$data = array(
			"UserNum"=>$tenantName,
			"CourseID"=>$courseID,
			"VMID"=>$serverInfo['id'],
			"VMName"=>$name,
			"VMURL"=>$serverInfo['links']['0']['href'],
			"isTarget"=>$isTarget);
		$this->db->insert("coursevm",$data);
	}
	function delete_vm($courseID,$vmID){
		$this->load->model('openstack');
		$token = $this->openstack->authenticate_v2();
		$tokenID = $token['access']['token']['id'];
		$tenantID = $token['access']['token']['tenant']['id'];
		$this->load->library('session');
		$tenantName = $this->session->userdata("s_id");
		$this->openstack->delete_server($tokenID,$tenantID,$tenantName,$vmID);
		$this->db->where("CourseID",$courseID)->where("VMID",$vmID)->delete("coursevm");
	}
	function read_student_list($courseID){
		$data = $this->db->select("*")
		->from("selectcourse")
		->where("CourseID",$courseID)
		->get()->result();
		return $data;
	}

	function get_lately_added_courseID(){
		$data = $this->db->select("*")
			->limit(1)
			->from("courses")
			->order_by("CourseID","desc")
			->get()->result();
		return $data[0]->CourseID;
		// print_r($data);
		// $query = "select top 1 * from courses order by CourseID desc";
		// $data = $this->db->query($query);
	}
}
?>