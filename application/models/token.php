<?php
class Token extends CI_Model(){	
	function __construct(){
		parent::__construct();
		$this->load->database();
	}
	function add_token($token,$userNum){

echo strtotime("now"), "\n";
echo strtotime("10 September 2000"), "\n";
echo strtotime("+1 day"), "\n";
echo strtotime("+1 week"), "\n";
echo strtotime("+1 week 2 days 4 hours 2 seconds"), "\n";
echo strtotime("next Thursday"), "\n";
echo strtotime("last Monday"), "\n";
		//$time = date('Y-m-d')
		//$this->db->insert("tokens",array("Token"=>$token,"UserNum"=>$userNum,"Time"=>$time));
	}
	function delete_token($token){
		$this->db->delete("tokens")->where("Token",$token);
	}
	function check_token($token,$userNum){
		//1.查看有没有这个$token,
		//2.查看有没有这个$userNum,
		//3.查看时间有没有超时,
		$data = $this->db->select("UerNum,Time")->where("Token",$token)->from("tokens")->get()->result();
		if(count($data)){
			//1. ok!
			if($data[0]->UserNum == $userNum){
				//2.ok!
				//PHP 日期加减小时
				$time = date("Y-m-d h:i:s",strtotime($data[0]->Time." +1 hour"));
				echo $time;
				$now = date('Y-m-d H:i:s');
				echo $now;
				if($data[0]->Time){

				}
			}
		}
	}
}

?>