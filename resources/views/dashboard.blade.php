<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Dashboard - SB Admin</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
        <script src="{{ asset('js/scripts.js') }}"></script>
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <style>
            .card {
                background-color: white !important;
                color: black !important;
                border: 1px solid #ddd !important;
                box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1) !important;
                border-radius: 10px !important;
            }
            .card-body {
                text-transform: uppercase;
            }
            .card-footer {
                display: flex;
                justify-content: space-between;
                align-items: center;
                border-top: 1px solid #ddd !important;
                background: white !important;
            }
            .card-footer i {
                color: black !important;
            }
        </style>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand -->
            <a class="navbar-brand ps-3" href="index.html">Zakat App</a>

            <!-- Sidebar Toggle -->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>

            <!-- Navbar di sisi kanan -->
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user fa-fw"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item">Logout</button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Menu</div>
                            <a class="nav-link" href="{{ route('dashboard') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>
                            <a class="nav-link" href="{{ route('rekap_zakat') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Rekap Zakat
                            </a>
                            <a class="nav-link" href="{{ route('rekap_pemohon') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Rekap Pemohon
                            </a>
                            <a class="nav-link" href="{{ route('rekap_pengeluaran') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Rekap Pengeluaran
                            </a>
                        </div>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Dashboard</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Dashboard Statistik Zakat</li>
                        </ol>

                        <div>
                            <form action="{{ route('export.dashboard') }}" class="d-inline">
                                <button type="submit" class="btn btn-success btn-lg">Download Excel</button>  
                            </form>
                        </div>
                        <br>

                        <div class="row">
                            <div class="col-xl-4 col-md-6">
                                <div class="card mb-4 shadow-sm border-0">
                                    <div class="card-body">Total Uang Keseluruhan</div>
                                    <div class="card-footer">
                                        <h4>Rp {{ number_format($total_uang, 0, ',', '.') }}</h4>
                                        <i class="fas fa-wallet fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-6">
                                <div class="card mb-4 shadow-sm border-0">
                                    <div class="card-body">Total Beras Keseluruhan</div>
                                    <div class="card-footer">
                                        <h4>{{ $total_beras }} kg</h4>
                                        <i class="fas fa-weight-hanging fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-6">
                                <div class="card mb-4 shadow-sm border-0">
                                    <div class="card-body">Total Pemohon</div>
                                    <div class="card-footer">
                                        <h4>{{ $total_pemohon }}</h4>
                                        <i class="fas fa-users fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6">
                                <div class="card mb-4 shadow-sm border-0">
                                    <div class="card-body">Total Pengeluaran Uang</div>
                                    <div class="card-footer">
                                        <h4>Rp {{ number_format($total_pengeluaran_uang, 0, ',', '.') }}</h4>
                                        <i class="fas fa-money-bill-wave fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6">
                                <div class="card mb-4 shadow-sm border-0">
                                    <div class="card-body">Total Pengeluaran Beras</div>
                                    <div class="card-footer">
                                        <h4>{{ $total_pengeluaran_beras }} kg</h4>
                                        <i class="fas fa-box-open fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6">
                                <div class="card mb-4 shadow-sm border-0">
                                    <div class="card-body">Total Uang Bersih</div>
                                    <div class="card-footer">
                                        <h4>Rp {{ number_format($total_uang_bersih, 0, ',', '.') }}</h4>
                                        <i class="fas fa-wallet fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6">
                                <div class="card mb-4 shadow-sm border-0">
                                    <div class="card-body">Total Beras Bersih</div>
                                    <div class="card-footer">
                                        <h4>{{ $total_beras_bersih }} kg</h4>
                                        <i class="fas fa-weight-hanging fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">
                                Copyright &copy; Masjid Al Hikmah <span id="year"></span>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="/assets/demo/chart-area-demo.js"></script>
        <script src="/assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="/js/datatables-simple-demo.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function () {
                $(".alert").delay(3000).slideUp(300);
            });

            document.getElementById("year").textContent = new Date().getFullYear();

            document.addEventListener("DOMContentLoaded", function () {
                const urlParams = new URLSearchParams(window.location.search);
                const query = urlParams.get("query");
                if (query) {
                    document.getElementById("search-result").innerText = "Hasil pencarian untuk: " + query;
                    // Tambahkan fungsi untuk mencari data sesuai query
                }
            });

        </script>
    </body>
</html>