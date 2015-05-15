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
		$this->db->delete("coursetype")->where("TypeID",$typeID);
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
		return $query->result();
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
	function count_course(){
		$data = array();
		for($i=0;$i<3;$i++){
			$data[] = $this->db->select("count(*) AS COUNT")->from("courses")->where("State",$i)->get()->result()[0]->COUNT;
		}
		return $data;
	}

}
?>