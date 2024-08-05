<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Relatorio_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function gerar_relatorio($tipo_relatorio, $data_inicio, $data_fim) {
        $relatorio = '';
        if ($tipo_relatorio == 'vendas') {
            $this->db->where('data_venda >=', $data_inicio);
            $this->db->where('data_venda <=', $data_fim);
            $query = $this->db->get('vendas');
            $relatorio .= "Relatório de Vendas\n";
            $relatorio .= "=====================\n";
            foreach ($query->result() as $row) {
                $relatorio .= "Cliente: {$row->cliente_nome}\n";
                $relatorio .= "Preço Total: R$ {$row->preco_total}\n";
                $relatorio .= "Data da Venda: {$row->data_venda}\n";
                $relatorio .= "---------------------\n";
            }
        } elseif ($tipo_relatorio == 'catalogo') {
            $query = $this->db->get('materials');
            $relatorio .= "Relatório de Catálogo\n";
            $relatorio .= "=====================\n";
            foreach ($query->result() as $row) {
                $relatorio .= "Material: {$row->nome}\n";
                $relatorio .= "Quantidade: {$row->quantidade}\n";
                $relatorio .= "Preço: R$ {$row->preco}\n";
                $relatorio .= "---------------------\n";
            }
        } elseif ($tipo_relatorio == 'servicos') {
            $this->db->where('data_inicio >=', $data_inicio);
            $this->db->where('data_inicio <=', $data_fim);
            $query = $this->db->get('services');
            $relatorio .= "Relatório de Serviços\n";
            $relatorio .= "=====================\n";
            foreach ($query->result() as $row) {
                $relatorio .= "Cliente: {$row->cliente}\n";
                $relatorio .= "Descrição: {$row->descricao}\n";
                $relatorio .= "Valor da Mão de Obra: R$ {$row->valor_mao_obra}\n";
                $relatorio .= "Valor Total: R$ {$row->valor_total}\n";
                $relatorio .= "Data de Início: {$row->data_inicio}\n";
                $relatorio .= "Data de Conclusão Estimada: {$row->data_conclusao_estimada}\n";
                $relatorio .= "---------------------\n";
            }
        }
        return $relatorio;
    }
}
?>
