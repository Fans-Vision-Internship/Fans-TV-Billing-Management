<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Pelanggan;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ImportDataFromExcel extends Command
{
    protected $signature = 'import:data-excel {file}'; // Parameter file excel
    protected $description = 'Import data pelanggan dari file Excel';

    public function handle()
    {
        $filePath = $this->argument('file'); // Dapatkan path file dari argument

        // Load file Excel
        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();

        // Loop dari baris ke-4 sampai ke-113
        for ($row = 4; $row <= 113; $row++) {
            // Ambil data dari kolom B (Nama), C (Wilayah), dan D (Kewajiban Iuran)
            $nama = $sheet->getCell("B$row")->getValue();
            $wilayah = $sheet->getCell("C$row")->getValue();
            $kewajibanIuran = $sheet->getCell("D$row")->getValue();

            // Mulai transaksi
            DB::beginTransaction();

            try {
                // Cari atau buat pelanggan
                Pelanggan::firstOrCreate(
                    ['nama' => $nama],
                    [
                        'wilayah' => $wilayah,
                        'kewajiban_iuran' => $kewajibanIuran,
                    ]
                );

                // Commit transaksi
                DB::commit();

            } catch (\Exception $e) {
                // Rollback transaksi jika ada error
                DB::rollBack();
                Log::error('Error importing data: ' . $e->getMessage());
            }
        }

        $this->info('Data pelanggan imported successfully!');
    }
}
