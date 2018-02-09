<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Mensajes extends \Restserver\Libraries\REST_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('string');
		$this->load->model('sms_model');
		//$this->methods['sms_get']['limit'] = 50;
	}
	// envia sms
	// curl -X POST 'http://127.0.0.1/sms/index.php/api/create' \
	//         -F token="jhonny" \
	//        -F texto="hola" \
	//         -F telefonos[]=4129632587 \
	//         -F telefonos[]=4246669985
	//
	// curl -X POST 'http://127.0.0.1/sms/index.php/api/create' \
	//        -F token="jhonny" \
	//        -F texto="hola" \
	//        -F telefonos=4129632587
	public function sms_post() {
		$token = $this->post('token');
		// si token no viene como parametro genera error
		if (!$token) {
			$this->response([
				'error' => true,
				'mensaje' => 'Falta token de acceso',
			], \Restserver\Libraries\REST_Controller::HTTP_UNAUTHORIZED);
		} else {
			$telefonos = $this->post('telefonos');

			// verificacion de token de usuario
			// si esta en la base de datos
			// envia mensaje
			if ($this->checkToken($token)) {
				$fechayhora = date('Y-m-d H:i:s');
				// si telefono no viene como parametro
				if (!$this->post('telefonos')) {
					$this->response([
						'error' => true,
						'mensaje' => 'Falta parametro telefono(s)',
					], \Restserver\Libraries\REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
				} elseif (!$this->post('texto')) {
					// si texto no viene como parametro
					$this->response([
						'error' => true,
						'mensaje' => 'Falta parametro texto',
					], \Restserver\Libraries\REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
				} elseif (!is_array($this->post('telefonos'))) {
					if ($this->post('fecha_hora')) {
						$timestamp = $this->post('fecha_hora');
					} else {
						$timestamp = $fechayhora;
					}
					// si viene 1 solo contacto == 1 mensaje
					$mensaje = [
						'token' => random_string('md5'),
						'texto' => $this->post('texto'),
						'telefono_dest' => $this->post('telefonos'),
						'fecha_hora_envio' => $timestamp,
						'estatus' => 'Por enviar',
						'id_usuario' => $this->obtenerUserId($token),
						'operadora' =>  $this->getOperadora($this->post('telefonos')),
					];
					// mensaje se envia y retorna un id
					$saldo = intval($this->checkSaldo($token));
					// verifica saldo
					if ($saldo >= 1) {
						$envio = $this->sms_model->enviar_mensaje($mensaje);
						if ($envio) {
							$estatus = $this->sms_model->estatus_enviado($envio);
							$respuesta = array(
								'status' => $estatus->estatus,
								'token_sms' => $estatus->token,
								'fecha_hora_envio' => $estatus->fecha_hora_envio,
								'destinatario' => $estatus->telefono_dest,
							);
							$this->response($respuesta, \Restserver\Libraries\REST_Controller::HTTP_OK);
							$this->sms_model->descontar_sms($token);
						} else {
							$this->response([
								'error' => true,
								'mensaje' => 'Error del servidor',
							], \Restserver\Libraries\REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
						}
					} elseif ($saldo < 1) {
						$this->response([
							'error' => true,
							'mensaje' => 'No posee mensajes disponibles',
						], \Restserver\Libraries\REST_Controller::HTTP_PAYMENT_REQUIRED);
					}
				} else {
					if ($this->post('fecha_hora')) {
						$timestamp = $this->post('fecha_hora');
					} else {
						$timestamp = $fechayhora;
					}
					$envios = array();
					// si vienen varios contactos == varios mensajes
					foreach ($this->post('telefonos') as $numero) {
						$mensaje = [
							'token' => random_string('md5'),
							'texto' => $this->post('texto'),
							'telefono_dest' => $numero,
							'fecha_hora_envio' => $timestamp,
							'estatus' => 'Por enviar',
							'id_usuario' => $this->obtenerUserId($token),
							'operadora' => $this->getOperadora($numero),
						];
						// mensaje se envia y retorna un id

						$saldo = intval($this->checkSaldo($token));
						if ($saldo < 1) {
							$this->response([
								'error' => true,
								'mensaje' => 'No posee mensajes disponibles',
							], \Restserver\Libraries\REST_Controller::HTTP_PAYMENT_REQUIRED);
						} elseif ($saldo >= 1) {
							$envio = $this->sms_model->enviar_mensaje($mensaje);
							$this->sms_model->descontar_sms($token);
							$envios[] = $envio;
						}
					}
					if ($envios) {
						$response = array();
						foreach ($envios as $envio) {
							$estatus = $this->sms_model->estatus_enviado($envio);
							$respuesta = array(
								'status' => $estatus->estatus,
								'token_sms' => $estatus->token,
								'fecha_hora_envio' => $estatus->fecha_hora_envio,
								'destinatario' => $estatus->telefono_dest,
							);
							$response[] = $respuesta;
						}
						$this->response($response, \Restserver\Libraries\REST_Controller::HTTP_OK);
					}
				}

			} else {
				$this->response([
					'error' => true,
					'mensaje' => 'No autorizado',
				], \Restserver\Libraries\REST_Controller::HTTP_UNAUTHORIZED);
			}
		}
	}
	//curl -X GET 'http://127.0.0.1/sms/index.php/api/list?token=jhonny'
	public function sms_get() {
		$token = $this->get('token');
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
				$mensajes = $this->sms_model->obtener_mensajes($token);
				$this->response($mensajes, \Restserver\Libraries\REST_Controller::HTTP_OK);
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

	public function checkSaldo($token) {
		$data = $this->sms_model->check_user_info($token);
		return $data->msj_dispon;
	}

	public function consultar_get() {
		$token = $this->get('token');
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
				$mensajes = $this->checkSaldo($token);
				$this->response([
					'mensajes disponibles' => intval($mensajes),
				], \Restserver\Libraries\REST_Controller::HTTP_OK);
			} else {
				$this->response([
					'error' => true,
					'mensaje' => 'No autorizado',
				], \Restserver\Libraries\REST_Controller::HTTP_UNAUTHORIZED);
			}
		}
	}

	public function obtenerUserId($token) {
		$data = $this->sms_model->check_user_info($token);
		return $data->id;
	}
	
	public function getOperadora($telefono) {
		$longTelefono = strlen($telefono); 
		if ($longTelefono == 11) {
 			$codigo = substr($telefono, 0, 4);
		}elseif ($longTelefono == 10) {
  			$codigo = substr($telefono, 0, 3);
		}
		
		if ($codigo == '0424' || $codigo == '424'|| $codigo == '414' || $codigo == '0414') {
  			$operadora = "movistar";
		}elseif ($codigo == '0426' || $codigo == '426'|| $codigo == '416' || $codigo == '0416') {
  			$operadora = "movilnet";
		}elseif ($codigo == '0412' || $codigo == '412') {
  			$operadora = "digitel";
		}else{
   			$operadora = "";
		}

		return $operadora;
	}

	// public function sms_delete()
	// {
	//     $id = (int) $this->get('id');

	//     // Validate the id.
	//     if ($id <= 0)
	//     {
	//         // Set the response and exit
	//         $this->response(NULL, \Restserver\Libraries\REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
	//     }

	//     // $this->some_model->delete_something($id);
	//     $message = [
	//         'id' => $id,
	//         'message' => 'Deleted the resource'
	//     ];

	//     $this->set_response($message, \Restserver\Libraries\REST_Controller::HTTP_NO_CONTENT); // NO_CONTENT (204) being the HTTP response code
	// }

}
