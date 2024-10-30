                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Core</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-doughnut me-1"></i>
                                        Jumlah Stok Laptop berdasarkan Merk
                                    </div>
                                    <div class="card-body">
                                        <canvas id="myDoughnutChart" width="100%" height="40"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-bar me-1"></i>
                                        Jumlah Penjualan Laptop berdasarkan Merk
                                    </div>
                                    <div class="card-body">
                                        <canvas id="myBarChart" width="100%" height="40"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Available Laptop Data
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Serie</th>
                                            <th>Merk</th>
                                            <th>Stok</th>
                                            <th>Harga</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>No.</th>
                                            <th>Serie</th>
                                            <th>Merk</th>
                                            <th>Stok</th>
                                            <th>Harga</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php
                                        $i = 1; 
                                        foreach($laptop as $l) : 
                                        ?>
                                        <tr>
                                            <td><?= $i++ ?></td>
                                            <td><?= $l['seri_laptop'] ?></td>
                                            <td><?= $l['merk_laptop'] ?></td>
                                            <td><?= $l['stok'] ?></td>
                                            <td style="text-align: right;">Rp <?= number_format($l['harga'], 0, ',', '.') ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.min.js"></script>

                    <script>
                        const baseUrl = "<?php echo base_url(); ?>";

                        // Fungsi untuk menampilkan Bar Chart menggunakan data dari AJAX
                        const loadBarChart = (chartId) => {
                            $.ajax({
                                url: baseUrl + 'BarChartController/chart_data',
                                dataType: 'json',
                                method: 'GET',
                                success: response => {
                                    const labels = response.chart_data.map(item => item.merk_laptop);
                                    const data = response.chart_data.map(item => item.total_quantity);

                                    const ctx = document.getElementById(chartId).getContext('2d');
                                    new Chart(ctx, {
                                        type: 'bar',
                                        data: {
                                            labels: labels,
                                            datasets: [{
                                                label: 'Penjualan Laptop Berdasarkan Merk',
                                                data: data,
                                                backgroundColor: [
                                                    'rgba(75, 192, 192, 0.6)',
                                                    'rgba(54, 162, 235, 0.6)',
                                                    'rgba(255, 206, 86, 0.6)',
                                                    'rgba(255, 99, 132, 0.6)',
                                                    'rgba(153, 102, 255, 0.6)'
                                                ],
                                                borderColor: [
                                                    'rgba(75, 192, 192, 1)',
                                                    'rgba(54, 162, 235, 1)',
                                                    'rgba(255, 206, 86, 1)',
                                                    'rgba(255, 99, 132, 1)',
                                                    'rgba(153, 102, 255, 1)'
                                                ],
                                                borderWidth: 1
                                            }]
                                        },
                                        options: {
                                            responsive: true,
                                            plugins: {
                                                legend: {
                                                    position: 'top'
                                                },
                                                title: {
                                                    display: true,
                                                    text: 'Penjualan Laptop Berdasarkan Merk'
                                                }
                                            },
                                            scales: {
                                                y: {
                                                    beginAtZero: true
                                                }
                                            }
                                        }
                                    });
                                },
                                error: err => {
                                    console.error('Error fetching chart data:', err);
                                }
                            });
                        };

                        const loadDoughnutChart = (chartId) => {
                            $.ajax({
                                url: baseUrl + 'PieChartController/chart_data', 
                                dataType: 'json',
                                method: 'GET', 
                                success: response => {
                                    let chartX = [];
                                    let chartY = [];

                                    // Process the data correctly
                                    response.chart_data.forEach(item => {
                                        chartX.push(item.merk_laptop);
                                        chartY.push(item.total_stok);
                                    });

                                    const chartData = {
                                        labels: chartX, 
                                        datasets: [{
                                            label: 'Laptop Stock by Brand', 
                                            data: chartY, 
                                            backgroundColor: [
                                                'rgba(255, 99, 132, 0.6)',
                                                'rgba(54, 162, 235, 0.6)',
                                                'rgba(255, 206, 86, 0.6)',
                                                'rgba(75, 192, 192, 0.6)',
                                                'rgba(153, 102, 255, 0.6)'
                                            ],
                                            borderColor: [
                                                'rgba(255, 99, 132, 1)',
                                                'rgba(54, 162, 235, 1)',
                                                'rgba(255, 206, 86, 1)',
                                                'rgba(75, 192, 192, 1)',
                                                'rgba(153, 102, 255, 1)'
                                            ],
                                            borderWidth: 1
                                        }]
                                    };

                                    const ctx = document.getElementById(chartId).getContext('2d');
                                    const config = {
                                        type: 'doughnut', // Tipe chart
                                        data: chartData,
                                        options: {
                                            responsive: true,
                                            // animation: {
                                            //     duration: 1000, // Durasi animasi
                                            //     easing: 'easeInOutBounce' // Jenis easing
                                            // },
                                            plugins: {
                                                legend: {
                                                    position: 'top', // Posisi legenda
                                                },
                                                title: {
                                                    display: true,
                                                    text: 'Laptop Stock by Brand', // Judul chart
                                                    font: {
                                                        size: 20 // Ukuran font judul
                                                    }
                                                },
                                                tooltip: {
                                                    callbacks: {
                                                        label: function(tooltipItem) {
                                                            return tooltipItem.label + ': '     + tooltipItem.raw; // Menampilkan label dan data
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    };

                                    new Chart(ctx, config);
                                },
                                error: err => {
                                    console.error('Error fetching chart data:', err);
                                }
                            });
                        };

                        // Call the function with the correct chart ID
                        loadDoughnutChart('myDoughnutChart');

                        // Panggil fungsi untuk menampilkan chart
                        loadBarChart('myBarChart');
                    </script>