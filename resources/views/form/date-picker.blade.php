<div class="mb-3">
    <x-bootstrap::form.label :label="$label" :for="$name"/>
    <div class="input-group date">
        @isset($prepend)
            <div class="input-group-text">
                {!! $prepend !!}
            </div>
        @endisset
        <input type="text"
               {!! $attributes->merge(['class' => 'form-control ' . ($hasError($name) ? 'is-invalid' : '')]) !!} id="{{$name}}"
               name="{{$name}}" value="{{$value}}">
        <div class="input-group-text">
            <i class="fa fa-calendar-days"></i>
        </div>
        @if($hasErrorAndShow($name))
            <x-bootstrap::form.errors :name="$name"/>
        @endif
    </div>
</div>


@once
    @push('styles')
        <link rel="stylesheet" type="text/css"
              href="{{asset('vendor/bootstrap-components/css/bootstrap-datepicker.standalone.min.css')}}">
    @endpush
    @push('scripts')
        <script src="{{asset('vendor/bootstrap-components/js/bootstrap-datepicker.min.js')}}"
                type="text/javascript"></script>
    @endpush
@endonce
@push('scripts')
    <script>
        $("[name='{{$name}}']").datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
        });
    </script>
@endpush
