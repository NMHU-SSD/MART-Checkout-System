<?php
class Clearance_Model extends CI_Model {

  function __construct() {
    parent::__construct();
  }

  public function get_clearance() {
    //
    $query = $this->db->get("clearance");
    return $query->result();
  }
  public function get_clearance_item($id) {
    // Get clearance at id
    $query = $this->db->get_where("clearance", array("id"=>$id));
    $results = $query->result();
    return $results[0];
  }

  public function get_clearance_row(){
    $this->db->select('level');
    $this->db->from('clearance');

    return $this->db->get()->result();

  }

  public function insert_clearance($data) {
    // Insert Clearance
    if ($this->db->insert("clearance", $data)) {
      return true;
    }
  }

  public function delete_clearance($id) {
    // Delete clearance
    return $this->db->delete("clearance", "id = ".$id);
  }

  public function update_clearance($data, $id) {
    // Update Clearance Level
    $this->db->where("id", $id);
    $this->db->update("clearance", $data);
  }
}
?>
