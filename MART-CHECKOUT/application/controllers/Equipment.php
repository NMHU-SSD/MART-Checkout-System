<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Equipment extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->database();
		$this->load->model('User_Model');
		$this->load->model('Equipment_Model');
		$this->load->model('Clearance_Model');

		if(!isset($_SESSION['logged_in'])){
			redirect('login');
		}
	}

	public function index() {
		$this->load->view('templates/header');
		$nav_items = $this->User_Model->get_navigation($_SESSION['user_role']);
		$this->load->view('templates/navigation', $nav_items);
		$data['records'] = $this->Equipment_Model->get_equipment();
		$data['clearance'] = $this->Clearance_Model->get_clearance();
		$this->load->view('equipment/Equipment_view', $data);
		$this->load->view('templates/footer');
	}

	public function new() {
		$this->load->view('templates/header');
		$nav_items = $this->User_Model->get_navigation($_SESSION['user_role']);
		$this->load->view('templates/navigation',$nav_items);
		$data['clearance'] = $this->Clearance_Model->get_clearance();
		$this->load->view('equipment/Equipment_add_view', $data);
		$this->load->view('templates/footer');
	}



	public function add() {
		$this->form_validation->set_rules('barcode','barcode', 'trim|required');
		$this->form_validation->set_rules('name','name', 'required');
		if( is_array( $this->input->post('clearance') ) ) {
			$clear =  join(",", $this->input->post('clearance'));
		} else {
			$clear =  $this->input->post('clearance');
		}

		if($this->form_validation->run() == false){
			$this->load->view('templates/header');
			$nav_items = $this->User_Model->get_navigation($_SESSION['user_role']);
			$this->load->view('templates/navigation',$nav_items);
			$this->load->view('equipment/Equipment_add_view');
			$this->load->view('templates/footer');
		}else{
			$data = array(
				'barcode' => $this->input->post('barcode'),
				'name' => $this->input->post('name'),
				'description' => $this->input->post('description'),
				'clearance' => $clear,
				'notes' => $this->input->post('notes'),
				'account_purchased_from' => $this->input->post('account_purchased_from'),
				'status' => $this->input->post('status')
			);
			$this->Equipment_Model->insert($data, TRUE);
			redirect('equipment');
		}
	}

	public function edit($id){

		$this->load->view('templates/header');
		$nav_items = $this->User_Model->get_navigation($_SESSION['user_role']);
		$this->load->view('templates/navigation',$nav_items);
		$data['records'] = $this->Equipment_Model->get_equipment_item($id);
		$data['clearance'] = $this->Clearance_Model->get_clearance();
		$this->load->view('equipment/Equipment_edit_view', $data);
		$this->load->view('templates/footer');
	}


	public function update($id) {

		$this->form_validation->set_rules('barcode','barcode', 'trim|required');
		$this->form_validation->set_rules('name','name', 'required');
		$this->form_validation->set_rules('description','description', 'required');
		if( is_array( $this->input->post('clearance') ) ) {
			$clear =  join(",", $this->input->post('clearance'));
		} else {
			$clear =  $this->input->post('clearance');
		}

		if($this->form_validation->run() == false){
			$this->load->view('templates/header');
			$nav_items = $this->User_Model->get_navigation($_SESSION['user_role']);
			$this->load->view('templates/navigation',$nav_items);

			$post_vars = array(
				'barcode' => $this->input->post('barcode'),
				'name' => $this->input->post('name'),
				'description' => $this->input->post('description'),
				'clearance' => $clear,
				'notes' => $this->input->post('notes'),
				'account_purchased_from' => $this->input->post('account_purchased_from'),
				'status' => $this->input->post('status')
			);

			$objects = new ArrayObject($post_vars);
			$objects->setFlags(ArrayObject::STD_PROP_LIST|ArrayObject::ARRAY_AS_PROPS);
			$data['records'] = $objects;

			$this->load->view('equipment/Equipment_edit_view', $data);
			$this->load->view('templates/footer');

		}else{
			$data = array(
				'barcode' => $this->input->post('barcode'),
				'name' => $this->input->post('name'),
				'description' => $this->input->post('description'),
				'clearance' => $clear,
				'notes' => $this->input->post('notes'),
				'account_purchased_from' => $this->input->post('account_purchased_from'),
				'status' => $this->input->post('status')
			);

			$old_barcode = $this->input->post('old_barcode');
			$this->Equipment_Model->update($data, $old_barcode,TRUE);

			redirect('equipment');
		}
	}

	public function delete($id) {

		if( $this->Equipment_Model->delete($id)){
			$this->session->set_flashdata('message', '<div class="alert alert-success text-center">Successfully Deleted. </div>');
		} else {
			$this->session->set_flashdata('message', '<div class="alert alert-danger text-center">Error. Please try again. </div>');
		}
		redirect('equipment');
	}
}

?>
