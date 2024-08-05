<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_users() {
        $this->db->select('users.*, (CASE WHEN mecanicos.id IS NOT NULL THEN 1 ELSE 0 END) AS is_mecanico');
        $this->db->from('users');
        $this->db->join('mecanicos', 'mecanicos.user_id = users.id', 'left');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_user($nome, $role) {
        log_message('info', 'Buscando usuário no banco de dados: ' . $nome . ' com role: ' . $role);
        try {
            $this->db->where('nome', $nome);
            $this->db->where('tipo_usuario', $role);
            $query = $this->db->get('users');
            return $query->row();
        } catch (Exception $e) {
            log_message('error', 'Erro ao buscar usuário: ' . $e->getMessage());
            return null;
        }
    }

    public function get_user_by_id($user_id) {
        $this->db->where('id', $user_id);
        $query = $this->db->get('users');
        return $query->row();
    }

    public function get_user_by_venda($venda_id) {
        $this->db->select('users.nome, users.email, users.cpf');
        $this->db->from('vendas');
        $this->db->join('users', 'vendas.vendedor_id = users.id');
        $this->db->where('vendas.id', $venda_id);
        $query = $this->db->get();
        return $query->row();
    }

    public function delete_usuario($id) {
        $this->db->where('id', $id);
        return $this->db->delete('users');
    }
}
