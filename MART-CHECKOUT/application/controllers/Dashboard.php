<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller{

  public function __construct(){
    parent::__construct();

    $this->load->library('session');
    $this->load->helper('form');
    $this->load->library('form_validation');
    $this->load->helper('url');
    $this->load->database();
    $this->load->model('User_Model');

  }

  public function index(){

    if(isset($_SESSION['logged_in'])){

      $this->load->view('templates/header');

      //get nav based on role
      $nav_items = $this->User_Model->get_navigation($_SESSION['user_role']);
      $this->load->view('templates/navigation', $nav_items);

      $this->load->view('dashboard_view');

      $this->load->view('templates/footer');

    }else{
      redirect('login');
    }

  }


  public function logout(){

    if($this->session->has_userdata('user_id')){

      $userdata = $this->session->all_userdata();
      foreach($userdata as $key => $value) {
        $this->session->unset_userdata($key); //clears session vars
      }
      $this->session->sess_destroy(); //destroys session flie

      redirect('login');
    }
  }

}
