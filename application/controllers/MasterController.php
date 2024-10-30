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

    public function add() {
        // Load the file upload library
        $this->load->library('upload');
    
        // Set upload configuration
        $config['upload_path'] = './assets/images/'; // Path to save uploaded images
        $config['allowed_types'] = 'jpg|jpeg|png|gif'; // Allowed file types
        $config['max_size'] = 2048; // Max file size in KB (2 MB)
    
        // Initialize the upload library with the config
        $this->upload->initialize($config);
    
        // Check if the file was uploaded
        if ($this->upload->do_upload('gambar')) {
            // Get uploaded file data
            $upload_data = $this->upload->data();
            
            // Get the latest ID from the database
            $this->db->select_max('id_laptop'); // Assuming 'id_laptop' is your primary key
            $query = $this->db->get('laptop'); // Get the max id from the laptop table
            $latest_id = $query->row()->id_laptop; // Get the latest id
            $new_id = $latest_id ? $latest_id + 1 : 1; // Increment or set to 1 if there are no records
    
            // Generate new unique image name
            $new_image_name = 'IMG_DATA_' . $new_id . $upload_data['file_ext']; // e.g., IMG_DATA_1.jpg
    
            // Rename the uploaded file
            rename('./assets/images/' . $upload_data['file_name'], './assets/images/' . $new_image_name);
    
            // Prepare data for the database (including the image name)
            $data = [
                'seri_laptop' => $this->input->post('seri'),
                'merk_laptop' => $this->input->post('merk'),
                'stok' => $this->input->post('stok'),
                'harga' => $this->input->post('harga'),
                'gambar' => $new_image_name, // Set the new image name
                'status' => 1 // Assuming status is always 1 for new entries
            ];
    
            // Insert data into the database
            $this->LaptopModel->insert_laptop($data);
    
            // Redirect with success message
            redirect('index.php/MasterController/view?message=Data+berhasil+disimpan!');
        } else {
            // Handle the error and redirect back with an error message
            $error = $this->upload->display_errors();
            redirect('index.php/MasterController/view?message=' . urlencode($error));
        }
    }  
    public function editLaptop() {
        // Ambil data dari form
        $id = $this->input->post('id');
        $seri = $this->input->post('seri'); 
        $merk = $this->input->post('merk'); 
        $stok = $this->input->post('stok');
        $harga = $this->input->post('harga'); 
        $currentImage = $this->input->post('currentImage'); // Nama gambar saat ini
    
        $gambar = $currentImage; // Default gambar adalah gambar lama
    
        // Cek apakah ada file gambar yang di-upload
        if (!empty($_FILES['gambar']['name'])) {
            $this->load->library('upload');
    
            // Konfigurasi upload
            $config['upload_path'] = './assets/images/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['max_size'] = 2048; // Maksimum ukuran 2MB
            $config['file_name'] = time() . '_' . $_FILES['gambar']['name']; // Nama unik
    
            $this->upload->initialize($config);
    
            // Proses upload
            if ($this->upload->do_upload('gambar')) {
                // Ambil nama file baru
                $gambar = $this->upload->data('file_name');
    
                // Opsional: Hapus gambar lama jika ada dan berbeda dari default
                if ($currentImage && file_exists('./assets/images/' . $currentImage)) {
                    unlink('./assets/images/' . $currentImage);
                }
            } else {
                // Jika gagal upload, tampilkan pesan error
                $error = $this->upload->display_errors();
                redirect('index.php/MasterController/view?message=' . urlencode($error));
                return; // Stop eksekusi
            }
        }
    
        // Siapkan data untuk di-update
        $data = [
            'seri_laptop' => $seri,
            'merk_laptop' => $merk,
            'stok' => $stok,
            'harga' => $harga,
            'gambar' => $gambar
        ];
    
        // Update data di database
        $this->LaptopModel->update_laptop($id, $data);
    
        // Redirect dengan pesan sukses
        redirect('index.php/MasterController/view?message=Data+berhasil+diupdate!');
    }
         
}
