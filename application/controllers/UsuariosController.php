<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UsuariosController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->model('Mecanico_model');
        $this->load->library('session');
        $this->load->helper('url');
        
        // Verifica se o usuário está logado e é admin
        if (!$this->session->userdata('user_id') || $this->session->userdata('user_role') != 'admin') {
            redirect('login');
        }
    }

    public function index() {
        $data['usuarios'] = $this->User_model->get_all_users();
        $data['view'] = 'usuarios/index';
        $this->load->view('layouts/main', $data);
    }

    public function store() {
        $nome = $this->input->post('nome');
        $cpf = $this->input->post('cpf');
        $email = $this->input->post('email');
        $senha = password_hash($this->input->post('senha'), PASSWORD_BCRYPT);
        $tipo_usuario = $this->input->post('tipo_usuario');
        $is_mecanico = $this->input->post('is_mecanico') == '1' ? true : false;

        $data_user = array(
            'nome' => $nome,
            'cpf' => $cpf,
            'email' => $email,
            'senha' => $senha,
            'tipo_usuario' => $tipo_usuario
        );

        $this->db->trans_start();
        $this->db->insert('users', $data_user);
        $user_id = $this->db->insert_id();

        if ($is_mecanico) {
            $data_mecanico = array(
                'user_id' => $user_id,
                'nome' => $nome,
                'cpf' => $cpf,
                'email' => $email
            );
            $this->db->insert('mecanicos', $data_mecanico);
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->session->set_flashdata('error', 'Erro ao criar usuário.');
        } else {
            $this->session->set_flashdata('success', 'Usuário criado com sucesso.');
        }

        redirect('index.php/UsuariosController/index');
    }

    public function edit($id) {
        $data['usuario'] = $this->User_model->get_user_by_id($id);
        $this->load->view('usuarios/edit', $data);
    }

    public function update($id) {
        $nome = $this->input->post('nome');
        $cpf = $this->input->post('cpf');
        $email = $this->input->post('email');
        $tipo_usuario = $this->input->post('tipo_usuario');
        $is_mecanico = $this->input->post('is_mecanico') == '1' ? true : false;

        $data_user = array(
            'nome' => $nome,
            'cpf' => $cpf,
            'email' => $email,
            'tipo_usuario' => $tipo_usuario
        );

        $this->db->trans_start();
        $this->db->where('id', $id);
        $this->db->update('users', $data_user);

        if ($is_mecanico) {
            $data_mecanico = array(
                'user_id' => $id,
                'nome' => $nome,
                'cpf' => $cpf,
                'email' => $email
            );
            $this->db->replace('mecanicos', $data_mecanico);
        } else {
            $this->db->where('user_id', $id);
            $this->db->delete('mecanicos');
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->session->set_flashdata('error', 'Erro ao atualizar usuário.');
        } else {
            $this->session->set_flashdata('success', 'Usuário atualizado com sucesso.');
        }

        redirect('index.php/UsuariosController/index');
    }

    public function delete($id) {
        $this->db->trans_start();
        $this->db->where('id', $id);
        $this->db->delete('users');

        $this->db->where('user_id', $id);
        $this->db->delete('mecanicos');

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->session->set_flashdata('error', 'Erro ao excluir usuário.');
        } else {
            $this->session->set_flashdata('success', 'Usuário excluído com sucesso.');
        }

        redirect('index.php/UsuariosController/index');
    }

    public function logout() {
        // Destruir todas as sessões
        $this->session->sess_destroy();
        // Redirecionar para a página de login
        redirect(base_url('index.php/LoginController'));
    }
}
?>
