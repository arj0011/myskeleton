@include('layouts.header')
@stack('style')
@include('layouts.sidebar')
@yield('content')
@include('layouts.footer')
@stack('scripts')