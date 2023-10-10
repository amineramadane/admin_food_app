<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Carbon\Carbon;

use HelperSelects;

class ProductsExport implements FromCollection,WithHeadings, WithMapping, ShouldAutoSize
{
    protected $products;

    public function __construct($products)
    {
        $this->products = $products;
    }

    public function collection()
    {
        return $this->products;
    }

    public function headings():array{
        return [
            __('name'),
            __('category'),
            __('vat_rate'),
            __('ht_price'),
            __('price'),
            __('prepareTime'),
            __('description'),
            __('active'),
        ];
    }

    public function map($product): array
    {
        // dd($product->created_at);
        return [
            $product->name,
            $product->category->name,
            "$product->vat_rate",
            $product->ht_price,
            $product->price,
            $product->prepareTime,
            $product->description,
            __(HelperSelects::Boolean[$product->active]),
        ];
    }
    
}
