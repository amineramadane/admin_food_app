<?php

namespace App\Http\Livewire;
use Livewire\Component;
use Carbon\{Carbon, CarbonPeriod};
use App\Models\{ Order, Product, Category };

class StatisticComponent extends Component
{
    public $view;
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

        $periodYears = CarbonPeriod::create('2023-01-01', '1 year' ,Carbon::now()->format('Y-m-d'))->toArray();
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

        $data = [
            [
                'title' => 'graphique 1',
                'count' => 30,
                'childrens' => [
                    [
                        'name' => 'bacon burger',
                        'key' => 'product1',
                        'count' => 10,
                    ],
                    [
                        'name' => 'pizza royale',
                        'key' => 'product2',
                        'count' => 20,
                    ]
                ]
            ],
            [
                'title' => 'graphique 2',
                'count' => 60,
                'childrens' => [
                    [
                        'name' => 'panini merguez',
                        'key' => 'product1',
                        'count' => 10,
                    ],
                    [
                        'name' => 'panini thon',
                        'key' => 'product2',
                        'count' => 20,
                    ],
                    [
                        'name' => 'pizza saisons',
                        'key' => 'product2',
                        'count' => 30,
                    ],
                ]
            ],
        ];

        
        if($this->view == 'index') $compact['allData'] = $data ?? [];
        return view('livewire.statistic.page', $compact ?? []);
    }
}
