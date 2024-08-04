<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Venda_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function create_venda($data, $itens_venda) {
        $this->db->trans_start(); // Inicia uma transação

        $this->db->insert('vendas', $data);
        $venda_id = $this->db->insert_id();

        foreach ($itens_venda as &$item) {
            $item['venda_id'] = $venda_id;

            // Reduzir quantidade no estoque
            $this->db->set('quantidade', 'quantidade - ' . $item['quantidade'], FALSE);
            $this->db->where('id', $item['material_id']);
            $this->db->update('materials');
        }
        $this->db->insert_batch('itens_venda', $itens_venda);

        $this->db->trans_complete(); // Completa a transação

        return $this->db->trans_status(); // Retorna o status da transação
    }

    public function get_all_vendas() {
        $query = $this->db->get('vendas');
        return $query->result();
    }

    public function get_venda($id) {
        $this->db->select('vendas.*, itens_venda.*, materials.nome as material_nome');
        $this->db->from('vendas');
        $this->db->join('itens_venda', 'vendas.id = itens_venda.venda_id');
        $this->db->join('materials', 'itens_venda.material_id = materials.id');
        $this->db->where('vendas.id', $id);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_vendas_by_vendedor($vendedor_id) {
        $this->db->select('vendas.*, itens_venda.*, materials.nome as material_nome');
        $this->db->from('vendas');
        $this->db->join('itens_venda', 'vendas.id = itens_venda.venda_id');
        $this->db->join('materials', 'itens_venda.material_id = materials.id');
        $this->db->where('vendas.vendedor_id', $vendedor_id);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_sales_data() {
        $this->db->select('DATE(data_venda) as data_venda, SUM(preco_total) as preco_total');
        $this->db->group_by('DATE(data_venda)');
        $this->db->order_by('DATE(data_venda)', 'ASC');
        $query = $this->db->get('vendas');
        return $query->result_array();
    }
    
}
?>
