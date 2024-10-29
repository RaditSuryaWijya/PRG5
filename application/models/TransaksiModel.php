<?php

class TransaksiModel extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function insert_transaksi($data, $detail) {
        $this->db->insert('pembelian', $data);
        $id_pembelian = $this->db->insert_id(); 

        if (!empty($detail)) {
            foreach ($detail as $item) {
                $detail_data = [
                    'id_pembelian' => $id_pembelian,
                    'id_laptop' => $item['id_laptop'],
                    'qty' => $item['qty'],
                    'subtotal' => $item['subtotal']
                ];
                $this->db->insert('detail', $detail_data);
            }
        }
        
        return $id_pembelian; 
    }

    public function get_all() {
        return $this->db->get('pembelian')->result_array();
    }

    public function get_by_id($id) {
        return $this->db->get_where('pembelian', ['id_pembelian' => $id])->row_array();
    }

    public function get_latest_id() {
        $this->db->select_max('id_pembelian');
        $query = $this->db->get('pembelian');
        return $query->row()->id_pembelian;
    }

    public function get_detail_pembelian($id_pembelian) {
        $this->db->select('id_pembelian, id_laptop, qty, subtotal');
        $this->db->from('detail');
        $this->db->where('id_pembelian', $id_pembelian);
        return $this->db->get()->result_array();
    }
}
