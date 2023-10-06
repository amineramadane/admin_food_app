<?php
      
namespace App\Http\Livewire;
use Livewire\Component;
use App\Models\Bot;
use HelperSelects;

class BotComponent extends Component
{
    use \Livewire\WithPagination, \App\Traits\SinglePageTrait;
    public function mount($id = null)
    {
        $this->Model = Bot::class;

        $this->mountSync($id);
        $this->mountSyncUrl();
    }
        
    public function render()
    {
        if($this->view == 'index') $this->resetErrorBag();
        if($this->view == 'edit' || $this->view == 'create'){
            $this->Object->reminder_time ??= 60;
            $this->Object->status ??= 1;
            $this->Object->number_reminders ??= 0;
        }
        $this->editRules = [
            'Object.title' => 'required',
            'Object.status' => 'required|numeric',
            'Object.reminder_time' => 'required|numeric',
            'Object.number_reminders' => 'numeric',
            'Object.description' => '',
        ];
        $this->renderSync();
        $this->renderSyncUrl();
        $this->renderSyncRules();

        // List Table
        // $this->ObjectFilter->id = 2;
        if($this->view == 'index') $compact['TableList'] = $this->dataTable();
        $compact['ListStatus'] = HelperSelects::OnOff;
        
        return view('livewire.bot.page', $compact ?? []);
    }
}
