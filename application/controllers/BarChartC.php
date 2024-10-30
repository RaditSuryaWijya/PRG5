<?php

class BarChartC extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('BarChartM');
    }

    public function chart_data() {
        $this->load->model('BarChartM');
        $data['chart_data'] = $this->BarChartM->chart_database(); // Ambil data stok
        $data['detail'] = $this->db->get('detail')->result_array(); // Untuk tabel
    
        echo json_encode($data);
        // $this->load->view('dashboard', $data); // Kirim data ke view
    }
}

?>
