<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clearance extends CI_Controller{

  public function __construct(){
    parent::__construct();
    $this->load->library('session');
    $this->load->helper('form');
    $this->load->library('form_validation');
    $this->load->helper('url');
    $this->load->database();
    $this->load->model('User_Model');
    $this->load->model('Clearance_Model');

    if(!isset($_SESSION['logged_in'])){
      redirect('login');
    }

//only loads for admin and manager roles
    if ( $_SESSION['user_role'] == 'Assistant' || $_SESSION['user_role'] == 'Student Employee' ){
      redirect('dashboard');
    }

  }

  public function index(){
    $this->load->view('templates/header');
    //get nav based on role
    $nav_items = $this->User_Model->get_navigation($_SESSION['user_role']);
    $this->load->view('templates/navigation', $nav_items);
    $data['records'] = $this->Clearance_Model->get_clearance_levels();
    $this->load->view('clearance/clearance_view', $data);
    $this->load->view('templates/footer');

  }

  public function new() {
    $this->load->view('templates/header');
    $nav_items = $this->User_Model->get_navigation($_SESSION['user_role']);
    $this->load->view('templates/navigation',$nav_items);
    $this->load->view('clearance/clearance_add_view');
    $this->load->view('templates/footer');
  }

  public function add(){
    $this->form_validation->set_rules('clearance_name','clearance name', 'required');

    if($this->form_validation->run() == false){
      echo validation_errors();
      $this->load->view('templates/header');
      $nav_items = $this->User_Model->get_navigation($_SESSION['user_role']);
      $this->load->view('templates/navigation',$nav_items);
      $this->load->view('clearance/Clearance_add_view');
      $this->load->view('templates/footer');
    }else{
      $data = array(
        'name' => $this->input->post('clearance_name'),
        'description' => $this->input->post('clearance_description'),
        'courses' => $this->input->post('clearance_courses')
      );
      $this->Clearance_Model->insert_clearance_level($data, TRUE);
      redirect('clearance');
    }
  }

  public function edit($id){
    $this->load->view('templates/header');
    $nav_items = $this->User_Model->get_navigation($_SESSION['user_role']);
    $this->load->view('templates/navigation',$nav_items);
    $data['records'] = $this->Clearance_Model->get_clearance_level($id);
    $this->load->view('clearance/clearance_edit_view', $data);
    $this->load->view('templates/footer');
  }

  public function update($id) {

    $this->form_validation->set_rules('clearance_name','clearance name', 'required');

    if($this->form_validation->run() == false){
      echo validation_errors();
      $this->load->view('templates/header');
      $nav_items = $this->User_Model->get_navigation($_SESSION['user_role']);
      $this->load->view('templates/navigation',$nav_items);

      $post_vars = array(
        'id' => $this->input->post($id),
        'name' => $this->input->post('clearance_name'),
        'description' => $this->input->post('clearance_description'),
        'courses' => $this->input->post('clearance_courses'),
      );

      $objects = new ArrayObject($post_vars);
      $objects->setFlags(ArrayObject::STD_PROP_LIST|ArrayObject::ARRAY_AS_PROPS);
      $data['records'] = $objects;

      $this->load->view('clearance/clearance_edit_view', $data);
      $this->load->view('templates/footer');

    }else{
      $data = array(
        'name' => $this->input->post('clearance_name'),
        'description' => $this->input->post('clearance_description'),
        'courses' => $this->input->post('clearance_courses'),
      );

      $id = $this->input->post('old_id');
      $this->Clearance_Model->update_clearance_level($data, $id,TRUE);

      redirect('clearance');
    }
  }

  public function delete($id) {

		if( $this->Clearance_Model->delete_clearance($id)){
			$this->session->set_flashdata('message', '<div class="alert alert-success text-center">Successfully Deleted. </div>');
		} else {
			$this->session->set_flashdata('message', '<div class="alert alert-danger text-center">Error. Please try again. </div>');
		}
		redirect('clearance');
	}

  public function hide($id){
    if( $this->Clearance_Model->hide_clearance($id)){
      $this->session->set_flashdata('message', '<div class="alert alert-success text-center">Successfully Deleted. </div>');
    } else{
      $this->session->set_flashdata('message', '<div class="alert alert-danger text-center">Error. Please try again. </div>');
    }
    redirect('clearance');
  }
}
