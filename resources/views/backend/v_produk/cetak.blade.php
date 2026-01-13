<!DOCTYPE html>
<html>
<head>
    <title>{{ $judul }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 3px solid #333;
        }
        .header h2 {
            margin: 5px 0;
            color: #333;
        }
        .info-box {
            background: #f5f5f5;
            padding: 15px;
            margin-bottom: 20px;
            border-left: 4px solid #4CAF50;
        }
        .info-box p {
            margin: 5px 0;
            line-height: 1.6;
        }
        .stats-container {
            display: table;
            width: 100%;
            margin-bottom: 25px;
        }
        .stat-box {
            display: table-cell;
            width: 25%;
            padding: 15px;
            text-align: center;
            background: #f8f9fa;
            border: 2px solid #dee2e6;
            vertical-align: middle;
        }
        .stat-box.blue { border-color: #2196F3; background: #E3F2FD; }
        .stat-box.green { border-color: #4CAF50; background: #E8F5E9; }
        .stat-box.red { border-color: #f44336; background: #FFEBEE; }
        .stat-box.orange { border-color: #ff9800; background: #FFF3E0; }
        .stat-label {
            font-size: 11px;
            color: #666;
            margin-bottom: 5px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .stat-value {
            font-size: 28px;
            font-weight: bold;
            color: #333;
        }
        .stat-subtitle {
            font-size: 14px;
            color: #666;
            margin-top: 5px;
        }
        .section-title {
            font-size: 16px;
            font-weight: bold;
            margin: 25px 0 15px 0;
            padding: 10px 15px;
            background: #4CAF50;
            color: white;
            border-radius: 3px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
        }
        th {
            background: #4CAF50;
            color: white;
            padding: 12px 8px;
            text-align: left;
            font-weight: bold;
            border: 1px solid #4CAF50;
        }
        td {
            padding: 10px 8px;
            border: 1px solid #ddd;
        }
        tr:nth-child(even) {
            background: #f9f9f9;
        }
        tr:hover {
            background: #f0f0f0;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .badge {
            padding: 4px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
        }
        .badge-success {
            background: #4CAF50;
            color: white;
        }
        .badge-danger {
            background: #f44336;
            color: white;
        }
        .badge-warning {
            background: #ff9800;
            color: white;
        }
        .badge-secondary {
            background: #9E9E9E;
            color: white;
        }
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        .alert-warning {
            background: #FFF3CD;
            border-left: 4px solid #ff9800;
            color: #856404;
        }
        .alert-danger {
            background: #F8D7DA;
            border-left: 4px solid #f44336;
            color: #721C24;
        }
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 2px solid #333;
            text-align: right;
            font-size: 11px;
            color: #666;
        }
        @media print {
            body { padding: 10px; }
            .stat-box, .section-title { page-break-inside: avoid; }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h2>{{ $judul }}</h2>
        <p>Emina Beauty - Stay Cute, Stay Confident</p>
    </div>

    <!-- Info Laporan -->
    <div class="info-box">
        <p><strong>Periode:</strong> {{ date('d/m/Y', strtotime($tanggalAwal)) }} s/d {{ date('d/m/Y', strtotime($tanggalAkhir)) }}</p>
        @if($filterKategori)
            <p><strong>Kategori:</strong> {{ $kategori->where('id', $filterKategori)->first()->nama_kategori ?? 'Semua Kategori' }}</p>
        @else
            <p><strong>Kategori:</strong> Semua Kategori</p>
        @endif
        <p><strong>Tanggal Cetak:</strong> {{ date('d/m/Y H:i:s') }}</p>
    </div>

    <!-- Statistik Utama -->
    <div class="stats-container">
        <div class="stat-box blue">
            <div class="stat-label">Total Produk</div>
            <div class="stat-value">{{ $totalProduk }}</div>
            <div class="stat-subtitle">Item</div>
        </div>
        <div class="stat-box green">
            <div class="stat-label">Stok Tersedia</div>
            <div class="stat-value">{{ $stokTersedia }}</div>
            <div class="stat-subtitle">Produk</div>
        </div>
        <div class="stat-box red">
            <div class="stat-label">Stok Habis</div>
            <div class="stat-value">{{ $stokHabis }}</div>
            <div class="stat-subtitle">Produk</div>
        </div>
        <div class="stat-box orange">
            <div class="stat-label">Stok Menipis</div>
            <div class="stat-value">{{ $stokMenipis }}</div>
            <div class="stat-subtitle">Produk &lt; 10</div>
        </div>
    </div>

    <!-- Total Nilai Stok -->
    <div class="info-box" style="border-left-color: #2196F3; text-align: center; padding: 20px;">
        <h3 style="margin: 0; color: #2196F3;">TOTAL NILAI STOK KESELURUHAN</h3>
        <h2 style="margin: 10px 0; color: #333; font-size: 32px;">
            Rp. {{ number_format($totalNilaiStok, 0, ',', '.') }}
        </h2>
        <p style="margin: 0; color: #666;">Harga × Stok seluruh produk</p>
    </div>

    <!-- ========== STATISTIK PER KATEGORI ========== -->
    <div class="section-title">📊 STATISTIK PER KATEGORI</div>
    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="35%">Kategori</th>
                <th width="20%" class="text-center">Jumlah Produk</th>
                <th width="20%" class="text-center">Total Stok</th>
                <th width="20%" class="text-right">Total Nilai Stok</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($kategoriStats as $index => $stat)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td><strong>{{ $stat['nama_kategori'] }}</strong></td>
                    <td class="text-center">{{ $stat['jumlah_produk'] }} item</td>
                    <td class="text-center">{{ $stat['total_stok'] }} unit</td>
                    <td class="text-right"><strong>Rp. {{ number_format($stat['total_nilai'], 0, ',', '.') }}</strong></td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center" style="padding: 20px; color: #999;">
                        Tidak ada data kategori
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- ========== PRODUK TERLARIS ========== -->
    @if($produkTerlaris->count() > 0)
        <div class="section-title">🏆 PRODUK TERLARIS (10 TERATAS)</div>
        <table>
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="50%">Nama Produk</th>
                    <th width="20%" class="text-center">Total Terjual</th>
                    <th width="25%" class="text-right">Total Pendapatan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($produkTerlaris as $item)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td><strong>{{ $item->nama_produk }}</strong></td>
                        <td class="text-center">{{ $item->total_terjual }} unit</td>
                        <td class="text-right"><strong>Rp. {{ number_format($item->total_pendapatan, 0, ',', '.') }}</strong></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <!-- ========== PRODUK STOK HABIS ========== -->
    @if($produkStokHabis->count() > 0)
        <div class="alert alert-danger">
            <strong>⚠️ PERHATIAN:</strong> Terdapat {{ $produkStokHabis->count() }} produk dengan stok habis!
        </div>
        <div class="section-title" style="background: #f44336;">🚨 DAFTAR PRODUK STOK HABIS</div>
        <table>
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="30%">Kategori</th>
                    <th width="45%">Nama Produk</th>
                    <th width="20%" class="text-right">Harga</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($produkStokHabis as $row)
                    <tr style="background: #FFEBEE;">
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $row->kategori->nama_kategori ?? '-' }}</td>
                        <td><strong>{{ $row->nama_produk }}</strong></td>
                        <td class="text-right">Rp. {{ number_format($row->harga, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <!-- ========== PRODUK STOK MENIPIS ========== -->
    @if($produkStokMenipis->count() > 0)
        <div class="alert alert-warning">
            <strong>⚠️ PERHATIAN:</strong> Terdapat {{ $produkStokMenipis->count() }} produk dengan stok menipis (< 10 unit)!
        </div>
        <div class="section-title" style="background: #ff9800;">⚠️ DAFTAR PRODUK STOK MENIPIS (&lt; 10)</div>
        <table>
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="25%">Kategori</th>
                    <th width="40%">Nama Produk</th>
                    <th width="15%" class="text-center">Stok</th>
                    <th width="15%" class="text-right">Harga</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($produkStokMenipis as $row)
                    <tr style="background: #FFF3E0;">
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $row->kategori->nama_kategori ?? '-' }}</td>
                        <td><strong>{{ $row->nama_produk }}</strong></td>
                        <td class="text-center">
                            <span class="badge badge-warning">{{ $row->stok }} unit</span>
                        </td>
                        <td class="text-right">Rp. {{ number_format($row->harga, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <!-- ========== DAFTAR SEMUA PRODUK ========== -->
    <div class="section-title">📦 DAFTAR SEMUA PRODUK</div>
    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="20%">Kategori</th>
                <th width="10%" class="text-center">Status</th>
                <th width="30%">Nama Produk</th>
                <th width="15%" class="text-right">Harga</th>
                <th width="10%" class="text-center">Stok</th>
                <th width="10%" class="text-right">Nilai Stok</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($cetak as $row)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $row->kategori->nama_kategori ?? '-' }}</td>
                    <td class="text-center">
                        @if ($row->status == 1)
                            <span class="badge badge-success">Publis</span>
                        @else
                            <span class="badge badge-secondary">Blok</span>
                        @endif
                    </td>
                    <td>{{ $row->nama_produk }}</td>
                    <td class="text-right">Rp. {{ number_format($row->harga, 0, ',', '.') }}</td>
                    <td class="text-center">
                        @if($row->stok == 0)
                            <span class="badge badge-danger">{{ $row->stok }}</span>
                        @elseif($row->stok < 10)
                            <span class="badge badge-warning">{{ $row->stok }}</span>
                        @else
                            <span class="badge badge-success">{{ $row->stok }}</span>
                        @endif
                    </td>
                    <td class="text-right">Rp. {{ number_format($row->harga * $row->stok, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center" style="padding: 20px; color: #999;">
                        Tidak ada data produk pada periode ini
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Footer -->
    <div class="footer">
        <p>Dicetak oleh: {{ Auth::user()->nama }} | {{ date('d F Y, H:i:s') }}</p>
    </div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>