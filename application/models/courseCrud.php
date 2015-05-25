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
	function search_course_list($type="-1",$isAdmin="0",$column,$keyword){
		$this->db->select("CourseID,CourseName,TeacherID,TypeID,State,SubmitLimit,CourseDesc,Created");
		if($type){$this->db->where("TypeID",$type);}
		if(!$isAdmin){$this->db->where("Created","1");}
		$query = $this->db->like($column,$keyword)->from("courses")->get();
		return $query->result();
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
	function upload_file(){
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
		return $this->upload->data();

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
		$this->db->where("CourseID",$courseID)->update("courses",array("State"=>0));
	}
	function finish_course($courseID){
		$this->db->where("CourseID",$courseID)->update("courses",array("State"=>2));
	}
	function read_vm($courseID,$userNum){
		$targetVM = $this->db->select("*")->where("CourseID",$courseID)->where("UserNum",$userNum)->where("isTarget",1)->from("coursevm")->get()->result();
		$attackerVM = $this->db->select("*")->where("CourseID",$courseID)->where("UserNum",$userNum)->where("isTarget",0)->from("coursevm")->get()->result();
		$data = array('targetVM' => $targetVM, 'attackerVM'=>$attackerVM);
		return $data;
	}
}
?>