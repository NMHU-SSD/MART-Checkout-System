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
    $query = $this->db->get_where('equipment', array("barcode"=>$id));
    $results = $query->result();
    if ($results != null){
      return $results[0];
    } else {
      return false;
    }
  }

  public function insert($data) {
    if ($this->db->insert("equipment", $data)) {
      return true;
    }
  }


  public function delete($barcode) {
    return $this->db->delete("equipment", "barcode = ".$barcode);
  }

  public function update($data, $barcode) {
    $this->db->where("barcode", $barcode);
    $this->db->update("equipment", $data);
  }



  public function check_status($barcode){
    $query = $this->db->get_where("equipment", array("barcode"=>$barcode));
    $results = $query->result();
    return $results[0]->status;
  }

  //get enum status from equipment table
  public function get_status_enum($TYPE){

    if (strtolower($TYPE) == "object"){

      $row = $this->db->query("SHOW COLUMNS FROM equipment LIKE 'status'")->row()->Type;
      $regex = "/'(.*?)'/";
      preg_match_all( $regex , $row, $enum_array );
      $enum_fields = $enum_array[1];
      foreach ($enum_fields as $key=>$value)
      {
          $enums[$value] = $value;
      }
      return $enums;

    }else if (strtolower($TYPE) == "array"){

      $row = $this->db->query("SHOW COLUMNS FROM equipment LIKE 'status'")->row(0)->Type;
      $regex = "/'(.*?)'/";
      preg_match_all( $regex , $row, $enum_array );
      $enum_fields = $enum_array[1];
      foreach ($enum_fields as $key=>$value)
      {
          $enums[$key] = $value;
      }
      return $enums;

    }

  }

  public function updateStatus($barcode, $status){
    $this->db->where('barcode', $barcode);
    $this->db->update('equipment', array('status' => $status));
    return true;
  }

  public function hide($barcode){
    $this->db->where('barcode', $barcode);
    $this->db->update('equipment', array('isDeleted' => TRUE));
    return true;
  }

}
?>
