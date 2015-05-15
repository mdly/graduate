<?php

class Test extends CI_Controller{
	public function index() {

		$config["protocol"]="smtp";
		$config["charset"]="utf-8";
		$config["smtp_host"]="smtp.qq.com";
		$config["smtp_port"]="465";
		$config["smtp_user"]="1656016399@qq.com";
		$config["smtp_pass"]="3991qq.www";

		$this->load->library('email', $config);

		$this->email->from('1656016399@qq.com', 'Your Name');
		$this->email->to('1656016399@qq.com'); 

		$this->email->subject('Email Test');
		$this->email->message('Testing the email class.'); 

		$this->email->send();

		echo $this->email->print_debugger();
	}
	
}