<?php //if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class UserCrud extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->load->database();
	}
	function create_user($data){
		//1.check if userNum exists
		$msg = "";
		$errorNo=0;
		$query = $this->db->select("*")->from("users")
		->where("UserNum",$data['UserNum'])->get()->result();
		if($query){
			//userNum exists,cannot create the user!
			$msg = "此学号/工号已被使用！";
			$errorNo = 1;
		}elseif (!filter_var($data['Email'],FILTER_VALIDATE_EMAIL)) {
		//2.check the email is valid.
			//echo "check 1";
			$msg = "您输入的邮箱不存在！";
			$errorNo = 2;
		}else{
			$domain = explode('@', $data['Email']);
			//print_r($domain);
			if(!checkdnsrr($domain[1],'MX')){
				$msg = "您输入的邮箱不可用！";
				$errorNo = 3;
			}else{
				//在OpenStack中创建用户
				$this->load->model('openstack');
				$tokenID = $this->openstack->get_admin_token()["tokenID"];
				$user_OS = $this->openstack->create_user($tokenID,$data);
				//print_r($result_OS);
				//$this->openstack->user_create($data);
				if($user_OS){
					$result1 = $this->db->insert("users",$data);
					$result2 = $this->db->where("UserNum",$data["UserNum"])->update("users",$user_OS);
					if($result1&&$result2){
						$msg = "创建成功！";
						$errorNo = 0;
					}else{
						$msg="创建失败！请检查输入的用户信息！";
						$errorNo = 4;
					}
				}else{
					$msg="云用户创建失败！";
					$errorNo=5;
				}

			}
		}
		return array("message"=>$msg,"success"=>$errorNo);
	}
	function read_user_list($type="-1"){//if $type==-1, read all the users
		$this->db->select("UserNum,UserName,UserID,TenantID,Gender,Email,Section,Type");
		if($type!="-1") $this->db->where("Type",$type);
		$query=$this->db->from("users")->get();
		return $query->result();
	}
	function read_user_info($userNum){
		$query = $this->db->select("UserNum,UserName,UserID,TenantID,Gender,Email,Section,Type")
		->where("UserNum",$userNum)->from("users")->get();
		return $query->result();
	}
	function read_user_email($userNum){
		$email = $this->db->select("Email")->from("users")->where("UserNum",$userNum)->get()->result();
		if(count($email)==1){
			return $email[0]->Email;
		}
		return $email;
	}
	function read_user_type($userNum){
		return $this->db->select("Type")->from("users")
		->where("userNum",$userNum)->get()->result()[0]->Type;
	}
	function read_user_login_info($userNum){
		$query = $this->db->select("Type,UserNum,Password")
		->where("UserNum",$userNum)->from("users")->get()->result();
		if (count($query)==0){return array();}
		else return $query[0];
	}

	function update_user_info($data,$userNum){
		$this->db->where("UserNum",$userNum)->update("users",$data);
	}

	function delete_user($data){
		//1.判断要删除的用户是否管理员或教师用户
		//若是，则只需删除本地数据库
		//若否，则还要删除openstack中用户，以及用户创建的虚拟机和网络
		//网络部分先等等
		$this->load->model("openstack");
		$this->load->library("session");
		$myself = $this->session->userdata('s_id');
		$msg="删除成功！";
		$errorNo=0;
		for ($i=0; $i < count($data); $i++) { 
			if($myself==$data[$i]){
				$msg="您无法删除自己的账号！";
				$errorNo=1;
			}else{
				if($this->read_user_type($data[$i])==2){
					//student
					$user_OS = $this->db->select("TenantID,UserID")->from("users")
					->where("UserNum",$data[$i])->get()->result()[0];
					$this->openstack->delete_tenant($user_OS->TenantID);
					$this->openstack->delete_user($user_OS->UserID);
				}
				//$this->openstack->delete_user($data[$i]);
				$result = $this->db->where("UserNum",$data[$i])->delete("users");
				if (!$result){$msg="数据库删除失败!";$errorNo=2;}
			}
		}
		return array("message"=>$msg,"success"=>$errorNo);
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
			$data[] = $this->db->select("count(*) AS COUNT")->from("users")
			->where("Type",$i)->get()->result()[0]->COUNT;
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