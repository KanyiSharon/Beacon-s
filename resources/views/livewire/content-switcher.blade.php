<div>
    @switch($currentView)
        @case('home')
            @include('reception.childregistration')
            @break
        @case('about')
            @include('reception.parentregistration')
            @break
        @default
            @include('home')
    @endswitch
</div>