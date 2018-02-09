<?php
class Sms_model extends CI_Model {
	public function __construct() {
		parent::__construct();
		$this->load->database();
	}
	public function check_user_info($token) {
		$whereCondition = array('token' => $token);
		$query = $this->db->select('*')
			->from('usuarios')
			->where($whereCondition)
			->get();
		return $query->row();
	}
	public function enviar_mensaje($mensaje) {
		$this->db->insert('mensajes', $mensaje);
		return $this->db->insert_id();
	}
	public function estatus_enviado($id) {
		$whereCondition = array('id' => $id);
		$query = $this->db->select('*')
			->from('mensajes')
			->where($whereCondition)
			->get();
		return $query->row();
	}
	public function obtener_mensajes($token) {
		$id_usuario = $this->obtener_usuario($token);
		$whereCondition = array('id_usuario' => $id_usuario->id);
		$query = $this->db->select('token, conf_recibido as recibido, fecha_hora_envio, fecha_hora_enviado, estatus as status, telefono_dest as destinatario')
			->from('mensajes')
			->where($whereCondition)
			->get();
		return $query->result();
	}
	public function obtener_mensaje($id, $token) {
		$id_usuario = $this->obtener_usuario($token);
		$whereCondition = array('token'=> $id, 'id_usuario' => $id_usuario->id);
		$query = $this->db->select('token, conf_recibido as recibido, fecha_hora_envio, fecha_hora_enviado, estatus as status, telefono_dest as destinatario')
			->from('mensajes')
			->where($whereCondition)
			->get();
		return $query->row();
	}
	public function obtener_usuario($token) {
		$whereCondition = array('token' => $token);
		$query = $this->db->select('*')
			->from('usuarios')
			->where($whereCondition)
			->get();
		return $query->row();
	}
	public function descontar_sms($token) {
		$this->db->simple_query("update usuarios set msj_dispon = msj_dispon - 1 where token=" . "'" . $token . "'" . " and msj_dispon > 0");
	}
	public function obtener_mensajes_disponibles($id) {
		$whereCondition = array('id' => $id);
		$query = $this->db->select('msj_dispon')
			->from('usuarios')
			->where($whereCondition)
			->get();
		return $query->row();
	}
}
