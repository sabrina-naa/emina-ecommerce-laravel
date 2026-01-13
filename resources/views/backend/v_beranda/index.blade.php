@extends('backend.v_layouts.app')
@section('content')
    <style>
        .stat-card {
            border-radius: 15px;
            padding: 20px;
            color: white;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }
        
        .stat-card.blue {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .stat-card.green {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }
        
        .stat-card.orange {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }
        
        .stat-card.purple {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        }
        
        .stat-icon {
            font-size: 48px;
            opacity: 0.8;
        }
        
        .stat-number {
            font-size: 36px;
            font-weight: bold;
            margin: 10px 0;
        }
        
        .stat-label {
            font-size: 16px;
            opacity: 0.9;
        }
        
        .chart-container {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        
        .chart-title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #333;
        }
        
        .welcome-banner {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 30px;
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }
        
        .welcome-banner h2 {
            margin: 0;
            font-size: 32px;
            font-weight: bold;
        }
        
        .welcome-banner p {
            margin: 10px 0 0 0;
            opacity: 0.9;
        }
    </style>

    <!-- Welcome Banner -->
    <div class="welcome-banner">
        <h2>Selamat Datang di Dashboard Emina Beauty, {{ auth()->guard('admin')->check() ? auth()->guard('admin')->user()->nama : 'Admin' }} !!!</h2>
        <p>Kelola data toko Anda dengan mudah dan pantau performa penjualan</p>
    </div>

    <!-- Stat Cards -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="stat-card blue">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-label">Total User</div>
                        <div class="stat-number">{{ $totalUser }}</div>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-3">
            <div class="stat-card green">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-label">Total Kategori</div>
                        <div class="stat-number">{{ $totalKategori }}</div>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-tags"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-3">
            <div class="stat-card orange">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-label">Total Produk</div>
                        <div class="stat-number">{{ $totalProduk }}</div>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-box"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-3">
            <div class="stat-card purple">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-label">Penjualan Bulan Ini</div>
                        <div class="stat-number">Rp 15.5M</div>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="row">
        <!-- Grafik Penjualan Bulanan -->
        <div class="col-md-8 mb-4">
            <div class="chart-container">
                <div class="chart-title">
                    <i class="fas fa-chart-bar text-primary"></i> Grafik Penjualan Produk 2025
                </div>
                <canvas id="salesChart" height="80"></canvas>
            </div>
        </div>
        
        <!-- Grafik Kategori Produk -->
        <div class="col-md-4 mb-4">
            <div class="chart-container">
                <div class="chart-title">
                    <i class="fas fa-chart-pie text-success"></i> Distribusi Kategori
                </div>
                <canvas id="categoryChart" height="160"></canvas>
            </div>
        </div>
    </div>

    <!-- Produk Terlaris & Stok Menipis -->
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="chart-container">
                <div class="chart-title">
                    <i class="fas fa-fire text-danger"></i> Top 5 Produk Terlaris
                </div>
                <canvas id="topProductsChart" height="120"></canvas>
            </div>
        </div>
        
        <div class="col-md-6 mb-4">
            <div class="chart-container">
                <div class="chart-title">
                    <i class="fas fa-exclamation-triangle text-warning"></i> Penjualan Per Hari (7 Hari Terakhir)
                </div>
                <canvas id="dailySalesChart" height="120"></canvas>
            </div>
        </div>
    </div>

    <!-- Chart.js Script -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <script>
        // Grafik Penjualan Bulanan (Line Chart)
        const salesCtx = document.getElementById('salesChart').getContext('2d');
        const salesChart = new Chart(salesCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [{
                    label: 'Penjualan (Juta Rupiah)',
                    data: [12, 15, 13, 18, 20, 22, 19, 25, 23, 28, 26, 30],
                    borderColor: 'rgb(102, 126, 234)',
                    backgroundColor: 'rgba(102, 126, 234, 0.1)',
                    tension: 0.4,
                    fill: true,
                    pointRadius: 5,
                    pointHoverRadius: 7
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value + 'M';
                            }
                        }
                    }
                }
            }
        });

        // Grafik Kategori Produk (Doughnut Chart)
        const categoryCtx = document.getElementById('categoryChart').getContext('2d');
        const categoryChart = new Chart(categoryCtx, {
            type: 'doughnut',
            data: {
                labels: ['Skincare', 'Makeup', 'Lip Products', 'Sun Protection', 'Lainnya'],
                datasets: [{
                    data: [35, 25, 20, 15, 5],
                    backgroundColor: [
                        'rgba(102, 126, 234, 0.8)',
                        'rgba(245, 87, 108, 0.8)',
                        'rgba(79, 172, 254, 0.8)',
                        'rgba(67, 233, 123, 0.8)',
                        'rgba(255, 193, 7, 0.8)'
                    ],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        // Grafik Top Produk (Bar Chart Horizontal)
        const topProductsCtx = document.getElementById('topProductsChart').getContext('2d');
        const topProductsChart = new Chart(topProductsCtx, {
            type: 'bar',
            data: {
                labels: ['Emina Tone Up Cream Gel', 'Emina Water Gel', 'Emina Jelly Stain & Glass Tint', 'Emina Glow & Matte 3in1 Skincare Cushion SPF 50 PA++++', 'Emina Low pH Micellar Water Complete Series'],
                datasets: [{
                    label: 'Terjual (Unit)',
                    data: [450, 380, 320, 280, 250],
                    backgroundColor: [
                        'rgba(102, 126, 234, 0.8)',
                        'rgba(245, 87, 108, 0.8)',
                        'rgba(79, 172, 254, 0.8)',
                        'rgba(67, 233, 123, 0.8)',
                        'rgba(255, 193, 7, 0.8)'
                    ],
                    borderRadius: 5
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Grafik Penjualan Harian (Bar Chart)
        const dailySalesCtx = document.getElementById('dailySalesChart').getContext('2d');
        const dailySalesChart = new Chart(dailySalesCtx, {
            type: 'bar',
            data: {
                labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
                datasets: [{
                    label: 'Penjualan (Juta)',
                    data: [2.5, 3.2, 2.8, 4.1, 3.5, 5.2, 4.8],
                    backgroundColor: 'rgba(67, 233, 123, 0.8)',
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value + 'M';
                            }
                        }
                    }
                }
            }
        });
    </script>
@endsection