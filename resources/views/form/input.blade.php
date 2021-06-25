<div class="@if($type === 'hidden') d-none @else form-group @endif">
    <x-bootstrap::form.label :label="$label" :for="$name" />

    <div class="input-group">
        @isset($prepend)
            <div class="input-group-prepend">
                <div class="input-group-text">
                    {!! $prepend !!}
                </div>
            </div>
        @endisset

        <input {!! $attributes->merge(['class' => 'form-control ' . ($hasError($name) ? 'is-invalid' : '')]) !!}
            type="{{ $type }}"

            @if($isWired())
                wire:model="{{ $name }}"
            @else
                name="{{ $name }}"
                value="{{ $value }}"
            @endif
        />
            @if($hasErrorAndShow($name))
                <x-bootstrap::form.errors :name="$name" />
            @endif

        @isset($append)
            <div class="input-group-append">
                <div class="input-group-text">
                    {!! $append !!}
                </div>
            </div>
        @endisset
    </div>

    {!! $help ?? null !!}


</div>
