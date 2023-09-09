<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Input extends Component
{
    public $name;
    public $type;
    public $placeholder;

    public function __construct($name,$type,$placeholder)
    {
        $this->name  = $name;
        $this->type  = $type;
        $this->placeholder  = $placeholder;
    }

    public function render()
    {
        return view('components.input');
    }
}
