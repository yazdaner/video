<?php

namespace App\View\Components;

use Illuminate\View\Component;

class InputHome extends Component
{
    public $name;
    public $type;
    public $label;

    public function __construct($name,$type,$label)
    {
        $this->name  = $name;
        $this->type  = $type;
        $this->label  = $label;
    }

    public function render()
    {
        return view('components.inputHome');
    }
}
