<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once FCPATH . 'vendor/autoload.php'; // Pastikan path ini

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class exportExcelController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database(); // Load database
    }

    public function exportExcel() {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set judul dan header kolom
        $sheet->setTitle('Data Transaksi');
        
        // Set
        $sheet->setCellValue('A1', 'Data Transaksi NesTech');
        $sheet->mergeCells('A1:F1');
        $sheet->getStyle('A1')->getFont()->setBold(true); // Make the title bold
        $sheet->getStyle('A1')->getFont()->setSize(16); // Set font size for the title
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Center the title

        $sheet->setCellValue('A3', 'No');
        $sheet->setCellValue('B3', 'ID Penjualan');
        $sheet->setCellValue('C3', 'Tanggal Jual');
        $sheet->setCellValue('D3', 'Tipe Pembayaran');
        $sheet->setCellValue('E3', 'No Rekening');
        $sheet->setCellValue('F3', 'Total');

        // Center the text for the header row
        $sheet->getStyle('A3:F3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // Ambil data dari database
        $query = $this->db->get('Pembelian'); // Ganti 'msbuku' dengan nama tabel Anda
        $books = $query->result_array();
        $row = 4;
        $no = 1;

        // Looping data untuk mengisi sheet
        foreach ($books as $book) {
            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, $book['id_pembelian']);
            $sheet->setCellValue('C' . $row, $book['tgl_beli']);
            $sheet->setCellValue('D' . $row, $book['tipe_pembayaran']);
            $sheet->setCellValue('E' . $row, $book['no_rekening']);
            $sheet->setCellValue('F' . $row, $book['total_harga']);
            $row++;
        }

        // $sheet->getColumnDimension('F')->setAutoSize(true); // Optional: Auto size the column
        $sheet->getStyle('F4:F' . ($row))
        ->getNumberFormat()
        ->setFormatCode('_-"Rp" * #,##0.00_-;_- "Rp" * -#,##0.00_-;_- "Rp" * "-"??_-;_-@_-');

        // Auto-size columns A to F
        foreach (range('A', 'F') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        // Set header untuk download file Excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Data-Transaksi-NesTech.xlsx"');
        header('Cache-Control: max-age=0');

        // Menyimpan file Excel ke output
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}