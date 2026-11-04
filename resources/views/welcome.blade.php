@php
    $userRole = session('user.role', 'opd');
    $isAdmin = $userRole === 'admin';
@endphp

@if($isAdmin)
    @include('admin.dashboard')
@else
    @include('user.dashboard')
@endif
