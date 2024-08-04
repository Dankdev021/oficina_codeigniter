<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mecanico_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_mecanicos() {
        $query = $this->db->get('mecanicos');
        return $query->result();
    }

    public function get_mecanico($id) {
        $query = $this->db->get_where('mecanicos', array('id' => $id));
        return $query->row();
    }
}
?>
