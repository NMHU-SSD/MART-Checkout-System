<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

  public function __construct(){
    parent::__construct();

    $this->load->helper('form');
    $this->load->library('form_validation');
    $this->load->library('session');
    $this->load->helper('url');
    $this->load->database();
    $this->load->model('User_Model');
  }

  public function index()
  {
    if(isset($_SESSION['logged_in'])){

      //welcome message
      $this->session->set_flashdata('message', '<div class="alert alert-success text-center">Welcome '.$_SESSION['user_name'].'</div>');

      redirect('dashboard');

    } else {
      $this->load->view('templates/header');
      $this->load->view('login_view');
      $this->load->view('templates/footer');
    }
  }

  public function verify(){

    $this->form_validation->set_rules('form_id','banner id', 'required|numeric|trim');
    // $this->form_validation->set_rules('form_password','banner password', 'numeric|trim');

    if ($this->form_validation->run() == false){
      $this->load->view('header');
      $this->load->view('login_view');
      $this->load->view('footer');
    }else{

      $banner_id= $this->input->post('form_id');
      $banner_password = $this->input->post('form_password');

      if($this->User_Model->login_user($banner_id, $banner_password)){

        $userdata = $this->User_Model->login_user($banner_id, $banner_password);
        $this->session->set_userdata($userdata);

        redirect();

      } else {
        $this->session->set_flashdata('message', '<div class="alert alert-danger text-center">Login Failed!! Please try again.</div>');

        redirect();
      }
    }
  }
}
