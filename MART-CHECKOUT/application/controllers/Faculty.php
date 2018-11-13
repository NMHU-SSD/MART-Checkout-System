<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faculty extends CI_Controller {

  function __construct(){
    parent::__construct();
    $this->load->helper('url');
    $this->load->library('session');
    $this->load->helper('form');
    $this->load->library('form_validation');
    $this->load->database();
    $this->load->model('User_Model');
    $this->load->model('Faculty_Model');
    $this->load->model('Clearance_Model');

    if(!isset($_SESSION['logged_in'])){
      redirect('login');
    }

    if($_SESSION['user_role'] != 'Manager'){
      redirect('dashboard');
    }
  }

  public function index() {
    $this->load->view('templates/header');
    $nav_items = $this->User_Model->get_navigation($_SESSION['user_role']);
    $this->load->view('templates/navigation',$nav_items);
    $data['faculties'] = $this->Faculty_Model->get_faculties();
    $data['clearance'] = $this->Clearance_Model->get_clearance();
    $this->load->view('faculty/faculty_view',$data);
    $this->load->view('templates/footer');
  }

  //displays form for new user
  public function new(){
    $this->load->view('templates/header');
    $nav_items = $this->User_Model->get_navigation($_SESSION['user_role']);
    $this->load->view('templates/navigation',$nav_items);
    $data['clearance'] = $this->Clearance_Model->get_clearance();
    $this->load->view('faculty/faculty_add_view', $data);
    $this->load->view('templates/footer');
  }

  public function add() {
    $this->form_validation->set_rules('email','email', 'required|valid_email');
    $this->form_validation->set_rules('name','name', 'required');
    $this->form_validation->set_rules('banner_id','banner id', 'trim|required|is_unique[students.banner_id]|numeric');
    $this->form_validation->set_rules('phone', 'phone number', 'required');

    if($this->form_validation->run() == false){

      $this->load->view('templates/header');
      $nav_items = $this->User_Model->get_navigation($_SESSION['user_role']);
      $this->load->view('templates/navigation',$nav_items);
      $this->load->view('faculty/faculty_add_view');
      $this->load->view('templates/footer');

    }else{
      $data = array(
        'banner_id' => $this->input->post('banner_id'),
        'name' => $this->input->post('name'),
        'email' => $this->input->post('email'),
        'phone' => $this->input->post('phone'),
        'clearance_level' => $this->input->post('clearance_level'),
        'amount_owed' => $this->input->post('amount_owed'),
        'enrollment' => $this->input->post('active'),
        'eligibility' => $this->input->post('eligible')
      );

      $this->Faculty_Model->insert_faculty($data, TRUE);

      redirect('faculty');
    }
  }

  public function edit($id){
    $this->load->view('templates/header');
    $nav_items = $this->User_Model->get_navigation($_SESSION['user_role']);
    $this->load->view('templates/navigation',$nav_items);
    $data['records'] = $this->Faculty_Model->get_faculty($id);
    $this->load->view('faculty/faculty_edit_view',$data);
    $this->load->view('templates/footer');
  }

  public function update($id) {

    $this->form_validation->set_rules('email','email', 'required|valid_email');
    $this->form_validation->set_rules('name','name', 'required');
    $this->form_validation->set_rules('banner_id','banner id', 'trim|required|numeric');
    $this->form_validation->set_rules('phone', 'phone number', 'required');


    if($this->form_validation->run() == false){
      $this->load->view('templates/header');
      $nav_items = $this->User_Model->get_navigation($_SESSION['user_role']);
      $this->load->view('templates/navigation',$nav_items);

      $post_vars = array(
        'banner_id' => $this->input->post('banner_id'),
        'name' => $this->input->post('name'),
        'email' => $this->input->post('email'),
        'phone' => $this->input->post('phone'),
        'clearance_level' => $this->input->post('clearance_level'),
        'amount_owed' => $this->input->post('amount_owed'),
        'enrollment' => $this->input->post('active'),
        'eligibility' => $this->input->post('eligible')
      );

      $object = new ArrayObject($post_vars);
      $object -> setFlags( ArrayObject::STD_PROP_LIST|ArrayObject::ARRAY_AS_PROPS);

      $data['records'] = $object;

      $this->load->view('faculty/faculty_edit_view', $data);
      $this->load->view('templates/footer');

    } else {

      $data = array(
        'banner_id' => $this->input->post('banner_id'),
        'name' => $this->input->post('name'),
        'email' => $this->input->post('email'),
        'phone' => $this->input->post('phone'),
        'clearance_level' => $this->input->post('clearance_level'),
        'amount_owed' => $this->input->post('amount_owed'),
        'enrollment' => $this->input->post('active'),
        'eligibility' => $this->input->post('eligible')
      );

      $this->Faculty_Model->update_faculty($data, $id, TRUE);

      redirect('faculty');
    }
  }

  public function delete($id) {
    if( $this->Faculty_Model->delete_faculty($id)){
      $this->session->set_flashdata('message', '<div class="alert alert-success text-center">Successfully Deleted. </div>');
    } else{
      $this->session->set_flashdata('message', '<div class="alert alert-danger text-center">Error. Please try again. </div>');
    }
    redirect('faculty');
  }
}
