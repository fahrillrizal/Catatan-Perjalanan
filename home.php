<?php

session_start();
include "database/koneksi.php";

error_reporting(E_ALL & ~E_NOTICE);

if (!isset($_SESSION['username'])) {
    echo "
        <script src='assets/jquery/jquery.min.js'></script>
        <script src='assets/swal2/sweetalert2.all.min.js'></script>
        <script type='text/javascript'>
            setTimeout(function(){
                Swal.fire({
                    title: 'Silahkan Login Terlebih Dahulu',
                    icon: 'warning',
                    showConfirmButton: true
                });
            });
            window.setTimeout (function(){
            window.location.replace('index.php');
            }, 3000);
        </script>
    ";
}

// update profil
if (isset($_POST["update"])) {
    $id_pengguna        = $_POST['id_pengguna'];
    $nik                = $_POST['nik'];
    $username           = $_POST['username'];
    $nm_pengguna        = $_POST['nama_pengguna'];
    $alamat_pengguna    = $_POST['alamat_pengguna'];
    $jk                 = $_POST['jk'];
    $foto_nama          = $_FILES['foto']['name'];
    $ektensi_izin       = array('png', 'jpg', 'jpeg');
    $x  = explode('.', $foto_nama);
    $ektensi    = strtolower(end($x));
    $ukuran = $_FILES['foto']['size'];
    $fiel_tmp   = $_FILES['foto']['tmp_name'];

    if(!empty($_FILES["foto"]["tmp_name"])){


    if (in_array($ektensi, $ektensi_izin) === true) {
        if ($ukuran < 1044070) {
            move_uploaded_file($fiel_tmp, 'foto/' . $foto_nama);

            $query  = mysqli_query($connect, "UPDATE tb_pengguna SET nik='$nik', username='$username',nama_pengguna='$nm_pengguna', alamat_pengguna='$alamat_pengguna', jenis_kelamin='$jk', foto='$foto_nama' WHERE id_pengguna='$id_pengguna' ");

            if ($query) {
                echo "
                    <script src='assets/jquery/jquery.min.js'></script>
                    <script src='assets/swal2/sweetalert2.all.min.js'></script>
                    <script type='text/javascript'>
                        setTimeout(function(){
                            Swal.fire({
                                title: 'Berhasil memperbarui Profil',
                                icon: 'success',
                                showConfirmButton: true
                            });
                    });
                    </script>
                ";
            } else {
                echo "
                    <script scr='assets/swal2/sweetalert2.all.min.js'></script>
                    <script type='text/javascript'>
                        setTimeout(function(){
                            Swal.fire({
                                title: 'Gagal memperbarui profil',
                                text: 'Silahkan Coba Lagi',
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
}else{
    $sql = "UPDATE tb_pengguna SET nik='$nik', username='$username',nama_pengguna='$nm_pengguna', alamat_pengguna='$alamat_pengguna', jenis_kelamin='$jk' WHERE id_pengguna='$id_pengguna'";
    $query  = mysqli_query($connect, $sql);
    if ($query) {
        echo "
            <script src='assets/jquery/jquery.min.js'></script>
            <script src='assets/swal2/sweetalert2.all.min.js'></script>
            <script type='text/javascript'>
                setTimeout(function(){
                    Swal.fire({
                        title: 'Berhasil memperbarui Profil',
                        icon: 'success',
                        showConfirmButton: true
                    });
            });
            </script>
        ";
    } else {
        echo "
            <script scr='assets/swal2/sweetalert2.all.min.js'></script>
            <script type='text/javascript'>
                setTimeout(function(){
                    Swal.fire({
                        title: 'Gagal memperbarui profil',
                        text: 'Silahkan Coba Lagi',
                        icon: 'error',
                        showConfirmButton: true
                    });
                }, 10);
            </script>
        ";
    }
}

}

$id_pengguna    = $_SESSION['id_pengguna'];
$select         = mysqli_query($connect, "SELECT * FROM tb_pengguna WHERE id_pengguna='$id_pengguna' ");
$results        = mysqli_fetch_all($select, MYSQLI_ASSOC);

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

    <!-- Font Awesome -->
    <link rel="stylesheet" href="assets/fontawesome6/css/fontawesome.min.css">

    <title>Peduli Diri</title>
    <link rel="shortcut icon" href="img/PEDULI DIRI.png">
</head>

<body style="background: url('img/14.jpg');background-position: center;background-repeat: no-repeat;background-attachment: fixed;background-size: cover;">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg  navbar-dark bg-dark">
        <div class='container'>
            <a class="navbar-brand nb mt-1 title-nav" style="font-size: 2em; font-weight:bold" href="#">
                <img src="img/PEDULI DIRI.png" width="45" height="45" alt="" style="border-radius:50px;">
                Peduli Diri
            </a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link link mt-1" href="home.php">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link link mt-1" href="caper.php">Catatan Perjalanan</a>
                    </li>
                    <li>
                        <div class="dropdown show">
                            <a class="btn bg-primary text-white dropdown-toggle ml-3" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?php foreach ($results as $result) : ?>
                                    <?php echo $result['username']; ?> |
                                    <?php if ($_SESSION['foto'] == "") { ?>
                                        <img src="img/user/user.png" alt="" width="40" height="40" class="rounded-circle">
                                    <?php } else { ?>
                                        <img src="foto/<?php echo $result['foto']; ?>" alt="" width="40" height="40" class="rounded-circle">
                                    <?php } ?>
                                <?php endforeach; ?>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#profil">Profil Pengguna<i class="fa-solid fa-user ml-2 mt-1" style="float: right;"></i></a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" onclick="logout();">Log out<i class="fa-solid fa-power-off ml-2 mt-1" style="float: right;"></i></a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- alert -->
    <div class="container mt-5">
        <div class="alert alert-success welcome text-center" role="alert" style="font-size: 1.2em;">

        </div>
    </div>


    <div class="container mt-5">
        <div class="alert alert-success text-center" role="alert" style="font-size: 1.1em;">
            Aplikasi ini diciptakan ditengah pandemi COVID-19. Aplikasi ini bertujuan untuk memudahkan pengguna mencatat kegiatan atau perjalanan pengguna di masa PANDEMI COVID-19. Aplikasi ini dapat mencatat tanggal, waktu, lokasi, serta suhu tubuh pengguna. Dan aplikasi ini memiliki beberapa fitur seperti register, login, edit profil, catat perjalanan, mengurutkan data perjalanan, fitur searching data perjalanan, serta fitur login.
        </div>
    </div>


    <!-- Profil Pengguna -->
    <div class="modal fade bd-example-modal-lg" id="profil" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Profil Pengguna</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" onsubmit="validasiReg();" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6">
                                <img src="foto/<?php echo $result['foto']; ?>" alt="" width="380px" height="450px">
                                <div class="form-group mt-3">
                                    <label for="foto">Foto</label>
                                    <input type="file" class="form-control-file" id="foto" name="foto" value="foto/<?php echo $result['foto']; ?>">
                                    <small>Maksimal 10 MB. Tipe PNG, JPG, JPEG</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" hidden class="form-control" id="nik" name="id_pengguna" placeholder="Masukkan id pengguna" required autofocus onkeypress="return hanyaAngka(event);" value="<?php echo $result['id_pengguna']; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="nik">NIK</label>
                                    <input type="text" class="form-control" id="nik" name="nik" placeholder="Masukkan NIK" required autofocus onkeypress="return hanyaAngka(event);" value="<?php echo $result['nik'] ?>">
                                </div>
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="username" class="form-control" id="username" name="username" placeholder="Masukkan Username" value="<?php echo $result['username'] ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="nama_pengguna">Nama Pengguna</label>
                                    <input type="nama_pengguna" class="form-control" id="nama_pengguna" name="nama_pengguna" placeholder="Masukkan Nama Pengguna" required onkeypress="return hanyaHuruf(event);" value="<?php echo $result['nama_pengguna'] ?>">
                                </div>
                                <div class="form-group">
                                    <label for="alamat_pengguna">Alamat Pengguna</label>
                                    <textarea class="form-control" id="alamat_pengguna" name="alamat_pengguna" rows="3" required><?php echo $result['alamat_pengguna'] ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="jk">Jenis Kelamin</label>
                                    <select class="form-control" name="jk" id="jk" required>
                                        <?php
                                        if ($result['jenis_kelamin'] == 'laki-laki') {
                                            echo "<option value='laki-laki' selected>Laki-laki</option>";
                                            echo "<option value='perempuan'>Perempuan</option>";
                                        } elseif ($result['jenis_kelamin'] == 'perempuan') {
                                            echo "<option value='perempuan' selected>Perempuan</option>";
                                            echo "<option value='laki-laki'>Laki-laki</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa-solid fa-circle-xmark mr-2"></i>Close</button>
                    <button type="submit" class="btn btn-primary" name="update"><i class="fa-solid fa-user-pen mr-2"></i>Perbarui Profil</button>
                </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Footer -->
    <div class="main-footer bg-dark text-center text-white pb-3 pt-3" style="margin-top: 318px;">
        @Djiecouple 2023 | Created With <i class="fa-solid fa-heart text-danger"></i> By ADJIE MAULANA
    </div>
     <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>

    <script src="https://kit.fontawesome.com/5d1717637c.js" crossorigin="anonymous"></script>
    <script src="assets/swal2/sweetalert2.all.min.js"></script>
    <script src="assets/gsap/minified/gsap.min.js"></script>
    <script src="assets/gsap/minified/TextPlugin.min.js"></script>
    <script>
        // alert
        gsap.registerPlugin(TextPlugin);
        gsap.to(".welcome", {
            duration: 5,
            text: "Selamat Datang <b style='text-transform: capitalize;'><?php echo $_SESSION['nama']; ?></b> di Aplikasi Peduli Diri"
        });
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
        // function logout
        function logout() {
            Swal.fire({
                title: 'Yakin Ingin Log out?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yakin'
            }).then((result) => {
                if (result.isConfirmed) {
                    setTimeout(function() {
                        Swal.fire({
                            title: 'Berhasil Logout',
                            icon: 'success',
                            showConfirmButton: false
                        });
                    });
                    window.setTimeout(function() {
                        window.location.replace('logout.php');
                    }, 1000);
                }
            })
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