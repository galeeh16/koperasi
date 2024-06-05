@props(['messages'])

{{-- @if ($messages)
    <ul {{ $attributes->merge(['class' => 'text-sm text-red-600 space-y-1']) }}>
        @foreach ((array) $messages as $message)
            <li>{{ $message }}</li>
        @endforeach
    </ul>
@endif --}}

@if ($messages)
    <p {{ $attributes->merge(['class' => 'text-sm text-danger']) }}>
        {{ $messages[0] }}
    </p>
@endif
