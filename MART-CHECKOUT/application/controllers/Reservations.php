<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reservations extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->database();
		$this->load->model('User_Model');
		$this->load->model('Reservations_Model');
		$this->load->model('Equipment_Model');
		$this->load->model('Student_Model');
		$this->load->model('Faculty_Model');

		if(!isset($_SESSION['logged_in'])){
			redirect('login');
		}
	}

	public function index() {
		$data['records'] = $this->Reservations_Model->get_reservations();
		$this->load->view('templates/header');
		$nav_items = $this->User_Model->get_navigation($_SESSION['user_role']);
		$this->load->view('templates/navigation',$nav_items);
		$this->load->view('reservations/Reservations_view',$data);
		$this->load->view('templates/footer');
	}

	public function new() {
		$this->load->view('templates/header');
		$nav_items = $this->User_Model->get_navigation($_SESSION['user_role']);
		$this->load->view('templates/navigation',$nav_items);
		$this->load->view('reservations/Reservations_add_view');
		$this->load->view('templates/footer');
	}

	public function add() {

		$this->form_validation->set_rules('barcode[]','equipment barcode', 'required|trim|callback__validate_barcode' );
		$this->form_validation->set_rules('banner_id', 'banner id', 'required|numeric|trim');
		$this->form_validation->set_rules('date_pickup', 'pickup date', 'required');
		$this->form_validation->set_rules('date_due', 'due date', 'required');


		if($this->form_validation->run() == false){

			$this->load->view('templates/header');
			$nav_items = $this->User_Model->get_navigation($_SESSION['user_role']);
			$this->load->view('templates/navigation',$nav_items);
			$this->load->view('reservations/Reservations_add_view');
			$this->load->view('templates/footer');

		} else {

				// foreach ($data as $d) {
				// 	if($this->input->post('banner_id') == $d->banner_id){
				// 		if($d->clearance_level == "Restricted"){
				// 			$this->session->set_flashdata('message', '<div class="alert alert-success text-center">Student ID entered has Restricted Clearance Level. Must be a Manager to add reservation. </div>');
				// 		}
				// 	}
				// }

				// if(is_array($this->input->post('barcode')) ) {
				// 	$barcodes =  join(",", $this->input->post('barcode'));
				// } else {
				// 	$barcodes =  $this->input->post('barcode');
				// }

				date_default_timezone_set("America/Denver");
				$timestamp = date('D, M d,Y g:i a');

				$data = array(
						'equipment' =>  join(", ", $this->input->post('barcode[]')),
						'banner_id' => $this->input->post('banner_id'),
						'date_pickup' => $this->input->post('date_pickup'),
						'date_due' => $this->input->post('date_due'),
						'notes' => $this->input->post('notes'),
						'date_time' => $timestamp,
						'user_id' => $_SESSION['user_id']);

				$this->Reservations_Model->insert($data, TRUE);
				$available= $this->Equipment_Model->check_status($barcode);
				$states = $this->Equipment_Model->get_status_enum("array");

				$this->Equipment_Model->updateStatus($barcodes, $states[0]);
				redirect('reservations');

			}
		}

		public function edit($id) {
			$this->load->view('templates/header');
			$nav_items = $this->User_Model->get_navigation($_SESSION['user_role']);
			$this->load->view('templates/navigation',$nav_items);
			$data['records'] = $this->Reservations_Model->get_reservation($id);
			$results1 = $this->Student_Model->get_students();
			$results2 = $this->Faculty_Model->get_all_faculty();
			$equip = $this->Equipment_Model->get_equipment();
			$data['results'] = array_merge($results1, $results2);
			$data['equip'] = $equip;
			$this->load->view('reservations/Reservations_edit_view',$data);
			$this->load->view('templates/footer');
		}

		public function update($id){
			date_default_timezone_set("America/Denver");
			$timestamp = date('D, M d,Y g:i a');

			$this->form_validation->set_rules('barcode[]','item barcode', array('trim','required', 'validate_barcode' => array($this->Equipment_Model, 'valid_barcode') ));
			$this->form_validation->set_rules('banner_id', 'banner id', 'required');
			$this->form_validation->set_rules('date_pickup', 'date pickup', 'required');
			$this->form_validation->set_rules('date_due', 'date due', 'required');

			if($this->form_validation->run() == false){

				$this->load->view('templates/header');
				$nav_items = $this->User_Model->get_navigation($_SESSION['user_role']);
				$this->load->view('templates/navigation',$nav_items);

				$post_vars = array(
					'equipment' => $this->input->post('barcode[]'),
					'student_id' => $this->input->post('student_id'),
					'date_pickup' => $this->input->post('date_pickup'),
					'date_due' => $this->input->post('date_due'),
					'notes' => $this->input->post('notes'),
					'date_time' => $timestamp,
					'user_id' => $_SESSION['user_id']
				);

				$object = new ArrayObject($post_vars);
				$object -> setFlags( ArrayObject::STD_PROP_LIST|ArrayObject::ARRAY_AS_PROPS);

				$data['records'] = $object;

				$this->load->view('Reservations/Reservations_edit_view', $data);
				$this->load->view('templates/footer');
			}else{

				$tempCheckout = null;

				if ($this->input->post('checkedout') == 'true')	{
					$tempCheckout = TRUE;
				}else{
					$tempCheckout = FALSE;
				}

				$data = array(
					'equipment' => $this->input->post('barcode'),
					'student_id' => $this->input->post('student_id'),
					'date_pickup' => $this->input->post('date_pickup'),
					'date_due' => $this->input->post('date_due'),
					'notes' => $this->input->post('notes'),
					'date_time' => $timestamp,
					'isCheckedOut' => $tempCheckout,
					'user_id' => $_SESSION['user_id']
				);

				$this->Reservations_Model->update($data, $id,TRUE);
				redirect('reservations');
			}
		}

		public function delete_reservation($id) {
			if( $this->Reservations_Model->delete($id)){
				$this->session->set_flashdata('message', '<div class="alert alert-success text-center">Successfully Deleted. </div>');
			} else{
				$this->session->set_flashdata('message', '<div class="alert alert-danger text-center">Error. Please try again. </div>');
			}
			redirect('reservations');
		}

		public function hide($barcode){
			if( $this->Reservations_Model->hide($barcode)){
				$this->session->set_flashdata('message', '<div class="alert alert-success text-center">Successfully Deleted. </div>');
			} else{
				$this->session->set_flashdata('message', '<div class="alert alert-danger text-center">Error. Please try again. </div>');
			}
			redirect('reservations');
		}

		//callback method _ prevents access
		public function _validate_barcode($barcode){

			//for ($i = 0, i < count($barcodes))
			if ($this->Equipment_Model->get_equipment_item($barcode)){
				return TRUE;
			} else {
				$this->form_validation->set_message('_validate_barcode', 'Barcode does not exist');
				return FALSE;
			}

		}


		///intended for use with jquery ajax
		public function valid_barcode(){

			$barcode = $this->input->post('barcode');

			if (!$barcode){

				show_error("Access is not allowed.", 403, $heading = 'Forbidden');

			}


			if ($this->Equipment_Model->get_equipment_item($barcode) != null){
				$states = $this->Equipment_Model->get_status_enum("array");
				$status = $this->Equipment_Model->check_status($barcode);

				//available
				if ($status == $states[0] || $status == $states[1]){
					echo json_encode(array(true, $barcode, $status));
				} else {
					echo json_encode(array(false,$barcode, $status));
				}
			} else {
				$message = "This barcode does not exist.";
				echo json_encode(array(false,$barcode, $message));
			}


		}

		///intended for use with jquery ajax
		public function valid_bannerid(){

			$banner_id= $this->input->post('banner_id');

			if (!$banner_id){
				show_error("Access is not allowed.", 403, $heading = 'Forbidden');
			}

			if ($student = $this->Student_Model->get_student($banner_id)){
				$status = $student->eligibility;
				echo json_encode(array(true, $banner_id, $status));
			} else if ($faculty = $this->Faculty_Model->get_faculty($banner_id)){

				$message = "This banner id belongs to a Faculty member.";
				echo json_encode(array(true, $banner_id, $message));
			} else {
				$message = "This banner id does not exist in the system.";
				echo json_encode(array(false,$banner_id, $message));
			}

		}

}
?>
