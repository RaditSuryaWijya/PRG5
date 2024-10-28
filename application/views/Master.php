<div class="container-fluid px-4">
    <h1 class="mt-4">Master</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Laptop</li>
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

        <!-- Detail Modal -->
        <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detailModalLabel">Laptop Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <img id="detailImage" src="" alt="Laptop Image" class="img-fluid mb-3">
                        <p><strong>Serie:</strong> <span id="detailSerie"></span></p>
                        <p><strong>Merk:</strong> <span id="detailMerk"></span></p>
                        <p><strong>Stok:</strong> <span id="detailStok"></span></p>
                        <p><strong>Harga:</strong> <span id="detailHarga"></span></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-table me-1"></i>
                    Available Laptop Data
                </div>
                <button onclick="toggleForm('add')" class="btn btn-sm btn-primary">
                    <i class="mdi mdi-plus"></i> Add Data
                </button>
            </div>
            <div class="card-body">
                <table id="datatablesSimple">
                    <!-- Your existing table structure -->
                    <thead>
                        <tr>
                            <th class="hidden-column">ID</th>
                            <th>No.</th>
                            <th>Serie</th>
                            <th>Merk</th>
                            <th>Stok</th>
                            <th>Harga</th>
                            <th class="hidden-column">Gambar</th> <!-- Hidden Gambar column -->
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th class="hidden-column">ID</th>
                            <th>No.</th>
                            <th>Serie</th>
                            <th>Merk</th>
                            <th>Stok</th>
                            <th>Harga</th>
                            <th class="hidden-column">Gambar</th> <!-- Hidden Gambar column -->
                            <th>Aksi</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach($laptop as $l): 
                        ?>
                        <tr>
                            <td class="hidden-column"><?= $l['id_laptop'] ?></td>
                            <td><?= $i++ ?></td>
                            <td><?= $l['seri_laptop'] ?></td>
                            <td><?= $l['merk_laptop'] ?></td>
                            <td><?= $l['stok'] ?></td>
                            <td style="text-align: right;">Rp <?= number_format($l['harga'], 0, ',', '.') ?></td>
                            <td class="hidden-column"><?= $l['gambar'] ?></td> <!-- Hidden Gambar column -->
                            <td>
                                <button onclick="editData(<?= htmlspecialchars(json_encode($l), ENT_QUOTES, 'UTF-8') ?>)" class="btn btn-sm btn-warning">
                                    <i class="mdi mdi-pencil"></i> Edit
                                </button>
                                <button onclick="showDetails(<?= htmlspecialchars(json_encode($l), ENT_QUOTES, 'UTF-8') ?>)" class="btn btn-sm btn-info">
                                    <i class="mdi mdi-eye"></i> Details
                                </button>
                                <a href="<?= base_url('index.php/MasterKontroller/delete/'.$l['id_laptop']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                    <i class="mdi mdi-delete"></i> Delete
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Add Data Form Section -->
    <div id="addDataForm" style="display: none;">
        <div class="card mb-4">
            <div class="card-header">
                <i class="mdi mdi-plus"></i> Add Laptop Data
            </div>
            <div class="card-body">
                <form id="addForm" action="<?= base_url('index.php/MasterController/add') ?>" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="seri" class="form-label">Serie</label>
                        <input type="text" class="form-control" id="seri" name="seri" required>
                    </div>
                    <div class="mb-3">
                        <label for="merk" class="form-label">Merk</label>
                        <select class="form-select" name="merk" id="merk" required>
                            <option value="">-- Pilih Merk --</option>
                            <option value="Lenovo">Lenovo</option>
                            <option value="MSI">MSI</option>
                            <option value="HP">HP</option>
                            <option value="Acer">Acer</option>
                            <option value="Asus">Asus</option>
                            <option value="Predator">Predator</option>
                            <option value="Alienware">Alienware</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="stok" class="form-label">Stok</label>
                        <input type="number" class="form-control" id="stok" name="stok" required>
                    </div>
                    <div class="mb-3">
                        <label for="harga" class="form-label">Harga</label>
                        <input type="number" class="form-control" id="harga" name="harga" required>
                    </div>
                    <div class="mb-3">
                        <label for="gambar" class="form-label">Gambar</label>
                        <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*" required>
                        <small class="form-text text-muted">Click to select an image file.</small>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" onclick="toggleForm('main')" class="btn btn-secondary">Cancel</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Data Form Section -->
    <div id="editDataForm" style="display: none;">
        <div class="card mb-4">
            <div class="card-header">
                <i class="mdi mdi-pencil"></i> Edit Laptop Data
            </div>
            <div class="card-body">
                <form id="editForm" action="<?= base_url('index.php/MasterController/editLaptop') ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" id="edit_id" name="id">
                    <div class="mb-3">
                        <label for="edit_seri" class="form-label">Serie</label>
                        <input type="text" class="form-control" id="edit_seri" name="seri" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_merk" class="form-label">Merk</label>
                        <select class="form-select" name="merk" id="edit_merk" required>
                            <option value="Lenovo">Lenovo</option>
                            <option value="MSI">MSI</option>
                            <option value="HP">HP</option>
                            <option value="Acer">Acer</option>
                            <option value="Asus">Asus</option>
                            <option value="Predator">Predator</option>
                            <option value="Alienware">Alienware</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_stok" class="form-label">Stok</label>
                        <input type="number" class="form-control" id="edit_stok" name="stok" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_harga" class="form-label">Harga</label>
                        <input type="number" class="form-control" id="edit_harga" name="harga" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_gambar" class="form-label">Gambar</label>
                        <input type="file" class="form-control" id="edit_gambar" name="gambar" accept="image/*">
                        <small class="form-text text-muted">Click to select an image file (optional).</small>
                    </div>
                    <div class="mb-3">
                        <label>Current Image:</label><br>
                        <img id="currentImage" src="" alt="Current Laptop Image" style="max-width: 150px; height: auto; display: none;">
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                    <button type="button" onclick="toggleForm('main')" class="btn btn-secondary">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleForm(section) {
        document.getElementById('mainContent').style.display = section === 'main' ? 'block' : 'none';
        document.getElementById('addDataForm').style.display = section === 'add' ? 'block' : 'none';
        document.getElementById('editDataForm').style.display = section === 'edit' ? 'block' : 'none';
    }

    function editData(data) {
        toggleForm('edit');
        document.getElementById('edit_id').value = data.id_laptop;
        document.getElementById('edit_seri').value = data.seri_laptop;
        document.getElementById('edit_merk').value = data.merk_laptop;
        document.getElementById('edit_stok').value = data.stok;
        document.getElementById('edit_harga').value = data.harga;

        // Set the image source for the current image
        const currentImage = document.getElementById('currentImage');
        if (data.gambar) {
            currentImage.src = '<?= base_url('assets/images/') ?>' + data.gambar; // Adjust the path if needed
            currentImage.style.display = 'block'; // Show the image
        } else {
            currentImage.style.display = 'none'; // Hide if no image
        }
    }

    function showDetails(data) {
        document.getElementById('detailSerie').textContent = data.seri_laptop;
        document.getElementById('detailMerk').textContent = data.merk_laptop;
        document.getElementById('detailStok').textContent = data.stok;
        document.getElementById('detailHarga').textContent = 'Rp ' + new Intl.NumberFormat().format(data.harga);

        // Set image source
        if (data.gambar) {
            document.getElementById('detailImage').src = "<?= base_url('assets/images/') ?>" + data.gambar;
        } else {
            document.getElementById('detailImage').src = ""; // Handle case when there's no image
        }

        // Show the modal
        var myModal = new bootstrap.Modal(document.getElementById('detailModal'));
        myModal.show();
    }
</script>
