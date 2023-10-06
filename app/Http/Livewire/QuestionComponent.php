<?php
      
namespace App\Http\Livewire;
use Livewire\Component;
use App\Models\Question;
use Illuminate\Support\Str;
use HelperSelects;

class QuestionComponent extends Component
{
    use \Livewire\WithPagination, \App\Traits\SinglePageTrait;

    public $bot_id;
    public $choices;
    public $statusChoices;

    public function addChoice($par = null){
        $exp = Str::of($par)->explode('|')->toArray();
        $this->choices[$exp[0]] = $exp[1];
        $this->statusChoices[$exp[0]] = $exp[2];
    }

    public function deleteChoice($keyChoise = null){
        unset($this->choices[$keyChoise]);
        unset($this->statusChoices[$keyChoise]);
        if(count($this->choices) == 0) $this->Object->choices = null;
        if(count($this->statusChoices) == 0) $this->Object->status_choices = null;
    }

    public function mount($id = null){
        $this->Model = Question::class;
        $this->mountSync($id);
    }

    public function viewQuestionPosition(){
        $this->view = 'update_position';
    }

    public function updateQuestionPosition($questions){
        foreach($questions as $question){
            $this->Model::where('id', $question['value'])->update(['position' => $question['order']]);
        }
    }
    
    public function render()
    {
        $this->renderSync();
        $this->renderSyncRules();

        if($this->view == 'index') {
            $this->resetErrorBag();
            $this->choices = null;
            $this->statusChoices = null;
        }

        if($this->view == 'create') {
            $this->Object->bot_id = $this->bot_id;
            $this->Object->answer_type ??= 1;
            $this->Object->question_type ??= 1;
            $this->Object->status ??= 2;
        }

        $this->editRules = [
            'Object.title' => 'required',
            'Object.question_type' => 'required|numeric',
            'Object.answer_type' => 'required|numeric',
            'Object.condition' => 'required',
            'Object.choices' => '',
            'Object.status_choices' => '',
            'Object.status' => 'required|numeric',
            'Object.bot_id' => '',
        ];

        // List Table
        $this->sortColumn = 'position';
        $this->sortDirection = 'ASC';
        $this->ObjectFilter->bot_id = $this->bot_id;

        if($this->view == 'index') $compact['TableList'] = $this->dataTable();

        if($this->view == 'update_position') $compact['questions'] = Question::where('bot_id', $this->bot_id)->orderBy('position','asc')->get();
        

        if($this->view == 'create' || $this->view == 'edit') {
            if($this->Object->question_type == 1){
                $this->Object->condition = '0:10';
                $this->Object->choices = '';
            }else{
                if (
                    !empty($this->choices) && count($this->choices)
                    &&
                    !empty($this->statusChoices) && count($this->statusChoices)
                ) {
                    $this->Object->condition = implode(';',array_keys($this->choices));
                    $this->Object->choices = implode('|',$this->choices);
                    $this->Object->status_choices = implode('|',$this->statusChoices);
                }
                elseif (
                    !empty($this->Object->choices)
                    &&
                    !empty($this->Object->status_choices)
                ) {
                    $keychoices = explode(';',$this->Object->condition);

                    $valueChoices = explode('|',$this->Object->choices);
                    $this->choices = array_combine($keychoices,$valueChoices);
                    
                    $statusChoices = explode('|',$this->Object->status_choices);
                    $this->statusChoices = array_combine($keychoices,$statusChoices);
                }
            }
        }

        if( $this->view == 'show'){
            if( $this->Object->question_type == 2 ){
                $keychoices = explode(';',$this->Object->condition);

                $valueChoices = explode('|',$this->Object->choices);
                $this->choices = array_combine($keychoices,$valueChoices);

                $statusChoices = explode('|',$this->Object->status_choices);
                $this->statusChoices = array_combine($keychoices,$statusChoices);
            }
        }

        $compact['ListStatus'] = HelperSelects::OnOff;
        $compact['answerTypes'] = HelperSelects::AnswerTypes;
        $compact['questionTypes'] = HelperSelects::QuestionTypes;
        $compact['positiveORnegative'] = HelperSelects::positiveORnegative;
        return view('livewire.question.page', $compact ?? []);
    }
}
