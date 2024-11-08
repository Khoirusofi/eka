@if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('bidan'))
    @include('layouts.admin')
@else
    @include('layouts.patient')
@endif
