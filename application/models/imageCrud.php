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

	function add_attacker_image($courseID,$imageID){
		$ImageName = $this->db->select("ImageName")->from("images")->where("ImageID",$imageID)->get()->result()[0]->ImageName;
		$this->db->insert("attackerimage",array('CourseID'=>$courseID,'ImageID'=>$imageID,'ImageName'=>$ImageName));
	}
	function get_attacker_image($courseID){
		return $this->db->select("*")->from("attackerimage")->where("CourseID",$courseID)->get()->result();
	}
	function delete_attacker_image($courseID,$imageID){
		$this->db->where("CourseID",$courseID)->where("ImageID",$imageID)->delete("attackerimage");
	}


	function add_target_image($courseID,$imageID){
		$ImageName = $this->db->select("ImageName")->from("images")->where("ImageID",$imageID)->get()->result()[0]->ImageName;
		$this->db->insert("targetimage",array('CourseID'=>$courseID,'ImageID'=>$imageID,'ImageName'=>$ImageName));
	}
	function get_target_image($courseID){
		return $this->db->select("*")->from("targetimage")->where("CourseID",$courseID)->get()->result();
	}
	function delete_target_image($courseID,$imageID){
		$this->db->where("CourseID",$courseID)->where("ImageID",$imageID)->delete("targetimage");
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
}
?>