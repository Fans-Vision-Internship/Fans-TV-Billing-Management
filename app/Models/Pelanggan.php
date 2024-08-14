<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;

    protected $table = 'pelanggan';

    protected $fillable = [
        'nama',
        'wilayah',
        'kewajiban_iuran',
    ];

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class);
    }
}
