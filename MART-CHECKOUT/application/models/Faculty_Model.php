<?php
class Faculty_Model extends CI_Model{

  function __construct(){
    parent::__construct();
  }

  //get all faculties
  public function get_all_faculty(){
    $query = $this->db->get('faculty');
    return $query->result();
  }

  //get data from faculties table
  public function get_faculty($banner_id){
    $query = $this->db->get_where('faculty', array('banner_id' => $banner_id));
    $results = $query->result();
    if ($results != null){
      return $results[0];
    } else {
      return false;
    }
  }

  //insert data into faculties table
  public function insert_faculty($data){
    return $this->db->insert('faculty', $data);
  }

  //update data in faculties table
  public function update_faculty($data, $banner_id){
    $this->db->where("banner_id", $banner_id);
    $this->db->update("faculty", $data);
  }

  //delete data from faculties table
  public function delete_faculty($banner_id){
    return $this->db->delete('faculty', "banner_id = ".$banner_id);
  }

  public function hide_faculty($banner_id){
    $this->db->where('banner_id', $banner_id);
    $this->db->update('faculty', array('isDeleted' => TRUE));
    return true;
  }
}

?>
