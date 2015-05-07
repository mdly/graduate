<?php //if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Ucrud extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->load->database();
	}
	function u_insert($arr){
		$this->db->insert('users',$arr);
		//把传来的数据数组插到users表中
	}
	//to be continued
	function u_select($unum){//通过学号或工号也就是表中userNum来查询
		$this->db->where('UserNum',$unum);
		$this->db->select('*');//获取全部信息;
		$query = $this->db->get('users');
		return $query->result();
	}
	
	function u_selec_admin(){//
	}
}
/*
CREATE TABLE IF NOT EXISTS `Users` ( `UserNum` char(10) NOT NULL, `UserID` varchar(128) NOT NULL, `Password` char(32) NOT NULL, `UserName` varchar(128) NOT NULL, `Gender` char(1) NOT NULL, `Email` varchar(128) NOT NULL, `Section` varchar(32) NOT NULL, `Type` int(1) NOT NULL, `TenantID` varchar(128) NOT NULL, PRIMARY KEY (`UserNum`), UNIQUE KEY `Email` (`Email`) ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1
*/
?>