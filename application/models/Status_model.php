<?php
class Status_model extends CI_Model {
	public function __construct() {
		parent::__construct();
		$this->load->database();
	}
	public function obtener_status($serial) {
		$whereCondition = array('serial' => $serial);
		$query = $this->db->select('dato as valor, fecha_num as fecha, fecha_evento as timestamp')
			->from('log_sensor')
			->where($whereCondition)
			->limit('1')
			->get();
		return $query->result();
	}
	// public function obtener_status_rango($serial, $from, $to) {
	// 	$whereCondition = array('serial' => $serial);
	// 	$query = $this->db->select('dato as valor, fecha_num as fecha')
	// 		->from('log_sensor')
	// 		->where($whereCondition)
	// 		->get();
	// 	return $query->result();
	// }
	// public function obtener_status_fecha($serial, $from) {
	// 	$whereCondition = array('serial' => $serial, 'fecha_num' => $from);
	// 	$query = $this->db->select('dato as valor, fecha_num as fecha')
	// 		->from('log_sensor')
	// 		->where($whereCondition)
	// 		->get();
	// 	return $query->result();
	// }
}
