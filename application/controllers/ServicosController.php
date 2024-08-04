<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ServicosController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Servico_model');
        $this->load->model('Material_model');
        $this->load->model('Mecanico_model');
        $this->load->library('session');
        $this->load->helper('url');
        
        if (!$this->session->userdata('user_id')) {
            redirect('login');
        }
    }

    public function index() {
        $data['servicos'] = $this->Servico_model->get_all_servicos();
        $data['materiais'] = $this->Material_model->get_all_materials();
        $data['mecanicos'] = $this->Mecanico_model->get_all_mecanicos();
        $data['view'] = 'pages/servicos';
        $this->load->view('layouts/main', $data);
    }

    public function create() {
        $cliente = $this->input->post('cliente');
        $descricao = $this->input->post('descricao');
        $data_inicio = $this->input->post('data_inicio');
        $data_conclusao_estimada = $this->input->post('data_conclusao_estimada');
        $mecanico_id = $this->input->post('mecanico_id');
        $valor_mao_obra = $this->input->post('valor_mao_obra');
        $materiais = json_decode($this->input->post('materiais'), true);

        // Verifique se $materiais é um array
        if (!is_array($materiais)) {
            $materiais = [];
        }

        $valor_total_materiais = array_reduce($materiais, function($acc, $material) {
            return $acc + $material['price'];
        }, 0);

        $valor_total = $valor_mao_obra + $valor_total_materiais;

        $data_servico = array(
            'cliente' => $cliente,
            'descricao' => $descricao,
            'data_inicio' => $data_inicio,
            'data_conclusao_estimada' => $data_conclusao_estimada,
            'mecanico_id' => $mecanico_id,
            'valor_mao_obra' => $valor_mao_obra,
            'valor_total' => $valor_total
        );

        $this->db->trans_start();

        $this->db->insert('services', $data_servico);
        $servico_id = $this->db->insert_id();

        foreach ($materiais as $material) {
            $data_item_servico = array(
                'servico_id' => $servico_id,
                'material_id' => $material['id'],
                'quantidade' => $material['quantity'],
                'preco_total' => $material['price']
            );
            $this->db->insert('itens_servico', $data_item_servico);
        }

        $this->db->trans_complete();

        if ($this->db->trans_status()) {
            redirect(base_url('index.php/ServicosController/index'));
        } else {
            show_error('Erro ao criar o serviço.');
        }
    }
}
?>
