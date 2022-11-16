
<div>
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

        {!! $attributes->merge(['class' => 'form-select ' . ($hasError($nameDot) ? 'is-invalid' : '')]) !!} id="{{ $nameKebab }}">
        <option></option>
        @foreach($options as $key => $option)
            <option value="{{ $key }}" @if($isSelected($key)) selected="selected" @endif>
                {{ $option }}
            </option>
        @endforeach
    </select>
    @if($hasErrorAndShow($nameDot))
        <x-bootstrap::form.errors :name="$nameDot"/>
    @endif

    {!! $help ?? null !!}
</div>
@once
    @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-5-theme/1.3.0/select2-bootstrap-5-theme.min.css"/>
    @endpush
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    @endpush
@endonce

@push('scripts')
    <script>
        $(document).ready(function () {
            $('#{!! $nameKebab !!}').select2({
                theme: 'bootstrap-5',
                placeholder: '{!! $placeholder ?? $label !!}',
                allowClear: Boolean($(this).data('allow-clear')),
                minimumInputLength: 1,
                ajax: {
                    url: '{!! $url !!}',
                    dataType: 'json',
                    params: { // extra parameters that will be passed to ajax
                        contentType: 'application/json'
                    },
                    data: function (params) {
                        return {
                            query: params.term
                        };
                    },
                    processResults: function (data, params) {
                        // parse the results into the format expected by Select2
                        // since we are using custom formatting functions we do not need to
                        // alter the remote JSON data, except to indicate that infinite
                        // scrolling can be used
                        params.page = params.page || 1;
                        return {
                            results: $.map(data, function (item) {
                                return {
                                    text: item.name,
                                    id: item.id,
                                }
                            }),
                            pagination: {
                                more: (params.page * 30) < data.total_count
                            }
                        };
                    },
                },

            });
            $('#select2').on('change', function (e) {
                var item = $('#select2').select2("val");
            });
        });
    </script>
@endpush
@if($selectedKey)
    @push('scripts')
        <script>
            $(document).ready(function () {
                let selectedKey = {{ Illuminate\Support\Js::from(Arr::wrap($selectedKey)) }};

                // make a request for the selected data object
                $.ajax({
                    type: 'GET',
                    url: '{!! $url !!}',
                    data: {
                        key:selectedKey
                    },
                    dataType: 'json'
                }).then(function (data) {
                    $.map(data, function (item) {
                        $('#{{ $nameKebab }}').append(new Option(item.name, item.id, true, true));
                    });

                    // notify JavaScript components of possible changes
                    $("#{{ $nameKebab }}").trigger('change').trigger({
                        type: 'select2:select',
                        params: {
                            data: data
                        }
                    });
                });
            });
        </script>
    @endpush
@endif
