<?php
class Equipment_Model extends CI_Model {

  function __construct() {
    parent::__construct();
  }

  public function get_equipment() {
    $query = $this->db->get("equipment");
    return $query->result();
  }

  public function get_equipment_item($id) {
    $query = $this->db->get_where("equipment", array("barcode"=>$id));
    $results = $query->result();
    return $results[0];
  }

  public function insert($data) {
    if ($this->db->insert("equipment", $data)) {
      return true;
    }
  }

  public function delete($barcode) {
    return $this->db->delete("equipment", "barcode = ".$barcode);
  }

  public function update($data, $old_barcode) {
    $this->db->where("barcode", $old_barcode);
    $this->db->update("equipment", $data);
  }

  public function updateStatus($barcode){
    $this->db->where('barcode', $barcode);
    $this->db->update('equipment', array('status' => 'reserved'));
    return true;
  }

  public function updateStatusfromRes($barcode){
    $this->db->where('barcode', $barcode);
    $this->db->update('equipment', array('status' => 'available for checkout'));
    return true;
  }

  public function hide($barcode){
    $this->db->where('barcode', $barcode);
    $this->db->update('equipment', array('isDeleted' => TRUE));
    return true;
  }
}
?>
