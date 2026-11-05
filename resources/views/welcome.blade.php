@php
    $userRole = session('user.role', 'opd');
    $isAdmin = ($userRole === 'admin');
    $isWaliData = ($userRole === 'walidata');
@endphp

@if($isAdmin || $isWaliData)
    @include('admin.dashboard')
@else
    @include('user.dashboard')
@endif
