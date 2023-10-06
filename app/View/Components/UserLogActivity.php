<?php

namespace App\View\Components;

use Illuminate\View\Component;

class UserLogActivity extends Component
{
    public $audit;
    public $showName;

    public function __construct($audit, $showName)
    {
        $this->audit = $audit;
        $this->showName = $showName;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.user-log-activity');
    }
}
