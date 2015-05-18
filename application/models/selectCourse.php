<?php
class SelectCourse extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->load->database();
	}



	function count_student_by_course($courseID){
		$data = $this->db->select("count(*) AS COUNT")->from("selectcourse")->where("CourseID",$courseID)->get()->result()[0]->COUNT;
		//echo "count_student_by_course:";
		//print_r($data);
	}
	function read_user_list_by_course($courseID){
		//$data = $this->db->select("*")->from("selectcourse")->where('CourseID',$courseID)->get()->result[0]；
		$this->db->select("*");
		$this->db->from("selectcourse");
		$this->db->where("CourseID",$courseID);
		$data = $this->db->get();
		return $data->result();
	}
	//function 
}/*
CREATE TABLE IF NOT EXISTS `SelectCourse` (
	`SelectionID` int(11) NOT NULL,
    `CourseID` int(11) NOT NULL, 
    `StudentID` char(10) NOT NULL,
    `ReportPath` varchar(128),
    `Score` int(11),
    `LastSubmit` timestamp,
    `TimeConsumed` Time,
    `Finished` int(1),//用来记录课程是否已完成
    //`VMURL` varchar(256);
    PRIMARY KEY (`SelectionID`)) 
    ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1
*/
?>