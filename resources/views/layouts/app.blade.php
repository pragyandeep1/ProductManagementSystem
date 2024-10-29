@include('layout.header')
@stack('css')
@include('layout.leftpanel')
@include('layout.topbar')


{{-- content start --}}
@yield('content')
{{-- content end --}}
@include('layout.footer')
@stack('javascript')
