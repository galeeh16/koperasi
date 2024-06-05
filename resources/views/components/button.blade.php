<button {!! $attributes->merge(['type' => 'button', 'class' => 'btn d-flex align-items-center justify-content-center', 'style' => 'gap: 4px;'])!!}>
    {{ $slot }}
</button>
