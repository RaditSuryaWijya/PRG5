<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MasterController extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->model('LaptopModel');
    }

    public function main_page($title,$message=null){
        $data['title'] = $title;
        $data['message'] = $message;
        $data['laptop'] = $this->LaptopModel->get_all();

        $data['content'] = $this->load->view('master', $data, TRUE);

        $this->load->view('template', $data);
    }

	public function view()
	{
        $message = $this->input->get('message') ? $this->input->get('message') : null;
        $this->main_page('Master Laptop',$message);
	}

    public function add(){
        $data = [
            'seri_laptop' => $this->input->post('seri'),
            'merk_laptop' => $this->input->post('merk'),
            'stok' => $this->input->post('stok'),
            'harga' => $this->input->post('harga')
        ];

        $this->LaptopModel->insert_laptop($data);

        redirect('index.php/MasterController/view?message=Data+berhasil+disimpan!');
    }
}
