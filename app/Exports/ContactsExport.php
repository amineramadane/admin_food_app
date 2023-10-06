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

class ContactsExport implements FromCollection,WithHeadings,WithColumnFormatting, WithMapping, ShouldAutoSize
{
    protected $contacts;

    public function __construct($contacts)
    {
        $this->contacts = $contacts;
    }

    public function collection()
    {
        return $this->contacts;
    }

    public function headings():array{
        return [
            __('full_name'),
            __('Phone'),
            __('Email'),
            __('language'),
            __('Status'),
            __('Sending Date')
        ];
    }

    public function map($contact): array
    {
        // dd($contact->created_at);
        return [
            $contact->full_name,
            $contact->phone,
            $contact->email,
            $contact->language()->first()->code,
            __(HelperSelects::Contact_STATUS[$contact->status]),
            Date::dateTimeToExcel(Carbon::parse($contact->send_at)),
        ];
    }
    
    public function columnFormats(): array
    {
        return [
            'B' => '0#" "##" "##" "##" "##',
            'F' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }
}
