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
                    <h3>Data Pelanggan</h3>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Data Pelanggan</h5>
                    <!-- Tombol Tambah Pelanggan -->
                    <button type="button" class="btn btn-primary btn-icon-text" data-bs-toggle="modal"
                        data-bs-target="#modalTambahPelanggan">
                        <i class="bi bi-plus-circle-fill me-2"></i> Tambah Pelanggan
                    </button>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Wilayah</th>
                                <th>Kewajiban Iuran</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pelanggan as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->wilayah }}</td>
                                <td>Rp {{ number_format($item->kewajiban_iuran, 0, ',', '.') }}</td>
                                <td>
                                    <!-- Tombol Edit Pelanggan -->
                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#modalEditPelanggan{{ $item->id }}">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    
                                    <!-- Modal Edit Pelanggan -->
                                    <div class="modal fade text-left" id="modalEditPelanggan{{ $item->id }}" tabindex="-1" role="dialog"
                                        aria-labelledby="modalEditPelangganLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalEditPelangganLabel">Edit Pelanggan</h5>
                                                    <button type="button" class="close rounded-pill" data-bs-dismiss="modal"
                                                        aria-label="Close">
                                                        <i data-feather="x"></i>
                                                    </button>
                                                </div>
                                                <form action="{{ route('pelanggan.update', $item->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="nama">Nama</label>
                                                            <input type="text" class="form-control" id="nama" name="nama" value="{{ $item->nama }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="wilayah">Wilayah</label>
                                                            <input type="text" class="form-control" id="wilayah" name="wilayah" value="{{ $item->wilayah }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="kewajiban_iuran">Kewajiban Iuran</label>
                                                            <input type="number" class="form-control" id="kewajiban_iuran" name="kewajiban_iuran" value="{{ $item->kewajiban_iuran }}">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Tombol Hapus Pelanggan -->
                                    <button type="button" class="btn btn-danger" onclick="confirmDelete('{{ route('pelanggan.destroy', $item->id) }}')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>

    <!-- Modal Tambah Pelanggan -->
    <div class="modal fade text-left" id="modalTambahPelanggan" tabindex="-1" role="dialog"
        aria-labelledby="modalTambahPelangganLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahPelangganLabel">Tambah Pelanggan</h5>
                    <button type="button" class="close rounded-pill" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <form action="{{ route('pelanggan.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="form-group">
                            <label for="wilayah">Wilayah</label>
                            <input type="text" class="form-control" id="wilayah" name="wilayah">
                        </div>
                        <div class="form-group">
                            <label for="kewajiban_iuran">Kewajiban Iuran</label>
                            <input type="number" class="form-control" id="kewajiban_iuran" name="kewajiban_iuran">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('layouts.footer')
    <script>
        @if(session('success'))
        Swal.fire({
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            icon: 'success',
            confirmButtonText: 'OK'
        });
        @endif
    
        function confirmDelete(url) {
            Swal.fire({
                title: 'Anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    var form = document.createElement('form');
                    form.action = url;
                    form.method = 'POST';
                    form.innerHTML = '@csrf @method('DELETE')';
                    document.body.appendChild(form);
                    form.submit();
                }
            })
        }
    </script>
</div>
@endsection
