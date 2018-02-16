<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Status extends \Restserver\Libraries\REST_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('string');
		$this->load->model('status_model');
		//$this->methods['sms_get']['limit'] = 50;
	}
	
	public function status_get() {
		$serial = str_replace('"','',$this->get('serial'));
		if (!$serial) {
			$this->response([
				'error' => true,
				'mensaje' => 'Falta el parametro serial',
			], \Restserver\Libraries\REST_Controller::HTTP_UNAUTHORIZED);
		}else{
			// $from = str_replace('"','',$this->get('from'));
			// $to = str_replace('"','',$this->get('to'));
	        
			// if ($to && $from) {
			// 	$status = $this->status_model->obtener_status_rango($serial, $from, $to);
			// 	$this->response($status, \Restserver\Libraries\REST_Controller::HTTP_OK);
			// }elseif ($from) {
			// 	$status = $this->status_model->obtener_status_fecha($serial, $from);
			// 	$this->response($status, \Restserver\Libraries\REST_Controller::HTTP_OK);
			// }elseif ($serial && !$from && !$to){
			$status = $this->status_model->obtener_status($serial);
			$this->response($status, \Restserver\Libraries\REST_Controller::HTTP_OK);
			// }
		}
	}

}


// curl -X GET  -H "Accept: application/xml" 'http://noustech.dyndns.org/nous/api/index.php/status/?serial=2881B0AE05000005-H'
// curl -X GET  -H "Accept: application/json" 'http://noustech.dyndns.org/nous/api/index.php/status/?serial=2881B0AE05000005-H'
