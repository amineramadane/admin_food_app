<?php
      
namespace App\Http\Livewire;
use Livewire\Component;
use App\Models\{Answer, Bot, Question};
use HelperSelects;

use App\Exports\AnswersExport;
use Maatwebsite\Excel\Facades\Excel;


class AnswerComponent extends Component
{
    use \Livewire\WithPagination, \App\Traits\SinglePageTrait;

    public $bot_id;
    public $questions_id;

    public function mount($id = null)
    {
        $this->Model = Answer::class;
        $this->mountSync($id);
        $this->mountSyncUrl();
        
        $this->bot_id = optional(Bot::where('status', 2)->first())->id ?? null;
        $this->questions_id = optional(Question::where('bot_id', $this->bot_id)->pluck('title','id'))->toArray() ?? [];
    }

    public function export() 
    {
        return Excel::download(new AnswersExport($this->dataTable()), __('answers').'.xlsx');
    }
        
    public function render()
    {
        $this->renderSync();
        $this->renderSyncUrl();
        $this->renderSyncRules();
        
        if($this->view == 'index'){
            $compact['TableList'] = $this->dataTable();
            $compact['ListStatus'] =  HelperSelects::Answer_STATUS;
            $compact['ListQuestion'] =  $this->questions_id;
        }
        
        return view('livewire.Answer.page', $compact ?? []);
    }
}
