<?php
class Openstack extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	function curlOpt($url,$method,$data="",$header=""){
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
			default:
				break;
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
		$userName = $this->session->userdata('s_id');
		$this->load->model('userCrud');
		$password = $this->userCrud->read_user_login_info($userName)->Password;
		$url = ":5000/v2.0/tokens";
		$method = 'POST';		
		$passwordCredentials = array('username'=>$userName,'password'=>$password);
		$data = array('auth'=>array('tenantName'=>$tenantName,'passwordCredentials'=>$passwordCredentials));
		$header = array('Content-type: application/json');
		$result = $this->curlOpt($url,$method,$data,$header);
		//print_r($result);
		return $result;
	}
	function get_token_info($selection,$tenantName="admin"){
		$token = $this->authenticate_v2();
		switch ($selection) {
			case 'tokenID':
				$result = $token['access']['token']['id'];
				break;
			case 'tenantID':
				$result = $token['access']['token']['tenant']['id'];
			default:
				$result="";
				break;
		}
		return $result;
	}
	function create_tenant($tokenID,$name){
		$url = ":5000/v3/projects";
		$data = array('project'=>array('name'=>$name));
		$method = "POST";
		$header = array();
		$header[] = 'X-Auth-Token: '.$tokenID;
		$header[] = 'Content-type: application/json';
		$result = $this->curlOpt($url,$method,$data,$header);
		//echo "create_tenant";
		//print_r($result);
		return $result;
	}
	function get_role($tokenID){
		$url = ":5000/v3/roles";
		$method = "GET";
		$header = array('X-Auth-Token: '.$tokenID);
		$result = $this->curlOpt($url,$method,$data="",$header);
		return $result;
	}
	function create_user($tokenID,$data){
		//1.create tenant
		$tenant = $this->create_tenant($tokenID,$data['UserNum']);
		$tenantID = $tenant['project']['id'];
		//2.create user
		$url=":5000/v3/users";
		$user = array(
			'name'=>$data['UserNum'],
			'password'=>md5($data['Password']),
			'default_project_id'=>$tenantID,
			'email'=>$data['Email']
			);
		$data = array('user'=>$user);
		$method = "POST";
		$header = array();
		$header[] = 'X-Auth-Token: '.$tokenID;
		$header[] = 'Content-type: application/json';
		$result = $this->curlOpt($url,$method,$data,$header);
		$userID =$result['user']['id'];
		//3.grant role to a user
		$role = $this->get_role($tokenID);
		print_r($role);

		if ($data['Type']=="0"||$data['Type']=="1") {
			//管理员和教师用户作为openstack中的admin用户
			//查询一下
			$roleID = 
			# code...
		}else{
			//否则为学生用户，作为__member__用户
			$roleID = 
		}
		//$result ="";
		$this->grant_role($tokenID,$tenantID,$userID,$roleID);
		return $result;
	}
	function grant_role($tokenID,$tenantID,$userID,$roleID){
		$url = ":5000/v3/projects/​".$tenantID."/users/​".$userID."/roles/​".$roleID;
		$header = array('X-Auth-Token: '.$tokenID);
		$method = 'HEAD';		
		$result = $this->curlOpt($url,$method,$data="",$header);
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
		$result = $this->curlOpt($url,$method,$data="",$header);
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

		$result = $this->curlOpt($url,$method,$data,$header);
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
		$result = $this->curlOpt($url,$method,$data,$header);
		return $result;
	}
}
?>