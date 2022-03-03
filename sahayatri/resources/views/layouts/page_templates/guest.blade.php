@include('layouts.navbars.navs.guest')
<div class="wrapper wrapper-full-page">
    <div class="page-header login-page header-filter" filter-color="rose"
        style="background-image: url('{{ asset('material') }}'); background-size: cover; background-position: top center;align-items: center;"
        data-color="purple">
        @yield('content')
        @include('layouts.footers.guest')
    </div>
</div>
