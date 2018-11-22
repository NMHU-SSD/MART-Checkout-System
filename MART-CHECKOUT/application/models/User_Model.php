<?php
class User_Model extends CI_Model{

  function __construct(){
    parent::__construct();
    $this->load->library('session');
    $this->load->database();
  }

  //get all users
  public function get_users(){
    $query = $this->db->get('users');
    return $query->result_array();
  }

  //get data from users table
  public function get_user($banner_id){
    $query = $this->db->get_where('users', array('banner_id' => $banner_id));
    return $query->row_array();
  }

  //get data from users table
  public function get_user_name($banner_id){
    $query = $this->db->get_where('users', array('banner_id' => $banner_id));
    $result = $query->row_array();
    return $result['name'];
  }

  //insert data into users table
  public function insert_user($data){
    return $this->db->insert('users', $data);
  }

  //update data in users table
  public function update_user($data){
    return $this->db->replace('users', $data);
  }

  //delete data from users table
  public function delete_user($data){
    return $this->db->delete('users', $data);

  }

  //login user
  public function login_user($banner_id, $banner_password){

    $query = $this->db->get_where('users', array('banner_id' => $banner_id));
    if($query->num_rows() == 1){
      $userArray = array();
      foreach($query->result_array() as $row){
        $userArray[0] = $row['name'];
        $userArray[1] = $row['role'];
        $hashed_pwd = $row['password'];
      }

      //if role is a manager or assistant we need a password
      //If you want students to login delete /* */ below
      if($userArray[1] == 'Manager' || $userArray[1] == 'Assistant'  || $userArray[1] == 'Admin' ){
        if(password_verify($banner_password, $hashed_pwd)){
          $userData = array(
            'user_id' => $banner_id,
            'user_name' => $userArray[0],
            'user_role' => $userArray[1],
            'logged_in'=> TRUE
          );
          return $userData;
        }
      }
      else if($userArray[1] == 'Student Employee'){//if role is student log them in
        $userData = array(
          'user_id' => $banner_id,
          'user_name' => $userArray[0],
          'user_role' => $userArray[1],
          'logged_in'=> TRUE
        );
        return $userData;
      }else{
        return false;
      }
    }else{
      return false;
    }
  }

  //get enum roles from users table
  public function get_roles(){

    $row = $this->db->query("SHOW COLUMNS FROM users LIKE 'role'")->row()->Type;
    $regex = "/'(.*?)'/";
    preg_match_all( $regex , $row, $enum_array );
    $enum_fields = $enum_array[1];
    foreach ($enum_fields as $key=>$value)
    {
      $enums[$value] = $value;
    }
    return $enums;
  }

  //get navigation based on current user role
  public function get_navigation($role){

    // "link name"=>"controller"
    if ($role == "Manager" || $role == "Admin"){

      $nav_items['nav_items'] = array(
        'Employees'=>'employees',
        'Students'=>'students',
        'Clearance'=>'clearance',
        'Equipment' => 'equipment',
        'Reservations' => 'reservations',
        'Faculty' => 'faculty'
      );
    } else if ($role == "Assistant") {
      $nav_items['nav_items'] = array(
        'Students'=>'students',
        'Clearance'=>'clearance',
        'Equipment' => 'equipment',
        'Reservations' => 'reservations',
        'Faculty' => 'faculty'
      );
    } else if ($role == "Student Employee") {
      $nav_items['nav_items'] = array(
        'Equipment' => 'equipment',
        'Reservations' => 'reservations'
      );
    }
    return $nav_items;
  }


  public function password_reset($banner_id, $banner_password){
    //"update 'users' set password=$banner_password where banner_id=$banner_id"
    $this->db->where('banner_id', $banner_id);
    $this->db->update('users', array('password' => $banner_password));
    return true;
  }
}

?>
