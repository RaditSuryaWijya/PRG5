<?php

class TransaksiModel extends CI_Model{
    public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    public function insert_transaction($data){
        return $this->db->insert('pembelian',$data);
    }

    public function insert_detail($data){
        return $this->db->insert('detail',$data);
    }

    public function get_all(){
        return $this->db->get('pembelian')->result_array();
    }
}