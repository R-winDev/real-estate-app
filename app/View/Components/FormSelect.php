<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FormSelect extends Component
{
    public array $options;

    public function __construct(
        public string $label,
        public string $name,
        mixed $options = [],
    ) {
        $this->options = $options instanceof \Illuminate\Support\Collection
            ? $options->toArray()
            : (array) $options;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form-select');
    }
}
