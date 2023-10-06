<?php

namespace App\Imports;

use App\Models\Article;
use App\Helpers\ArticleList;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use App\Traits\ImportComponentTrait;

use Maatwebsite\Excel\Concerns\{Importable, ToCollection, WithLimit, WithMapping, WithStartRow, WithValidation};

class ImportArticles implements ToCollection, WithStartRow, WithLimit, WithValidation, WithMapping
{
    use ImportComponentTrait, Importable;
    // public static $StorageFolderName = 'ImportArticles';

    public function map($row): array
    {
        try {
            $row[$this->ColumnToIndex_AfterChange('unite_stock')] = trim($row[$this->ColumnToIndex_AfterChange('unite_stock')]);
            return $row;
        } catch (\Throwable $th) {
            return $row;
        }
    }

    public function rules(): array
    {
        return [
            '*.' . $this->ColumnToIndex_AfterChange('reference') => 'nullable|distinct:ignore_case',
            '*.' . $this->ColumnToIndex_AfterChange('reference_origine') => 'required|distinct:ignore_case',
            '*.' . $this->ColumnToIndex_AfterChange('type') => 'required|size:2|in:' . implode(',', $this->PermuteStringByChangingCase(ArticleList::TYPE)),
            '*.' . $this->ColumnToIndex_AfterChange('designation') => 'nullable',
            '*.' . $this->ColumnToIndex_AfterChange('nature_id') => 'nullable|integer',
            '*.' . $this->ColumnToIndex_AfterChange('qte_stock') => 'nullable|numeric',
            '*.' . $this->ColumnToIndex_AfterChange('unite_stock') => 'required|min:1|max:2|in:' . implode(',', $this->PermuteStringByChangingCase(ArticleList::UNITESTOCK)),
            '*.' . $this->ColumnToIndex_AfterChange('min_stock') => 'nullable|numeric',
            '*.' . $this->ColumnToIndex_AfterChange('prix_achat') => 'nullable|numeric',
            '*.' . $this->ColumnToIndex_AfterChange('pmp') => 'nullable|numeric',
            '*.' . $this->ColumnToIndex_AfterChange('num_lame') => 'nullable|integer',
            '*.' . $this->ColumnToIndex_AfterChange('position_id') => 'nullable|integer',
            '*.' . $this->ColumnToIndex_AfterChange('type_lame') => 'nullable|integer',
            '*.' . $this->ColumnToIndex_AfterChange('accessoires') => 'nullable|size:4|in:' . implode(',', $this->PermuteStringByChangingCase(ArticleList::ACCESSOIRES)),
            '*.' . $this->ColumnToIndex_AfterChange('origin_id') => 'nullable|integer',
            '*.' . $this->ColumnToIndex_AfterChange('decription') => 'nullable|string',
            '*.' . $this->ColumnToIndex_AfterChange('marque_id') => 'nullable|integer',
            '*.' . $this->ColumnToIndex_AfterChange('chant') => 'nullable|string',
            '*.' . $this->ColumnToIndex_AfterChange('nuance') => 'nullable|string',
            '*.' . $this->ColumnToIndex_AfterChange('adressage') => 'nullable|string',
            '*.' . $this->ColumnToIndex_AfterChange('fournisseur_1') => 'nullable|string',
            '*.' . $this->ColumnToIndex_AfterChange('fournisseur_2') => 'nullable|string',
            '*.' . $this->ColumnToIndex_AfterChange('fournisseur_3') => 'nullable|string',
            '*.' . $this->ColumnToIndex_AfterChange('largeur') => 'nullable|numeric',
            '*.' . $this->ColumnToIndex_AfterChange('epaisseur') => 'nullable|numeric',
            '*.' . $this->ColumnToIndex_AfterChange('diametre') => 'nullable|numeric',
            '*.' . $this->ColumnToIndex_AfterChange('diametre_exterieur') => 'nullable|numeric',
            '*.' . $this->ColumnToIndex_AfterChange('diametre_interieur') => 'nullable|numeric',
            // '*.' . $this->ColumnToIndex_AfterChange('section') => 'nullable|string',
            '*.' . $this->ColumnToIndex_AfterChange('tolerance') => 'nullable|integer',
        ];
    }

    public $orderList = [
        'reference'          => 0,
        'reference_origine'  => 1,
        'type'               => 2,
        'designation'        => 3,
        'nature_id'          => 4,
        'qte_stock'          => 5,
        'unite_stock'        => 6,
        'min_stock'          => 7,
        'prix_achat'         => 8,
        'pmp'                => 9,
        'num_lame'           => 10,
        'position_id'        => 11,
        'type_lame'          => 12,
        'accessoires'        => 13,
        'origin_id'          => 14,
        'decription'         => 15,
        'marque_id'          => 16,
        'chant'              => 17,
        'nuance'             => 18,
        'adressage'          => 19,
        'fournisseur_1'      => 20,
        'fournisseur_2'      => 21,
        'fournisseur_3'      => 22,
        'largeur'            => 23,
        'epaisseur'          => 24,
        'diametre'           => 25,
        'diametre_exterieur' => 26,
        'diametre_interieur' => 27,
        // 'section'            => 28,
        'tolerance'          => 28,
    ];

    public function collection(Collection $rows)
    {
        DB::beginTransaction();
        try {
            $array = [];
            foreach ($rows as $row) {
                foreach ($this->orderList as $columnName => $index)
                    if (isset($row[$index])) $array[$columnName] = $row[$index];
                if (isset($array['type'])) $array['type'] = array_search(strtolower(trim($array['type'])), array_map('strtolower', ArticleList::TYPE)) ?: null;
                if (isset($array['unite_stock'])) $array['unite_stock'] = array_search(strtolower(trim($array['unite_stock'])), array_map('strtolower', ArticleList::UNITESTOCK)) ?: null;
                if (isset($array['accessoires'])) $array['accessoires'] = array_search(strtolower(trim($array['accessoires'])), array_map('strtolower', ArticleList::ACCESSOIRES)) ?: null;

                Article::updateOrCreate(
                    [
                        'reference_origine' => $array['reference_origine'],
                    ],
                    $array ?? []
                );
            }
            DB::commit();
            session()->flash('success', __('Article imported!'));
        } catch (\Throwable $th) {

            DB::rollback();
            // session()->flash('error', __(Str::limit($th->getMessage(), 300, '...')));
            $str = $th->getMessage();
            $str = wordwrap($str, 150);
            $str = explode("\n", $str);
            session()->flash('error', __($str[0] . '...'));

            // session()->flash('error', __("There has been an error!"));
        }
    }
}
