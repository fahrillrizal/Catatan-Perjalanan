<?php

session_start();

// database
include "database/koneksi.php";


// register
if (isset($_POST["insert"])) {
    $nik                = $_POST['nik'];
    $username           = $_POST['username'];
    $password           = $_POST['password'];
    $repeat_password    = $_POST['password1'];
    $nm_pengguna        = $_POST['nama_pengguna'];
    $alamat_pengguna    = $_POST['alamat_pengguna'];
    $jk                 = $_POST['jk'];
    $email              = $_POST['email'];
    $verif              = $_POST['verifikasi'];
    $kode               = $_SESSION['kode'];
    $foto_nama          = $_FILES['foto']['name'];
    $ektensi_izin       = array('png', 'jpg', 'jpeg');
    $x  = explode('.', $foto_nama);
    $ektensi    = strtolower(end($x));
    $ukuran = $_FILES['foto']['size'];
    $fiel_tmp   = $_FILES['foto']['tmp_name'];


    if (in_array($ektensi, $ektensi_izin) === true) {
        if ($ukuran < 1044070) {
            if ($password != $repeat_password) {
                echo "
                    <script src='assets/jquery/jquery.min.js'></script>
                    <script src='assets/swal2/sweetalert2.all.min.js'></script>
                    <script type='text/javascript'>
                        setTimeout(function(){
                            Swal.fire({
                                title: 'Register Gagal',
                                text: 'Password berbeda',
                                icon: 'error',
                                showConfirmButton: true
                            });
                        }, 10);
                    </script>
                ";
            } else {
                if ($verif == $kode) {
                    move_uploaded_file($fiel_tmp, 'foto/' . $foto_nama);
                    $sql = "INSERT INTO tb_pengguna SET  nik='$nik', username='$username', password='$password', nama_pengguna='$nm_pengguna', alamat_pengguna='$alamat_pengguna', jenis_kelamin='$jk', foto='$foto_nama', email='$email' ";
                    $query  = mysqli_query($connect, $sql);
                    echo "
                        <script src='assets/jquery/jquery.min.js'></script>
                        <script src='assets/swal2/sweetalert2.all.min.js'></script>
                        <script type='text/javascript'>
                            setTimeout(function(){
                                Swal.fire({
                                    title: 'Register Berhasil',
                                    text: 'Silahkan login untuk melanjutkan',
                                    icon: 'success',
                                    showConfirmButton: true
                                });
                            }, 10);
                            
                        </script>
                    ";
                } else {
                    echo "
                    <script src='assets/jquery/jquery.min.js'></script>
                    <script src='assets/swal2/sweetalert2.all.min.js'></script>
                    <script type='text/javascript'>
                        setTimeout(function(){
                            Swal.fire({
                                title: 'Register Gagal',
                                text: 'Kode Chaptha salah',
                                icon: 'error',
                                showConfirmButton: true
                            });
                        }, 10);
                        
                    </script>

                ";
                }   
            }
        } else {
            echo "
                <script scr='assets/swal2/sweetalert2.all.min.js'></script>
                <script type='text/javascript'>
                    setTimeout(function(){
                        Swal.fire({
                            title: 'Register Gagal',
                            text: 'Ukuran foto terlalu besar',
                            icon: 'error',
                            showConfirmButton: true
                        });
                    }, 10);
                </script>
            ";
        }
    } else {
        echo "
            <script scr='assets/swal2/sweetalert2.all.min.js'></script>
            <script type='text/javascript'>
                setTimeout(function(){
                    Swal.fire({
                        title: 'Register Gagal',
                        text: 'Ekstensi foto anda tidak diperbolehkan',
                        icon: 'error',
                        showConfirmButton: true
                    });
                }, 10);
            </script>
        ";
    }
}

// login
if (isset($_POST["login"])) {
    $nik    = $_POST['nik'];
    // $nama   = $_POST['nama'];
    $password   = $_POST['password'];

    $login  = mysqli_query($connect, "SELECT * FROM tb_pengguna WHERE nik='$nik' AND password='$password' ");

    if ($login->num_rows > 0) {
        $query  = mysqli_fetch_assoc($login);
        $_SESSION['akun'] = $query;
        $_SESSION['id_pengguna'] = $query['id_pengguna'];
        $_SESSION['nik'] = $query['nik'];
        $_SESSION['username'] = $query['username'];
        $_SESSION['nama'] = $query['nama_pengguna'];
        $_SESSION['alamat'] = $query['alamat_pengguna'];
        $_SESSION['jk'] = $query['jenis_kelamin'];
        $_SESSION['foto'] = $query['foto'];
        $_SESSION['role'] = $query['role'];

        echo "
            <script src='assets/jquery/jquery.min.js'></script>
            <script src='assets/swal2/sweetalert2.all.min.js'></script>
            <script type='text/javascript'>
                setTimeout(function(){
                    Swal.fire({
                        title: 'Selamat...',
                        text: 'Login Berhasil',
                        icon: 'success',
                        showConfirmButton: false
                    });
                });
                window.setTimeout (function(){
                    window.location.replace('home.php');
                },3000);
            </script>
        ";
    } else {
        echo "
            <script src='assets/jquery/jquery.min.js'></script>
            <script src='assets/swal2/sweetalert2.all.min.js'></script>
            <script type='text/javascript'>
                setTimeout(function(){
                    Swal.fire({
                        title: 'Login Gagal',
                        text: 'Pastikan NIK dan Nama Benar Serta Akun Sudah Terdaftar',
                        icon: 'error',
                        showConfirmButton: true
                    });
                });
                window.setTimeout (function(){
                    window.location.replace('index.php');
                }, 10000);
            </script>
        ";
    }
}


?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dongle:wght@300;400;700&display=swap" rel="stylesheet">

    <!-- My CSS -->
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="assets/swal2/sweetalert2.min.css">

    <title>Peduli Diri</title>
    <link rel="shortcut icon" href="img/PEDULI DIRI.png">
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg  navbar-dark bg-dark">
        <div class='container'>
            <a class="navbar-brand nb mt-1 title-nav" style="font-size: 2em; font-weight:bold" href="#">
                <img src="img/PEDULI DIRI.png" width="45" height="45" alt="" style="border-radius:50px;">
                Peduli Diri
            </a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <button type="button" class="btn btn-outline-light button mr-3" data-toggle="modal" data-target="#register">
                            Register
                        </button>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="btn btn-outline-light button" data-toggle="modal" data-target="#login">
                            Login
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Slider / Hero -->
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="img/17.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block text-light" style="text-shadow: 2px 1px 1px black;">
                    <h3>SELAMAT DATANG DI APLIKASI PEDULI DIRI</h3>
                    <p>Aplikasi Peduli Diri ini dibuat untuk memudahkan dalam mencatat suhu tubuh anda di tengah pandemi COVID-19</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="img/12.png" class="d-block w-100" alt="....">
                <div class="carousel-caption d-none d-md-block text-light">
                    <h3>Silahkan lakukan register untuk membuat akun</h3>
                </div>
            </div>
            <div class="carousel-item">
                <img src="img/4.jpg" class="d-block w-100" alt="....">
                <div class="carousel-caption d-none d-md-block text-light" style="text-shadow: 2px 1px 1px black;">
                    <h3>Login untuk menggunakan Aplikasi Peduli Diri</h3>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-target="#carouselExampleIndicators" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-target="#carouselExampleIndicators" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </button>
    </div>

    <!-- Modal Register -->
    <div class="modal fade bd-example-modal-lg" id="register" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Form Register</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" onsubmit="validasiReg();" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nik">NIK</label>
                                    <input type="text" class="form-control" id="nik" name="nik" placeholder="Masukkan NIK" required autofocus onkeypress="return hanyaAngka(event);" minlength="16" maxlength="16" autocomplete="off">
                                    <small id="emailHelp" class="form-text text-muted">Masukkan NIK sesuai dengan KTP</small>
                                </div>
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="username" class="form-control" id="username" name="username" placeholder="Masukkan Username" autocomplete="off" required>
                                </div>
                                <div class="form-group">
                                    <label for="nama_pengguna">Nama Pengguna</label>
                                    <input type="nama_pengguna" class="form-control" id="nama_pengguna" name="nama_pengguna" placeholder="Masukkan Nama Pengguna" autocomplete="off" required onkeypress="return hanyaHuruf(event);">
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan Password" autocomplete="off" pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" required>
                                    <small id="emailHelp" class="form-text text-muted">Password hanya dapat di isi minimal 8 karakter, serta terdapat huruf besar, huruf kecil dan angka</small>
                                </div>
                                <div class="form-group">
                                    <label for="password1">Ulangi Password</label>
                                    <input type="password" class="form-control" id="password1" name="password1" placeholder="Ulangi Password" autocomplete="off" pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="alamat_pengguna">Alamat Pengguna</label>
                                    <textarea class="form-control" id="alamat_pengguna" autocomplete="off" name="alamat_pengguna" rows="3" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="jk">Jenis Kelamin</label>
                                    <select class="form-control" name="jk" id="jk" required>
                                        <option value="laki-laki">Laki-laki</option>
                                        <option value="perempuan">Perempuan</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="foto">Foto</label>
                                    <input type="file" class="form-control-file" id="foto" name="foto">
                                    <small>Maksimal 10 MB. Tipe PNG, JPG, JPEG</small>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan Email" autocomplete="off" required>
                                </div>
                                <div class="form-group">
                                    <label for="kode">Kode Captcha</label>
                                    <img src="captcha.php" alt="gambar">
                                </div>
                                <div class="form-group">
                                    <label for="varif">Verifikasi Captcha</label>
                                    <input type="text" class="form-control" id="varif" name="verifikasi" placeholder="Masukkan Kode Captcha" autocomplete="off" required>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa-solid fa-circle-xmark mr-2"></i>Close</button>
                    <button type="submit" class="btn btn-primary" name="insert"><i class="fa-solid fa-user-plus mr-2"></i>Register</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Login -->
    <div class="modal fade" id="login" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class=" modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Form Login</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <div class="form-group">
                            <label for="nik">NIK</label>
                            <input type="text" class="form-control" id="nik" name="nik" placeholder="Masukkan NIK" onkeypress="return hanyaAngka(event);" autocomplete="off" minlength="16" maxlength="16" required>
                        </div>
                        <!-- <div class="form-group">
                            <label for="nama">Nama Lengkap</label>
                            <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan Nama Lengkap" onkeypress="return hanyaHuruf(event);" autocomplete="off" required>
                        </div> -->
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan Password" autocomplete="off" pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" required>
                        </div>
                        <a href="lupa_password.php" class='btn btn-primary'>Lupa Password</a>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa-solid fa-circle-xmark mr-2"></i>Close</button>
                    <button type="submit" class="btn btn-primary" name="login"><i class="fa-solid fa-right-to-bracket mr-2"></i>Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer bg-dark text-center text-white pb-3 pt-3">
        @Copyright 2023 | Created With <i class="fa-solid fa-heart text-danger"></i> By ADJIE MAULANA
    </div>


    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="assets/jquery/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/5d1717637c.js" crossorigin="anonymous"></script>
    <script src="main.js"></script>
    <script src="assets/swal2/sweetalert2.all.min.js"></script>
    <script src="assets/DataTables/DataTables-1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/swal2/sweetalert2.all.min.js"></script>
    <script>
        // function angka
        function hanyaAngka(evt) {
            var charCode = (evt.which) ? evt.which : event.keyCode
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                Swal.fire({
                    title: 'Data tidak Valid',
                    text: 'Kolom NIK Hanya Dapat diisi Angka...!',
                    icon: 'warning',
                    showConfirmButton: true
                });
                return false;
            }        
            return true;
        }
        // function huruf
        function hanyaHuruf(evt) {
            var charCode = (evt.which) ? evt.which : event.keyCode
            if ((charCode < 65 || charCode > 90) && (charCode < 97 || charCode > 122) && charCode > 32) {
                Swal.fire({
                    title: 'Data tidak Valid',
                    text: 'Kolom Nama Hanya Dapat diisi Huruf...!',
                    icon: 'warning',
                    showConfirmButton: true
                });
                return false;  
            }
            return true;
        }
        // validasi register
        function validasiReg() {

        }
    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js" integrity="sha384-VHvPCCyXqtD5DqJeNxl2dtTyhF78xXNXdkwX1CZeRusQfRKp+tA7hAShOK/B/fQ2" crossorigin="anonymous"></script>
    -->
</body>

</html>