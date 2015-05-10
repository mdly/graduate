<?php //if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class ImageCrud extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->load->database();
	}
	function creat_image($data){
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
}
?>