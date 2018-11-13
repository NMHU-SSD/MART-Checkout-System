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
    $query = $this->db->get_where("reservations",array("barcode"=>$id));
    $results = $query->result();
    return $results[0];
  }

  public function insert($data) {
    if ($this->db->insert("reservations", $data)) {
      return true;
    }
  }

  public function delete($barcode) {
    return $this->db->delete("reservations", "barcode = ".$barcode);
  }

  public function update($data, $old_barcode) {
    $this->db->where("barcode", $old_barcode);
    $this->db->update("reservations", $data);
  }

  public function hide($barcode){
    $this->db->where('barcode', $barcode);
    $this->db->update('reservations', array('isDeleted' => TRUE));
    return true;
  }
}
?>
