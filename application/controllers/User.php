<?php

class User extends CI_Controller {

	public function __construct() {

		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('string');
		$this->load->model('user_model');
		$this->load->library('session');

	}

	public function index() {
		$this->load->view("register.php");
	}

	public function register_user() {

		$user = array(
			'nombre' => $this->input->post('nombre'),
			'apellido' => $this->input->post('apellido'),
			'correo' => $this->input->post('correo'),
			'clave' => md5($this->input->post('clave')),
			'telefono' => $this->input->post('telefono'),
			'token' => random_string('md5'),
		);
		//print_r($user);

		$email_check = $this->user_model->email_check($user['correo']);

		if ($email_check) {
			$this->user_model->register_user($user);
			$this->session->set_flashdata('success_msg', 'Registrado exitosamente.');
			redirect('user/login_view');

		} else {

			$this->session->set_flashdata('error_msg', 'El correo ya se encuentra registrado');
			redirect('user');

		}

	}

	public function login_view() {

		$this->load->view("login.php");

	}

	function login_user() {
		$user_login = array(

			'correo' => $this->input->post('correo'),
			'clave' => md5($this->input->post('clave')),

		);

		$data = $this->user_model->login_user($user_login['correo'], $user_login['clave']);
		if ($data) {
			$this->session->set_userdata('id', $data['id']);
			$this->session->set_userdata('correo', $data['correo']);
			$this->session->set_userdata('nombre', $data['nombre']);
			$this->session->set_userdata('token', $data['token']);

			redirect('/');

		} else {
			$this->session->set_flashdata('error_msg', 'Ocurrio un error, intente de nuevo');
			$this->load->view("login.php");

		}

	}

	// function user_profile() {

	// 	//$this->load->view('user_profile.php');

	// }
	public function user_logout() {

		$this->session->sess_destroy();
		redirect('/login', 'refresh');
	}

}

?>