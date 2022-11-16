<?php

    namespace Hostmoz\BladeBootstrapComponents\Components\Form;

    use Hostmoz\BladeBootstrapComponents\Components\Component;
    use Hostmoz\BladeBootstrapComponents\Components\HandlesValidationErrors;
    use Hostmoz\BladeBootstrapComponents\Components\HandlesBoundValues;
    use Illuminate\Support\Arr;
    use Illuminate\Support\Str;

    class Select2 extends Component
    {
        use HandlesValidationErrors;
        use HandlesBoundValues;

        public string $name;
        public string $label;
        public string $nameDot;
        public string $nameKebab;
        public $url;
        public $options;
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
            $url='',
            $options = [],
            $bind = null,
            $default = null,
            bool $multiple = false,
            bool $showErrors = true
        ) {
            $this->name    = $name;
            $this->label   = $label;
            $this->options = $options;

            $this->nameDot = str_replace(['[', ']'], ['.', ''], $name);
            if (Str::endsWith($this->nameDot, '.')) {
                $this->nameDot = substr_replace($this->nameDot, '', -1);
            }
            $this->nameKebab = str_replace('.', '-', $this->nameDot);

            if ($this->isNotWired()) {
                $default = $this->getBoundValue($bind, $name) ?: $default;

                $this->selectedKey = old($name, $default);

            }

            $this->url = $url;

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
