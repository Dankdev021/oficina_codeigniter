<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class VendasController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Venda_model');
        $this->load->model('Material_model');
        $this->load->model('User_model');
        $this->load->library('session');
        $this->load->helper(array('url', 'download'));
        
        // Verifica se o usuário está logado
        if (!$this->session->userdata('user_id')) {
            redirect('login');
        }
    }
    public function index() {
        $user_role = $this->session->userdata('user_role');
        $user_id = $this->session->userdata('user_id');

        if ($user_role == 'admin') {
            $data['vendas'] = $this->Venda_model->get_all_vendas();
        } else {
            $data['vendas'] = $this->Venda_model->get_vendas_by_usuario($user_id);
        }
        
        $data['materiais'] = $this->Material_model->get_all_materials();
        $data['view'] = 'pages/vendas';
        $this->load->view('layouts/main', $data);
    }

    public function create() {
        $cliente_nome = $this->input->post('cliente_nome');
        $preco_total = $this->input->post('preco_total');
        $itens_venda = $this->input->post('itens_venda'); // Será um array de itens de venda
        $vendedor_id = $this->session->userdata('user_id'); // Pegando o ID do vendedor logado
    
        // Validar itens de venda
        foreach ($itens_venda as $item) {
            if ($item['quantidade'] <= 0 || $item['preco_total'] <= 0) {
                $this->session->set_flashdata('error', 'Quantidade e preço não podem ser zero.');
                redirect(base_url('index.php/VendasController/index'));
                return;
            }
        }
    
        $data_venda = array(
            'cliente_nome' => $cliente_nome,
            'preco_total' => $preco_total,
            'vendedor_id' => $vendedor_id
        );
    
        $this->db->trans_start(); // Inicia uma transação
    
        $this->db->insert('vendas', $data_venda);
        $venda_id = $this->db->insert_id();
    
        foreach ($itens_venda as &$item) {
            $item['venda_id'] = $venda_id;
            // Reduzir a quantidade do material no estoque
            $this->db->set('quantidade', 'quantidade - ' . $item['quantidade'], FALSE);
            $this->db->where('id', $item['material_id']);
            $this->db->update('materials');
        }
        $this->db->insert_batch('itens_venda', $itens_venda);
    
        $this->db->trans_complete();
    
        if ($this->db->trans_status()) {
            $file_path = $this->generate_invoice($venda_id);
            // Redirecionar para a página de detalhes com o caminho do arquivo como parâmetro
            redirect(base_url('index.php/VendasController/detalhes/' . $venda_id . '?file_path=' . urlencode($file_path)));
        } else {
            show_error('Erro ao criar a venda.');
        }
    }

    private function generate_invoice($venda_id) {
        $venda = $this->Venda_model->get_venda($venda_id);
        $vendedor = $this->User_model->get_user_by_venda($venda_id);

        // Certifique-se de que o diretório downloads exista
        $dir = FCPATH . 'downloads';
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        
        $invoice = "NOTA FISCAL\n";
        $invoice .= "=======================\n";
        $invoice .= "Cliente: " . $venda[0]->cliente_nome . "\n";
        $invoice .= "Data da Venda: " . date('d/m/Y', strtotime($venda[0]->data_venda)) . "\n";
        $invoice .= "Horário da Venda: " . date('H:i:s', strtotime($venda[0]->data_venda)) . "\n";
        $invoice .= "Vendedor: " . $vendedor->nome . "\n";
        $invoice .= "-----------------------\n";
        $invoice .= "Itens Vendidos:\n";

        foreach ($venda as $item) {
            $invoice .= "Material: " . $item->material_nome . "\n";
            $invoice .= "Quantidade: " . $item->quantidade . "\n";
            $invoice .= "Preço Total: R$ " . number_format($item->preco_total, 2, ',', '.') . "\n";
            $invoice .= "-----------------------\n";
        }

        $invoice .= "Preço Total da Venda: R$ " . number_format(array_sum(array_column($venda, 'preco_total')), 2, ',', '.') . "\n";
        $invoice .= "=======================\n";

        $file_path = $dir . '/comprovante_venda_' . $venda_id . '.txt';
        file_put_contents($file_path, $invoice);
        return $file_path;
    }

    public function detalhes($id) {
        $data['venda'] = $this->Venda_model->get_venda($id);
        $data['vendedor'] = $this->User_model->get_user_by_venda($id);
        if (empty($data['venda'])) {
            show_error('Venda não encontrada');
        } else {
            $data['view'] = 'pages/detalhes_venda';
            $this->load->view('layouts/main', $data);
        }
    }
}
?>
