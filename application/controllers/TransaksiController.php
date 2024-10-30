<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TransaksiController extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->model('LaptopModel');
        $this->load->model('TransaksiModel');
    }

	public function view()
	{
        $data['title'] = 'Technest Marketplace';
        $data['laptop'] = $this->LaptopModel->get_all();

        $data['content'] = $this->load->view('Transaksi', $data, TRUE);

        $this->load->view('template', $data);
	}

    public function submit() {
        // Get customer details and transaction items from POST data
        $customer_name = $this->input->post('customerName');
        $customer_email = $this->input->post('customerEmail');
        $payment_type = $this->input->post('paymentType');
        $bank_account = $this->input->post('norek') ? $this->input->post('norek') : null;
        $transaction_notes = $this->input->post('transactionNotes');
        
        // Prepare transaction data
        $transaction_data = [
            // 'customer_name' => $customer_name,
            // 'customer_email' => $customer_email,
            'tipe_pembayaran' => $payment_type,
            'no_rekening' => $bank_account,
            'tgl_beli' => date('Y-m-d'),
            // 'notes' => $transaction_notes,  
            'total_harga' => $this->input->post('total_amount'),
            // 'created_at' => date('Y-m-d H:i:s'),
        ];
        
        // Insert transaction and get the transaction ID
        $this->TransaksiModel->insert_transaction($transaction_data);
        // Get the transaction items from POST data
        $items = json_decode($this->input->post('items'), true);

        $transaction_id = $this->TransaksiModel->get_latest_id();
        
        foreach ($items as $item) {
            $detail_data = [
                'id_pembelian' => $transaction_id,
                'id_laptop' => $item['item_id'], // Get from your item object
                'qty' => $item['quantity'],
                'subtotal' => $item['total_price']
            ];
            // Insert each item into the transaction_details table
            $this->TransaksiModel->insert_detail($detail_data);
        }
        
        // Redirect or return a response
        redirect('index.php/TransaksiController/view?message=Transaksi+berhasil!');
    }
}