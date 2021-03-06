@include('components.dashboard.header')
<body class="authentication-bg">
    <div class="account-pages my-5" id="app">
        @yield('auth')
    </div>
    @include('components.dashboard.footer')
    @yield('script')
</body>
</html>
