<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DashboardController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Venda_model');
        $this->load->model('Material_model');
        $this->load->model('User_model');
        $this->load->model('Servico_model'); // Novo modelo para serviços
        $this->load->library('session');
        $this->load->helper('url');
        
        // Verifica se o usuário está logado
        if (!$this->session->userdata('user_id')) {
            redirect('login');
        }
    }

    public function index() {
        $user_role = $this->session->userdata('user_role');
        $user_id = $this->session->userdata('user_id');

        if ($user_role == 'admin') {
            $data['materiais'] = $this->Material_model->get_all_materials();
            $data['vendas'] = $this->Venda_model->get_all_vendas();
            $data['servicos'] = $this->Servico_model->get_all_servicos();

            // Dados para o gráfico de vendas
            $sales_data = $this->Venda_model->get_sales_data();
            $data['sales_chart_labels'] = array_column($sales_data, 'data_venda');
            $data['sales_chart_data'] = array_column($sales_data, 'preco_total');
        } else {
            $data['vendedor'] = $this->User_model->get_user_by_id($user_id);
            $data['vendas'] = $this->Venda_model->get_vendas_by_vendedor($user_id);
        }

        $data['view'] = 'pages/dashboard';
        $this->load->view('layouts/main', $data);
    }
}
?>
