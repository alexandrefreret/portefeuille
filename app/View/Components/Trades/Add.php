<?php

namespace App\View\Components\Trades;

use Illuminate\View\Component;

class Add extends Component
{
    public $pair;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($pair)
    {
        $this->pair = $pair;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.trades.add');
    }
}
