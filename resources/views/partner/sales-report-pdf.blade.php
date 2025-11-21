<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Penjualan - WePlan(t)</title>
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
        <h1>LAPORAN PENJUALAN WEPLAN(T)</h1>
        <p>Mitra: {{ $partnerName }}</p>
        <p>Dibuat pada: {{ $generatedAt }}</p>
    </div>

    {{-- Sales Statistics --}}
    <div class="section">
        <div class="section-title">STATISTIK PENJUALAN</div>
        <div class="stats-grid">
            <div class="stats-row">
                <div class="stats-cell stats-label">Total Penjualan</div>
                <div class="stats-cell stats-value highlight">Rp {{ number_format($totalSales, 0, ',', '.') }}</div>
            </div>
            <div class="stats-row">
                <div class="stats-cell stats-label">Total Pesanan</div>
                <div class="stats-cell stats-value">{{ $totalOrders }}</div>
            </div>
            <div class="stats-row">
                <div class="stats-cell stats-label">Produk Terlaris</div>
                <div class="stats-cell stats-value">{{ $bestSellingProduct }}</div>
            </div>
            <div class="stats-row">
                <div class="stats-cell stats-label">Rata-rata per Pesanan</div>
                <div class="stats-cell stats-value">Rp {{ number_format($avgPerOrder, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>

    {{-- Monthly Sales --}}
    @if(count($monthlySalesData) > 0)
    <div class="section">
        <div class="section-title">PENJUALAN BULANAN (6 BULAN TERAKHIR)</div>
        <table>
            <thead>
                <tr>
                    <th>Bulan</th>
                    <th>Total Penjualan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($monthlySalesData as $data)
                <tr>
                    <td>{{ $data['month'] }}</td>
                    <td>Rp {{ number_format($data['sales'], 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    {{-- Top Products --}}
    @if($topProducts->count() > 0)
    <div class="section">
        <div class="section-title">PRODUK TERLARIS</div>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th>Jumlah Terjual</th>
                    <th>Total Pendapatan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($topProducts as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->product->name ?? 'N/A' }}</td>
                    <td>{{ number_format($item->total_sold, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($item->total_revenue, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    {{-- Sales Details --}}
    @if($salesDetails->count() > 0)
    <div class="section">
        <div class="section-title">RINCIAN PENJUALAN</div>
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>No. Pesanan</th>
                    <th>Produk</th>
                    <th>Jumlah</th>
                    <th>Harga Satuan</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($salesDetails as $item)
                <tr>
                    <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $item->order->order_number }}</td>
                    <td>{{ $item->product->name ?? 'N/A' }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
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


