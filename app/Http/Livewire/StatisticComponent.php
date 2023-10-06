<?php

namespace App\Http\Livewire;
use Livewire\Component;
use Carbon\{Carbon, CarbonPeriod};
use App\Models\{ Bot, Answer, Question };

class StatisticComponent extends Component
{
    public $view;
    public $questions;
    public $bot;
    public $years;
    public $months;
    public $year;
    public $fromMonth;
    public $toMonth;

    public function resetFilter(){ 
        $this->year = (int)Carbon::now()->format('Y');
        $this->fromMonth = 1;
        $this->toMonth = (int)Carbon::now()->format('m');
    }

    public function mount()
    {
        $this->view = 'index';
        $this->bot = optional(Bot::where('status','=',2))->first();
        if ( $this->bot ) { 
            $this->questions = $this->bot->question()->where('status', 2)->orderBy('position', 'asc')->get(); 
        }
        $periodYears = CarbonPeriod::create('2022-01-01', '1 year' ,Carbon::now()->format('Y-m-d'))->toArray();
        foreach($periodYears as $y){
            $this->years[$y->format('Y')] = $y->format('Y');
        }
        $this->months = [
            1  => 'January',
            2  => 'February',
            3  => 'March',
            4  => 'April',
            5  => 'May',
            6  => 'June',
            7  => 'July ',
            8  => 'August',
            9  => 'September',
            10 => 'October',
            11 => 'November',
            12 => 'December',
        ];
        $this->year = (int)Carbon::now()->format('Y');
        $this->fromMonth = 1;
        $this->toMonth = (int)Carbon::now()->format('m');
    }

    public function render()
    {
        if(empty($this->questions)) goto end;
        $this->questions = $this->questions->keyBy('id');
        $data = [];
        if($this->toMonth == 12) $to_date = ($this->year+1)."-01-01";
        else $to_date = "$this->year-".($this->toMonth+1)."-01";
        
        foreach ($this->questions as $que_id => $que){
            $data[$que_id]['question'] = $que;
            $data[$que_id]['answers'] = $que->answer()
                                            ->where('status', 2)
                                            ->whereDate('created_at','<', $to_date)
                                            ->whereDate('created_at','>=', "$this->year-$this->fromMonth-01")
                                            ->get()
                                            ->groupBy(function($answer){
                                                return $answer->answer;
                                            })
                                            ->map(function($answers){
                                                return count($answers);
                                            });
                                            
            if( $data[$que_id]['answers'] && count( $data[$que_id]['answers'] ) ) $data[$que_id]['sum'] = array_sum($data[$que_id]['answers']->toArray());
            else $data[$que_id]['sum'] = 0;

            if($que->question_type == 1){
                $data[$que_id]['nps'] = [
                        'detractors' => 0,
                        'passives' => 0,
                        'promotors' => 0,
                        'score' => 0,
                ]; 
                
                if(!count($data[$que_id]['answers'])) continue;
                $data[$que_id]['prc'] = [];
                foreach ($data[$que_id]['answers'] as $ans => $countAns){
                    $data[$que_id]['prc'][$ans] = (float)number_format((( $countAns / $data[$que_id]['sum'] ) * 100),2); 
                    switch(true){
                        case ($ans <= 6):
                            $data[$que_id]['nps']['detractors'] += $countAns;
                            break;
                        case ($ans == 7 || $ans == 8):
                            $data[$que_id]['nps']['passives'] += $countAns;
                            break;
                        case ($ans == 9 || $ans == 10):
                            $data[$que_id]['nps']['promotors'] += $countAns;
                            break;
                        default: break;
                    }
                }
                $data[$que_id]['nps']['score'] = (($data[$que_id]['nps']['promotors'] - $data[$que_id]['nps']['detractors']) / $data[$que_id]['sum'] ) * 100;
                $data[$que_id]['nps']['score'] = (float)number_format($data[$que_id]['nps']['score'],2);
            }else{
                $keyChoices = explode(';', $que->condition);
                $choices = explode('|', $que->choices);
                $data[$que_id]['choices'] = array_combine($keyChoices, $choices);
                ksort($data[$que_id]['choices']);

                $data[$que_id]['prc'] = [];
                foreach ($data[$que_id]['answers'] as $valueAnswer => $rateAnswer){
                    $data[$que_id]['prc'][$valueAnswer] = $data[$que_id]['sum'] == 0 ? 0 : (float)number_format((( $rateAnswer / $data[$que_id]['sum'] ) * 100 ), 2 ); 
                }
            }
        }        
        end:
        if($this->view == 'index') $compact['dataBot'] = $data ?? [];
        return view('livewire.statistic.page', $compact ?? []);
    }
}
