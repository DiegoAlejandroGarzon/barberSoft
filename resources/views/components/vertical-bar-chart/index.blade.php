@props(['width' => 'w-auto', 'height' => 'h-auto'])

<div class="{{ $width }} {{ $height }}">
    <x-base.chart
        class="vertical-bar-chart"
        {{ $attributes->merge($attributes->whereDoesntStartWith('class')->getAttributes()) }}
    >
    </x-base.chart>
</div>

@pushOnce('scripts')
    @vite('resources/js/utils/colors.js')
    @vite('resources/js/components/vertical-bar-chart.js')
@endPushOnce
