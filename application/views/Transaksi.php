<style>
    .form-control, .form-select {
        border-radius: 0.375rem; /* Adjust border radius to match */
    }

    .input-group-text {
        border-radius: 0.375rem 0 0 0.375rem; /* Match border radius */
    }

    .dropdown-menu {
        background-color: #007bff; /* Bootstrap primary blue */
    }

    .dropdown-item {
        color: white; /* White text for dropdown items */
    }

    .dropdown-item:hover {
        background-color: #0056b3; /* Darker blue on hover */
    }

    .laptop-card {
        margin-bottom: 30px; /* Margin at the bottom for spacing */
    }

    .card-img-top {
        width: 100%; /* Make images responsive */
        height: auto; /* Maintain aspect ratio */
    }
</style>

<div class="container mt-5">
    <h1 class="text-center mb-4">Laptop Marketplace</h1>
    
    <!-- Search Bar and Filter -->
    <div class="mb-4 row align-items-center">
        <div class="col-md-12">
            <div class="input-group">
                <input type="text" id="searchInput" class="form-control" placeholder="Search for laptops..." onkeyup="applyFilters()">
                <div class="input-group-append">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="bi bi-filter"></i> Filter
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="filterDropdown">
                        <li><a class="dropdown-item" href="#" onclick="applyFilter('')">All Brand</a></li>
                        <li><a class="dropdown-item" href="#" onclick="applyFilter('lenovo')">Lenovo</a></li>
                        <li><a class="dropdown-item" href="#" onclick="applyFilter('msi')">MSI</a></li>
                        <li><a class="dropdown-item" href="#" onclick="applyFilter('hp')">HP</a></li>
                        <li><a class="dropdown-item" href="#" onclick="applyFilter('acer')">Acer</a></li>
                        <li><a class="dropdown-item" href="#" onclick="applyFilter('asus')">Asus</a></li>
                        <li><a class="dropdown-item" href="#" onclick="applyFilter('predator')">Predator</a></li>
                        <li><a class="dropdown-item" href="#" onclick="applyFilter('alienware')">Alienware</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- First Content: Laptop Cards -->
    <div class="row" id="productCards">
        <?php foreach($laptop as $l): ?>
            <div class="col-md-4 col-sm-6 col-xs-12 laptop-card" data-title="<?= htmlspecialchars($l['seri_laptop']) ?>" data-brand="<?= htmlspecialchars($l['merk_laptop']) ?>" data-price="<?= $l['harga'] ?>">
                <div class="card" data-id="<?= $l['id_laptop'] ?>" data-stock="<?= $l['stok'] ?>">
                    <img src="<?= base_url('assets/images/' . $l['gambar']) ?>" class="card-img-top" alt="<?= htmlspecialchars($l['seri_laptop']) ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($l['seri_laptop']) ?></h5>
                        <p class="card-text">Merk: <?= htmlspecialchars($l['merk_laptop']) ?></p>
                        <p class="card-text">Stok: <span class="stock"><?= htmlspecialchars($l['stok']) ?></span></p>
                        <p class="card-text price">Rp <?= number_format($l['harga'], 0, ',', '.') ?></p>
                        <div class="input-group">
                            <button class="btn btn-outline-secondary qty-btn" onclick="updateQty(this, -1)">-</button>
                            <input type="number" class="form-control qty-input" value="0" min="0" max="<?= $l['stok'] ?>" readonly>
                            <button class="btn btn-outline-secondary qty-btn" onclick="updateQty(this, 1)">+</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- No Results Message -->
    <div id="noResultsMessage" class="text-center" style="display: none; margin-top: 20px;">
        <h5>No laptops available matching your search.</h5>
    </div>

    <!-- Chart Button -->
    <button id="floatingCartBtn" class="btn btn-primary" style="position: fixed; bottom: 30px; right: 30px; display: none;" onclick="toggleTransactionForm()">
        <i class="bi bi-cart"></i> <span id="floatingCartText">Items (0)</span>
    </button>
</div>

<script>
    function applyFilters() {
        const searchInput = document.getElementById('searchInput').value.toLowerCase();
        const laptops = document.querySelectorAll('.laptop-card');
        let hasResults = false;

        laptops.forEach(laptop => {
            const title = laptop.getAttribute('data-title').toLowerCase();
            const brand = laptop.getAttribute('data-brand').toLowerCase();

            // Check if the title or brand includes the search input
            if (title.includes(searchInput) || brand.includes(searchInput)) {
                laptop.style.display = 'block';
                hasResults = true; // Found at least one match
            } else {
                laptop.style.display = 'none';
            }
        });

        // Show or hide the no results message
        const noResultsMessage = document.getElementById('noResultsMessage');
        noResultsMessage.style.display = hasResults ? 'none' : 'block';
    }

    function applyFilter(brand) {
        const laptops = document.querySelectorAll('.laptop-card');
        let hasResults = false;

        laptops.forEach(laptop => {
            const laptopBrand = laptop.getAttribute('data-brand').toLowerCase();
            if (brand === '' || laptopBrand === brand) {
                laptop.style.display = 'block';
                hasResults = true; // Found at least one match
            } else {
                laptop.style.display = 'none';
            }
        });

        // Show or hide the no results message
        const noResultsMessage = document.getElementById('noResultsMessage');
        noResultsMessage.style.display = hasResults ? 'none' : 'block';
    }
</script>
