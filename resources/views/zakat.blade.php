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
                        <h1 class="mt-4">Rekap Zakat</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Rekap Zakat</li>
                        </ol>
                        <div class="d-flex justify-content-between mb-3 align-items-center">   
                            <!-- Tombol Hapus Semua Data di sisi kiri -->
                            <button class="btn btn-danger btn-lg" data-bs-toggle="modal" data-bs-target="#deleteAllModal">
                                <i class="fas fa-trash"></i> Hapus Semua Data
                            </button>

                            <!-- Tombol Export Excel, Masukkan Data Zakat, dan Search di sisi kanan -->
                            <div class="d-flex gap-2">
                                <form action="{{ route('export.zakat') }}" class="d-inline">
                                    <button type="submit" class="btn btn-success btn-lg">Download Excel</button>  
                                </form>
                                <form action="{{ route('form-zakat') }}" class="d-inline">
                                    <button type="submit" class="btn btn-primary btn-lg">Masukkan Data Zakat</button>  
                                </form>

                                <!-- Search -->
                                <form class="d-flex">
                                    <div class="input-group">
                                        <input class="form-control form-control-lg" type="text" name="query" placeholder="Cari Nama" aria-label="Search" required />
                                        <button class="btn btn-primary btn-lg" id="btnNavbarSearch" type="submit">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <br>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Total Pemasukan Zakat
                            <div class="card-body">
                                <table id="datatablesSimple" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>TANGGAL</th>
                                            <th>JUMLAH JIWA</th>
                                            <th>ZAKAT FITRAH UANG (Rp - IDR)</th>
                                            <th>ZAKAT FITRAH BERAS (KG)</th>
                                            <th>ZAKAT MAAL</th>
                                            <th>INFAQ/SHODAQOH</th>
                                            <th>FIDYAH UANG (Rp - IDR)</th>
                                            <th>FIDYAH BERAS (Kg)</th>
                                            <th>FIDYAH LAINNYA</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $groupedZakat = $zakat->groupBy(function($item) {
                                                return \Carbon\Carbon::parse($item->created_at)->format('Y-m-d');
                                            });

                                            // Hitung total keseluruhan uang
                                            $totalFitrahUang = $zakat->sum('fitrah_uang');
                                            $totalMaal = $zakat->sum('maal');
                                            $totalInfaq = $zakat->sum('infaq');
                                            $totalFidyahUang = $zakat->sum('fidyah_uang');
                                            $totalGabunganUang = $totalFitrahUang + $totalMaal + $totalInfaq + $totalFidyahUang;

                                            // Hitung total keseluruhan uang
                                            $totalFitrahBeras = $zakat->sum('fitrah_beras');
                                            $totalFidyahBeras = $zakat->sum('fidyah_beras');
                                            $totalGabunganBeras = $totalFitrahBeras + $totalFidyahBeras;
                                        @endphp
                                
                                        @foreach ($groupedZakat as $tanggal => $dataPerTanggal)
                                            <tr>
                                                <td>{{ \Carbon\Carbon::parse($tanggal)->format('d-m-Y') }}</td>
                                                <td>{{ number_format($dataPerTanggal->sum('jml_jiwa'), 0, ',', '.') }}</td>
                                                <td>Rp {{ number_format($dataPerTanggal->sum('fitrah_uang'), 0, ',', '.') }}</td>
                                                <td>{{ number_format($dataPerTanggal->sum('fitrah_beras'), 0, ',', '.') }} KG</td>
                                                <td>Rp {{ number_format($dataPerTanggal->sum('maal'), 0, ',', '.') }}</td>
                                                <td>Rp {{ number_format($dataPerTanggal->sum('infaq'), 0, ',', '.') }}</td>
                                                <td>Rp {{ number_format($dataPerTanggal->sum('fidyah_uang'), 0, ',', '.') }}</td>
                                                <td>{{ number_format($dataPerTanggal->sum('fidyah_beras'), 0, ',', '.') }} KG</td>
                                                <td>{{ number_format($dataPerTanggal->sum('fidyah_lainnya'), 0, ',', '.') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th></th>
                                            <th colspan="2" class="text-center">Total Uang Gabungan</th>
                                            <th colspan="2" class="text-center">Rp {{ number_format($totalGabunganUang, 0, ',', '.') }}</th>
                                            <th colspan="2" class="text-center">Total Beras Gabungan</th>
                                            <th colspan="2" class="text-center">{{ number_format($totalGabunganBeras, 0, ',', '.') }} KG</th>
                                        </tr>
                                    </tfoot>
                                    <tfoot>
                                        <tr>
                                            <th class="text-center">Total</th>
                                            <th>{{ number_format(collect($zakat)->sum('jml_jiwa'), 0, ',', '.') }} Jiwa</th>
                                            <th>Rp {{ number_format(collect($zakat)->sum('fitrah_uang'), 0, ',', '.') }}</th>
                                            <th>{{ number_format(collect($zakat)->sum('fitrah_beras'), 0, ',', '.') }} KG</th>
                                            <th>Rp {{ number_format(collect($zakat)->sum('maal'), 0, ',', '.') }}</th>
                                            <th>Rp {{ number_format(collect($zakat)->sum('infaq'), 0, ',', '.') }}</th>
                                            <th>Rp {{ number_format(collect($zakat)->sum('fidyah_uang'), 0, ',', '.') }}</th>
                                            <th>{{ number_format(collect($zakat)->sum('fidyah_beras'), 0, ',', '.') }} KG</th>
                                            <th>{{ number_format(collect($zakat)->sum('fidyah_lainnya'), 0, ',', '.') }}</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Rekap Zakat
                            <div class="card-body">
                                @if(session('success'))
                                    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                                        {{ session('success') }}
                                    </div>
                                @endif
                                <table id="datatablesSimple" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>NAMA</th>
                                            <th>JUMLAH JIWA</th>
                                            <th>ALAMAT</th>
                                            <th>ZAKAT FITRAH UANG (Rp - IDR)</th>
                                            <th>ZAKAT FITRAH BERAS (KG)</th>
                                            <th>ZAKAT MAAL</th>
                                            <th>INFAQ/SHODAQOH</th>
                                            <th>NAMA PENERIMA (PANITIA)</th>
                                            <th>FIDYAH UANG (Rp - IDR)</th>
                                            <th>FIDYAH BERAS (Kg)</th>
                                            <th>FIDYAH LAINNYA</th>
                                            <th>AKSI</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($zakat as $item)
                                            <tr>
                                                <td>{{ $item->nama }}</td>
                                                <td>{{ $item->jml_jiwa }}</td>
                                                <td>{{ $item->alamat }}</td>
                                                <td>Rp {{ number_format($item->fitrah_uang, 0, ',', '.') }}</td>
                                                <td>{{ $item->fitrah_beras }} KG</td>
                                                <td>Rp {{ number_format($item->maal, 0, ',', '.') }}</td>
                                                <td>Rp {{ number_format($item->infaq, 0, ',', '.') }}</td>
                                                <td>{{ $item->panitia }}</td>
                                                <td>Rp {{ number_format($item->fidyah_uang, 0, ',', '.') }}</td>
                                                <td>{{ $item->fidyah_beras }} KG</td>
                                                <td>{{ $item->fidyah_lainnya }}</td>
                                                <td>
                                                    <a href="{{ route('edit_zakat', $item->id) }}" class="btn btn-warning btn-sm">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button class="btn btn-danger btn-sm delete-btn" data-id="{{ $item->id }}" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>

                <!-- Modal Konfirmasi Hapus Semua Data -->
                <div class="modal fade" id="deleteAllModal" tabindex="-1" aria-labelledby="deleteAllModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteAllModalLabel">Konfirmasi Penghapusan</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Apakah Anda yakin ingin menghapus semua data pengeluaran?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <form id="deleteAllForm" action="{{ route('delete_all_zakat') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-danger">Hapus Semua</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                </div>

                <!-- Modal Konfirmasi Hapus -->
                <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Penghapusan</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Apakah Anda yakin ingin menghapus data ini?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <form id="deleteForm" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
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

            $(document).ready(function () {
                $('.delete-btn').on('click', function () {
                    var id = $(this).data('id');
                    var actionUrl = "{{ route('delete_zakat', ':id') }}".replace(':id', id);
                    $('#deleteForm').attr('action', actionUrl);
                });
            });
        </script>
    </body>
</html>
