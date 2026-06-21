@php
$steps = [1 => 'Trademark', 2 => 'Business', 3 => 'Legal Owner', 4 => 'Contact', 5 => 'Notes'];
@endphp
<div class="stepper-top">
    <div class="stepper-eyebrow">
        <span class="live-dot"></span>
        New Zealand Trademark Application
    </div>
    <div class="stepper-progress-label">Step {{ $currentStep }} of {{ count($steps) }}</div>
</div>
<div class="stepper">
    @foreach($steps as $num => $label)
        @php $state = $num < $currentStep ? 'done' : ($num === $currentStep ? 'active' : ''); @endphp
        <div class="stepper-step {{ $state }}">
            <div class="stepper-node">
                @if($state === 'done')
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>
                @else
                    {{ $num }}
                @endif
            </div>
            <span class="stepper-name">{{ $label }}</span>
        </div>
        @if(!$loop->last)
            <div class="stepper-track {{ $num < $currentStep ? 'done' : '' }}"></div>
        @endif
    @endforeach
</div>
