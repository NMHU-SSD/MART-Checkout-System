<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employees extends CI_Controller {

  public function __construct(){
    parent::__construct();

    $this->load->helper('form');
    $this->load->library('form_validation');
    $this->load->library('session');
    $this->load->helper('url');
    $this->load->database();
    $this->load->model('User_Model');

    if(!isset($_SESSION['logged_in'])){
      redirect('login');
    }

    if($_SESSION['user_role'] != 'Manager'){
      redirect('dashboard');
    }

  }

  //default view displays all employees
  public function index(){

    $this->load->view('templates/header');

    //create nav based on role
    $nav_items = $this->User_Model->get_navigation($_SESSION['user_role']);
    $this->load->view('templates/navigation', $nav_items);

    //get all users	data
    $data['employees'] = $this->User_Model->get_users();
    $this->load->view('employees/employees_view', $data);

    $this->load->view('templates/footer');
  }

  //displays form for new user
  public function new(){

    $this->load->view('templates/header');

    //create nav based on role
    $nav_items = $this->User_Model->get_navigation($_SESSION['user_role']);
    $this->load->view('templates/navigation', $nav_items);

    //get enum roles for dropdown
    $data['roles'] = $this->User_Model->get_roles();
    $this->load->view('employees/employees_register_view', $data);

    $this->load->view('templates/footer');
  }

  //validates and inserts new user
  public function register(){

    $this->form_validation->set_rules('form_role','role', 'required');
    $this->form_validation->set_rules('form_name','name', 'required');
    $this->form_validation->set_rules('form_id','banner id', 'trim|required|is_unique[users.banner_id]|numeric');
    $this->form_validation->set_rules('form_password', 'Password');
    // $this->form_validation->set_rules('form_confirm_password', 'Password Comformation', 'trim|required|matches[form_password]');


    if($this->form_validation->run() == false){

      $this->load->view('templates/header');

      //create nav based on role
      $nav_items = $this->User_Model->get_navigation($_SESSION['user_role']);
      $this->load->view('templates/navigation', $nav_items);

      //get enum roles for dropdown
      $data['roles'] = $this->User_Model->get_roles(); //gets enum privilege options for users
      $this->load->view('employees/employees_register_view', $data);

      $this->load->view('templates/footer');

    }else{
      $pass = $this->input->post('form_password');
      if($pass ==''){
        $pass = 'default';
      }
      //set data
      $data = array(
        'banner_id' => $this->input->post('form_id'),
        'name' => $this->input->post('form_name'),
        'role' => $this->input->post('form_role'),
        'password' => password_hash($pass, PASSWORD_BCRYPT)
      );

      //insert into db
      if($this->User_Model->insert_user($data)){
        $this->session->set_flashdata('message', '<div class="alert alert-success text-center">Successfully Registered. </div>');
      } else {
        $this->session->set_flashdata('message', '<div class="alert alert-danger text-center">Error. Please try again. </div>');
      }

      redirect('employees', 'refresh');
    }

  }

  //displays update form for user
  public function edit($id){

    $this->load->view('templates/header');
    //create nav based on role
    $nav_items = $this->User_Model->get_navigation($_SESSION['user_role']);
    $this->load->view('templates/navigation', $nav_items);
    //get enum roles for dropdown
    $data['roles'] = $this->User_Model->get_roles();
    //get user data
    $data['employee'] = $this->User_Model->get_user($id);
    $this->load->view('employees/employees_edit_view', $data);
    $this->load->view('templates/footer');
  }

  //validates and updates user
  public function update($id){

    $this->form_validation->set_rules('form_role','role', 'required');
    $this->form_validation->set_rules('form_name','name', 'required');
    $this->form_validation->set_rules('form_id','banner id', 'trim|numeric');

    if($this->form_validation->run() == false){

      $this->load->view('templates/header');
      //create nav based on role
      $nav_items = $this->User_Model->get_navigation($_SESSION['user_role']);
      $this->load->view('templates/navigation', $nav_items);
      //get enum roles for dropdown
      $data['roles'] = $this->User_Model->get_roles();
      //get user data
      //$data['employee'] = $this->User_Model->get_users($id);

      $data['employee'] = array(
        'banner_id' => $this->input->post('form_id'),
        'name' => $this->input->post('form_name'),
        'role' => $this->input->post('form_role')
      );
      $this->load->view('employees/employees_edit_view', $data);
      $this->load->view('templates/footer');

    }else{

      //set data
      $data = array(
        'banner_id' => $this->input->post('form_id'),
        'name' => $this->input->post('form_name'),
        'role' => $this->input->post('form_role')
      );

      //update db
      if($this->User_Model->update_user($data)){
        $this->session->set_flashdata('message', '<div class="alert alert-success text-center">Successfully Updated. </div>');
      } else {
        $this->session->set_flashdata('message', '<div class="alert alert-danger text-center">Error. Please try again. </div>');
      }
      redirect('employees', 'refresh');
    }

  }

  //password_reset for user
  public function password($id){

    $this->load->view('templates/header');
    $nav_items = $this->User_Model->get_navigation($_SESSION['user_role']);
    $this->load->view('templates/navigation', $nav_items);
    $data['roles'] = $this->User_Model->get_roles();
    $data['employee'] = $this->User_Model->get_user($id);

    if($_SESSION['user_role'] == 'Manager'){
      $this->load->view('employees/employees_reset_password', $data);
    }else{
      $data['employees'] = $this->User_Model->get_users();
      $this->load->view('employees/employees_view', $data);
    }
    $this->load->view('templates/footer');
  }


  public function reset_password($id){
    //Get banner_id for db compairison
    $this->form_validation->set_rules('form_id','banner id', 'trim|required');
    $this->form_validation->set_rules('form_password', 'Password', 'trim|required|matches[form_re-enter_password]');
    $this->form_validation->set_rules('form_re-enter_password', 'Password Comformation', 'trim|required|matches[form_password]');

    //Reload form with error displayed
    if($this->form_validation->run() == false){

      $this->load->view('templates/header');
      $nav_items = $this->User_Model->get_navigation($_SESSION['user_role']);
      $this->load->view('templates/navigation', $nav_items);
      $data['roles'] = $this->User_Model->get_roles();
      $data['employee'] = $this->User_Model->get_user($id);

      if($_SESSION['user_role'] == 'Manager' || $_SESSION['user_role'] == 'Admin'){
        $this->load->view('employees/employees_reset_password', $data);
      }else{
        $data['employees'] = $this->User_Model->get_users();
        $this->load->view('employees/employees_view', $data);
      }
      $this->load->view('templates/footer');

      // $this->session->set_flashdata('message', '<div class="alert alert-danger text-center">Field Where empty. </div>');
    }else{
      $banner_id= $this->input->post('form_id');
      $banner_password = password_hash($this->input->post('form_password'), PASSWORD_BCRYPT);

      //insert into db
      if($this->User_Model->password_reset($banner_id, $banner_password)){
        $this->session->set_flashdata('message', '<div class="alert alert-success text-center">Successfully Changed Password. </div>');
      } else {
        $this->session->set_flashdata('message', '<div class="alert alert-danger text-center">Error. Please try again. </div>');
      }
      redirect('employees', 'refresh');
    }
  }

  //deletes user
  public function delete($id){
    //get user data
    $data = $this->User_Model->get_user($id);

    //delete user from db
    if($this->User_Model->delete_user($data)){
      $this->session->set_flashdata('message', '<div class="alert alert-success text-center">Successfully Deleted. </div>');
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger text-center">Error. Please try again. </div>');
    }
    redirect('employees', 'refresh');

  }


}
