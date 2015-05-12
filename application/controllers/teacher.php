<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Teacher extends CI_Controller{	
	public function __construct() {
		parent::__construct();
		//首先检查用户是否已经登录，用户类型是否是管理员
		$this->load->library('session');
		$this->load->model('userCrud');	
		$userNum = $this->session->userdata('s_id');
		$userType = $this->userCrud->read_user_type($userNum);
		if ($userType!='1'){
			echo 'not authorized!';
			die();
			$this->load->view("login");
		}
	}

	public function index(){
		$this->load->model('userCrud');
		$this->load->view('/teacher/user')
	}
	
}