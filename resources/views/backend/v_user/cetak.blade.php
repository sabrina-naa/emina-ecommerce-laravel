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
            margin-bottom: 20px;
        }
        .stat-box {
            display: table-cell;
            width: 20%;
            padding: 15px;
            text-align: center;
            background: #f8f9fa;
            border: 2px solid #dee2e6;
            vertical-align: middle;
        }
        .stat-box.blue { border-color: #2196F3; }
        .stat-box.green { border-color: #4CAF50; }
        .stat-box.red { border-color: #f44336; }
        .stat-box.orange { border-color: #ff9800; }
        .stat-box.purple { border-color: #9c27b0; }
        .stat-label {
            font-size: 11px;
            color: #666;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .stat-value {
            font-size: 28px;
            font-weight: bold;
            color: #333;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 15px;
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
        .badge-primary {
            background: #2196F3;
            color: white;
        }
        .badge-secondary {
            background: #9E9E9E;
            color: white;
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
            body {
                padding: 10px;
            }
            .stat-box {
                page-break-inside: avoid;
            }
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
        @if($filterRole !== null && $filterRole !== '')
            <p><strong>Filter Role:</strong> {{ $filterRole == 1 ? 'Super Admin' : 'Admin' }}</p>
        @endif
        @if($filterStatus !== null && $filterStatus !== '')
            <p><strong>Filter Status:</strong> {{ $filterStatus == 1 ? 'Aktif' : 'Non Aktif' }}</p>
        @endif
        <p><strong>Tanggal Cetak:</strong> {{ date('d/m/Y H:i:s') }}</p>
    </div>

    <!-- Statistik -->
    <div class="stats-container">
        <div class="stat-box blue">
            <div class="stat-label">TOTAL USER</div>
            <div class="stat-value">{{ $totalUser }}</div>
        </div>
        <div class="stat-box green">
            <div class="stat-label">SUPER ADMIN</div>
            <div class="stat-value">{{ $totalSuperAdmin }}</div>
        </div>
        <div class="stat-box orange">
            <div class="stat-label">ADMIN</div>
            <div class="stat-value">{{ $totalAdmin }}</div>
        </div>
        <div class="stat-box purple">
            <div class="stat-label">AKTIF</div>
            <div class="stat-value">{{ $totalAktif }}</div>
        </div>
        <div class="stat-box red">
            <div class="stat-label">NON AKTIF</div>
            <div class="stat-value">{{ $totalNonAktif }}</div>
        </div>
    </div>

    <!-- Tabel Data -->
    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="25%">Nama</th>
                <th width="25%">Email</th>
                <th width="15%">HP</th>
                <th width="15%">Role</th>
                <th width="15%">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($cetak as $row)
                <tr>
                    <td style="text-align: center;">{{ $loop->iteration }}</td>
                    <td>{{ $row->nama }}</td>
                    <td>{{ $row->email }}</td>
                    <td>{{ $row->hp }}</td>
                    <td>
                        @if ($row->role == 1)
                            <span class="badge badge-primary">Super Admin</span>
                        @else
                            <span class="badge badge-secondary">Admin</span>
                        @endif
                    </td>
                    <td>
                        @if ($row->status == 1)
                            <span class="badge badge-success">Aktif</span>
                        @else
                            <span class="badge badge-danger">Non Aktif</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 20px; color: #999;">
                        Tidak ada data user pada periode ini
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