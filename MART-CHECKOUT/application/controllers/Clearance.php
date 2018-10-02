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
  }

  public function index(){
    $this->load->view('templates/header');
    //get nav based on role
    $nav_items = $this->User_Model->get_navigation($_SESSION['user_role']);
    $this->load->view('templates/navigation', $nav_items);
    $data['records'] = $this->Clearance_Model->get_clearance();
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
    $this->form_validation->set_rules('barcode','barcode', 'trim|required');
    $this->form_validation->set_rules('clearance','clearance', 'required');

    if($this->form_validation->run() == false){
      echo validation_errors();
      $this->load->view('templates/header');
      $nav_items = $this->User_Model->get_navigation($_SESSION['user_role']);
      $this->load->view('templates/navigation',$nav_items);
      $this->load->view('clearance/Clearance_add_view');
      $this->load->view('templates/footer');
    }else{
      $data = array(
        'level' => $this->input->post('clearance'),
        'barcode' => $this->input->post('barcode'),
        'description' => $this->input->post('description'),
        'class' => $this->input->post('class')
      );
      $this->Clearance_Model->insert_clearance($data, TRUE);
      redirect('clearance');
    }
  }

  public function edit($id){
    $this->load->view('templates/header');
    $nav_items = $this->User_Model->get_navigation($_SESSION['user_role']);
    $this->load->view('templates/navigation',$nav_items);
    $data['records'] = $this->Clearance_Model->get_clearance_item($id);
    $this->load->view('clearance/clearance_edit_view', $data);
    $this->load->view('templates/footer');
  }

  public function update($id) {

    $this->form_validation->set_rules('clearance','clearance', 'required');
    $this->form_validation->set_rules('barcode','barcode', 'trim|required');
    $this->form_validation->set_rules('description','description', 'required');


    if($this->form_validation->run() == false){
      echo validation_errors();
      $this->load->view('templates/header');
      $nav_items = $this->User_Model->get_navigation($_SESSION['user_role']);
      $this->load->view('templates/navigation',$nav_items);

      $post_vars = array(
        'id' => $this->input->post($id),
        'level' => $this->input->post('clearance'),
        'barcode' => $this->input->post('barcode'),
        'description' => $this->input->post('description'),
        'class' => $this->input->post('class'),
      );

      $objects = new ArrayObject($post_vars);
      $objects->setFlags(ArrayObject::STD_PROP_LIST|ArrayObject::ARRAY_AS_PROPS);
      $data['records'] = $objects;

      $this->load->view('clearance/clearance_edit_view', $data);
      $this->load->view('templates/footer');

    }else{
      $data = array(
        'level' => $this->input->post('clearance'),
        'barcode' => $this->input->post('barcode'),
        'description' => $this->input->post('description'),
        'class' => $this->input->post('class'),
      );

      $id = $this->input->post('old_id');
      $this->Clearance_Model->update_clearance($data, $id,TRUE);

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
}
