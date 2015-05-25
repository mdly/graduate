<?php
class Openstack extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	function authenticate_v2($userName,$password,$tenantName="admin"){
		//echo "userName=".$userName;
		//echo "password=".$password;
		$passwordCredentials = array('username'=>$userName,'password'=>$password);
		//$data = array('auth'=>array('tenantName'=>'symol','passwordCredentials'=>$passwordCredentials));
		$data = array('auth'=>array('tenantName'=>$tenantName,'passwordCredentials'=>$passwordCredentials));
		$data_json = json_encode($data);
		$header = array('Content-type: application/json');
		$site = "192.168.28.1:5000";
		$url = $site."/v2.0/tokens";
		$ch =  curl_init();
		curl_setopt($ch, CURLOPT_POST, 1);
		//array('Content-type: text/plain', 'Content-length: 100')
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		curl_close($ch);
		return json_decode($result,true);
	}
	function get_resources($tokenID,$tenantID,$resources){
		//$site = "202.120.58.110";
		$site = "192.168.28.1";
		//echo $tenantID;
		switch ($resources) {
			case 'keypair':$url = $site.":8774/v2/".$tenantID."/os-keypairs";break;
			case 'network':$url = $site.":9696/v2.0/networks";break;
			case 'flavor':$url = $site.":8774/v2/".$tenantID."/flavors";break;
			case 'image':$url = $site.":8774/v2/".$tenantID."/images";break;
			case 'server':$url = $site.":8774/v2/".$tenantID."/servers";break;
			//case 'image':$url = $site.":9292/v2/images";break;
			default:break;
		}		
		$header = array('X-Auth-Token: '.$tokenID);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HTTPGET, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		curl_close($ch);
		//print_r($result);
		//if($resources=="server")print_r($result);
		//if($resources=="keypair")print_r($result);
		//print_r($result);
		return json_decode($result,true);
	}

	function get_image_list($tokenID){
		//$site = "202.120.58.110:9292";
		$site = "192.168.28.1:9292";
		$url = $site."/v2/images";
		$header = array('X-Auth-Token: '.$tokenID);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		//curl_setopt($ch, CURLOPT_GET, 1);
		curl_setopt($ch, CURLOPT_HTTPGET, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		curl_close($ch);
		return json_decode($result,true);
	}
	function create_server($tokenID,$tenantID,$name,$imageRef,$key,$flavorRef,$network){
		echo "this is create_server";
		echo $network;
		echo "<br>";
		echo "flavorRef=";
		echo $flavorRef;
		//$site = "202.120.58.110:8774";
		$site = "192.168.28.1:8774";
		$url = $site.'/v2/'.$tenantID.'/servers';
		$header = array('X-Auth-Token: '.$tokenID,'Content-type: application/json');
		$server = array('name'=>$name,'network'=>$network,'imageRef'=>$imageRef,'key_name'=>$key,'flavorRef'=>$flavorRef,'max_count'=>1,'min_count'=>1);
		$data = array('server'=>$server);
		$data_json = json_encode($data);
		echo "<br>";
		echo "<br>";
		echo "<br>";
		print_r($data_json);
		echo "<br>";
		echo "<br>";
		echo "<br>";

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		//curl_setopt($ch, CURLOPT_GET, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		//curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);//POST数据
		$result = curl_exec($ch);
		curl_close($ch);
		return json_decode($result,true);
	}
	function get_vm_console($serverID,$tenantID,$serverID){
		//$site="202.120.58.110:8774";
		$site="192.168.28.1:8774";

		$url= $site."/v2/​".$tenantID."/servers/​".$serverID."/action";
		echo "this is get_vn_console";



		$header = array('X-Auth-Token: '.$tokenID,'Content-type: application/json');
		$server = array('name'=>$name,'network'=>$network,'imageRef'=>$imageRef,'key_name'=>$key,'flavorRef'=>$flavorRef,'max_count'=>1,'min_count'=>1);
		$data = array('server'=>$server);
		$data_json = json_encode($data);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		//curl_setopt($ch, CURLOPT_GET, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		//curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);//POST数据
		$result = curl_exec($ch);
		curl_close($ch);
		return json_decode($result,true);
	}
}
?>