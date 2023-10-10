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

class CustomersExport implements FromCollection,WithHeadings,WithColumnFormatting, WithMapping, ShouldAutoSize
{
    protected $customers;

    public function __construct($customers)
    {
        $this->customers = $customers;
    }

    public function collection()
    {
        return $this->customers;
    }

    public function headings():array{
        return [
            __('full_name'),
            __('Phone'),
            __('Email'),
            __('created at'),
        ];
    }

    public function map($customer): array
    {
        // dd($customer->created_at);
        return [
            $customer->full_name,
            $customer->phone,
            $customer->email,
            Date::dateTimeToExcel(Carbon::parse($customer->created_at)),
        ];
    }
    
    public function columnFormats(): array
    {
        return [
            'B' => '0#" "##" "##" "##" "##',
            'D' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }
}
