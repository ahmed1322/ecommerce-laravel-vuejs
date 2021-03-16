@include('components.dashboard.header')
<!-- Page Container START -->
<div class="page-container" id="app">
    @include('partials.dashboard.breadcrumb')
    @yield('dashboard')
</div>
</div>
@include('partials.dashboard.search')
@include('partials.dashboard.quick-view')
@include('components.dashboard.footer')
