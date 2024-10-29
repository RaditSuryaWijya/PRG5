<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TransaksiController extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('LaptopModel');
        $this->load->model('TransaksiModel');
    }

    public function view() {
        $data['title'] = 'Technest Marketplace';
        $data['laptop'] = $this->LaptopModel->get_all();

        // Memuat konten halaman
        $data['content'] = $this->load->view('Transaksi', $data, TRUE);

        // Memuat template
        $this->load->view('template', $data);
    }

    public function add_trs() {
        $id = $this->input->post('id_pembelian');

        $data = [
            'tipe_pembayaran' => $this->input->post('paymentType'),
            'no_rekening' => $this->input->post('norek'),
            'tgl_beli' => $this->input->post('transactionDate'),
            'total_harga' => $this->input->post('transactionTotal'),
        ];

        $detail = $this->TransaksiModel->get_detail_pembelian($id);

        try {
            $id_pembelian = $this->TransaksiModel->insert_transaksi($data, $detail);
            
            if ($id_pembelian) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Transaction saved successfully!',
                    'id_pembelian' => $id_pembelian
                ]);
            } else {
                throw new Exception('Failed to save transaction.');
            }
        } catch (Exception $e) {
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
}
