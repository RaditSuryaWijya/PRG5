<div class="container-fluid px-4">
    <h1 class="mt-4">Pembelian</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Data Pembelian</li>
    </ol>
    
    <!-- Main Content Section -->
    <div id="mainContent">
        <!-- Message alert -->
        <?php if (isset($message)): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= $message ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-table me-1"></i>
                    Data Pembelian
                </div>
                <div class="ms-auto"> <!-- Use ms-auto for Bootstrap 5 -->
                    <button onclick="exportToExcel()" class="btn btn-sm btn-success me-2"> <!-- Add me-2 for spacing -->
                        <i class="mdi mdi-file-excel"></i> Export to Excel
                    </button>
                    <button onclick="exportToPDF()" class="btn btn-sm btn-danger">
                        <i class="mdi mdi-file-pdf"></i> Export to PDF
                    </button>
                </div>
            </div>
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>ID Pembelian</th>
                            <th>Tipe Pembayaran</th>
                            <th>No Rekening</th>
                            <th>Tanggal Beli</th>
                            <th>Total Harga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No.</th>
                            <th>ID Pembelian</th>
                            <th>Tipe Pembayaran</th>
                            <th>No Rekening</th>
                            <th>Tanggal Beli</th>
                            <th>Total Harga</th>
                            <th>Aksi</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach($pembelian as $p): 
                        ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><?= $p['id_pembelian'] ?></td>
                            <td><?= $p['tipe_pembayaran'] ?></td>
                            <td><?= $p['no_rekening'] ?></td>
                            <td><?= $p['tgl_beli'] ?></td>
                            <td style="text-align: right;">Rp <?= number_format($p['total_harga'], 0, ',', '.') ?></td>
                            <td>
                                <button onclick="showDetails(<?= htmlspecialchars(json_encode($p), ENT_QUOTES, 'UTF-8') ?>)" class="btn btn-sm btn-info">
                                    <i class="mdi mdi-eye"></i> Details
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Detail Modal -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">Detail Pembelian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>ID Pembelian:</strong> <span id="detailIdPembelian"></span></p>
                    <p><strong>Tipe Pembayaran:</strong> <span id="detailTipePembayaran"></span></p>
                    <p><strong>No Rekening:</strong> <span id="detailNoRekening"></span></p>
                    <p><strong>Tanggal Beli:</strong> <span id="detailTglBeli"></span></p>
                    <p><strong>Total Harga:</strong> <span id="detailTotalHarga"></span></p>
                    
                    <hr>
                    <h6>Detail Item:</h6>
                    <div id="detailItems">
                        <!-- Detail items will be populated here -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function showDetails(data) {
        document.getElementById('detailIdPembelian').textContent = data.id_pembelian;
        document.getElementById('detailTipePembayaran').textContent = data.tipe_pembayaran;
        document.getElementById('detailNoRekening').textContent = data.no_rekening;
        document.getElementById('detailTglBeli').textContent = data.tgl_beli;

        // Fetch detail items from TransaksiModel
        fetch(`<?= base_url('index.php/TransaksiController/get_detail_pembelian/') ?>${data.id_pembelian}`)
            .then(response => response.json())
            .then(details => {
                const detailsContainer = document.getElementById('detailItems');
                detailsContainer.innerHTML = ''; // Clear previous content
                
                details.forEach(item => {
                    const itemDiv = document.createElement('div');
                    itemDiv.className = 'mb-2';
                    itemDiv.innerHTML = `
                        <p class="mb-1">
                            <strong>ID Pembelian:</strong> ${item.id_pembelian}<br>
                            <strong>ID Laptop:</strong> ${item.id_laptop}<br>
                            <strong>Quantity:</strong> ${item.qty}<br>
                            <strong>Subtotal:</strong> Rp ${new Intl.NumberFormat().format(item.subtotal)}
                        </p>
                    `;
                    detailsContainer.appendChild(itemDiv);
                });
            })
            .catch(error => console.error('Error:', error));

        // Show the modal
        var myModal = new bootstrap.Modal(document.getElementById('detailModal'));
        myModal.show();
    }

    
    function exportToExcel() {
         window.location.href = "<?= base_url('ExportExcelController/exportExcel') ?>";
    }

    function exportToPDF() {
        window.location.href = "<?= base_url('ExportPDFController/exportPDF') ?>";
    }
    
</script>
