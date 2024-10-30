<?php

class PieChartController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('PieChartModel');
    }

    public function chart_data() {
        $this->load->model('PieChartModel');
        $data['chart_data'] = $this->PieChartModel->chart_database(); // Ambil data stok
    
        echo json_encode($data);
        // $this->load->view('dashboard', $data); // Kirim data ke view
    }
}

?>
