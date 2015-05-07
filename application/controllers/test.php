<?php

class Test extends CI_Controller{
	public function index() {
		echo 123;
		var_dump( $this->input->post() );
	}
	
}