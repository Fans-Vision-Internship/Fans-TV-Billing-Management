<?php
namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

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

        Pembayaran::create([
            'pelanggan_id' => $request->pelanggan_id,
            'nominal' => $request->nominal,
            'tanggal' => $request->tanggal,
        ]);

        return redirect()->route('pembayaran.create')->with('success', 'Pembayaran berhasil ditambahkan.');
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
