@include('components.auth.header')
<body class="authentication-bg">
    <div class="account-pages my-5" id="app">
        @yield('auth')
    </div>
    @include('components.auth.footer')
    @yield('script')
</body>
</html>
