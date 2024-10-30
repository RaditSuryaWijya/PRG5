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
            
            // 'notes' => $transaction_notes,  
            'total_harga' => $this->input->post('total_amount'), // Ensure you send total_amount from frontend
            // 'created_at' => date('Y-m-d H:i:s'),
        ];
        
        // Insert transaction and get the transaction ID
        $transaction_id = $this->Transaction_model->insert_transaction($transaction_data);
        
        // Get the transaction items from POST data
        $items = $this->input->post('items'); // Expecting items as JSON string
        
        foreach ($items as $item) {
            $detail_data = [
                'transaction_id' => $transaction_id,
                'item_id' => $item['item_id'], // Get from your item object
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'total_price' => $item['total_price'],
            ];
            // Insert each item into the transaction_details table
            $this->Transaction_model->insert_transaction_detail($detail_data);
        }
        
        // Redirect or return a response
        redirect('transaction/success'); // Change this to your desired redirection
    }
}
