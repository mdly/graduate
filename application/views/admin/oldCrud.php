<?php //if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Crud extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->load->database();
	}
	//common function, can be used for users, courses and images.
	//every section should include crud --> create(insert), read(select), update(update), delete(delete) and count number functon
	//0.count function
	//used to get the general info
	function count_all($tableName){
		//无条件计数
		$this->db->select("count(*) AS COUNT");
		$this->db->from($tableName);
		$data = $this->db->get()->result()->result();
		return $data[0]->COUNT;
	}
	function count_by_type($tableName,$colName,$colValue){
		//有条件计数
		$this->db->select("count(*) AS COUNT");
		$this->db->from($tableName);
		$this->db->where($colName,$colValue);
		$data = $this->db->get()->result()->result();
		return $data[0]->COUNT;
	}
	//1.create function
	function create($tableName,$data){
		//can be used to insert users/ courses/ images
		$this->db->insert($tableName,$data);
	}
	//2.read function
	function read_all($tableName){
		$this->db->select("*");
		$this->db->from($tableName);
		$query = $this->db->get();
		return $query->result();
	}
	function read_some_line($tableName,$colName,$colValue){
		$this->db->select("*");
		$this->db->from($tableName);
		$this->db->where($colName,$colValue);
		$query = $this->db->get();
		return $query->result();
	}
	function read_some_value($readCon,$tableName,$colName,$colValue){
		$this->db->select($readCon);
		$this->db->from($tableName);
		$this->db->where($colName,$colValue);
		$query = $this->db->get();
		return $query->result();
	}
	//3.update function
	function update($colu){
		$this->db->where('userNum',$userNum);
		$this->db->update('users',$arr);//更新

	}







	function insert($arr){//$arr为二维数组，$arr[0]表示数据表，$arr[1]表示插入的内容
		$this->db->insert($arr[0][0],$arr[1]);
	}
	function insert_user($arr){
		$this->db->insert('users',$arr);
	}
	function select_all($table){
		$this->db->select("*");
		$this->db->from($table);
		$query = $this->db->get();
		return $query->result();
	}
	function select($arr){
		//$arr[0]为查询内容，$arr[1]为查询表名，$arr[2]为查询条件列名，$arr[3]为查询条件值
		$this->db->select($arr[0]);
		$this->db->from($arr[1]);
		$this->db->where($arr[2],$arr[3]);
		$query = $this->db->get();
		return $query->result();
	}
	function select_course_type(){
		//主要用于课程中课程类型的查询
		//$this->db->select("DISTINCT Type");
		$this->db->select("TypeName");
		$this->db->from("coursetype");
		$query = $this->db->get();
		return $query->result();
	}
	function selectUser($arr){
		//用于查询用户的概要信息，一般按照用户类型分别查询。
		$this->db->select('*');
		$this->db->from($arr[1]);
		$this->db->where($arr[2],$arr[3]);
		$query = $this->db->get();
		return $query->result();
	}
	function count_nolimit($arr){
		//无条件计数
		//$arr[0]为查询内容，$arr[1]为查询表名
		$this->db->select($arr[0]);
		$this->db->from($arr[1]);
		$query = $this->db->get();
		return $query->result();
	}
	function u_update($userNum,$arr){
		//$userNum为学号/工号，$arr为新的用户数据
		$this->db->where('userNum',$userNum);
		$this->db->update('users',$arr);//更新
	}
	function delete_user($col,$colVal,$table){
		$this->db->where($col,$colVal);
		$this->db->delete($table);
	}
	//查询数目
	/*
	function select_count($arr){//$arr[0]查询表名，$arr[1]查询条件列名，$arr[2]查询条件值
		$this->db->select('count(*)');
		$this->db->from($arr[0]);
		$this->db->where($arr[1],$arr[2]);
		$query = $this->db->get();
		return $query->result();
	}*/	
}
/*
//用户表
CREATE TABLE IF NOT EXISTS `Users` ( `UserNum` char(10) NOT NULL, `UserID` varchar(128) NOT NULL, `Password` char(32) NOT NULL, `UserName` varchar(128) NOT NULL, `Gender` char(1) NOT NULL, `Email` varchar(128) NOT NULL, `Section` varchar(32) NOT NULL, `Type` int(1) NOT NULL, `TenantID` varchar(128) NOT NULL, PRIMARY KEY (`UserNum`), UNIQUE KEY `Email` (`Email`) ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1
?>