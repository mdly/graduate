<?php
class Openstack extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	function curl_opt($url,$method,$data="",$header="",$nodebug=true){
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
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, $nodebug);
		$result = curl_exec($ch);
		curl_close($ch);
		return json_decode($result,true);
	}
	function authenticate_v2(){
		$this->load->library("session");
		$userNum = $this->session->userdata('s_id');
		$this->load->model('userCrud');
		$user = $this->userCrud->read_user_login_info($userNum);
		$userType = $user->Type;
		if($userType!=2){
			//管理员和教师在云平台中的只对应一个用户
			$userName = "admin";
			$password = "xuexihao";
			$tenantName = "admin";
		}else{
			$userName = $userNum;
			$password = $user->Password;
			$tenantName = $userName;
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
	function create_keypair($tokenID,$tenantID,$tenantName){
		//curl -g -i -X POST http://192.168.28.1:8774/v2/8bdaead9c5234d018e30709c9de16c3a/os-keypairs -H "User-Agent: python-novaclient" -H "Content-Type: application/json" -H "Accept: application/json" -H "X-Auth-Token: {SHA1}1ebcd810fa5e2b4975b105949c7e2ab9dd862ee3" -d '{"keypair": {"name": "123"}}'
		$url = ":8774/v2/".$tenantID."/os-keypairs";
		$method = "POST";
		$data = array("keypair"=>array("name"=>$tenantName));
		$header = array();
		$header[] = 'X-Auth-Token: '.$tokenID;
		// $header[] = 'X-Auth-Project-Id:'.$tenantName;
		$header[] = 'User-Agent: python-novaclient';
		$header[] = 'Content-type: application/json';
		$result = $this->curl_opt($url,$method,$data,$header,false);
		return $result;
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
				//4.create a keypair
				//$this->create_keypair($tokenID,$tenantID);
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
	function get_subnet_detail($tokenID,$subnetID){
		$url = ":9696/v2.0/subnets/".$subnetID;
		$method = "GET";
		$header = array('X-Auth-Token: '.$tokenID);
		$result = $this->curl_opt($url,$method,$data="",$header)['subnet'];
		return $result;
	}
	function create_server($tokenID,$tenantName,$tenantID,$name,$imageRef,$flavorRef,$network){
		$url = ':8774/v2/'.$tenantID.'/servers';
		$method = "POST";
		$header = array();
		$header[] = 'X-Auth-Token: '.$tokenID;
		$header[] = 'X-Auth-Project-Id:'.$tenantName;
		$header[] = 'User-Agent: python-novaclient';
		$header[] = 'Content-type: application/json';
		$server = array(
			'name'=>$name,
			'imageRef'=>$imageRef,
			'flavorRef'=>$flavorRef,
			'max_count'=>1,
			'min_count'=>1,
			'networks'=>array("0"=>array("uuid"=>$network)));
		$data = array('server'=>$server);
		$result = $this->curl_opt($url,$method,$data,$header)['server'];
		return $result;
	}
	function delete_server($tokenID,$tenantID,$tenantName,$vmID){
		//curl -g -i -X DELETE http://192.168.28.1:8774/v2/8bdaead9c5234d018e30709c9de16c3a/servers/1cfceb02-74d2-4e13-b20a-13d9b0c6f6e9 -H "User-Agent: python-novaclient" -H "Accept: application/json" -H "X-Auth-Token: {SHA1}af8110f2bf4714ff7c8a99ab572950416f3eff01"

		$url = ':8774/v2/'.$tenantID."/servers/".$vmID;
		$method = "DELETE";
		$header = array();
		$header[] = 'X-Auth-Token: '.$tokenID;
		$header[] = 'X-Auth-Project-Id:'.$tenantName;
		$header[] = 'User-Agent: python-novaclient';
		$header[] = 'Content-type: application/json';
		// $data = array("forceDelete"=>"null");
		$this->curl_opt($url,$method,$data="",$header,'false');
	}
	function get_tokenID(){
		$token = $this->authenticate_v2();
		return $token['access']['token']['id'];
	}
	function slash_ID($id){
		return substr($id, 0,8)."-".substr($id, 8,4)."-".substr($id, 12,4)."-".substr($id, 14,4)."-".substr($id, 18);
	}
	function get_server_url($tokenID,$tenantID,$vmID){
		$url = ":8774/v2/".$tenantID."/servers/".$vmID."/action";
		$header = array();
		$header[] = 'User-Agent: python-novaclient';
		$header[] = 'Content-type: application/json';
		$header[] = 'Accept: application/json';
		$header[] = 'X-Auth-Token: '.$tokenID;
		$method = 'POST';
		$data = array("os-getVNCConsole"=>array("type"=>'novnc'));
		$result = $this->curl_opt($url,$method,$data,$header);
		// {"console": {"url": "http://192.168.28.1:6080/vnc_auto.html?token=9b8088ca-7465-486c-8a5c-207bcc8036dc", "type": "novnc"}}
		$VMURL = $result['console']['url'];
		return $VMURL;
	}

	function get_server_detail($vmID){
		$token = $this->authenticate_v2();
		$tenantID=$token['access']['token']['tenant']['id'];
		$tokenID = $token['access']['token']['id'];
		$url = ":8774/v2/".$tenantID."/servers/".$vmID;
		$method="GET";
		$header = array('X-Auth-Token: '.$tokenID);
		$vmInfo = $this->curl_opt($url,$method,$data="",$header)['server'];
		$VMURL = $this->get_server_url($tokenID,$tenantID,$vmID);
		// print_r($vmInfo);
		return array('basicInfo'=>$vmInfo,'url'=>$VMURL);
	}
	function create_network($tokenID,$name,$subnetName,$subnetCIDR){
		//创建网络
		$url = ":9696/v2.0/networks";
		$method = "POST";
		$header = array('X-Auth-Token: '.$tokenID);
		$network = array("name"=>$name,"admin_state_up"=>true);
		$data = array("network"=>$network);
		$result = $this->curl_opt($url,$method,$data,$header);
		$networkID = $result['network']['id'];
		//创建子网
		$url = ":9696/v2.0/subnets";
		$data = array("subnet"=>array("network_id"=>$networkID,"ip_version"=>"4","cidr"=>$subnetCIDR));
		$subnet = $this->curl_opt($url,$method,$data,$header)["subnet"];
	}
	function create_router($tokenID){
		echo "we are developing it...";
	}
	function create_image($tokenID,$name,$imagePath){


		// curl -i -X PUT -H "X-Auth-Token: $token" 
		// -H "Content-Type: application/octet-stream" 
		// -d @/home/glance/ubuntu-12.10.qcow2 $image_url/v2/images/{image_id}/file
		$url = ":9292/v1/images";
		$method = "POST";
		$header = array('X-Auth-Token: '.$tokenID);
		$data = array('name'=>$name);
		$this->curl_opt($url,$method,$data,$header,false);

// curl -g -i -X POST 
// -H 'Accept-Encoding: gzip, deflate' 
// -H 'x-image-meta-container_format: bare' 
// -H 'Accept: */*' 
// -H 'X-Auth-Token: {SHA1}2e98002171130d1f5e122507d24de80aca792780'
// -H 'x-image-meta-size: 262275584' 
// -H 'Connection: keep-alive'
// -H 'x-image-meta-is_public: True' 
// -H 'User-Agent: python-glanceclient' 
// -H 'Content-Type: application/octet-stream' 
// -H 'x-image-meta-disk_format: qcow2' 
// -H 'x-image-meta-name: ubuntu1204'

		// $url=":9292/v2/images/".$imageID."/file";
		// $method="POST";
		// $header=array();
		// $header[] = 'User-Agent: python-novaclient';
		// $header[] = 'Content-type: application/octet-stream';
		// $header[] = 'Accept: application/json';
		// $header[] = 'X-Auth-Token: '.$tokenID;
		// $data = $imagePath;"


// <http-version>1.1</http-version>
// <http-follow-redirects/>
// <URL>https://[FLOATING_IP_ADDRESS]:9292/v1/images</URL>
// <method>POST</method>
// <ssl>
// <trust-self-signed-cert/>
// <hostname-verifier>ALLOW_ALL</hostname-verifier>
// <truststore file="[PATH_TO_TRUSTSTORE]" password="[TRUSTSTORE_PWD]"/>
// </ssl>
// <headers>
// <header key="x-image-meta-container_format" value="ovf"/>
// <header key="x-image-meta-disk_format" value="vmdk"/><header key="x-image-meta-name" value="[IMAGE_NAME]"/>
// <header key="X-Auth-Token" value="[KEYSTONE_TOKEN]"/>
// </headers>
// <body>
// <file content-type="application/octet-stream" charset="UTF-8">[PATH_TO_IMAGE_FILE]</file>
// </body>
// </request>
// </rest-client>





	}
}
?>