<?php

class Test extends CI_Controller{
	public function index() {
		/*
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
		
		$role = Array(
			"links"=>Array("self"=>"http://192.168.28.1:5000/v3/roles", "previous"=>"", "next" =>"" ),
			"roles"=> Array('0'=>Array("id"=> "4fddda26d701458aa009359e6cdd4bf5", 'links' =>"",Array ( "self" => "http://192.168.28.1:5000/v3/roles/4fddda26d701458aa009359e6cdd4bf5" ), "name" => 'ResellerAdmin' ),
    		'1' => Array ( "id" => "5f191b57f8f349d5aca495e9e064c568", 'links' =>"", Array ( "self" => "http://192.168.28.1:5000/v3/roles/5f191b57f8f349d5aca495e9e064c568" ), "name" => 'admin' ),
     		'2' => Array ( "id" => "9fe2ff9ee4384b1894a90878d3e92bab", 'links' =>"", Array ( "self" => "http://192.168.28.1:5000/v3/roles/9fe2ff9ee4384b1894a90878d3e92bab" ), "name" => '_member_' ),
     		'3' => Array ( "id" => "a0fbdca271d545f19587548acbf41661", 'links' =>"", Array ( "self" => "http://192.168.28.1:5000/v3/roles/a0fbdca271d545f19587548acbf41661" ), "name" => 'SwiftOperator' ) ) );
		for ($i=0; $i < count($role); $i++) { 
			if($role['roles'][$i]['name']=="admin"){
				echo $role['roles'][$i]['id'];
			}
		}

		$roleID_admin = in_array("admin", $role['roles']);
		$roleID_member = in_array("_member_", $role['roles']);
		echo "roleID_admin=";
		print_r($roleID_admin);
		echo "<br>";
		echo "roleID_member=";
		print_r($roleID_member);*/
		$this->load->model("openstack");
		$result= $this->openstack->delete_user("fa65238a341a4945bca2a5381c6b10b7");

		print_r($result);

	}
	
}