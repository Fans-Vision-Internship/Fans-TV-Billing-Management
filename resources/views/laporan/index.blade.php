@extends('layouts.main')

@section('contents')
@include('layouts.sidebar')
<div id="main">
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Laporan Pembayaran Pelanggan</h3>
                    
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-header mb-0">
                    <h5 class="card-title mb-2">Data Pelanggan</h5>
                    <a href="{{ route('export.excel', ['year' => $year]) }}" class="btn btn-success mb-2">Export to Excel</a>
                    <a href="{{ route('export.pdf', ['year' => $year]) }}" class="btn btn-danger mb-2">Export to PDF</a>
                    <form method="GET" action="{{ route('laporan.pelanggan') }}">
                        <div class="form-group">
                            <label for="year">Filter Tahun:</label>
                            <select name="year" id="year" class="form-control" onchange="this.form.submit()">
                                @for($i = date('Y'); $i >= date('Y') - 10; $i--)
                                    <option value="{{ $i }}" {{ $year == $i ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </form>

                </div>
                <div class="card-body mt-0">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Wilayah</th>
                                <th>Kewajiban Iuran</th>
                                <th>Januari</th>
                                <th>Februari</th>
                                <th>Maret</th>
                                <th>April</th>
                                <th>Mei</th>
                                <th>Juni</th>
                                <th>Juli</th>
                                <th>Agustus</th>
                                <th>September</th>
                                <th>Oktober</th>
                                <th>November</th>
                                <th>Desember</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pelanggan as $item)
                            <tr>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->wilayah }}</td>
                                <td>Rp {{ number_format($item->kewajiban_iuran, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format(optional($item->pembayaran->first())->januari, 0, ',', '.') }}
                                </td>
                                <td>Rp {{ number_format(optional($item->pembayaran->first())->februari, 0, ',', '.') }}
                                </td>
                                <td>Rp {{ number_format(optional($item->pembayaran->first())->maret, 0, ',', '.') }}
                                </td>
                                <td>Rp {{ number_format(optional($item->pembayaran->first())->april, 0, ',', '.') }}
                                </td>
                                <td>Rp {{ number_format(optional($item->pembayaran->first())->mei, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format(optional($item->pembayaran->first())->juni, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format(optional($item->pembayaran->first())->juli, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format(optional($item->pembayaran->first())->agustus, 0, ',', '.') }}
                                </td>
                                <td>Rp {{ number_format(optional($item->pembayaran->first())->september, 0, ',', '.') }}
                                </td>
                                <td>Rp {{ number_format(optional($item->pembayaran->first())->oktober, 0, ',', '.') }}
                                </td>
                                <td>Rp {{ number_format(optional($item->pembayaran->first())->november, 0, ',', '.') }}
                                </td>
                                <td>Rp {{ number_format(optional($item->pembayaran->first())->desember, 0, ',', '.') }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>

    @include('layouts.footer')
</div>
@endsection