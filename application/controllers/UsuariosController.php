<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UsuariosController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('session');
        $this->load->helper('url');
        
        // Verifica se o usuário está logado
        if (!$this->session->userdata('user_id')) {
            redirect('login');
        }
    }

    public function index() {
        $data['usuarios'] = $this->User_model->get_all_users();
        $data['view'] = 'usuarios/index';
        $this->load->view('layouts/main', $data);
    }

    public function store() {
        $data = array(
            'nome' => $this->input->post('nome'),
            'cpf' => $this->input->post('cpf'),
            'email' => $this->input->post('email'),
            'senha' => password_hash($this->input->post('senha'), PASSWORD_BCRYPT),
            'tipo_usuario' => $this->input->post('tipo_usuario'),
            'is_mecanico' => $this->input->post('is_mecanico')
        );

        $this->db->trans_start();
        try {
            $this->db->insert('users', $data);
            $user_id = $this->db->insert_id();

            if ($this->input->post('is_mecanico') == '1') {
                $data_mecanico = array(
                    'user_id' => $user_id,
                    'nome' => $this->input->post('nome'),
                    'cpf' => $this->input->post('cpf'),
                    'email' => $this->input->post('email')
                );
                $this->db->insert('mecanicos', $data_mecanico);
            }

            $this->db->trans_complete();

            if ($this->db->trans_status()) {
                $this->session->set_flashdata('success', 'Usuário adicionado com sucesso!');
                redirect('UsuariosController/index');
            } else {
                throw new Exception('Erro ao salvar o usuário.');
            }
        } catch (Exception $e) {
            $this->db->trans_rollback();
            $this->session->set_flashdata('error', $e->getMessage());
            redirect('UsuariosController/index');
        }
    }

    public function update($id) {
        $data = array(
            'nome' => $this->input->post('nome'),
            'cpf' => $this->input->post('cpf'),
            'email' => $this->input->post('email'),
            'tipo_usuario' => $this->input->post('tipo_usuario'),
            'is_mecanico' => $this->input->post('is_mecanico')
        );

        $this->db->trans_start();
        try {
            $this->db->where('id', $id);
            $this->db->update('users', $data);

            if ($this->input->post('is_mecanico') == '1') {
                $data_mecanico = array(
                    'nome' => $this->input->post('nome'),
                    'cpf' => $this->input->post('cpf'),
                    'email' => $this->input->post('email')
                );
                if ($this->db->where('user_id', $id)->get('mecanicos')->num_rows() > 0) {
                    $this->db->where('user_id', $id);
                    $this->db->update('mecanicos', $data_mecanico);
                } else {
                    $data_mecanico['user_id'] = $id;
                    $this->db->insert('mecanicos', $data_mecanico);
                }
            } else {
                $this->db->where('user_id', $id);
                $this->db->delete('mecanicos');
            }

            $this->db->trans_complete();

            if ($this->db->trans_status()) {
                $this->session->set_flashdata('success', 'Usuário atualizado com sucesso!');
                redirect('UsuariosController/index');
            } else {
                throw new Exception('Erro ao atualizar o usuário.');
            }
        } catch (Exception $e) {
            $this->db->trans_rollback();
            $this->session->set_flashdata('error', $e->getMessage());
            redirect('UsuariosController/index');
        }
    }

    public function delete($id) {
        $this->db->trans_start();

        try {
            // Remover o usuário da tabela mecanicos antes de excluir da tabela users
            $this->db->where('user_id', $id);
            $this->db->delete('mecanicos');

            $this->User_model->delete_usuario($id);

            $this->db->trans_complete();

            if ($this->db->trans_status()) {
                $this->session->set_flashdata('success', 'Usuário excluído com sucesso!');
                redirect('UsuariosController/index');
            } else {
                throw new Exception('Erro ao excluir o usuário.');
            }
        } catch (Exception $e) {
            $this->db->trans_rollback();
            $this->session->set_flashdata('error', $e->getMessage());
            redirect('UsuariosController/index');
        }
    }
}
