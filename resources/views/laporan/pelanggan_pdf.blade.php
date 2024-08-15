<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pelanggan</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: center;
        }
        .month-header {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Laporan Pembayaran Pelanggan</h2>
    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Wilayah</th>
                <th>Kewajiban Iuran</th>
                <th colspan="6" class="month-header">Januari - Desember</th>
            </tr>
            <tr>
                <th colspan="3"></th>
                <th class="month-header">Jan</th>
                <th class="month-header">Feb</th>
                <th class="month-header">Mar</th>
                <th class="month-header">Apr</th>
                <th class="month-header">Mei</th>
                <th class="month-header">Jun</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pelanggan as $item)
            <tr>
                <td>{{ $item->nama }}</td>
                <td>{{ $item->wilayah }}</td>
                <td>Rp {{ number_format($item->kewajiban_iuran, 0, ',', '.') }}</td>
                <td>{{ optional($item->pembayaran->first())->januari }}</td>
                <td>{{ optional($item->pembayaran->first())->februari }}</td>
                <td>{{ optional($item->pembayaran->first())->maret }}</td>
                <td>{{ optional($item->pembayaran->first())->april }}</td>
                <td>{{ optional($item->pembayaran->first())->mei }}</td>
                <td>{{ optional($item->pembayaran->first())->juni }}</td>
            </tr>
            <tr>
                <td colspan="3"></td> <!-- Mengosongkan bagian nama, wilayah, dan kewajiban iuran -->
                <th class="month-header">Jul</th>
                <th class="month-header">Agu</th>
                <th class="month-header">Sep</th>
                <th class="month-header">Okt</th>
                <th class="month-header">Nov</th>
                <th class="month-header">Des</th>
            </tr>
            <tr>
                <td colspan="3"></td> <!-- Mengosongkan bagian nama, wilayah, dan kewajiban iuran -->
                <td>{{ optional($item->pembayaran->first())->juli }}</td>
                <td>{{ optional($item->pembayaran->first())->agustus }}</td>
                <td>{{ optional($item->pembayaran->first())->september }}</td>
                <td>{{ optional($item->pembayaran->first())->oktober }}</td>
                <td>{{ optional($item->pembayaran->first())->november }}</td>
                <td>{{ optional($item->pembayaran->first())->desember }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
