<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ColorBox extends Component
{
    /**
     * The color to display.
     *
     * @var string
     */
    public $color;

    /**
     * Create a new component instance.
     *
     * @param  string  $color
     * @return void
     */
    public function __construct($color)
    {
        $this->color = $color;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.color-box');
    }
}
