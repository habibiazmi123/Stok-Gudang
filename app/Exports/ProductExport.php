<?php

namespace App\Exports;

use App\Product;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;

class ProductExport implements FromCollection, WithHeadings, ShouldAutoSize, WithMapping, WithColumnFormatting
{
    public $start, $end;

    public function __construct($start, $end)
    {
        $this->start = $start;
        $this->end = $end;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Product::select(
            "product_code",
            "name",
            "unit",
            "qty",
            DB::raw("(SELECT sum(qty) FROM product_stock WHERE product_id=product.id AND type = 'in' AND DATE(created_at) >= '" . $this->start . "' AND DATE(created_at) <= '" . $this->end . "') as sum_in"),
            DB::raw("(SELECT sum(qty) FROM product_stock WHERE product_id=product.id AND type = 'out' AND DATE(created_at) >= '" . $this->start . "' AND DATE(created_at) <= '" . $this->end . "') as sum_out")
        )
            ->get();
    }

    public function headings(): array
    {
        return [
            "KODE BARANG",
            "NAMA BARANG",
            "SATUAN",
            "BARANG MASUK",
            "BARANG KELUAR",
            "STOK SAAT INI"
        ];
    }

    public function map($row): array
    {
        return [
            $row->product_code,
            $row->name,
            $row->unit,
            $row->sum_in,
            $row->sum_out,
            $row->qty
        ];
    }

    public function columnFormats(): array
    {
        return [];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $cellRange = 'A1:W1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
            },
        ];
    }
}
