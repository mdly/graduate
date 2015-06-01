<?php //if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class ImageCrud extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->load->database();
	}
	function get_image_from_os($data){
		$this->db->insert('images',$data);
	}
	function create_image($data){
		//gaigaigai
		$this->db->insert("images",$data);
	}
	function read_image_list(){
		$query = $this->db->select("*")->from("images")->get();
		return $query->result();
	}
	function update_image($data,$ImageID){
		$this->db->update("images",$data)->where("ImageID",$ImageID);
	}
	function delete_image($ImageID){
		$this->db->delete("images")->where("ImageID",$ImageID);
	}
	function count_image(){
		$data=$this->db->select("count(*) AS COUNT")->from("images")->get()->result()[0]->COUNT;
		return $data;
	}

	function read_imageName_by_ID($courseID){
		$imageID = $this->db->select("ImageIDAtk,ImageIDTgt")->from("courses")->where("CourseID",$courseID)->get()->result()[0];
		$attackerID = explode(';',$imageID->ImageIDAtk);
		$attackerName = array();
		for ($i=0; $i <count($attackerID) ; $i++) {
			$attackerName[]= $this->db->select("ImageName")->from("images")->where("ImageId",$attackerID[$i])->get()->result()[0]->ImageName;
		}

		$targetID = explode(';',$imageID->ImageIDTgt);
		$targetName = array();
		for ($i=0; $i <count($targetID) ; $i++) {
			$targetName[]= $this->db->select("ImageName")->from("images")->where("ImageId",$targetID[$i])->get()->result()[0]->ImageName;
		}
		$data = array("ImageNameAtk"=>$attackerName,"ImageNameTgt"=>$targetName);
		return $data;

		//print_r($imageID);
	}
	function read_imageID_by_ID($courseID){
		$imageID = $this->db->select("ImageIDAtk,ImageIDTgt")->from("courses")->where("CourseID",$courseID)->get()->result()[0];
		$attacherID = explode(";", $imageID->ImageIDAtk);
		$targetID = explode(";", $imageID->ImageIDTgt);
		$data = array("ImageIDAtk"=>$attacherID,"ImageIDTgt"=>$targetID);
		return $data;
	}
	function read_imageURL_by_imageID($imageID){
		return $this->db->select("ImageURL")->from("images")->where("ImageID",$imageID)->get()->result()[0]->ImageURL;
	}

	function read_courseImage_list($courseID,$isTarget="-1"){
		//echo "courseID=".$courseID;
		if($isTarget!="-1"){
			$data=$this->db->select("*")->from("courseImage")->where("CourseID",$courseID)->where("isTarget",$isTarget)->get()->result();
		}else{
			$attackerImage = $this->db->select("*")->from("courseImage")->where("CourseID",$courseID)->where("isTarget",0)->get()->result();
			$targetImage = $this->db->select("*")->from("courseImage")->where("CourseID",$courseID)->where("isTarget",1)->get()->result();
			$data = array("attackerImage"=>$attackerImage,"targetImage"=>$targetImage);
		}
		//print_r($data);
		return $data;
	}
	function add_courseImage($isTarget,$courseID,$imageID){
	$data = $this->db->select("*")->from("courseImage")->where("CourseID",$courseID)->where("ImageID",$imageID)->where("isTarget",$isTarget)->get()->result();
		
		if($data){
			print_r($data);
			echo"this image has been add into the course";
		}else{
			$image = $this->db->select("ImageName,ImageURL")->from('images')->where("ImageID",$imageID)->get()->result()[0];
			$imageName = $image->ImageName;
			$imageURL = $image->ImageURL;
			$data = array("ImageID"=>$imageID,"ImageName"=>$imageName,"ImageURL"=>$imageURL,"CourseID"=>$courseID,"isTarget"=>$isTarget);
			$this->db->insert("courseimage",$data);
		}
	}
	function delete_courseImage($isTarget,$courseID,$imageID){
		$this->db->where("isTarget",$isTarget)->where("CourseID",$courseID)->where("ImageID",$imageID)->delete("courseImage");
	}
	function syc_openstack(){
		$this->load->model("openstack");
		$token = $this->openstack->authenticate_v2();
		//print_r($token);
		$images = $this->openstack->get_resources($token['access']['token']['id'],$token['access']['token']['tenant']['id'],'image')['images'];
		//$images = $this->openstack->get_resources($token['access']['token']['id'],$token['access']['token']['tenant']['id'],'image');
		//print_r($images);
		//只有那些已经创建完成的才能被添加到数据库中！
		$this->db->like("ImageID","")->delete('images');
		for ($i=0; $i < count($images); $i++) {
			//if($images[$i]);
			$data = array('ImageID'=>$images[$i]['id'],"ImageName"=>$images[$i]['name'],"ImageURL"=>$images[$i]['links'][0]['href']);
			$this->db->insert('images',$data);
		}	
	}
	

}
?>