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
            
            // Calculando os valores totais
            $data['valor_total_vendas'] = $this->Venda_model->get_total_sales_value();
            $data['valor_total_servicos'] = $this->Servico_model->get_total_service_value();
            $data['faturamento_total'] = $data['valor_total_vendas'] + $data['valor_total_servicos'];
        } else {
            $data['vendedor'] = $this->User_model->get_user_by_id($user_id);
            $data['vendas'] = $this->Venda_model->get_vendas_by_vendedor($user_id);
        }

        $data['view'] = 'pages/dashboard';
        $this->load->view('layouts/main', $data);
    }

    public function filter_data() {
        $period = $this->input->post('period');
    
        if ($period == 'day') {
            $start_date = date('Y-m-d 00:00:00');
            $end_date = date('Y-m-d 23:59:59');
        } elseif ($period == 'week') {
            $start_date = date('Y-m-d 00:00:00', strtotime('-1 week'));
            $end_date = date('Y-m-d 23:59:59');
        } elseif ($period == 'month') {
            $start_date = date('Y-m-01 00:00:00');
            $end_date = date('Y-m-t 23:59:59');
        }
    
        $sales_data = $this->Venda_model->get_vendas_by_period($start_date, $end_date);
        $service_data = $this->Servico_model->get_servicos_by_period($start_date, $end_date);
    
        echo json_encode(['sales' => $sales_data, 'services' => $service_data]);
    }
    
}
?>
