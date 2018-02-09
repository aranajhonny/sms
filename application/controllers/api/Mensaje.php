<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Mensaje extends \Restserver\Libraries\REST_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('string');
		$this->load->model('sms_model');
		//$this->methods['sms_get']['limit'] = 50;
	}
	//curl -X GET 'http://127.0.0.1/sms/index.php/api/status/{TOKEN}/?token=jhonny'
	public function sms_get() {
		$token = $this->get('token');
		$id = $this->get('id');
		// si token no viene como parametro genera error
		if (!$token) {
			$this->response([
				'error' => true,
				'mensaje' => 'Falta token de acceso',
			], \Restserver\Libraries\REST_Controller::HTTP_UNAUTHORIZED);
		} else {
			// verificacion de token de usuario
			// si esta en la base de datos
			if ($this->checkToken($token)) {
				$mensaje = $this->sms_model->obtener_mensaje($id, $token);
				if ($mensaje) {
					$this->response($mensaje, \Restserver\Libraries\REST_Controller::HTTP_OK);
				} else {
					$this->response([
						'error' => true,
						'mensaje' => 'SMS no encontrado',
					], \Restserver\Libraries\REST_Controller::HTTP_NOT_FOUND);
				}
			} else {
				$this->response([
					'error' => true,
					'mensaje' => 'No autorizado',
				], \Restserver\Libraries\REST_Controller::HTTP_UNAUTHORIZED);
			}
		}
	}

	public function checkToken($token) {
		$data = $this->sms_model->check_user_info($token);
		if ($data) {
			return true;
		} else {
			return false;
		}
	}
}
