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
		$results1 = $this->Student_Model->get_students();
		$results2 = $this->Faculty_Model->get_faculties();
		$equip = $this->Equipment_Model->get_equipment();
		$data['results'] = array_merge($results1, $results2);
		$data['equip'] = $equip;
		$this->load->view('reservations/Reservations_add_view', $data);
		$this->load->view('templates/footer');
	}

	public function add() {



		$this->form_validation->set_rules('barcode[]','item barcode', 'trim|required|is_unique[reservations.barcode]');
		$this->form_validation->set_rules('student_id', 'student id', 'required');
		$this->form_validation->set_rules('date_pickup', 'date pickup', 'required');
		$this->form_validation->set_rules('date_due', 'date due', 'required');


		if($this->form_validation->run() == false){
			$this->load->view('templates/header');
			$nav_items = $this->User_Model->get_navigation($_SESSION['user_role']);
			$this->load->view('templates/navigation',$nav_items);
			$this->load->view('reservations/Reservations_add_view');
			$this->load->view('templates/footer');

		} else {

			$results1 = $this->Student_Model->get_students();
			$results2 = $this->Faculty_Model->get_faculties();
			$data = array_merge($results1, $results2);

			if($_SESSION['user_role'] != "Manager"){
				foreach ($data as $d) {
					if($this->input->post('student_id') == $d->banner_id){
						if($d->clearance_level == "Restricted"){
							$this->session->set_flashdata('message', '<div class="alert alert-success text-center">Student ID entered has Restricted Clearance Level. Must be a Manager to add reservation. </div>');
							redirect('reservations');
						}
					}
				}
			}

			if( is_array( $this->input->post('barcode') ) ) {
				foreach($this->input->post("barcode") as $row) {
					// Update DB on number of barcode input made
					date_default_timezone_set("America/Denver");
					$timestamp = date('D, d M y h:i:sa');

					$data = array(
						'barcode' => $row,
						'student_id' => $this->input->post('student_id'),
						'date_pickup' => $this->input->post('date_pickup'),
						'date_due' => $this->input->post('date_due'),
						'notes' => $this->input->post('notes'),
						'date_time' => $timestamp,
						'user_id' => $_SESSION['user_id']);

						$this->Reservations_Model->insert($data, TRUE);
						$this->Equipment_Model->updateStatus($row);
				}
			} else {
				$clear =  $this->input->post('barcode');
			}

				redirect('reservations');
			}
		}

		public function edit($id) {
			$this->load->view('templates/header');
			$nav_items = $this->User_Model->get_navigation($_SESSION['user_role']);
			$this->load->view('templates/navigation',$nav_items);
			$data['records'] = $this->Reservations_Model->get_reservation($id);
			$results1 = $this->Student_Model->get_students();
			$results2 = $this->Faculty_Model->get_faculties();
			$data['results'] = array_merge($results1, $results2);
			$this->load->view('reservations/Reservations_edit_view',$data);
			$this->load->view('templates/footer');
		}

		public function update($id){
			date_default_timezone_set("America/Denver");
			$timestamp = date('D, d M y h:i:sa');

			$this->form_validation->set_rules('barcode','item barcode', 'trim|required');
			$this->form_validation->set_rules('student_id', 'student id', 'required');
			$this->form_validation->set_rules('date_pickup', 'date pickup', 'required');
			$this->form_validation->set_rules('date_due', 'date due', 'required');

			if($this->form_validation->run() == false){
				$this->load->view('templates/header');
				$nav_items = $this->User_Model->get_navigation($_SESSION['user_role']);
				$this->load->view('templates/navigation',$nav_items);

				$post_vars = array(
					'barcode' => $this->input->post('barcode'),
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
					'barcode' => $this->input->post('barcode'),
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
	}
	?>
