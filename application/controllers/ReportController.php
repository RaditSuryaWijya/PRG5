<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ReportController extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->model('TransaksiModel');
    }

    public function main_page($title,$message=null){
        $data['title'] = $title;
        $data['message'] = $message;
        $data['pembelian'] = $this->TransaksiModel->get_all();

        $data['content'] = $this->load->view('pembelian', $data, TRUE);

        $this->load->view('template', $data);
    }


	public function view()
	{
        $message = $this->input->get('message') ? $this->input->get('message') : null;
        $this->main_page('Report Transaksi',$message);
	}
         
}
