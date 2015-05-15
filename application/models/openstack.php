<?php
class Openstack extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	function authenticate_v2($userName,$password){
		//echo "userName=".$userName;
		//echo "password=".$password;
		$passwordCredentials = array('username'=>$userName,'password'=>$password);
		$data = array('auth'=>array('tenantName'=>'symol','passwordCredentials'=>$passwordCredentials));
		$data_json = json_encode($data);
		$header = array('Content-type: application/json');
		$site = "202.120.58.110:5000";
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
		$site = "202.120.58.110";
		//echo $tenantID;
		switch ($resources) {
			case 'network':$url = $site.":9696/v2.0/networks";break;
			case 'flavor':$url = $site.":8774/v2/".$tenantID."/flavors";break;
			//8774/v2/tenant_id/flavors
			//case 'flavor':$url = $site.":8774/v2/".$tenantID."​/flavors/detail";break;
			//case 'flavor':$url = $site.":8774/v2/".$tenantID."​/flavors";break;
			//case 'flavor':$url =$site.":8774/v2.1/flavors/os-flavor-rxtx/detail";break;
			//case'flavor':$url = $site.':8774/v2.1/flavors';break;
			case 'image':$url = $site.":9292/v2/images";break;
			default:break;
		}		
		$header = array('X-Auth-Token: '.$tokenID);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		//curl_setopt($ch, CURLOPT_GET, 1);
		curl_setopt($ch, CURLOPT_HTTPGET, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		//curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		curl_close($ch);
		print_r($result);
		return json_decode($result,true);
	}

	function get_image_list($tokenID){
		$site = "202.120.58.110:9292";
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
	function get_network_list($tokenID){
		$site = "202.120.58.110:9696";
		$url = $site."/v2.0/networks";
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
}
?>