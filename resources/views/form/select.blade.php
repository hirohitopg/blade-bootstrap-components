<div class="mb-3">
    <x-bootstrap::form.label :label="$label" :for="$name" />
    <select
        @if($isWired())
            wire:model="{{ $name }}"
        @else
            name="{{ $name }}"
        @endif

        @if($multiple)
            multiple
        @endif

        {!! $attributes->merge(['class' => 'form-select ' . ($hasError($nameDot) ? 'is-invalid' : '')]) !!}>
        @if($empty)
        <option value=""></option>
        @endif
        @foreach($options as $key => $option)
            <option value="{{ $key }}" @if($isSelected($key)) selected="selected" @endif>
                {{ $option }}
            </option>
        @endforeach
    </select>

    @if($hasErrorAndShow($nameDot))
        <x-bootstrap::form.errors :name="$nameDot" />
    @endif

    {!! $help ?? null !!}
</div>
