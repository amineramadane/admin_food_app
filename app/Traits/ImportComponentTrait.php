<?php

namespace App\Traits;

trait ImportComponentTrait
{
    public $startRow = 1;
    public $limitRows = 1;
    private $arrayExcelColulmn = [];
    public $orderListDefault = null;

    public function __construct($startRow = 1, $limitRows = 1, $orderList = null)
    {
        $this->startRow = $startRow;
        $this->limitRows = $limitRows;

        if ($this->orderListDefault == null) $this->orderListDefault = $this->orderList;
        if ($orderList) $this->orderList = $orderList;

        // list A, B, C to ... CX, CY, CZ (Excel Column)
        $n = 'A';
        do {
            $this->arrayExcelColulmn[] = $n++;
        } while ($n !== 'CZ');
    }

    public function startRow(): int
    {
        return $this->startRow;
    }
    public function limit(): int
    {
        return $this->limitRows;
    }

    // public function prepareForValidation($data, $index)
    // {
    //     // dd($data, $index, $this->orderList);
    //     return $data;
    // }

    public function ColumnToIndex_AfterChange($columnName): int
    {
        if (!isset($this->orderList[$columnName])) return $this->orderListDefault[$columnName];
        return array_search(array_search($this->orderList[$columnName], $this->orderListDefault), array_keys($this->orderListDefault));
    }

    public function withValidator(\Illuminate\Validation\Validator $validator)
    {
        foreach ($validator->getMessageBag()->messages() as $key => $value) {
            $arrayPosition = explode('.', $key);
            session()->flash('error', __('[' . $this->arrayExcelColulmn[$arrayPosition[1]] . $arrayPosition[0] . '] : ' . $value[0]));
            return false;
        }

        // if($validator->fails()) session()->flash('error', __($validator->getMessageBag()->first()));
    }

    public function PermuteStringByChangingCase($array)
    {
        $result = [];
        foreach ($array as $input) {
            
            $n = strlen($input);

            // Number of permutations is 2^n
            $max = 1 << $n;

            // Converting string to lower case
            $input = strtolower($input);

            // Using all subsequences and permuting them
            for ($i = 0; $i < $max; $i++) {
                $combination = $input;

                // If j-th bit is set, we convert
                // it to upper case
                for ($j = 0; $j < $n; $j++) {
                    if ((($i >> $j) & 1) == 1)
                        $combination[$j] = chr(ord($combination[$j]) - 32);
                }

                // Add to array the current combination
                $result[] = $combination;
            }
        }
        return $result;
    }
}
