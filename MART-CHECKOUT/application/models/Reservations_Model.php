<?php
class Reservations_Model extends CI_Model {

  function __construct() {
    parent::__construct();
  }

  public function get_reservations() {
    $query = $this->db->get("reservations");
    $results = $query->result();

    return $results;
  }

  public function get_reservation($id) {
    $query = $this->db->get_where("reservations",array("id"=>$id));
    $results = $query->result();
    return $results[0];
  }

  public function insert($data) {
    if ($this->db->insert("reservations", $data)) {
      return true;
    }
  }

  public function delete($id) {
    return $this->db->delete("reservations", "id = ".$id);
  }

  public function update($data, $id) {
    $this->db->where("id", $id);
    $this->db->update("reservations", $id);
  }

  public function hide($id){
    $this->db->where('id', $id);
    $this->db->update('reservations', array('is_deleted' => TRUE));
    return true;
  }

}

?>
