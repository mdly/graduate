<?php //if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class UserCrud extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->load->database();
	}
	function create_user($data){
		$this->db->insert("users",$data);
	}
	function read_user_list($type="-1"){//if $type==-1, read all the users
		$this->db->select("UserNum,UserName,UserID,TenantID,Gender,Email,Section,Type");
		if($type!="-1") $this->db->where("Type",$type);
		$query=$this->db->from("users")->get();
		return $query->result();
	}
	function read_user_info($userNum){
		$query = $this->db->select("UserNum,UserName,UserID,TenantID,Gender,Email,Section,Type")->where("UserNum",$userNum)->from("users")->get();
		return $query->result();
	}
	function read_user_type($userNum){
		return $this->db->select("Type")->from("users")->where("userNum",$userNum)->get()->result()[0]->Type;
	}
	function read_user_login_info($userNum){
		$query = $this->db->select("Type,UserNum,Password")->where("UserNum",$userNum)->from("users")->get();
		return $query->result();
	}

	function update_user_info($data,$userNum){
		$this->db->where("UserNum",$userNum)->update("users",$data);
	}

	function delete_user($userNum){
		$this->db->delete("users")->where("UserNum",$userNum);
	}
	function search_user($columnName,$keyword,$type="-1"){
		$this->db->select("UserNum,UserName,UserID,TenantID,Gender,Email,Section,Type")->from("users");
		if ($type!="-1") $this->db->where("Type",$type);
		$query = $this->db->like($columnName,$keyword)->get();
		return $query->result();
	}
	function count_user(){
		$data = array();
		for ($i=0;$i<3;$i++){
			$data[] = $this->db->select("count(*) AS COUNT")->from("users")->where("Type",$i)->get()->result()[0]->COUNT;
		}
		return $data;
	}
	function read_teacher_list(){
		return $this->db->select("UserNum,UserName")->from("users")->where("Type","1")->get()->result();
	}
	function read_userName_by_ID($userNum){
		return $this->db->select("UserName")->from("users")->where("UserNum",$userNum)->get()->result()[0]->UserName;
	}
}
/*
//用户表
CREATE TABLE IF NOT EXISTS `Users` ( `UserNum` char(10) NOT NULL, `UserID` varchar(128) NOT NULL, `Password` char(32) NOT NULL, `UserName` varchar(128) NOT NULL, `Gender` char(1) NOT NULL, `Email` varchar(128) NOT NULL, `Section` varchar(32) NOT NULL, `Type` int(1) NOT NULL, `TenantID` varchar(128) NOT NULL, PRIMARY KEY (`UserNum`), UNIQUE KEY `Email` (`Email`) ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1
//课程表
CREATE TABLE IF NOT EXISTS `Courses` ( 
    `CourseID` char(10) NOT NULL, 
    `CourseName` varchar(128) NOT NULL,
    `TeacherID` char(10) NOT NULL,
    `TypeID` varchar(128) NOT NULL, //课程类型，与courseType关联
    `State` int(1) NOT NULL,//课程状态，0:off, 1:on, 1:done
    `InfoFile` varchar(128) NOT NULL,
    `Duration` time NOT NULL,
    `SubmitLimit` int(1) NOT NULL,
    `CourseDesc` text,
    `StartTime` datetime,
    `StopTime` datetime,
    `Location` varchar(128),
    `ImageID` varchar(128),
    `Created` int(1),
    PRIMARY KEY (`CourseID`)) 
    ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1
//镜像表
CREATE TABLE IF NOT EXISTS `Images` ( 
    `ImageIndex` int(10) NOT NULL,
    `ImageName` varchar(128) NOT NULL,
    `ImageID` varchar(128) NOT NULL,
    `ImageDesc` text,
    PRIMARY KEY (`ImageIndex`),
	UNIQUE KEY `ImageID` (`ImageID`))
    ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1
//课程类型表
CREATE TABLE IF NOT EXISTS `CourseType` ( 
    `TypeID` int(10) NOT NULL,
    `TypeName` varchar(128) NOT NULL,
    `TypeDesc` text,
    PRIMARY KEY (`TypeID`),
	UNIQUE KEY `TypeID` (`TypeID`))
    ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1
	*/
?>