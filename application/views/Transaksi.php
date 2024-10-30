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
      /* Style for Background Container */
    .transaction-background {
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        max-width: 600px;
        margin: 0 auto;
    }

    .transaction-form h2 {
        color: #333;
    }

    .transaction-form input, .transaction-form select, .transaction-form textarea {
        margin-bottom: 15px;
    }

    .transaction-table {
        margin-bottom: 20px;
    }
</style>

<div class="container mt-5">
    <?php if (isset($message)): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $message ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>
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
        <?php foreach ($laptop as $l): ?>
            <div class="col-md-4 col-sm-6 col-xs-12 laptop-card" data-title="<?= htmlspecialchars($l['seri_laptop']) ?>" data-brand="<?= htmlspecialchars($l['merk_laptop']) ?>" data-price="<?= $l['harga'] ?>">
                <div class="card shadow-sm mb-4" data-id="<?= $l['id_laptop'] ?>" data-stock="<?= $l['stok'] ?>" style="border-radius: 10px; overflow: hidden;">
                    <div class="card-img-container" style="width: 100%; height: 200px; overflow: hidden; background-color: #f5f5f5;">
                        <img src="<?= base_url('assets/images/' . $l['gambar']) ?>" class="card-img-top" alt="<?= htmlspecialchars($l['seri_laptop']) ?>" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div class="card-body text-center">
                        <h5 class="card-title mb-1"><?= htmlspecialchars($l['seri_laptop']) ?></h5>
                        <p class="card-text text-muted small">Brand: <?= htmlspecialchars($l['merk_laptop']) ?></p>
                        <p class="card-text"><small>Stock: <span class="stock"><?= htmlspecialchars($l['stok']) ?></span></small></p>
                        <p class="card-text price text-primary fw-bold">Rp <?= number_format($l['harga'], 0, ',', '.') ?></p>
                        <div class="input-group qty-group mx-auto" style="width: 100px;">
                            <button class="btn btn-sm btn-outline-secondary qty-btn" onclick="updateQty(this, -1)">-</button>
                            <input type="number" class="form-control form-control-sm qty-input text-center" value="0" min="0" max="<?= $l['stok'] ?>" readonly style="width: 40px; padding: 0;">
                            <button class="btn btn-sm btn-outline-secondary qty-btn" onclick="updateQty(this, 1)">+</button>
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

    <div class="transaction-background" id="transactionForm" style="display: none;">
        <form id="transactionFormElement" method="post" action="<?= base_url('index.php/TransaksiController/submit') ?>">
            <div class="transaction-form">
                <h2 class="text-center mb-4">Transaction Details</h2>
                
                <!-- Listed Items Table -->
                <table class="table table-bordered transaction-table">
                    <thead>
                        <tr>
                            <th scope="col" style="display: none;">Item ID</th> <!-- Hidden Item ID column -->
                            <th scope="col">Item</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Unit Price</th>
                            <th scope="col">Total Price</th>
                        </tr>
                    </thead>
                    <tbody id="transactionItems">
                        <!-- Item rows will be added dynamically with hidden item ID column -->
                    </tbody>
                </table>

                <!-- Customer Information -->
                <div class="mb-3">
                    <label for="customerName" class="form-label">Customer Name</label>
                    <input type="text" class="form-control" id="customerName" name="customerName" placeholder="Enter your name" required>
                </div>
                <div class="mb-3">
                    <label for="customerEmail" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="customerEmail" name="customerEmail" placeholder="Enter your email" required>
                </div>

                <!-- Payment Information -->
                <div class="mb-3">
                    <label for="paymentType" class="form-label">Payment Type</label>
                    <select class="form-select" id="paymentType" name="paymentType" required>
                        <option selected disabled>Select payment type</option>
                        <option value="Bank Transfer">Bank Transfer</option>
                        <option value="Cash on Delivery">Cash on Delivery</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="norek" class="form-label">Bank Account</label>
                    <input type="number" class="form-control" id="norek" name="norek" placeholder="Enter your bank account" required>
                </div>
                <div class="mb-3">
                    <label for="transactionNotes" class="form-label">Notes</label>
                    <textarea class="form-control" id="transactionNotes" name="transactionNotes" rows="3" placeholder="Additional notes" required></textarea>
                </div>

                <!-- Total Amount -->
                <div class="mb-3">
                    <h5>Total: Rp <span id="transactionTotal"> 0</span></h5>
                    <input type="hidden" name="total_amount" id="total_amount">
                </div>

                <!-- Confirm Button -->
                <button type="submit" class="btn btn-success w-100">Confirm Purchase</button>
                <button type="button" class="btn btn-secondary w-100 mt-2" onclick="toggleTransactionForm()">Cancel</button>
            </div>
        </form>
    </div>
    <hr>
</div>

<script>
    document.getElementById('paymentType').addEventListener('change', function() {
        const norekField = document.getElementById('norek');
        
        if (this.value === 'Cash on Delivery') {
            norekField.disabled = true;
            norekField.value = ''; // Clear the field when disabled
        } else {
            norekField.disabled = false;
        }
    });

    function toggleTransactionForm() {
        const form = document.getElementById('transactionForm');
        const products = document.getElementById('productCards');
        const searchBar = document.querySelector('.mb-4.row');

        if (form.style.display === 'none' || form.style.display === '') {
            form.style.display = 'block';
            products.style.display = 'none';
            searchBar.style.display = 'none';
            loadTransactionItems();
        } else {
            form.style.display = 'none';
            products.style.display = 'flex';
            searchBar.style.display = 'flex';
        }
    }

    function loadTransactionItems() {
        const items = document.querySelectorAll('.qty-input');
        const transactionItems = document.getElementById('transactionItems');
        transactionItems.innerHTML = ''; // Clear previous items
        let total = 0;
        let itemArray = []; // Array to hold item data for submission

        items.forEach(input => {
            const quantity = parseInt(input.value, 10) || 0;
            if (quantity > 0) {
                const card = input.closest('.card');
                const title = card.querySelector('.card-title').textContent;
                const price = parseInt(card.querySelector('.price').textContent.replace('Rp ', '').replace(/\./g, ''));
                const itemTotal = quantity * price;
                total += itemTotal;

                // Get the item ID
                const itemId = card.getAttribute('data-id');

                // Create a new row for each item with hidden ID column
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td style="display: none;">${itemId}</td> <!-- Hidden ID column -->
                    <td>${title}</td>
                    <td>${quantity}</td>
                    <td>Rp ${price.toLocaleString('id-ID')}</td>
                    <td>Rp ${itemTotal.toLocaleString('id-ID')}</td>
                `;
                transactionItems.appendChild(row);

                // Push item data to the array
                itemArray.push({
                    item_id: itemId,
                    quantity: quantity,
                    total_price: itemTotal
                });
            }
        });

        // Update total amount
        document.getElementById('transactionTotal').textContent = `${total.toLocaleString('id-ID')}`;
        document.getElementById('total_amount').value = total;

        // Store the items array in a hidden input field to send with the form
        const itemsInput = document.createElement('input');
        itemsInput.type = 'hidden';
        itemsInput.name = 'items';
        itemsInput.value = JSON.stringify(itemArray); // Convert to JSON
        document.getElementById('transactionFormElement').appendChild(itemsInput);
    }

    function updateQty(button, change) {
        const input = button.parentElement.querySelector('.qty-input');
        const stock = parseInt(button.closest('.card').getAttribute('data-stock'), 10);
        let quantity = parseInt(input.value, 10) || 0;

        // Adjust quantity based on button clicked (+ or -)
        quantity += change;

        // Prevent quantity from going below 0 or above stock
        if (quantity < 0) quantity = 0;
        if (quantity > stock) quantity = stock;

        input.value = quantity;

        // Check the stock to disable/enable the plus button
        const minusButton = button.parentElement.querySelector('.qty-btn:nth-child(1)');
        const plusButton = button.parentElement.querySelector('.qty-btn:nth-child(3)');

        if (quantity >= stock) {
            plusButton.disabled = true;
        } else {
            plusButton.disabled = false;
        }

        if (quantity <= 0) {
            minusButton.disabled = true;
        } else {
            minusButton.disabled = false;
        }

        updateFloatingCart();
    }

    function updateFloatingCart() {
        let totalItems = 0;
        document.querySelectorAll('.qty-input').forEach(input => {
            totalItems += parseInt(input.value, 10) || 0;
        });
        
        const cartText = document.getElementById('floatingCartText');
        cartText.textContent = `Items (${totalItems})`;

        // Show or hide the cart button based on the number of items
        const floatingCartBtn = document.getElementById('floatingCartBtn');
        floatingCartBtn.style.display = totalItems > 0 ? 'block' : 'none';
    }

    // Initialize disable state for minus button at zero quantity
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll('.qty-input').forEach(input => {
            const minusButton = input.parentElement.querySelector('.qty-btn:nth-child(1)');
            minusButton.disabled = true;
        });
    });

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
