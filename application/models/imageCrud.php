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
}
?>