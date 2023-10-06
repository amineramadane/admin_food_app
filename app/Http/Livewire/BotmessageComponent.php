<?php
      
namespace App\Http\Livewire;
use Livewire\Component;
use App\Models\{Botmessage, Language};

class BotmessageComponent extends Component
{
    use \Livewire\WithPagination, \App\Traits\SinglePageTrait;

    public $bot_id;

    public function mount($id = null)
    {
        $this->Model = Botmessage::class;
        $this->mountSync($id);
        $this->mountSyncUrl();
    }
    
    public function render()
    {
        if($this->view == 'index') $this->resetErrorBag();

        $this->editRules = [
            'Object.welcome_message' => 'required',
            'Object.excuse_message' => 'required',
            'Object.cancel_message' => 'required',
            'Object.language_id' => 'required',
            'Object.bot_id' => 'required',
        ];
        $this->renderSync();
        $this->renderSyncRules();

        // List Table
        $this->ObjectFilter->bot_id = $this->bot_id;
        if($this->view == 'index') $compact['TableList'] = $this->dataTable();
        
        $Langs = Language::pluck('title', 'id')->toArray();
        $compact['ListLang'] = $Langs;
        $existlangs = $this->Model::where('bot_id', $this->bot_id)->distinct()->pluck('language_id')->toArray();
        foreach($Langs as $k => $lang){
            if($this->view == 'edit' && $k == $this->Object->language_id) continue;
            if(in_array($k, $existlangs)) unset($Langs[$k]);
        }
        if($this->view == 'create') {
            if(count($Langs)) $this->Object->language_id ??= array_key_first($Langs);
            $this->Object->bot_id ??= $this->bot_id;
        }
        $compact['existlangs'] = $Langs;

        return view('livewire.botmessage.page', $compact ?? []);
    }
}
