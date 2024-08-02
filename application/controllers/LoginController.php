<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LoginController extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('session');
        $this->load->helper('url');
    }

    public function index() {
        $this->load->view('pages/login');
    }

    public function authenticate() {
        try {
            $nome = $this->input->post('nome');
            $senha = $this->input->post('senha');
            $role = $this->input->post('role');
    
            log_message('info', 'Tentativa de login para o usuário: ' . $nome);
    
            $user = $this->User_model->get_user($nome, $role);
    
            if ($user) {
                log_message('info', 'Usuário encontrado: ' . print_r($user, true));
    
                if (password_verify($senha, $user->senha)) {
                    $this->session->set_userdata('user_id', $user->id);
                    $this->session->set_userdata('user_role', $user->tipo_usuario);
                    log_message('info', 'Login bem-sucedido para o usuário: ' . $nome);
                    echo json_encode(['success' => true]);
                } else {
                    log_message('error', 'Senha inválida para o usuário: ' . $nome);
                    echo json_encode(['success' => false, 'message' => 'Nome de usuário, senha ou permissão inválidos']);
                }
            } else {
                log_message('error', 'Usuário não encontrado: ' . $user->nome);
                echo json_encode(['success' => false, 'message' => 'Nome de usuário, senha ou permissão inválidos']);
            }
        } catch (Exception $e) {
            log_message('error', 'Erro na autenticação: ' . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'Erro ao processar a solicitação.']);
        }
    }
    

    public function logout() {
        $this->session->sess_destroy();
        redirect('login');
    }
}
