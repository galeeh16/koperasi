<div class="card">
    @isset($header)
    <div class="card-header">
        <h5 class="card-title">{{ $header }}</h5>
        @endisset
    </div>
    <div class="card-body">
        {{ $slot }}
    </div>
</div>
