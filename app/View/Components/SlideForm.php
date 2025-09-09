<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SlideForm extends Component
{

    public $buttonText;
    public $title;
    /**
     * Create a new component instance.
     */
    public function __construct($buttonText = 'Open Form', $title = 'Form')
    {
        $this->buttonText = $buttonText;
        $this->title = $title;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.slide-form');
    }
}
