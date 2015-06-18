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
		// $this->load->model("openstack");
		// //$result= $this->openstack->delete_user("fa65238a341a4945bca2a5381c6b10b7");
		// $this->load->database();
		// $this->db->where("StudentID","5110159006")->delete("selectcourse");
		// //print_r($result);
		// $token = $this->openstack->get_admin_token();
		// $tokenID = $token['tokenID'];
		// //$this->openstack-> run_VM($tokenID,"3cedbe928a884c4ebeca586f24f34404","47bd8248-29aa-4280-ab9f-f43919ffa42c","1","123","b2b20621-530f-42e6-acf3-2b979e8c9d74");
		// $data ='{"server": {"name": "test1", "imageRef": "47bd8248-29aa-4280-ab9f-f43919ffa42c", "flavorRef": "1", "max_count": 1, "min_count": 1, "networks": [{"uuid": "caa44e0b-97c8-4aab-aa50-af69ba2f6007"}]}}';
		// print_r($data);
		// $json = json_decode($data);
		// print_r($json);
		// $url="http://192.168.28.1:6080/vnc_auto.html?token=39c91e8d-74a0-45b6-99b4-3071eed1be7f&title=demoVM(ed635b09-fb0b-459e-b81e-22b439e7dd16)";
		// echo "<a href=".$url.">".$url."</a>";
		//$this->load->model('courseCrud');
		//$result = $this->courseCrud->read_vm(30,5110159004);
		// print_r($tokenID);
		// echo $tokenID;
		// $token = substr($tokenID, 0,8);
		// echo "<br>";
		// $token = substr($tokenID, 0,8)."-".substr($tokenID, 8,4)."-".substr($tokenID, 12,4)."-".substr($tokenID, 14,4)."-".substr($tokenID, 18);
		// echo "$token";
		// $tenantID= $token['tenantID'];
		// $vmID = "7361350a-49e6-49a2-afdf-ec282d00effe";
		// $tenantName = "5110159004";
		// $this->openstack->create_keypair($tokenID,$tenantID,$tenantName);
		// $name= "test";
		// $this->openstack->create_image($tokenID,$name,$imagePath="");


		// $this->openstack->delete_server($tokenID,$tenantID,"5110159004",$vmID);
		$this->load->model('courseCrud');
		$this->load->model('imageCrud');
		$courseID = $this->courseCrud->get_lately_added_courseID();
		$isTarget = '1';
		$imageID = '6ba6c84b-0646-4b4a-ac0d-c8ce1d95f697';
		$this->imageCrud->add_courseImage($isTarget,$courseID,$imageID);

	}
	
}