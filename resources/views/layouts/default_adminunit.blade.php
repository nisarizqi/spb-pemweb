<!DOCTYPE html>
<html>

<head>
    @include('partition_adminunit.head')
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-light bg-light">
        @include('partition_adminunit.navtop')
    </nav>
    <div id="layoutSidenav">

        <div id="layoutSidenav_nav">
            @include('partition_adminunit.navside')
        </div>
        <div id="layoutSidenav_content">
            @yield('content')
            @include('partition_adminunit.footer')
        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="/js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="/assets/demo/chart-bar-barang.js"></script>
    <script src="/assets/demo/chart-pie-peminjaman.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="/js/datatables-simple-demo.js"></script>
</body>

</html>