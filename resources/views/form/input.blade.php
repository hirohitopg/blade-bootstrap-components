<div class="@if($type === 'hidden') d-none @endif mb-3">
    <x-bootstrap::form.label :label="$label" :for="$name"/>

    @php
        $shouldHaveInputGroup = isset($prepend) || isset($append);
    @endphp

    @if($shouldHaveInputGroup)<div class="input-group">@endif
        @isset($prepend)
            <div class="input-group-text">
                {!! $prepend !!}
            </div>
        @endisset

        @if($maskSettings = config("blade-bootstrap-components.inputmask.$mask"))
            @php
                $attributes = $attributes->merge($maskSettings);
            @endphp

            @once
                @push('scripts')
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.7/jquery.inputmask.min.js"></script>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.7/bindings/inputmask.binding.min.js"></script>
                @endpush
            @endonce
        @endif

        <input {!! $attributes->merge(['class' => 'form-control ' . ($hasError($name) ? 'is-invalid' : '')]) !!}
               type="{{ $type }}"

               @if($isWired())
                   wire:model="{{ $name }}"
               @else
                   name="{{ $name }}"
               value="{{ $value }}"
               @endif
               placeholder="{{$placeholder??$label}}"
        />
        @isset($append)
            <div class="input-group-text">
                {!! $append !!}
            </div>
        @endisset
        @if($hasErrorAndShow($name))
            <x-bootstrap::form.errors :name="$name"/>
        @endif
    @if($shouldHaveInputGroup)</div>@endif

    {!! $help ?? null !!}
</div>
