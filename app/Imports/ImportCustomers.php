<?php

namespace App\Imports;

use App\Models\{Customer, Language};
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use App\Traits\ImportComponentTrait;
use Illuminate\Support\Str;

use Maatwebsite\Excel\Concerns\{Importable, ToCollection, WithLimit, WithMapping, WithStartRow, WithValidation};

class ImportCustomers implements ToCollection, WithStartRow, WithLimit, WithValidation, WithMapping
{
    use ImportComponentTrait, Importable;
    
    public function map($row): array
    {
        try {
            $row[$this->ColumnToIndex_AfterChange('phone')] = preg_replace('/[^\d0-9]/i', '', $row[$this->ColumnToIndex_AfterChange('phone')]);
            return $row;
        } catch (\Throwable $th) {
            return $row;
        }
    }
    public function rules(): array
    {
        return [
            '*.' . $this->ColumnToIndex_AfterChange('full_name') => 'nullable',
            '*.' . $this->ColumnToIndex_AfterChange('phone') => 'required|numeric|notIn:' . implode(',',Customer::pluck('phone')->toArray() ?? []),
            '*.' . $this->ColumnToIndex_AfterChange('email') => 'nullable|email|distinct:ignore_case',
        ];
    }

    public $orderList = [
        'full_name'  => 0,
        'phone'       => 1,
        'email'       => 2,
    ];

    public function collection(Collection $rows)
    {
        DB::beginTransaction();
        try {
            
            $array = [];
            foreach ($rows as $row) {
                foreach ($this->orderList as $columnName => $index){
                    if (isset($row[$index])) $array[$columnName] = $row[$index];
                }

                Customer::updateOrCreate(
                    [
                        
                    ],
                    $array ?? []
                );
            }
            DB::commit();
            session()->flash('success', __('Customer imported!'));
        } catch (\Throwable $th) {
            DB::rollback();
            $str = $th->getMessage();
            $str = wordwrap($str, 150);
            $str = explode("\n", $str);
            session()->flash('error', __($str[0] . '...'));
        }
    }

}
