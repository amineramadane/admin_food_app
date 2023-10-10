<?php
      
namespace App\Http\Livewire;
use Livewire\{Component, WithFileUploads};
use App\Models\{Category, Product};
use HelperSelects;
use App\Exports\ProductsExport;
use Maatwebsite\Excel\Facades\Excel;

class ProductComponent extends Component
{
    use \Livewire\WithPagination, \App\Traits\SinglePageTrait, WithFileUploads;

    public function mount($id = null)
    {
        $this->Model = Product::class;

        $this->mountSync($id);
        $this->mountSyncUrl();
    }

    public function export() 
    {
        return Excel::download(new ProductsExport($this->dataTable()), __('products').'.xlsx');
    }
        
    public function render()
    {
        if($this->view == 'index') $this->resetErrorBag();
        if($this->view == 'create') {
            $this->Object->active ??= 1;
            $this->Object->vat_rate ??= HelperSelects::VatRates[0];
        }
        $this->editRules = [
            'Object.name' => 'required',
            'Object.category_id' => 'required',
            'Object.vat_rate' => 'required|numeric|min:0',
            'Object.ht_price' => 'required|numeric|min:0',
            'Object.prepareTime' => 'required|numeric|min:1',
            'Object.description' => '',
            'Object.active' => 'required',
        ];
        
        $this->renderSync();
        $this->renderSyncUrl();
        $this->renderSyncRules();

        // List Table
        if($this->view == 'index') $compact['TableList'] = $this->dataTable();
        $compact['ListBoolean'] =  HelperSelects::Boolean;
        $compact['ListCategories'] =  Category::pluck('name', 'id');
        $compact['ListVatRates'] =  HelperSelects::VatRates;
        
        return view('livewire.product.page', $compact ?? []);
    }
}
