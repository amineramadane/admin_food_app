<?php

namespace App\View\Components;

use Illuminate\View\Component;

class modalDelete extends Component
{

    public $objDelete;
    public $message;
    public $action;

    public function __construct($objDelete, $message = null, $action)
    {
        $this->objDelete = $objDelete;
        $this->message = $message;
        $this->action = $action;
    }


    public function render()
    {
        return view('components.modal-delete');
    }
}
