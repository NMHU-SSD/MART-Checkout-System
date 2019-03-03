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
		$data['clearance_options'] = $this->Clearance_Model->get_clearance_levels();
		$this->load->view('equipment/Equipment_view', $data);
		$this->load->view('templates/footer');
	}

	public function new() {

		$this->load->view('templates/header');
		$nav_items = $this->User_Model->get_navigation($_SESSION['user_role']);
		$this->load->view('templates/navigation',$nav_items);

		$data['clearance_options'] = $this->Clearance_Model->get_clearance_levels();

		$data['states'] = $this->Equipment_Model->get_status_enum("object"); //get enum as array
		$data['status'] = $this->Equipment_Model->get_status_enum("array")[0]; //get status as obj for dropdown

		$this->load->view('equipment/Equipment_add_view', $data);
		$this->load->view('templates/footer');
	}


	public function add() {

		$this->form_validation->set_rules('barcode','barcode', 'trim|required|is_unique[equipment.barcode]');
		$this->form_validation->set_rules('name','name', 'required');

		if( is_array( $this->input->post('clearance') ) ) {
			$levels =  join(",", $this->input->post('clearance'));
		} else {
			$levels =  $this->input->post('clearance');
		}

		$this->form_validation->set_rules('clearance','clearance levels', 'required');
		$this->form_validation->set_rules('form_status','status', 'required');

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
				'clearance' => $levels,
				'notes' => $this->input->post('notes'),
				'purchase_account' => $this->input->post('account_purchased_from'),
				'status' => $this->input->post('form_status')
			);
			$this->Equipment_Model->insert($data, TRUE);
			redirect('equipment');
		}
	}

	public function edit($id){
		if($_SESSION['user_role'] == "Student Employee"){
			redirect('equipment');
		}
		$this->load->view('templates/header');
		$nav_items = $this->User_Model->get_navigation($_SESSION['user_role']);
		$this->load->view('templates/navigation',$nav_items);

		$data['record'] = $this->Equipment_Model->get_equipment_item($id);

		$data['clearance_options'] = $this->Clearance_Model->get_clearance_levels();

		$data['states'] = $this->Equipment_Model->get_status_enum("object"); //get enam as array
		$data['status'] = $this->Equipment_Model->check_status($id); //get status as obj for dropdown

		$this->load->view('equipment/Equipment_edit_view', $data);
		$this->load->view('templates/footer');
	}


	public function update($id) {
		$this->form_validation->set_rules('barcode','barcode', 'trim|required');
		$this->form_validation->set_rules('name','name', 'required');
		$this->form_validation->set_rules('description','description', 'required');

		if( is_array( $this->input->post('clearance') ) ) {
			$levels =  join(",", $this->input->post('clearance'));
		} else {
			$levels =  $this->input->post('clearance');
		}
		$this->form_validation->set_rules('form_status','status', 'required');

		if($this->form_validation->run() == false){
			$this->load->view('templates/header');
			$nav_items = $this->User_Model->get_navigation($_SESSION['user_role']);
			$this->load->view('templates/navigation',$nav_items);

			$post_vars = array(
				'barcode' => $this->input->post('barcode'),
				'name' => $this->input->post('name'),
				'description' => $this->input->post('description'),
				'clearance' => $levels,
				'notes' => $this->input->post('notes'),
				'purchase_account' => $this->input->post('account_purchased_from'),
				'status' => $this->input->post('form_status')
			);

			$objects = new ArrayObject($post_vars);
			$objects->setFlags(ArrayObject::STD_PROP_LIST|ArrayObject::ARRAY_AS_PROPS);
			$data['records'] = $objects;
			$data['clearance_options'] = $this->Clearance_Model->get_clearance_levels();

			$this->load->view('equipment/Equipment_edit_view', $data);
			$this->load->view('templates/footer');

		}else{

			$data = array(
				'barcode' => $this->input->post('barcode'),
				'name' => $this->input->post('name'),
				'description' => $this->input->post('description'),
				'clearance' => $levels,
				'notes' => $this->input->post('notes'),
				'purchase_account' => $this->input->post('account_purchased_from'),
				'status' => $this->input->post('form_status')
			);

			$old_barcode = $this->input->post('old_barcode');
			$this->Equipment_Model->update($data, $old_barcode,TRUE);

			redirect('equipment');
		}
	}

	public function delete($id) {
		if($_SESSION['user_role'] == "Student Employee"){
			redirect('equipment');
		}
		if( $this->Equipment_Model->delete($id)){
			$this->session->set_flashdata('message', '<div class="alert alert-success text-center">Successfully Deleted. </div>');
		} else {
			$this->session->set_flashdata('message', '<div class="alert alert-danger text-center">Error. Please try again. </div>');
		}
		redirect('equipment');
	}

	public function hide($barcode){
		if( $this->Equipment_Model->hide($barcode)){
			$this->session->set_flashdata('message', '<div class="alert alert-success text-center">Successfully Deleted. </div>');
		} else{
			$this->session->set_flashdata('message', '<div class="alert alert-danger text-center">Error. Please try again. </div>');
		}
		redirect('equipment');
	}


}

?>
