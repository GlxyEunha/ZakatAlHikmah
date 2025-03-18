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
                        <h1 class="mt-4">Form Pemohon</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Form Pemohon</li>
                        </ol>
                        <form action="{{ route('pemohon') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="pemohon">NAMA LEMBAGA/PEMOHON</label>
                                <input name="pemohon" type="text" class="form-control">
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="alamat">ALAMAT</label>
                                <textarea name="alamat" class="form-control"></textarea>
                            </div>
                            <br>
                            <div class="form-group">
                                <div class="form-check">
                                  <input class="form-check-input" name="gridCheck" type="checkbox" id="gridCheck">
                                  <label class="form-check-label" for="gridCheck">
                                    Diterima
                                  </label>
                                </div>
                              </div>
                              <br>
                            <button type="submit" class="btn btn-primary">Tambah</button>
                            </form>
                    </div>
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
        </script>
    </body>
</html>

