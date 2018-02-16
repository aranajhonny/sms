<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	public function __construct() {
		// parent::__construct();
		// $this->load->library(array('session'));
		// $this->load->helper(array('url'));
		// $this->load->model('sms_model');
		// if (isset($_SESSION['token'])) {
		// } else {
		// 	redirect('login');
		// }
	}

	public function index() {
		// $data = array('mensajes' => $this->getMensajes(), 'nombre' => strtoupper($_SESSION['nombre']), 'titulo' => 'SMS');
		// $this->load->view('header', $data);
		// $this->load->view('home');
		// $this->load->view('footer');
	}

	// public function perfil() {

	// 	$data = new stdClass();

	// 	$this->load->helper('form');
	// 	$this->load->library('form_validation');

	// 	$this->form_validation->set_rules('viejaclave', 'clave', 'required');
	// 	$this->form_validation->set_rules('nuevaclave', 'clave', 'required');

	// 	if ($this->form_validation->run() == false) {
	// 		$data = array('mensajes' => $this->getMensajes(), 'nombre' => strtoupper($_SESSION['nombre']), 'titulo' => 'SMS');
	// 		$this->load->view('header', $data);
	// 		$this->load->view('perfil');
	// 		$this->load->view('footer');
	// 	} else {
	// 		// capturo variables desde el formulario
	// 		$viejaclave = $this->input->post('viejaclave');
	// 		$nuevaclave = $this->input->post('nuevaclave');
	// 		$rif = $_SESSION['rif'];
	// 		// invoco la funcion que verfifica usuario y contraseña
	// 		$result = $this->sesiones_model->update_perfil($rif, $viejaclave, $nuevaclave);
	// 		if ($result == 0) {
	// 			$data = array('msj' => 'Contraseña actualizada correctamente.', 'mensajes' => $this->getMensajes(), 'nombre' => strtoupper($_SESSION['nombre']), 'titulo' => 'SMS');
	// 			$this->load->view('header', $data);
	// 			$this->load->view('perfil');
	// 			$this->load->view('footer');
	// 		} else if ($result == 1) {
	// 			$data = array('msj' => 'La contraseña anterior es incorrecta.', 'mensajes' => $this->getMensajes(), 'nombre' => strtoupper($_SESSION['nombre']), 'titulo' => 'SMS');
	// 			$this->load->view('header', $data);
	// 			$this->load->view('perfil');
	// 			$this->load->view('footer');
	// 		} else {
	// 			$data = array('msj' => 'El usuario no existe', 'mensajes' => $this->getMensajes(), 'nombre' => strtoupper($_SESSION['nombre']), 'titulo' => 'SMS');
	// 			$this->load->view('header', $data);
	// 			$this->load->view('perfil');
	// 			$this->load->view('footer');
	// 		}
	// 	}
	// }

	// public function token() {
	// 	$data = array('mensajes' => $this->getMensajes(), 'nombre' => strtoupper($_SESSION['nombre']), 'titulo' => 'SMS');
	// 	$this->load->view('header', $data);
	// 	$this->load->view('token');
	// 	$this->load->view('footer');
	// }

	// public function porenviar() {
	// 	$data = array('mensajes' => $this->getMensajes(), 'nombre' => strtoupper($_SESSION['nombre']), 'titulo' => 'SMS');
	// 	$this->load->view('header', $data);
	// 	$this->load->view('porenviar');
	// 	$this->load->view('footer');
	// }

	// public function getMensajes() {
	// 	$saldo = $this->sms_model->obtener_mensajes_disponibles($_SESSION['id']);
	// 	return $saldo->msj_dispon;
	// 	//return $this->sms_model->obtener_mensajes_disponibles($_SESSION['id']);
	// }

}
