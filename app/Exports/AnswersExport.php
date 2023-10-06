<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use HelperSelects;

class AnswersExport implements FromCollection,WithHeadings,WithColumnFormatting, WithMapping, ShouldAutoSize
{
    protected $answers;

    public function __construct($answers)
    {
        $this->answers = $answers;
    }

    public function collection()
    {
        return $this->answers;
    }

    public function headings():array{
        return [
            __('full name'),
            __('Questions'),
            __('status'),
            __('Answers'),
            __('Sending Date'),
            __('Answer date')
        ];
    }

    public function map($answers): array
    {
        return [
            $answers->contact()->first()->full_name,
            $answers->question()->first()->title,
            __(HelperSelects::Answer_STATUS[$answers->status]),
            $answers->answer,
            Date::dateTimeToExcel($answers->created_at),
            Date::dateTimeToExcel($answers->updated_at)
        ];
    }
    
    public function columnFormats(): array
    {
        return [
            'E' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'F' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }
}
