<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RelatoriosController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Relatorio_model');
        $this->load->library('session');
        $this->load->helper(array('url', 'download'));
        
        if (!$this->session->userdata('user_id')) {
            redirect('login');
        }
    }

    public function index() {
        $data['view'] = 'pages/relatorios';
        $this->load->view('layouts/main', $data);
    }

    public function gerar_relatorio() {
        $tipo_relatorio = $this->input->post('tipo_relatorio');
        $data_inicio = $this->input->post('data_inicio');
        $data_fim = $this->input->post('data_fim');
        
        $relatorio = $this->Relatorio_model->gerar_relatorio($tipo_relatorio, $data_inicio, $data_fim);
        
        $file_name = "relatorio_{$tipo_relatorio}_" . date('YmdHis') . ".txt";
        $file_path = FCPATH . 'downloads/' . $file_name;
        
        if (!is_dir(FCPATH . 'downloads')) {
            mkdir(FCPATH . 'downloads', 0755, true);
        }
        
        file_put_contents($file_path, $relatorio);
        $this->session->set_flashdata('relatorio_sucesso', 'Relatório gerado com sucesso!');
        force_download($file_path, NULL);
    }
}
?>
