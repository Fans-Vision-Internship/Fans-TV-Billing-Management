@extends('layouts.main')

@section('contents')
@include('layouts.sidebar')
<div id="main">
    <div class="container">
        <h2>Tambah Pembayaran</h2>

        <form action="{{ route('pembayaran.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="pelanggan">Pilih Pelanggan</label>
                <select id="pelanggan" name="pelanggan_id" class="choices form-select">
                    <option value="">Pilih Pelanggan</option>
                    @foreach($pelanggan as $p)
                        <option value="{{ $p->id }}">{{ $p->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="wilayah">Wilayah</label>
                <input type="text" id="wilayah" class="form-control" readonly>
            </div>

            <div class="form-group">
                <label for="kewajiban">Kewajiban Iuran</label>
                <input type="text" id="kewajiban" class="form-control" readonly>
            </div>

            <div class="form-group">
                <label for="nominal">Nominal Pembayaran</label>
                <input type="number" id="nominal" name="nominal" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="tanggal">Tanggal Pembayaran</label>
                <input type="date" id="tanggal" name="tanggal" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Tambah Pembayaran</button>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('#pelanggan').change(function() {
    var pelangganID = $(this).val();
    console.log('Selected Pelanggan ID:', pelangganID); // Debugging
    if (pelangganID) {
        $.ajax({
            url: '/pelangganPembayaran/' + pelangganID,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                if (data.error) {
                    alert(data.error); // Tampilkan pesan error jika pelanggan tidak ditemukan
                } else {
                    $('#wilayah').val(data.wilayah);
                    $('#kewajiban').val(data.kewajiban_iuran);
                }
            },
            error: function() {
                alert('Data tidak ditemukan');
            }
        });
    } else {
        $('#wilayah').val('');
        $('#kewajiban').val('');
    }
});

@if(session('success'))
        Swal.fire({
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            icon: 'success',
            confirmButtonText: 'OK'
        });
        @endif
</script>

@endsection
