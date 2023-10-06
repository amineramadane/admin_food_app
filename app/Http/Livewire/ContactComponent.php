<?php
      
namespace App\Http\Livewire;
use Livewire\Component;
use App\Models\{Contact, Language};
use HelperSelects;
use App\Exports\ContactsExport;
use Maatwebsite\Excel\Facades\Excel;

class ContactComponent extends Component
{
    use \Livewire\WithPagination, \App\Traits\SinglePageTrait;

    public function mount($id = null)
    {
        $this->Model = Contact::class;

        $this->mountSync($id);
        $this->mountSyncUrl();
    }

    public function export() 
    {
        return Excel::download(new ContactsExport($this->dataTable()), __('contacts').'.xlsx');
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
            'Object.phone' => 'required|numeric',
            // 'Object.phone' => 'required|numeric|unique:contacts,phone,'.optional($this->Object)->id,
            'Object.status' => 'required',
            'Object.number_times_sent' => 'required|numeric',
            'Object.email' => '',
            'Object.language_id' => 'required',
            //'Object.send_at_start' => '',
            //'Object.send_at_end' => '',
        ];
        $this->renderSync();
        $this->renderSyncUrl();
        $this->renderSyncRules();

        // List Table
        if($this->view == 'index') $compact['TableList'] = $this->dataTable();
        $compact['ListLang'] = Language::pluck('title', 'id')->toArray();
        $compact['ListStatus'] =  HelperSelects::Contact_STATUS;
        
        return view('livewire.contact.page', $compact ?? []);
    }
}
