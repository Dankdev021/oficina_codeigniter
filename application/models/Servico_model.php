<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Servico_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_servicos() {
        $query = $this->db->get('services');
        return $query->result();
    }

    public function get_servico($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('services');
        return $query->row();
    }

    public function get_all_materiais() {
        $query = $this->db->get('materials');
        return $query->result();
    }

    public function get_all_mecanicos() {
        $query = $this->db->where('id IN (SELECT user_id FROM mecanicos)')->get('users');
        return $query->result();
    }

    public function get_servico_materiais($servico_id) {
        $this->db->select('materials.nome, itens_servico.quantidade, itens_servico.preco_total');
        $this->db->from('itens_servico');
        $this->db->join('materials', 'itens_servico.material_id = materials.id');
        $this->db->where('itens_servico.servico_id', $servico_id);
        $query = $this->db->get();
        return $query->result();
    }
}
