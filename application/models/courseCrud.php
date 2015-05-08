<?php
class CourseCrud extends CI_Model(){
	function __construct (){
		parent::__construct();
		$this->load->database();
	}
	//this is functions about courses and coursetypes
	//first part is the coursetype functions
	//insert function should be called after the validation
	function create_type($data){
		$this->db->insert("coursetype",$data);
	}
	function read_type(){
		//read all the courseType info: TypeID, TypeName, TypeDesc
		$query = $this->db->select("*")->from("coursetype");
		return $query->result;
	}
	function update_type($typeID,$newRecord){
		//update course type info
		$this->db->update("coursetype",$newRecord)->where("TypeID",$typeID);
	}
	function delete_type($typeID){
		$this->db->delete("coursetype")->where("TypeID",$typeID);
	}
	function create_course($data){
		$this->db->insert("courses",$date);
	}
	function read_course_overview($type="",$isAdmin=""){
		//can read course overview according to the type if the type is set 
		//or can read all coures' overview if type is not set
		//if the caller is admin user, the course list should include those not created successfully.
		//if the caller is teacher or student, the course list should include only those created successfully. 
		$this->db->select("courseID,courseName,teacherID,TypeID,State")->from("courses");
		if($type){$this->db->where("TypeID",$type);}
		if($isAdmin){$this->db->where("Create","1");}
		$query = $this->db->get();
		return $query->result();
	}
	function read_course_detail($courseID){
		$this->db->select("*")->where("courseID",$courseID)->from("courses");
		$query = $this->db->get();
		return $query->result();
	}
	function update_course_detail($data,$courseID){
		$this->db->update("courses",$data)->where("courseID",$courseID);
	}
	function delete_course($courseID){
		$this->db->delete("courses")->where("courseID",$courseID);
	}

}
?>