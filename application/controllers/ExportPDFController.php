<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ExportPDFController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database(); // Load database
        $this->load->library('fpdf'); // Load FPDF library
    }

    public function exportPDF() {
        // Create instance of FPDF
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 12);

        // Set title
        $pdf->Cell(0, 10, 'Data Transaksi NesTech', 0, 1, 'C');

        // Set column headers
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Ln();
        $pdf->Cell(10, 10, 'No', 1, 0, 'C');
        $pdf->Cell(25, 10, 'ID Transaksi', 1, 0, 'C');
        $pdf->Cell(25, 10, 'Tanggal', 1, 0, 'C');
        $pdf->Cell(45, 10, 'Tipe Pembayaran', 1, 0, 'C');
        $pdf->Cell(35, 10, 'No Rekening', 1, 0, 'C');
        $pdf->Cell(50, 10, 'Total', 1, 1, 'C');
        // $pdf->Ln();

        // Set font for data
        $pdf->SetFont('Arial', '', 10);

        // Get data from database
        $query = $this->db->get('Pembelian'); // Change 'Laptop' to your table name
        $books = $query->result_array();
        $no = 1;

        // Loop through data to fill the table
        foreach ($books as $book) {
            $pdf->Cell(10, 10, $no++, 1, 0, 'C');
            $pdf->Cell(25, 10, $book['id_pembelian'], 1);
            $pdf->Cell(25, 10, $book['tgl_beli'], 1);
            $pdf->Cell(45, 10, $book['tipe_pembayaran'], 1);
            $pdf->Cell(35, 10, $book['no_rekening'], 1, 0, 'C');
            
            // Format nomor
            $priceFormatted = number_format($book['total_harga'], 2, ',', '.');
            $space = 47 - strlen($priceFormatted);
            $pdf->Cell(
                w: 50,      // lebar total
                h: 10,       // tinggi total
                // Format teks
                txt: 'Rp' . str_pad($priceFormatted, $space, ' ', STR_PAD_LEFT),
                border: 1, 
                ln: 0,      // tidak pindah baris
                align: 'L', // rata tengah
                // fill: 1     // 1 untuk memberi warna latar belakang??
            );
            $pdf->Ln();
        }

        // Output the generated PDF to the browser
        $pdf->Output('D', 'Data-Transaksi-NesTech.pdf'); // D for download
        // $pdf->Output(); // D for download
    }
}