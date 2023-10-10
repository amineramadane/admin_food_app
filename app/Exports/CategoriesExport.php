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

class CategoriesExport implements FromCollection,WithHeadings, WithMapping, ShouldAutoSize
{
    protected $categories;

    public function __construct($categories)
    {
        $this->categories = $categories;
    }

    public function collection()
    {
        return $this->categories;
    }

    public function headings():array{
        return [
            __('name'),
            __('active'),
            __('descripton'),
        ];
    }

    public function map($category): array
    {
        // dd($category->created_at);
        return [
            $category->name,
            __(HelperSelects::Boolean[$category->active]),
            $category->descripton,
        ];
    }
    
}
