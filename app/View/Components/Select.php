<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Select extends Component
{

    public $name;
    public $placeholder;

    public function __construct($name,$placeholder)
    {
        $this->name  = $name;
        $this->placeholder  = $placeholder;
    }

    public function render()
    {
        return view('components.select');
    }
}
