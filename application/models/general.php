<?php
class General extends CI_Model{
	function  __construct(){
		parent::__construct();
	}
	function load_view($user,$left,$rightView,$rightData){
		$topView = "/".$user."/top";
		$topData = array();
		$leftVIew = "/".$user."/left";
		$leftData = array('left' => $left);
		$
		$bottonView = "/".$user."/botton";
		$bottonData = array();
		$this->load->view($topView,$topData);
		$this->load->view($leftVIew,$leftData);
		$this->load->view($rightView,$rightData);
		$this->load->view($bottonView,$bottonData);
	}


}
?>