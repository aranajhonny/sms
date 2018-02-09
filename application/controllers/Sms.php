<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sms extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('Sms_site_model', 'sms');
		$this->load->model('Sms_site_porenviar_model', 'psms');
	}

	public function lista() {
		$list = $this->sms->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $sms_i) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $sms_i->texto;
			// $row[] = $sms_i->token;
			$row[] = $sms_i->conf_recibido;
			$row[] = $sms_i->fecha_hora_envio;
			$row[] = $sms_i->fecha_hora_enviado;
			$row[] = $sms_i->estatus;
			$row[] = $sms_i->telefono_dest;

			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->sms->count_all(),
			"recordsFiltered" => $this->sms->count_filtered(),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}
	public function porenviar() {
		$list = $this->psms->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $sms_i) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $sms_i->texto;
			// $row[] = $sms_i->token;
			$row[] = $sms_i->conf_recibido;
			$row[] = $sms_i->fecha_hora_envio;
			$row[] = $sms_i->fecha_hora_enviado;
			$row[] = $sms_i->estatus;
			$row[] = $sms_i->telefono_dest;

			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->psms->count_all(),
			"recordsFiltered" => $this->psms->count_filtered(),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}

}