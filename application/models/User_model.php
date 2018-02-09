<?php
class User_model extends CI_model {
public function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function register_user($user) {

		$this->db->insert('usuarios', $user);

	}

	public function login_user($correo, $clave) {

		$this->db->select('*');
		$this->db->from('usuarios');
		$this->db->where('correo', $correo);
		$this->db->where('clave', $clave);

		if ($query = $this->db->get()) {
			return $query->row_array();
		} else {
			return false;
		}

	}
	public function email_check($correo) {

		$this->db->select('*');
		$this->db->from('usuarios');
		$this->db->where('correo', $correo);
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return false;
		} else {
			return true;
		}

	}

}

?>