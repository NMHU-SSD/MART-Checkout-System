<?php
class Student_Model extends CI_Model {

  function __construct() {
    parent::__construct();
  }

  public function get_students() {
    $query = $this->db->get("students");
    return $query->result();
  }

  public function get_student($banner_id) {
    $query = $this->db->get_where('students',array("banner_id"=>$banner_id));
    $results = $query->result();
    if ($results != null){
      return $results[0];
    } else {
      return false;
    }
  }

  public function insert($data) {
    if ($this->db->insert("students", $data)) {
      return true;
    }
  }

  public function delete($banner_id) {
    return $this->db->delete("students", "banner_id = ".$banner_id);
  }

  public function update($data, $old_banner_id) {
    $this->db->where("banner_id", $old_banner_id);
    $this->db->update("students", $data);
  }

  public function hide($banner_id){
    $this->db->where('banner_id', $banner_id);
    $this->db->update('students', array('isDeleted' => TRUE));
    return true;
  }

  public function check_eligibility($banner_id){
    $query = $this->db->get_where("students", array("banner_id"=>$banner_id));
    $results = $query->result();
    return $results[0]->eligibility;
  }

}
?>
