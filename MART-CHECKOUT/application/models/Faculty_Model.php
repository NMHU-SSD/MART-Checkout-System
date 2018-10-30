<?php
class Faculty_Model extends CI_Model{

  function __construct(){
    parent::__construct();
  }

  //get all faculties
  public function get_faculties(){
    $query = $this->db->get('faculties');
    return $query->result();
  }

  //get data from faculties table
  public function get_faculty($banner_id){
    $query = $this->db->get_where('faculties', array('banner_id' => $banner_id));
    $results = $query->result();
    return $results[0];
  }

  //insert data into faculties table
  public function insert_faculty($data){
    return $this->db->insert('faculties', $data);
  }

  //update data in faculties table
  public function update_faculty($data, $old_banner_id){
    $this->db->where("banner_id", $old_banner_id);
    $this->db->update("faculties", $data);
  }

  //delete data from faculties table
  public function delete_faculty($banner_id){
    return $this->db->delete('faculties', "banner_id = ".$banner_id);
  }
}

?>
