<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kwitansi Pembayaran</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
        }

        .container {
            width: 100%;
            padding: 20px;
            margin: 0 auto;
        }

        .header {
            text-align: center;
        }

        .header p {
            text-align: justify;
        }

        .header img {
            width: 150px;
        }

        .no-border {
            border: none;
            border-collapse: collapse;
            width: auto;
        }

        .no-border td {
            border: none;
            /* Menghilangkan border di sel */
            padding: 3px 5px;
            /* Menambahkan padding jika diperlukan */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 40px;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th {
            padding: 10px;
            text-align: center;
        }

        td {
            padding: 10px;
            text-align: justify;
        }

        .signature {
            margin-top: 50px;
        }

        .signature div {
            display: inline-block;
            width: 45%;
            text-align: center;
        }

        div.a {
            text-decoration: underline;
        }

        .signature div p {
            margin-top: 60px;
            padding-top: 5px;
        }

        footer {
            text-align: center;
            font-weight: normal;
            position: fixed;
            bottom: 0px;
            left: 0px;
            right: 0px;
            margin-bottom: 0px;
        }

        footer pre {
            text-align: right;
            font-weight: bold;
            font-family: 'Times New Roman', Times, serif;
        }
        .signature {
        display: flex;
        justify-content: space-between;
        margin-top: 50px;
    }

    .signature div {
        width: 45%;
    }

    .signature-with-stamp {
        position: relative;
        display: inline-block;
        text-align: center;
    }

    .signature-with-stamp .stamp {
        position: absolute;
        top: 0;
        left: 70%;
        transform: translate(-50%, -50%);
        width: 150px; /* Sesuaikan ukuran stempel */
        z-index: -1; /* Letakkan stempel di belakang teks */
    }

    .signature-with-stamp .signed-name {
        position: relative;
        z-index: 1; /* Letakkan teks di depan stempel */
        margin-top: 50px; /* Tambahkan ruang agar stempel tidak menutupi teks */
    }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <table style="width: 100%; table-layout: fixed; border: none; margin-bottom: 0px;">
                <tr>
                    <td style="width: 20%; vertical-align: top; border: none;">
                        <img src="{{ public_path('images/logo.png') }}" alt="Logo" style="max-width: 100%;">
                    </td>
                    <td style="width: 80%; text-align: center; vertical-align: middle; border: none;">
                            <em><strong>PT. FANS VISION JEMBER</strong></em> <br>
                            Perum Griya Mangli Indah DF. 1A Mangli, RT.03 RW.04 Kelurahan Mangli.	<br>
                            Kec. Kaliwates. Kab. Jember. Jawa Timur, Kode Pos 68136 <br>
                            Telp./HP. 081231877433, Email : fansvision2020@gmail.com
                    
                    </td>
                </tr>
            </table>
            <hr>
            <h3>KWITANSI PEMBAYARAN</h3>
            <table class="no-border">
                <tr>
                    <td>Tanggal</td>
                    <td>: {{ \Carbon\Carbon::parse($pembayaran->tanggal)->locale('id')->translatedFormat('d F Y') }}
                    </td>
                </tr>

                <tr>
                    <td>Kwitansi No.</td>
                    <td>: {{ str_pad($pembayaran->id, 4, '0', STR_PAD_LEFT) }}</td>
                </tr>
            </table>
        </div>

        <div class="content">
            <table class="no-border">
                <tr>
                    <td><strong>Terima dari</strong></td>
                    <td><strong>: {{ $pelanggan->nama }}</strong></td>
                </tr>
                <tr>
                    <td><strong>Jumlah Pembayaran</strong></td>
                    <td><strong>: Rp {{ number_format($pembayaran->nominal, 0, ',', '.') }}</strong></td>
                </tr>
                <tr>
                    <td><strong>Terbilang</strong></td>
                    <td><strong>: {{ terbilang($pembayaran->nominal) }} Rupiah</strong></td>
                </tr>
            </table>

            <table>
                <thead>
                    <tr>
                        <th style="width: 5%">No</th>
                        <th style="width: 45%">Deskripsi</th>
                        <th style="width: 20%">Harga</th>
                        <th style="width: 10%">Qty</th>
                        <th style="width: 20%">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Pembayaran konstribusi lokal operator bulan
                            {{ \Carbon\Carbon::parse($pembayaran->tanggal)->locale('id')->translatedFormat('F') }} tahun
                            {{ \Carbon\Carbon::parse($pembayaran->tanggal)->format('Y') }}</td>
                        <td>Rp {{ number_format($pembayaran->nominal, 0, ',', '.') }}</td>
                        <td>1</td>
                        <td>Rp {{ number_format($pembayaran->nominal, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>

            <div class="signature">
                <div style="text-align: center;">
                    <p><strong>Penerima <br><span style="text-decoration: underline;">Silvyana Claudya</span></strong></p>
                    <div class="signature-with-stamp">
                        <img src="{{ public_path('images/logottd.png') }}" alt="Stempel" class="stamp">
                        <p><strong>Admin</strong></p>
                    </div>
                </div>
                <div style="text-align: center;">
                    <p><strong>Pembayar <br><br><br></strong></p>
                    <p class="signed-name" style="text-decoration: underline;"><strong>{{ $pelanggan->nama }}</strong></p>
                </div>
            </div>
            
            
        </div>
        <footer>
            <p>Thank you for your business!</p>
            <br>
            <hr>
            <pre>Perum Griya Mangli Indah Blok DF 01, Kaliwates, Jember, Jawa Timur, 68136
                Telp: 08123187433
            </pre>
        </footer>
    </div>
</body>

</html>
