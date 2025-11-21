<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan WePlan(t)</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #22c55e;
            padding-bottom: 20px;
        }
        .header h1 {
            color: #22c55e;
            margin: 0;
            font-size: 24px;
        }
        .header p {
            color: #666;
            margin: 5px 0;
        }
        .section {
            margin-bottom: 25px;
            page-break-inside: avoid;
        }
        .section-title {
            background-color: #22c55e;
            color: white;
            padding: 10px;
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 10px;
        }
        .stats-grid {
            display: table;
            width: 100%;
            margin-bottom: 15px;
        }
        .stats-row {
            display: table-row;
        }
        .stats-cell {
            display: table-cell;
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
        .stats-label {
            font-weight: bold;
            width: 60%;
        }
        .stats-value {
            text-align: right;
            width: 40%;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #22c55e;
            color: white;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9fafb;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            text-align: center;
            color: #666;
            font-size: 10px;
        }
        .highlight {
            font-size: 18px;
            font-weight: bold;
            color: #22c55e;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN WEPLAN(T)</h1>
        <p>Platform Ekosistem Kelapa Sawit</p>
        <p>Dibuat pada: {{ $generatedAt }}</p>
    </div>

    {{-- User Statistics --}}
    <div class="section">
        <div class="section-title">STATISTIK PENGGUNA</div>
        <div class="stats-grid">
            <div class="stats-row">
                <div class="stats-cell stats-label">Total Pengguna</div>
                <div class="stats-cell stats-value highlight">{{ $userStats['total'] }}</div>
            </div>
            <div class="stats-row">
                <div class="stats-cell stats-label">Admin</div>
                <div class="stats-cell stats-value">{{ $userStats['admin'] }}</div>
            </div>
            <div class="stats-row">
                <div class="stats-cell stats-label">Petani</div>
                <div class="stats-cell stats-value">{{ $userStats['farmer'] }}</div>
            </div>
            <div class="stats-row">
                <div class="stats-cell stats-label">Mitra</div>
                <div class="stats-cell stats-value">{{ $userStats['partner'] }}</div>
            </div>
        </div>
    </div>

    {{-- Product Statistics --}}
    <div class="section">
        <div class="section-title">STATISTIK PRODUK</div>
        <div class="stats-grid">
            <div class="stats-row">
                <div class="stats-cell stats-label">Total Produk</div>
                <div class="stats-cell stats-value highlight">{{ $productStats['total'] }}</div>
            </div>
            <div class="stats-row">
                <div class="stats-cell stats-label">Disetujui</div>
                <div class="stats-cell stats-value">{{ $productStats['approved'] }}</div>
            </div>
            <div class="stats-row">
                <div class="stats-cell stats-label">Menunggu</div>
                <div class="stats-cell stats-value">{{ $productStats['pending'] }}</div>
            </div>
            <div class="stats-row">
                <div class="stats-cell stats-label">Ditolak</div>
                <div class="stats-cell stats-value">{{ $productStats['rejected'] }}</div>
            </div>
        </div>
    </div>

    {{-- Order Statistics --}}
    <div class="section">
        <div class="section-title">STATISTIK PESANAN</div>
        <div class="stats-grid">
            <div class="stats-row">
                <div class="stats-cell stats-label">Total Pesanan</div>
                <div class="stats-cell stats-value highlight">{{ $orderStats['total'] }}</div>
            </div>
            <div class="stats-row">
                <div class="stats-cell stats-label">Menunggu</div>
                <div class="stats-cell stats-value">{{ $orderStats['pending'] }}</div>
            </div>
            <div class="stats-row">
                <div class="stats-cell stats-label">Diproses</div>
                <div class="stats-cell stats-value">{{ $orderStats['processing'] }}</div>
            </div>
            <div class="stats-row">
                <div class="stats-cell stats-label">Dikirim</div>
                <div class="stats-cell stats-value">{{ $orderStats['shipped'] }}</div>
            </div>
            <div class="stats-row">
                <div class="stats-cell stats-label">Selesai</div>
                <div class="stats-cell stats-value">{{ $orderStats['completed'] }}</div>
            </div>
            <div class="stats-row">
                <div class="stats-cell stats-label">Dibatalkan</div>
                <div class="stats-cell stats-value">{{ $orderStats['cancelled'] }}</div>
            </div>
        </div>
    </div>

    {{-- Revenue Statistics --}}
    <div class="section">
        <div class="section-title">PENDAPATAN</div>
        <div class="stats-grid">
            <div class="stats-row">
                <div class="stats-cell stats-label">Total Pendapatan</div>
                <div class="stats-cell stats-value highlight">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
            </div>
            <div class="stats-row">
                <div class="stats-cell stats-label">Total Item Terjual</div>
                <div class="stats-cell stats-value">{{ number_format($totalItemsSold, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>

    {{-- Top Products --}}
    @if($topProducts->count() > 0)
    <div class="section">
        <div class="section-title">PRODUK TERLARIS</div>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th>Kategori</th>
                    <th>Jumlah Terjual</th>
                </tr>
            </thead>
            <tbody>
                @foreach($topProducts as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->product->name ?? 'N/A' }}</td>
                    <td>{{ $item->product->category ?? 'N/A' }}</td>
                    <td>{{ number_format($item->total_sold, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    {{-- Recent Orders --}}
    @if($recentOrders->count() > 0)
    <div class="section">
        <div class="section-title">PESANAN TERBARU</div>
        <table>
            <thead>
                <tr>
                    <th>No. Pesanan</th>
                    <th>Tanggal</th>
                    <th>Pelanggan</th>
                    <th>Total</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentOrders as $order)
                <tr>
                    <td>{{ $order->order_number }}</td>
                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $order->name }}</td>
                    <td>Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                    <td>{{ ucfirst($order->status) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <div class="footer">
        <p>Laporan ini dibuat secara otomatis oleh sistem WePlan(t)</p>
        <p>&copy; {{ date('Y') }} WePlan(t). All rights reserved.</p>
    </div>
</body>
</html>


