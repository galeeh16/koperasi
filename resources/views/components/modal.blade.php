@props(['size' => 'md'])

<div {!! $attributes->merge(['class' => 'modal fade']) !!}>
    <div class="modal-dialog modal-{{$size}}">
        <div class="modal-content">
            @isset($header)
            <div class="modal-header">
                <h5 class="modal-title">{{ $header }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            @endisset
            <div class="modal-body">
                {{ $slot }}
            </div>
            @isset($footer)
            <div class="modal-footer">
            {!! $footer !!}
            </div>
            @endisset
        </div>
    </div>
</div>
