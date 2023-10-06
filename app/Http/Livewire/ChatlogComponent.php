<?php
      
namespace App\Http\Livewire;
use Livewire\Component;
use App\Models\Chatlog;
use HelperSelects;

class ChatlogComponent extends Component
{
    use \Livewire\WithPagination, \App\Traits\SinglePageTrait;
    public function mount($id = null)
    {
        $this->Model = Chatlog::class;
        $this->mountSync($id);
        $this->mountSyncUrl();
    }
        
    public function render()
    {
        $this->renderSync();
        $this->renderSyncUrl();
        $this->renderSyncRules();

        // List Table
        if($this->view == 'index') $compact['TableList'] = $this->dataTable();
        if($this->view == 'index') $compact['ListStatus'] =  HelperSelects::CHATLOG_STATUS;
        if($this->view == 'index') $compact['ListType'] =  HelperSelects::CHATLOG_TYPE;
        
        return view('livewire.chatlog.page', $compact ?? []);
    }
}
