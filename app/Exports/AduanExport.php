<?php

namespace App\Exports;

use App\Models\Aduan;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AduanExport implements
    FromCollection,
    WithHeadings,
    WithStyles,
    WithColumnWidths,
    WithTitle,
    WithEvents
{
    protected $aduans;

    public function __construct()
    {
        $user = Auth::user();

        if ($user->role === 'petugas') {
            $this->aduans = Aduan::with('petugas')
                ->where('created_by', $user->id)
                ->orderBy('tanggal_aduan', 'desc')
                ->get();
        } else {
            $this->aduans = Aduan::with('petugas')
                ->orderBy('tanggal_aduan', 'desc')
                ->get();
        }
    }

    public function collection()
    {
        $no = 1;
        return $this->aduans->map(function ($aduan) use (&$no) {
            return [
                'No'              => $no++,
                'Nomor Aduan'     => $aduan->nomor_aduan,
                'Tanggal'         => $aduan->tanggal_aduan
                                        ? $aduan->tanggal_aduan->format('d/m/Y')
                                        : '-',
                'Kanal'           => $aduan->kanal        ?? '-',
                'Klasifikasi'     => $aduan->klasifikasi  ?? '-',
                'Nama Pelapor'    => $aduan->nama_pelapor,
                'Nama Akun'       => $aduan->nama_akun    ?? '-',
                'Kontak'          => $aduan->kontak_pelapor ?? '-',
                'Isi Aduan'       => $aduan->isi_aduan,
                'Status Respon'   => $aduan->sudah_direspon ? 'Sudah Direspon' : 'Belum Direspon',
                'Isi Respon'      => $aduan->isi_respon_awal ?? '-',
                'Petugas Input'   => $aduan->petugas->name ?? '-',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No',
            'Nomor Aduan',
            'Tanggal',
            'Kanal',
            'Klasifikasi',
            'Nama Pelapor',
            'Nama Akun Sosmed',
            'Kontak',
            'Isi Aduan',
            'Status Respon',
            'Isi Respon',
            'Petugas Input',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,   // No
            'B' => 18,  // Nomor Aduan
            'C' => 14,  // Tanggal
            'D' => 16,  // Kanal
            'E' => 16,  // Klasifikasi
            'F' => 22,  // Nama Pelapor
            'G' => 20,  // Nama Akun Sosmed
            'H' => 20,  // Kontak
            'I' => 50,  // Isi Aduan
            'J' => 18,  // Status Respon
            'K' => 45,  // Isi Respon
            'L' => 22,  // Petugas Input
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $totalRows = $this->aduans->count() + 2; // +1 header +1 karena mulai dari baris 2

        // Header styling (baris 1)
        $sheet->getStyle('A1:L1')->applyFromArray([
            'font' => [
                'bold'  => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size'  => 11,
            ],
            'fill' => [
                'fillType'   => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '1E40AF'], // biru tua
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER,
                'wrapText'   => true,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color'       => ['rgb' => 'FFFFFF'],
                ],
            ],
        ]);

        // Tinggi baris header
        $sheet->getRowDimension(1)->setRowHeight(30);

        // Styling data rows
        if ($totalRows > 1) {
            // Baris genap & ganjil (zebra striping)
            for ($row = 2; $row <= $totalRows; $row++) {
                $bgColor = ($row % 2 === 0) ? 'EFF6FF' : 'FFFFFF'; // biru muda / putih

                $sheet->getStyle("A{$row}:L{$row}")->applyFromArray([
                    'fill' => [
                        'fillType'   => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => $bgColor],
                    ],
                    'font' => ['size' => 10],
                    'alignment' => [
                        'vertical' => Alignment::VERTICAL_TOP,
                        'wrapText' => true,
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color'       => ['rgb' => 'DBEAFE'],
                        ],
                    ],
                ]);

                // Tinggi baris data
                $sheet->getRowDimension($row)->setRowHeight(60);
            }

            // Kolom No: rata tengah
            $sheet->getStyle("A2:A{$totalRows}")->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_CENTER);

            // Kolom Tanggal: rata tengah
            $sheet->getStyle("C2:C{$totalRows}")->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_CENTER);

            // Kolom Kanal & Klasifikasi: rata tengah
            $sheet->getStyle("D2:E{$totalRows}")->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_CENTER);

            // Kolom Status Respon: rata tengah + warna sesuai status
            for ($row = 2; $row <= $totalRows; $row++) {
                $cellValue = $sheet->getCell("J{$row}")->getValue();
                if ($cellValue === 'Sudah Direspon') {
                    $sheet->getStyle("J{$row}")->applyFromArray([
                        'font' => ['color' => ['rgb' => '15803D'], 'bold' => true],
                    ]);
                } else {
                    $sheet->getStyle("J{$row}")->applyFromArray([
                        'font' => ['color' => ['rgb' => 'DC2626'], 'bold' => true],
                    ]);
                }
                $sheet->getStyle("J{$row}")->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER);
            }
        }

        return [];
    }

    public function title(): string
    {
        return 'Data Aduan';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Freeze baris header agar tetap terlihat saat scroll
                $sheet->freezePane('A2');

                // Auto filter pada header
                $sheet->setAutoFilter('A1:L1');

                // Set print area & orientasi landscape
                $sheet->getPageSetup()
                    ->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE)
                    ->setFitToWidth(1)
                    ->setFitToHeight(0)
                    ->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A3);

                // Print title (header berulang di setiap halaman)
                $sheet->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 1);

                // Margin cetak
                $sheet->getPageMargins()->setTop(0.5)->setBottom(0.5)->setLeft(0.5)->setRight(0.5);

                // Nama sheet tab dengan tanggal generate
                $event->sheet->getDelegate()->getParent()
                    ->getActiveSheet()
                    ->setTitle('Aduan_' . date('Ymd'));
            },
        ];
    }
}
