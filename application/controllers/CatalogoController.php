<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CatalogoController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Material_model');
        $this->load->library('session');
        $this->load->helper('url');
        
        // Verifica se o usuário está logado
        if (!$this->session->userdata('user_id')) {
            redirect('login');
        }
    }

    public function index() {
        $data['materiais'] = $this->Material_model->get_all_materials();
        $data['view'] = 'pages/catalogo';
        $this->load->view('layouts/main', $data);
    }

    public function adicionar_material() {
        // Apenas admin pode acessar esta função
        if ($this->session->userdata('user_role') != 'admin') {
            show_error('Você não tem permissão para acessar esta página.', 403, 'Acesso Proibido');
        }

        $this->load->view('pages/adicionar_material');
    }

    public function salvar_material() {
        // Apenas admin pode acessar esta função
        if ($this->session->userdata('user_role') != 'admin') {
            show_error('Você não tem permissão para acessar esta página.', 403, 'Acesso Proibido');
        }

        $data = array(
            'nome' => $this->input->post('nome'),
            'preco' => $this->input->post('preco'),
            'quantidade' => $this->input->post('quantidade')
        );

        $this->Material_model->add_material($data);
        redirect('catalogo');
    }

    public function entrada_material() {
        // Apenas admin pode acessar esta função
        if ($this->session->userdata('user_role') != 'admin') {
            show_error('Você não tem permissão para acessar esta página.', 403, 'Acesso Proibido');
        }

        $material_id = $this->input->post('material_id');
        $quantidade = $this->input->post('quantidade');

        $this->Material_model->update_quantity($material_id, $quantidade);
        redirect('catalogo');
    }
}
?>
