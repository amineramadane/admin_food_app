<?php
      
namespace App\Http\Livewire;
use Livewire\Component;
use App\Models\{Questionlanguage, Language};
use Illuminate\Support\Str;

class QuestionlanguageComponent extends Component
{
    use \Livewire\WithPagination, \App\Traits\SinglePageTrait;

    public $question_id;

    public function mount($id = null)
    {
        $this->Model = Questionlanguage::class;
        $this->mountSync($id);
    }
    
    public function render()
    {
        if($this->view == 'index') $this->resetErrorBag();

        $this->editRules = [
            'Object.message' => 'required',
            'Object.error_message' => 'required',
            'Object.language_id' => 'required',
            'Object.question_id' => 'required',
        ];

        $this->renderSync();
        $this->renderSyncRules();

        // List Table
        $this->ObjectFilter->question_id = $this->question_id;
        if($this->view == 'index') $compact['TableList'] = $this->dataTable();

        $Langs = Language::pluck('title', 'id')->toArray();
        $compact['ListLang'] = $Langs;
        $existlangs = $this->Model::where('question_id', $this->question_id)->distinct()->pluck('language_id')->toArray();
        foreach($Langs as $k => $lang){
            if($this->view == 'edit' && $k == $this->Object->language_id) continue;
            if(in_array($k, $existlangs)) unset($Langs[$k]);
        }
        if($this->view == 'create') {
            if(count($Langs)) $this->Object->language_id ??= array_key_first($Langs);
            $this->Object->question_id ??= $this->question_id;
        }
        $compact['existlangs'] = $Langs;
        
        return view('livewire.questionlanguage.page', $compact ?? []);
    }
}
