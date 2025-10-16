@if(auth()->check() && auth()->user()->hasRole('superadmin'))
    @include('layouts.partials.sidebar.superadmin')

@elseif(auth()->check() && auth()->user()->hasAnyRole(['admin', 'user']))
    @include('layouts.partials.sidebar.users')
@endif
