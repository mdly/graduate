<?php //if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Validation extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->load->database();
	}
	function is_valid_password($password1,$password2){
		//这边还可以设置密码的规则，比如要求必须要有数字，字母，特殊字符，密码长度等。
		if ($password1){//非空
			if ($password1 == $password2){//前后两次相同
				return true;
			}else return false;
		}else return false;
	}
	function is_valid_email($userEmail,$userNum){
		//用于检验用户输入的email和用户名是匹配的
		$this->load->database();
		$this->db->select("Email");
		$this->db->from("users");
		$this->db->where("UserNum",$userNum);
		$query = $this->db->get()->result();
		echo "this is in the model";
		if ($query[0]->Email==$userEmail)return true;
		else return false;
	}
}
?>