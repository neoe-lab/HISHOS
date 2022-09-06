<!DOCTYPE html>
<html lang="en">

<head>
    @include('includes.header')
</head>

<body class="layout-fixed hold-transition sidebar-mini text-sm sidebar-collapse layout-footer-fixed layout-navbar-fixed">
    <div class="wrapper">

        {{-- start perloader --}}
        @include('includes.preloader')
        {{-- end perloader --}}

        {{-- start navbar --}}
        @include('includes.navbar')
        {{-- end navbar --}}



        {{-- start menu --}}
        @include('includes.menu')
        {{-- end menu --}}

        <div class="content-wrapper">
            {{-- in pages --}}
            @yield('page')
            {{-- end in pages --}}
        </div>




        {{-- start sidebar --}}
        @include('includes.sidebar')
        {{-- end sidebar --}}

        {{-- start footer --}}
        @include('includes.footer')
        {{-- end footer --}}
    </div>
    {{-- start foot --}}
    @include('includes.foot')
    {{-- end foot --}}
</body>

</html>
