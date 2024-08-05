<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CatalogoController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Material_model');
        $this->load->library('session');
        $this->load->helper('url');
        
        if (!$this->session->userdata('user_id')) {
            redirect('login');
        }
    }

    public function index() {
        $data['materiais_ativos'] = $this->Material_model->get_all_materials('ativo');
        $data['materiais_inativos'] = $this->Material_model->get_all_materials('inativo');
        $data['view'] = 'pages/catalogo';
        $this->load->view('layouts/main', $data);
    }

    public function adicionar_material() {
        if ($this->session->userdata('user_role') != 'admin') {
            show_error('Você não tem permissão para acessar esta página.', 403, 'Acesso Proibido');
        }

        $this->load->view('pages/adicionar_material');
    }

    public function salvar_material() {
        if ($this->session->userdata('user_role') != 'admin') {
            show_error('Você não tem permissão para acessar esta página.', 403, 'Acesso Proibido');
        }

        $data = array(
            'nome' => $this->input->post('nome'),
            'preco' => $this->input->post('preco'),
            'quantidade' => $this->input->post('quantidade')
        );

        $this->Material_model->add_material($data);
        $this->session->set_flashdata('success', 'Material salvo com sucesso!');
        redirect(base_url('index.php/CatalogoController/index'));
    }

    public function entrada_material() {
        if ($this->session->userdata('user_role') != 'admin') {
            show_error('Você não tem permissão para acessar esta página.', 403, 'Acesso Proibido');
        }

        $material_id = $this->input->post('material_id');
        $quantidade = $this->input->post('quantidade');

        $this->Material_model->update_quantity($material_id, $quantidade);
        redirect('catalogo');
    }

    public function inactivate($id) {
        if ($this->session->userdata('user_role') != 'admin') {
            show_error('Você não tem permissão para acessar esta página.', 403, 'Acesso Proibido');
        }

        $this->Material_model->inactivate_material($id);
        $this->session->set_flashdata('success', 'Material inativado com sucesso!');
        redirect(base_url('index.php/CatalogoController/index'));
    }

    public function activate($id) {
        if ($this->session->userdata('user_role') != 'admin') {
            show_error('Você não tem permissão para acessar esta página.', 403, 'Acesso Proibido');
        }

        $this->Material_model->activate_material($id);
        $this->session->set_flashdata('success', 'Material ativado com sucesso!');
        redirect(base_url('index.php/CatalogoController/index'));
    }
}
?>
