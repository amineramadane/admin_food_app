<?php
      
namespace App\Http\Livewire;
use Livewire\{Component, WithFileUploads};
use App\Models\{Category};
use HelperSelects;
use App\Exports\CategoriesExport;
use Maatwebsite\Excel\Facades\Excel;

class CategoryComponent extends Component
{
    use \Livewire\WithPagination, \App\Traits\SinglePageTrait, WithFileUploads;

    public function mount($id = null)
    {
        $this->Model = Category::class;

        $this->mountSync($id);
        $this->mountSyncUrl();
    }

    public function export() 
    {
        return Excel::download(new CategoriesExport($this->dataTable()), __('categories').'.xlsx');
    }
        
    public function render()
    {
        if($this->view == 'index') $this->resetErrorBag();
        if($this->view == 'create') {
            $this->Object->active ??= 1;
        }
        $this->editRules = [
            'Object.name' => 'required',
            'Object.description' => '',
            'Object.active' => 'required',
        ];
        
        $this->renderSync();
        $this->renderSyncUrl();
        $this->renderSyncRules();

        // List Table
        if($this->view == 'index') $compact['TableList'] = $this->dataTable();
        $compact['ListBoolean'] =  HelperSelects::Boolean;
        
        return view('livewire.category.page', $compact ?? []);
    }
}
