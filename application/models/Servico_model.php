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
        $this->db->select('users.id, users.nome');
        $this->db->from('users');
        $this->db->join('mecanicos', 'mecanicos.user_id = users.id');
        $query = $this->db->get();
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

    public function get_total_service_value() {
        $this->db->select_sum('valor_total');
        $query = $this->db->get('services');
        return $query->row()->valor_total;
    }

    public function get_service_data($start_date, $end_date) {
        $this->db->select('DATE(created_at) as date, SUM(valor_total) as total');
        $this->db->where('created_at >=', $start_date);
        $this->db->where('created_at <=', $end_date);
        $this->db->group_by('DATE(created_at)');
        $query = $this->db->get('services');
        return $query->result_array();
    }
    
    public function get_servicos_by_period($start_date, $end_date) {
        $this->db->where('created_at >=', $start_date);
        $this->db->where('created_at <=', $end_date);
        $query = $this->db->get('services');
        return $query->result();
    }
    
    
}
?>
