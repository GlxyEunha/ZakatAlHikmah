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
                        <h1 class="mt-4">Form Zakat</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Form Zakat</li>
                        </ol>
                        <form action="{{ route('zakat') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="nama">Nama</label>
                                <br>
                                <small class="form-text text-muted">Tulis nama keluarganya saja (contoh: KLG. Bp/Ibu. Nazar)</small>
                                <br>
                                <small class="form-text text-muted">Jika zakat untuk dirinya sendiri maka tulis nama lengkapnya (contoh: Ali Hidayat)</small>
                                <input name="nama" type="text" class="form-control">
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="jml_jiwa">Jumlah Jiwa</label>
                                <br>
                                <small class="form-text text-muted">Tulis angka saja</small>
                                <input name="jml_jiwa" type="text" class="form-control">
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <br>
                                <small class="form-text text-muted">Tulis alamat tempat tinggal yang disingkat (contoh: Candi Mutiara Raya III Nomor 1 maka ditulis -- CMR III/1)</small>
                                <textarea name="alamat" class="form-control"></textarea>
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="fitrah_uang">Zakat Fitrah Uang</label>
                                <br>
                                <small class="form-text text-muted">Tulis angka saja</small>
                                <input name="fitrah_uang" type="text" class="form-control input-rupiah">
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="fitrah_beras">Zakat Fitrah Beras</label>
                                <br>
                                <small class="form-text text-muted">Tulis angka saja</small>
                                <input name="fitrah_beras" type="text" class="form-control input-beras">
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="maal">Zakat Maal</label>
                                <br>
                                <small class="form-text text-muted">Tulis angka saja</small>
                                <input name="maal" type="text" class="form-control input-rupiah">
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="infaq">Infaq/Shodaqoh</label>
                                <br>
                                <small class="form-text text-muted">Tulis angka saja</small>
                                <input name="infaq" type="text" class="form-control input-rupiah">
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="fidyah_uang">Fidyah Uang</label>
                                <br>
                                <small class="form-text text-muted">Tulis angka saja</small>
                                <input name="fidyah_uang" type="text" class="form-control input-rupiah">
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="fidyah_beras">Fidyah Beras</label>
                                <br>
                                <small class="form-text text-muted">Tulis angka saja</small>
                                <input name="fidyah_beras" type="text" class="form-control input-beras">
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="fidyah_lainnya">Fidyah Lainnya</label>
                                <br>
                                <small class="form-text text-muted">Apabila tidak ada isian maka diberi angka 0 (Nol)</small>
                                <input name="fidyah_lainnya" type="text" class="form-control">
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="panitia">Nama Penerima/Panitia</label>
                                <br>
                                <small class="form-text text-muted">Nama penerima (panitia) yang menerima zakat fitrah, maal, infaq/shodaqoh (contoh: Rizqi AP-BARRA)</small>
                                <input name="panitia" type="text" class="form-control">
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

            document.addEventListener("DOMContentLoaded", function () {
                // Fungsi untuk memformat angka menjadi format rupiah
                function formatRupiah(angka, prefix) {
                    let number_string = angka.replace(/[^,\d]/g, "").toString(),
                        split = number_string.split(","),
                        sisa = split[0].length % 3,
                        rupiah = split[0].substr(0, sisa),
                        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                    if (ribuan) {
                        let separator = sisa ? "." : "";
                        rupiah += separator + ribuan.join(".");
                    }

                    rupiah = split[1] !== undefined ? rupiah + "," + split[1] : rupiah;
                    
                    // Jika angka kosong, jangan tampilkan "Rp "
                    return rupiah.length === 0 ? "" : (prefix === undefined ? rupiah : "Rp " + rupiah);
                }

                // Fungsi untuk memformat angka beras (dengan satuan KG)
                function formatBeras(input) {
                    let value = input.value.replace(/[^0-9,]/g, ""); // Hanya angka dan koma
                    if (value !== "") {
                        input.value = value.endsWith(" KG") ? value : value + " KG";
                    }
                }

                // Event listener untuk input biaya uang (format rupiah)
                document.querySelectorAll(".input-rupiah").forEach(function (input) {
                    input.addEventListener("keyup", function () {
                        input.value = formatRupiah(this.value, "Rp ");
                    });
                });

                // Event listener untuk input beras
                document.querySelectorAll(".input-beras").forEach(function (input) {
                    input.addEventListener("keyup", function () {
                        formatBeras(this);
                    });

                    input.addEventListener("focus", function () {
                        this.value = this.value.replace(" KG", ""); // Hapus "KG" saat fokus
                    });

                    input.addEventListener("blur", function () {
                        formatBeras(this); // Tambahkan kembali "KG" saat blur
                    });
                });
            });

        </script>
    </body>
</html>

