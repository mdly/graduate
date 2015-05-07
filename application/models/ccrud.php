<?php //if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Ucrud extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->load->database();
	}
	function c_insert($arr){
		$this->db->insert('courses',$arr);
		//把传来的数据数组插到users表中
	}
	//to be continued
	function c_select($unum){//通过学号或工号也就是表中userNum来查询
		$this->db->where('CourseID',$unum);
		$this->db->select('count(*)');//获取课程数目
		$query = $this->db->get('users');
		return $query->result();
	}
	function c_select_off(){//查询所有已经完成的课程的数目
		$this->db->select('count(*)');
		$this->db->where('Type','0');
		$query = $this->db->get('courses');
		return $query->result();	
	}
	function c_select_on(){//查询所有开启的课程的数目
		$this->db->select('count(*)');		
		$this->db->where('Type','1');
		$query = $this->db->get('courses');
		return $query->result();	
	}
	function c_select_done(){//查询所有未开启的课程的数目
		$this->db->select('count(*)');
		$this->db->where('Type','2');
		$query = $this->db->get('courses');
		return $query->result();
	}	
}/*
CREATE TABLE IF NOT EXISTS `Courses` ( 
    `CourseID` char(10) NOT NULL, 
    `CourseName` varchar(128) NOT NULL,
    `TeacherID` char(10) NOT NULL,
    `Type` varchar(128) NOT NULL,
    `State` int(1) NOT NULL,
    `InfoFile` varchar(128) NOT NULL,
    `Duration` time NOT NULL,
    `SubmitLimit` int(1) NOT NULL,
    `CourseDesc` text,
    `StartTime` datetime,
    `StopTime` datetime,
    `Location` varchar(128),
    `ImageID` varchar(128),
    PRIMARY KEY (`CourseID`) ) 
    ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1
*/
?>