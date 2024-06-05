@props(['required' => true])

<label {!! $attributes->merge(['style' => 'margin-bottom: 5px;']) !!}>
    {{ $slot }}
    {!! $required ? '<span class="text-danger">*</span>' : '' !!}
</label>
