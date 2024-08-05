<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Material_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_materials($status = 'ativo') {
        $this->db->where('status', $status);
        $query = $this->db->get('materials');
        return $query->result();
    }

    public function get_material($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('materials');
        return $query->row();
    }

    public function add_material($data) {
        $this->db->insert('materials', $data);
    }

    public function update_quantity($material_id, $quantity) {
        $this->db->set('quantidade', 'quantidade + ' . (int)$quantity, FALSE);
        $this->db->where('id', $material_id);
        $this->db->update('materials');

        $data_entrada = array(
            'id' => $material_id,
            'quantidade' => $quantity
        );
        $this->db->insert('entradas_estoque', $data_entrada);
    }

    public function inactivate_material($id) {
        $this->db->set('status', 'inativo');
        $this->db->where('id', $id);
        $this->db->update('materials');
    }

    public function activate_material($id) {
        $this->db->set('status', 'ativo');
        $this->db->where('id', $id);
        $this->db->update('materials');
    }
}
?>
