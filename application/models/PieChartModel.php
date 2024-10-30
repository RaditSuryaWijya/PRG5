<?php

class PieChartModel extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function chart_database() {
        $this->db->select('merk_laptop, SUM(stok) as total_stok');
        $this->db->from('Laptop');
        $this->db->group_by('merk_laptop');
        $query = $this->db->get();
        return $query->result();
    }
}
?>