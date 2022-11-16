<?php

namespace Hostmoz\BladeBootstrapComponents\Components\Form;

use Hostmoz\BladeBootstrapComponents\Components\Component;
use Hostmoz\BladeBootstrapComponents\Components\HandlesValidationErrors;
use Hostmoz\BladeBootstrapComponents\Components\HandlesBoundValues;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class Select extends Component
{
    use HandlesValidationErrors;
    use HandlesBoundValues;

    public string $name;
    public string $nameDot;
    public string $label;
    public $options;
    public $empty=false;
    public $selectedKey;
    public bool $multiple;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        string $name,
        string $label = '',
        $options = [],
        $bind = null,
        $default = null,
        bool $multiple = false,
        bool $showErrors = true,
        bool $empty = false
    ) {
        $this->name    = $name;
        $this->label   = $label;
        $this->options = $options;

        $this->empty = $empty;

        $this->nameDot = str_replace(['[', ']'], ['.', ''], $name);
        if (Str::endsWith($this->nameDot, '.')) {
            $this->nameDot = substr_replace($this->nameDot, '', -1);
        }

        if ($this->isNotWired()) {
            $default = $this->getBoundValue($bind, $name) ?: $default;

            $this->selectedKey = old($name, $default);

        }

        $this->multiple   = $multiple;
        $this->showErrors = $showErrors;
    }

    public function isSelected($key): bool
    {
        if ($this->isWired()) {
            return false;
        }

        return in_array($key, Arr::wrap($this->selectedKey));
    }
}
