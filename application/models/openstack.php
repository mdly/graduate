<?php
class Openstack extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	function curl_opt($url,$method,$data="",$header=""){
		$site = "192.168.28.1";
		$fullURL = $site.$url;
		$ch =  curl_init();
		if($data)$data_json = json_encode($data);
		switch ($method) {
			case 'POST':
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
				break;
			case 'GET':
				curl_setopt($ch, CURLOPT_HTTPGET, 1);
				break;
			case 'HEAD':
				curl_setopt($ch, CURLOPT_HEADER, 1);
				break;
			case 'PUT':
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
				break;
			case 'DELETE':
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
				break;
			default:break;
		}
		//array('Content-type: text/plain', 'Content-length: 100')
		curl_setopt($ch, CURLOPT_URL, $fullURL);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		curl_close($ch);
		return json_decode($result,true);
	}
	function authenticate_v2($tenantName="admin"){
		$this->load->library("session");
		$userNum = $this->session->userdata('s_id');
		$this->load->model('userCrud');
		$user = $this->userCrud->read_user_login_info($userNum);
		$userType = $user->Type;
		if($userType!=2){
			//管理员和教师在云平台中的只对应一个用户
			$userName = "admin";
			$password = "xuexihao";
		}else{
			$userName = $userNum;
			$password = $user->Password;
		}
		$url = ":5000/v2.0/tokens";
		$method = 'POST';		
		$passwordCredentials = array('username'=>$userName,'password'=>$password);
		$data = array('auth'=>array('tenantName'=>$tenantName,'passwordCredentials'=>$passwordCredentials));
		$header = array('Content-type: application/json');
		$result = $this->curl_opt($url,$method,$data,$header);
		return $result;
	}
	function get_admin_token(){
		$userName='admin';
		$password='xuexihao';
		$tenantName = 'admin';
		$url = ":5000/v2.0/tokens";
		$method = 'POST';		
		$passwordCredentials = array('username'=>$userName,'password'=>$password);
		$data = array('auth'=>array('tenantName'=>$tenantName,'passwordCredentials'=>$passwordCredentials));
		$header = array('Content-type: application/json');
		$result = $this->curl_opt($url,$method,$data,$header);

		$userID = $result['access']['user']['id'];
		$tenantID = $result['access']['token']['tenant']['id'];
		$tokenID = $result['access']['token']['id'];
		//print_r($result);
		return array("userID"=>$userID,"tenantID"=>$tenantID,"tokenID"=>$tokenID);
	}
	function get_tenant_list($tokenID,$name){
		$url=":5000/v3/projects";
		$method="GET";
		$header= array('X-Auth-Token: '.$tokenID);
		$result = $this->curl_opt($url,$method,$data="",$header);
		return $result;
	}
	function create_tenant($tokenID,$name){
		$tenants = $this->get_tenant_list($tokenID,$name);
		for ($i=0; $i < count($tenants['projects']); $i++) {
			if($tenants['projects'][$i]['name']==$name){
				return 0;
			}
		}
		$url = ":5000/v3/projects";
		$data = array('project'=>array('name'=>$name));
		$method = "POST";
		$header = array();
		$header[] = 'X-Auth-Token: '.$tokenID;
		$header[] = 'Content-type: application/json';
		$result = $this->curl_opt($url,$method,$data,$header);
		return $result;
	}
	function get_role($tokenID){
		$url = ":5000/v3/roles";
		$method = "GET";
		$header = array('X-Auth-Token: '.$tokenID);
		$role = $this->curl_opt($url,$method,$data="",$header);
		for ($i=0; $i < count($role['roles']); $i++) { 
			if($role['roles'][$i]['name']=="admin"){
				$roleID_admin=$role['roles'][$i]['id'];
			}
			if($role['roles'][$i]['name']=='_member_'){
				$roleID_member=$role['roles'][$i]['id'];
			}
		}
		return array("admin"=>$roleID_admin,"member"=>$roleID_member);
	}
	function create_user($tokenID,$data){
		//if the user is admin or teacher, need not to create a tenant
		//return the 
		//if the user is student, create ad tenant
		if ($data['Type']!=2){
			$userID = $this->get_admin_token()["userID"];
			$tenantID = $this->get_admin_token()["tenantID"];
		}else{
			//1.create tenant
			$tenant = $this->create_tenant($tokenID,$data['UserNum']);
			if($tenant){
				$tenantID = $tenant['project']['id'];
				//2.add admin to the tenant
				$adminToken = $this->get_admin_token();
				$adminTokenID = $adminToken["tokenID"];
				$adminUserID = $adminToken["userID"];
				$adminRoleID = $this->get_role($adminTokenID)['admin'];
				$this->grant_role($adminTokenID,$tenantID,$adminUserID,$adminRoleID);
				//3.create user
				$url=":5000/v3/users";
				$user = array(
					'name'=>$data['UserNum'],
					'password'=>$data['Password'],
					'default_project_id'=>$tenantID,
					'email'=>$data['Email']
					);
				$curlData = array('user'=>$user);
				$method = "POST";
				$header = array();
				$header[] = 'X-Auth-Token: '.$tokenID;
				$header[] = 'Content-type: application/json';
				$result = $this->curl_opt($url,$method,$curlData,$header);
				$userID = $result['user']['id'];
				$roleID = $this->get_role($adminTokenID)['member'];
				//3.grant member role to new user			
				$this->grant_role($tokenID,$tenantID,$userID,$roleID);
			}else{
				return 0;
			}
		}
		return array("userID"=>$userID,"tenantID"=>$tenantID);
	}
	function delete_tenant($tenantID){
		$tokenID=$this->get_admin_token()["tokenID"];
		$header = array('X-Auth-Token: '.$tokenID);
		$url=":5000/v3/projects/".$tenantID;
		$method = "DELETE";
		$this->curl_opt($url,$method,$data="",$header);
	}
	
	function delete_user($userID){
		$tokenID=$this->get_admin_token()["tokenID"];
		$url=":5000/v3/users/".$userID;
		$method="DELETE";
		$header = array('X-Auth-Token: '.$tokenID);
		$result = $this->curl_opt($url,$method,$data="",$header);
	}
	function grant_role($tokenID,$tenantID,$userID,$roleID){		
		//add a user to a tenant
		$url = ":35357/v2.0/tenants/".$tenantID."/users/".$userID."/roles/OS-KSADM/".$roleID;
		$method = 'PUT';
		$header = array('X-Auth-Token: '.$tokenID);
		$result1 = $this->curl_opt($url,$method,$data="",$header);

		$url = ":5000/v3/projects/​".$tenantID."/users/​".$userID."/roles/​".$roleID;
		$header = array('X-Auth-Token: '.$tokenID);
		$method = 'PUT';		
		$result = $this->curl_opt($url,$method,$data="",$header);
	}
	function get_resources($tokenID,$tenantID,$resources){
		//$site = "202.120.58.110";
		//echo $tenantID;
		switch ($resources) {
			case 'keypair':$url = ":8774/v2/".$tenantID."/os-keypairs";break;
			case 'network':$url = ":9696/v2.0/networks";break;
			case 'flavor':$url = ":8774/v2/".$tenantID."/flavors";break;
			case 'image':$url = ":8774/v2/".$tenantID."/images";break;
			case 'server':$url = ":8774/v2/".$tenantID."/servers";break;
			//case 'image':$url = $site.":9292/v2/images";break;
			default:break;
		}
		$method = 'GET';
		$header = array('X-Auth-Token: '.$tokenID);
		$result = $this->curl_opt($url,$method,$data="",$header);
		return $result;
	}
	function create_server($tokenID,$tenantID,$name,$imageRef,$key,$flavorRef,$network){
		echo "this is create_server";
		echo $network;
		echo "<br>";
		echo "flavorRef=";
		echo $flavorRef;
		//$site = "202.120.58.110:8774";
		$url = ':8774/v2/'.$tenantID.'/servers';
		$method = "POST";
		$header = array('X-Auth-Token: '.$tokenID);
		$server = array('name'=>$name,'network'=>$network,'imageRef'=>$imageRef,'key_name'=>$key,'flavorRef'=>$flavorRef,'max_count'=>1,'min_count'=>1);
		$data = array('server'=>$server);

		$result = $this->curl_opt($url,$method,$data,$header);
		return $result;

	}
	function get_vm_console($serverID,$tenantID,$serverID){
		//$site="202.120.58.110:8774";
		$url= ":8774/v2/​".$tenantID."/servers/​".$serverID."/action";
		echo "this is get_vn_console";
		$header = array('X-Auth-Token: '.$tokenID,'Content-type: application/json');
		$server = array('name'=>$name,'network'=>$network,'imageRef'=>$imageRef,'key_name'=>$key,'flavorRef'=>$flavorRef,'max_count'=>1,'min_count'=>1);
		$data = array('server'=>$server);
		$method = "POST";
		$result = $this->curl_opt($url,$method,$data,$header);
		return $result;
	}
}
?>