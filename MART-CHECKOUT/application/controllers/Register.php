<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {
  public function __construct(){
    parent::__construct();

    $this->load->helper('form');
    $this->load->library('form_validation');
    $this->load->library('session');
    $this->load->helper('url');
    $this->load->database();
    $this->load->model('User_Model');

    if ($_SESSION['user_role'] != 'Admin' || !$_SESSION['user_role'] != 'Manager'){
      redirect('dashboard');
    }

  }

  public function index(){
    $this->load->view('header');
    $data['roles'] = $this->User_Model->getRoles(); //get enum privilege options for users
    $this->load->view('register_view', $data);
    $this->load->view('footer');
  }

  public function register_form(){

    $this->form_validation->set_rules('form_role','role', 'required');
    $this->form_validation->set_rules('form_name','name', 'required');
    $this->form_validation->set_rules('form_id','id', 'trim|required|is_unique[users.role]|numeric');
    //$this->form_validation->set_rules('form_email','email', 'trim|required|valid_email|is_unique[users.email]');
    //$this->form_validation->set_rules('form_password','Password', 'required');
    //$this->form_validation->set_rules('form_confirm_password', 'Password Confirmation', 'trim|required|matches[form_password]');


    if($this->form_validation->run() == false){
      $this->load->view('header');
      $data['roles'] = $this->User_Model->getRoles(); //gets enum privilege options for users
      $this->load->view('register_view', $data);
      $this->load->view('footer');

    }else{
      //set data
      $data = array(
        'banner_id' => $this->input->post('form_id'),
        'name' => $this->input->post('form_name'),
        'role' => $this->input->post('form_role')
        //'email' => $this->input->post('form_email'),
        //'password' => password_hash($this->input->post('form_password'),PASSWORD_BCRYPT),
      );

      //insert into db
      if($this->User_Model->insertUser($data)){
        $this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Successfully Registered. </div>');
      } else {
        $this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Error. Please try again. </div>');
      }
      redirect('register');
    }
  }
}
