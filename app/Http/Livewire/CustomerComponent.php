<?php
      
namespace App\Http\Livewire;
use Livewire\Component;
use App\Models\{Customer};
use HelperSelects;
use App\Exports\CustomersExport;
use Maatwebsite\Excel\Facades\Excel;

class CustomerComponent extends Component
{
    use \Livewire\WithPagination, \App\Traits\SinglePageTrait;

    public function mount($id = null)
    {
        $this->Model = Customer::class;

        $this->mountSync($id);
        $this->mountSyncUrl();
    }

    public function export() 
    {
        return Excel::download(new CustomersExport($this->dataTable()), __('customers').'.xlsx');
    }
        
    public function render()
    {
        if($this->view == 'index') $this->resetErrorBag();
        if($this->view == 'create') {
            $this->Object->status = 1;
            $this->Object->number_times_sent ??= 0;
            $this->Object->language_id ??= 1;
        }
        
        $this->editRules = [
            'Object.full_name' => '',
            'Object.phone' => 'required|numeric|unique:customers,phone,'.optional($this->Object)->id,
            'Object.status' => 'required',
            'Object.number_times_sent' => 'required|numeric',
            'Object.email' => '',
            'Object.morphImage' => '',
        ];

        $this->renderSync();
        $this->renderSyncUrl();
        $this->renderSyncRules();

        // List Table
        if($this->view == 'index') $compact['TableList'] = $this->dataTable();
        $compact['ListStatus'] =  HelperSelects::Customer_STATUS;
        
        return view('livewire.customer.page', $compact ?? []);
    }
}
