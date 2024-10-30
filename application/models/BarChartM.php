<?php

class BarChartM extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function chart_database() {
        $this->db->select('l.merk_laptop, SUM(d.qty) as total_quantity');
        $this->db->from('detail d');
        $this->db->join('laptop l', 'd.id_laptop = l.id_laptop');
        $this->db->group_by('l.merk_laptop');
        $query = $this->db->get();
        return $query->result();
    }
    
}
?>