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
            '*.' . $this->ColumnToIndex_AfterChange('phone') => 'required|numeric|notIn:' . implode(',',Customer::where('status', 1)->pluck('phone')->toArray() ?? []),
            '*.' . $this->ColumnToIndex_AfterChange('email') => 'nullable|email|distinct:ignore_case',
            '*.' . $this->ColumnToIndex_AfterChange('language_id') => 'required|in:' . implode(',',Language::pluck('code')->toArray() ?? []),
        ];
    }

    public $orderList = [
        'full_name'  => 0,
        'phone'       => 1,
        'email'       => 2,
        'language_id' => 3,
    ];

    public function collection(Collection $rows)
    {
        DB::beginTransaction();
        try {
            
            $array = [];
            foreach ($rows as $row) {
                foreach ($this->orderList as $columnName => $index){
                    if ($columnName == 'language_id') $array['language_id'] = Language::pluck('id','code')->toArray()[$row[$index]] ?: null;
                    elseif (isset($row[$index])) $array[$columnName] = $row[$index];
                }

                Customer::updateOrCreate(
                    [
                        'status' => 1,
                        'number_times_sent' => 0
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
