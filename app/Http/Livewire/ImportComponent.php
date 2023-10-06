<?php

namespace App\Http\Livewire;

use Livewire\{Component, WithFileUploads};
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;

class ImportComponent extends Component
{
    use WithFileUploads;

    public $key;
    public $DemoFile;
    public $ImportModels;
    public $rules = [];

    public $orderListFixed;
    public $orderList;
    public $file;
    public $titlesValidateColumn;
    public $dataValidateColumn;
    public $dataValidateRows;
    public $date;
    public $withFirstLine;
    public $showFirstLine;
    public $ClassCssModalDialog;
    public $ClassCssPart1;
    public $ClassCssPart2;
    public $ClassCssPart3;
 
    public function render()
    {
        return view('livewire.import.index');
    }

    public function mount()
    {
        $this->resetAll();
    }

    public function downloadDemoFile()
    {
        return response()->download(public_path($this->DemoFile));
    }

    public function updatedWithFirstLine()
    {
        if ($this->ClassCssPart3 == '') $this->validateColumn();
    }

    public function updatedShowFirstLine()
    {
        if ($this->ClassCssPart3 == '') $this->validateColumn();
    }

    public function getModelName()
    {
        $ImportModelNames = explode('\\', $this->ImportModels);
        return Str::singular(Str::remove('Import', end($ImportModelNames)));
    }

    public function resetAll()
    {
        $this->date = [];
        $this->orderList = [];
        $this->orderListFixed = [];
        $this->dataValidateColumn = [];
        $this->dataValidateRows = [];
        $this->file = null;
        $this->withFirstLine = true;
        $this->showFirstLine = true;
        $this->ClassCssModalDialog = 'modal-md';
        $this->ClassCssPart1 = '';
        $this->ClassCssPart2 = 'd-none';
        $this->ClassCssPart3 = 'd-none';
    }

    public function updatedFile($file)
    {
        if (isset($file)) {
            // Stockage
            if (isset($this->ImportModels::$StorageFolderName)) $StorageFolderName = $this->ImportModels::$StorageFolderName;
            else $StorageFolderName = $this->getModelName();

            try {
                $file->storeAs('uploads/' . $StorageFolderName, date('d-m-Y H-i-s ') . $file->getClientOriginalName());
                // session()->flash('success', __('Uploading file success!'));
                $this->ClassCssModalDialog = 'modal-xl';
                // $this->ClassCssPart1 = 'd-none';
                $this->ClassCssPart2 = '';

                $ImportModels = new $this->ImportModels(1, 1, null);
                $this->dataValidateColumn = Excel::toArray($this->ImportModels, $file->path())[0];
                $this->orderList = $ImportModels->orderList;
                $this->orderListFixed = $this->orderList;

                // Le cas de changement de fichier il faut actualiser le tableau aussi et verifier les colonne
                if ($this->dataValidateRows != []) $this->validateColumn();
            } catch (\Throwable $th) {
                session()->flash('error', __("There has been an error!"));
            }
        }
    }

    public function validateColumn()
    {
        if (empty($this->rules) || (!empty($this->rules) && $this->validate())) {
            $this->ClassCssPart3 = '';
            $this->dataValidateRows = Excel::toArray(new $this->ImportModels($this->showFirstLine ? 1 : 2, ($this->showFirstLine) ? 4 : 3), $this->file->path())[0];
        }
    }

    public function importFile()
    {
        if (empty($this->rules) || (!empty($this->rules) && $this->validate())) {
            $ImportModels = new $this->ImportModels($this->withFirstLine ? 2 : 1, 99999999, null);
            $ImportModels->orderList = array_filter($this->orderList, 'strlen');
            Excel::import($ImportModels, $this->file->path());

            // $this->resetAll();
            $this->emit($this->getModelName() . 'IndexRender');
        }
    }
}
