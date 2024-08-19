<?php
namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PembayaranController extends Controller
{
    public function index()
    {
        $pelanggan = Pelanggan::all();
        return view('pembayaran.create', compact('pelanggan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pelanggan_id' => 'required',
            'nominal' => 'required|numeric',
            'tanggal' => 'required|date',
        ]);

        $pembayaran = Pembayaran::create([
            'pelanggan_id' => $request->pelanggan_id,
            'nominal' => $request->nominal,
            'tanggal' => $request->tanggal,
        ]);

        // Mengambil data pelanggan yang sesuai
        $pelanggan = Pelanggan::find($request->pelanggan_id);

        // Generate PDF menggunakan view dan data yang diambil
        $pdf = Pdf::loadView('pembayaran.receipt', compact('pembayaran', 'pelanggan'));

        // Mengembalikan file PDF
        return $pdf->download('kwitansi_pembayaran.pdf');
    }

    public function getPelangganData($id)
    {
        $pelanggan = Pelanggan::find($id);
        
        if ($pelanggan) {
            return response()->json($pelanggan);
        } else {
            return response()->json(['error' => 'Pelanggan tidak ditemukan'], 404);
        }
    }
}
