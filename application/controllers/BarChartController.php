<?php

class BarChartController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('BarChartModel');
    }

    public function chart_data() {
        $this->load->model('BarChartModel');
        $data['chart_data'] = $this->BarChartModel->chart_database(); // Ambil data stok
    
        echo json_encode($data);
        // $this->load->view('dashboard', $data); // Kirim data ke view
    }
}

?>
