<?php

class TransaksiModel extends CI_Model{
    public function __construct(){
        parent::__construct();
        $this->load->database();
    }
    public function insert_karyawan($data){
        return $this->db->insert('laptop',$data);
    }

    public function get_all(){
        return $this->db->get('pembelian')->result_array();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where('pembelian',['id_laptop' => $id])->row_array();
    }

    public function delete_karyawan($id){
        $this->db->where('id_laptop',$id);
        return $this->db->delete('laptop');
    }

    public function update_karyawan($id, $data) {
        $this->db->where('id_laptop', $id);
        return $this->db->update('laptop', $data);
    }

    public function get_latest_id() {
        $this->db->select_max('id_laptop');
        $query = $this->db->get('laptop');
        return $query->row()->id;
    }
    public function get_detail_pembelian($id_pembelian) {
        $this->db->select('id_pembelian, id_laptop, qty, subtotal');
        $this->db->from('detail_pembelian');
        $this->db->where('id_pembelian', $id_pembelian);
        return $this->db->get()->result_array();
    }
    
}