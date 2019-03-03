<?php
class Clearance_Model extends CI_Model {

  function __construct() {
    parent::__construct();
  }

  public function get_clearance_levels() {
    //get all clearance data
    $query = $this->db->get("clearance");
    return $query->result();
  }

  public function get_clearance_level($id) {
    // Get clearance by id
    $query = $this->db->get_where("clearance", array("id"=>$id));
    $results = $query->result();
    return $results[0];
  }

  public function insert_clearance_level($data) {
    // Insert Clearance
    if ($this->db->insert("clearance", $data)) {
      return true;
    }
  }

  public function delete_clearance_level($id) {
    // Delete clearance
    return $this->db->delete("clearance", "id = ".$id);
  }

  public function update_clearance_level($data, $id) {
    // Update Clearance Level
    $this->db->where("id", $id);
    $this->db->update("clearance", $data);
  }



}
?>
