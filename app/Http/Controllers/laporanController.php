<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class laporanController extends Controller
{
    public function laporanPelanggan()
    {
        $pelanggan = Pelanggan::with(['pembayaran' => function ($query) {
            $query->selectRaw('pelanggan_id, 
            SUM(CASE WHEN MONTH(tanggal) = 1 THEN nominal ELSE 0 END) AS januari,
            SUM(CASE WHEN MONTH(tanggal) = 2 THEN nominal ELSE 0 END) AS februari,
            SUM(CASE WHEN MONTH(tanggal) = 3 THEN nominal ELSE 0 END) AS maret,
            SUM(CASE WHEN MONTH(tanggal) = 4 THEN nominal ELSE 0 END) AS april,
            SUM(CASE WHEN MONTH(tanggal) = 5 THEN nominal ELSE 0 END) AS mei,
            SUM(CASE WHEN MONTH(tanggal) = 6 THEN nominal ELSE 0 END) AS juni,
            SUM(CASE WHEN MONTH(tanggal) = 7 THEN nominal ELSE 0 END) AS juli,
            SUM(CASE WHEN MONTH(tanggal) = 8 THEN nominal ELSE 0 END) AS agustus,
            SUM(CASE WHEN MONTH(tanggal) = 9 THEN nominal ELSE 0 END) AS september,
            SUM(CASE WHEN MONTH(tanggal) = 10 THEN nominal ELSE 0 END) AS oktober,
            SUM(CASE WHEN MONTH(tanggal) = 11 THEN nominal ELSE 0 END) AS november,
            SUM(CASE WHEN MONTH(tanggal) = 12 THEN nominal ELSE 0 END) AS desember')
                ->groupBy('pelanggan_id');
        }])->get();

        return view('laporan.index', compact('pelanggan'));
    }
    public function exportExcel()
    {
        $pelanggan = Pelanggan::with(['pembayaran' => function ($query) {
            $query->selectRaw('pelanggan_id, 
            SUM(CASE WHEN MONTH(tanggal) = 1 THEN nominal ELSE 0 END) AS januari,
            SUM(CASE WHEN MONTH(tanggal) = 2 THEN nominal ELSE 0 END) AS februari,
            SUM(CASE WHEN MONTH(tanggal) = 3 THEN nominal ELSE 0 END) AS maret,
            SUM(CASE WHEN MONTH(tanggal) = 4 THEN nominal ELSE 0 END) AS april,
            SUM(CASE WHEN MONTH(tanggal) = 5 THEN nominal ELSE 0 END) AS mei,
            SUM(CASE WHEN MONTH(tanggal) = 6 THEN nominal ELSE 0 END) AS juni,
            SUM(CASE WHEN MONTH(tanggal) = 7 THEN nominal ELSE 0 END) AS juli,
            SUM(CASE WHEN MONTH(tanggal) = 8 THEN nominal ELSE 0 END) AS agustus,
            SUM(CASE WHEN MONTH(tanggal) = 9 THEN nominal ELSE 0 END) AS september,
            SUM(CASE WHEN MONTH(tanggal) = 10 THEN nominal ELSE 0 END) AS oktober,
            SUM(CASE WHEN MONTH(tanggal) = 11 THEN nominal ELSE 0 END) AS november,
            SUM(CASE WHEN MONTH(tanggal) = 12 THEN nominal ELSE 0 END) AS desember')
                ->groupBy('pelanggan_id');
        }])->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header Titles
        $headers = ['Nama', 'Wilayah', 'Kewajiban Iuran', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $sheet->fromArray($headers, null, 'A1');

        // Apply Styles to Headers
        $headerStyle = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4CAF50'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ];

        // Apply Header Style
        $sheet->getStyle('A1:O1')->applyFromArray($headerStyle);

        // Fill Data
        $row = 2;
        foreach ($pelanggan as $item) {
            $sheet->setCellValue('A' . $row, $item->nama);
            $sheet->setCellValue('B' . $row, $item->wilayah);
            $sheet->setCellValue('C' . $row, $item->kewajiban_iuran);
            $sheet->setCellValue('D' . $row, optional($item->pembayaran->first())->januari);
            $sheet->setCellValue('E' . $row, optional($item->pembayaran->first())->februari);
            $sheet->setCellValue('F' . $row, optional($item->pembayaran->first())->maret);
            $sheet->setCellValue('G' . $row, optional($item->pembayaran->first())->april);
            $sheet->setCellValue('H' . $row, optional($item->pembayaran->first())->mei);
            $sheet->setCellValue('I' . $row, optional($item->pembayaran->first())->juni);
            $sheet->setCellValue('J' . $row, optional($item->pembayaran->first())->juli);
            $sheet->setCellValue('K' . $row, optional($item->pembayaran->first())->agustus);
            $sheet->setCellValue('L' . $row, optional($item->pembayaran->first())->september);
            $sheet->setCellValue('M' . $row, optional($item->pembayaran->first())->oktober);
            $sheet->setCellValue('N' . $row, optional($item->pembayaran->first())->november);
            $sheet->setCellValue('O' . $row, optional($item->pembayaran->first())->desember);
            $row++;
        }

        // Apply Borders to Data Cells
        $sheet->getStyle('A2:O' . ($row - 1))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        // Auto Width for All Columns
        foreach (range('A', 'O') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $fileName = 'Laporan_Pelanggan.xlsx';
        $filePath = storage_path('app/public/' . $fileName);

        $writer->save($filePath);

        return response()->download($filePath);
    }
    public function exportPDF()
    {
        $pelanggan = Pelanggan::with(['pembayaran' => function ($query) {
            $query->selectRaw('pelanggan_id, 
            SUM(CASE WHEN MONTH(tanggal) = 1 THEN nominal ELSE 0 END) AS januari,
            SUM(CASE WHEN MONTH(tanggal) = 2 THEN nominal ELSE 0 END) AS februari,
            SUM(CASE WHEN MONTH(tanggal) = 3 THEN nominal ELSE 0 END) AS maret,
            SUM(CASE WHEN MONTH(tanggal) = 4 THEN nominal ELSE 0 END) AS april,
            SUM(CASE WHEN MONTH(tanggal) = 5 THEN nominal ELSE 0 END) AS mei,
            SUM(CASE WHEN MONTH(tanggal) = 6 THEN nominal ELSE 0 END) AS juni,
            SUM(CASE WHEN MONTH(tanggal) = 7 THEN nominal ELSE 0 END) AS juli,
            SUM(CASE WHEN MONTH(tanggal) = 8 THEN nominal ELSE 0 END) AS agustus,
            SUM(CASE WHEN MONTH(tanggal) = 9 THEN nominal ELSE 0 END) AS september,
            SUM(CASE WHEN MONTH(tanggal) = 10 THEN nominal ELSE 0 END) AS oktober,
            SUM(CASE WHEN MONTH(tanggal) = 11 THEN nominal ELSE 0 END) AS november,
            SUM(CASE WHEN MONTH(tanggal) = 12 THEN nominal ELSE 0 END) AS desember')
                ->groupBy('pelanggan_id');
        }])->get();

        $html = view('laporan.pelanggan_pdf', compact('pelanggan'))->render();

        $options = new Options();
        $options->set('defaultFont', 'Courier');
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream('Laporan_Pelanggan.pdf', ['Attachment' => true]);
    }
}
