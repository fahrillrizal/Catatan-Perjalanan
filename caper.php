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

// insert catatan perjalanan
if (isset($_POST['tambah'])) {
    $id_pengguna    = $_POST['id_pengguna'];
    $tgl_catatan    = $_POST['tgl'];
    $waktu          = $_POST['waktu'];
    $lokasi         = $_POST['lokasi'];
    $suhu_tubuh     = $_POST['suhu'];

    if ($suhu_tubuh > 38 || $suhu_tubuh < 24) {
        echo "
            <script src='assets/jquery/jquery.min.js'></script>
            <script src='assets/swal2/sweetalert2.all.min.js'></script>
            <script type='text/javascript'>
                setTimeout(function(){
                    Swal.fire({
                        title: 'Suhu tubuh anda tidak normal, pastikan anda tetap berada dirumah',
                        icon: 'warning',
                        showConfirmButton: true
                    });
                }, 10);
            </script>
        ";
    } else {
        $query  = mysqli_query($connect, "INSERT INTO tb_catatan SET id_pengguna='$id_pengguna', tgl_catatan='$tgl_catatan', jam='$waktu', lokasi='$lokasi', suhu_tubuh='$suhu_tubuh' ");

        echo "
            <script src='assets/jquery/jquery.min.js'></script>
            <script src='assets/swal2/sweetalert2.all.min.js'></script>
                <script type='text/javascript'>
                    setTimeout(function(){
                        Swal.fire({
                            title: 'Berhasil Menambahkan Catatan Perjalanan',
                            icon: 'success',
                            showConfirmButton: true
                        });
                    });
            </script>
        ";
    }

    // $query  = mysqli_query($connect, "INSERT INTO tb_catatan SET id_pengguna='$id_pengguna', tgl_catatan='$tgl_catatan', jam='$waktu', lokasi='$lokasi', suhu_tubuh='$suhu_tubuh' ");

    // if ($query) {
    //     if ($suhu_tubuh > 38) {
    //         echo "
    //             <script src='assets/jquery/jquery.min.js'></script>
    //             <script src='assets/swal2/sweetalert2.all.min.js'></script>
    //                 <script type='text/javascript'>
    //                     setTimeout(function(){
    //                         Swal.fire({
    //                             title: 'Berhasil Menambahkan Catatan Perjalanan',
    //                             icon: 'error',
    //                             showConfirmButton: true
    //                         });
    //                     });
    //             </script>
    //         ";
    //     } else {
    //         echo "
    //         <script src='assets/jquery/jquery.min.js'></script>
    //         <script src='assets/swal2/sweetalert2.all.min.js'></script>
    //             <script type='text/javascript'>
    //                 setTimeout(function(){
    //                     Swal.fire({
    //                         title: 'Berhasil Menambahkan Catatan Perjalanan',
    //                         icon: 'success',
    //                         showConfirmButton: true
    //                     });
    //                 });
    //         </script>
    //     ";
    //     }
    // } else {
    //     echo "
    //         <script scr='assets/swal2/sweetalert2.all.min.js'></script>
    //         <script type='text/javascript'>
    //             setTimeout(function(){
    //                 Swal.fire({
    //                     title: 'Register Gagal',
    //                     text: 'Silahkan Coba Lagi',
    //                     icon: 'error',
    //                     showConfirmButton: true
    //                 });
    //             }, 10);
    //         </script>
    //     ";
    // }
}

if(isset($_SESSION['nik'])){
    $nik = $_SESSION['nik'];
    $login  = mysqli_query($connect, "SELECT * FROM tb_pengguna WHERE nik='$nik'");

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
    }
}

$id_pengguna    = $_SESSION['id_pengguna'];
$select         = mysqli_query($connect, "SELECT * FROM tb_catatan WHERE id_pengguna='$id_pengguna' ");
if($_SESSION['role']=='admin'){
    $select         = mysqli_query($connect, "SELECT * FROM tb_catatan left join tb_pengguna on tb_pengguna.id_pengguna=tb_catatan.id_pengguna");
}
$results        = mysqli_fetch_all($select, MYSQLI_ASSOC);

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
}

$id_pengguna1   = $_SESSION['id_pengguna'];
$select1        = mysqli_query($connect, "SELECT * FROM tb_pengguna WHERE id_pengguna='$id_pengguna1' ");
$results1       = mysqli_fetch_all($select1, MYSQLI_ASSOC);

$filter_lokasi  = mysqli_query($connect, "SELECT * FROM tb_catatan WHERE id_pengguna='$id_pengguna1' ORDER BY lokasi ASC");
$rows = mysqli_fetch_all($filter_lokasi, MYSQLI_ASSOC);


//hapus data
if(isset($_POST['hapus'])){
    $id= $_POST['id'];

    $query = "delete from tb_catatan where no_catatan='$id'";
    $result = mysqli_query($connect, $query);
    if ($result) {
        echo "
            <script src='assets/jquery/jquery.min.js'></script>
            <script src='assets/swal2/sweetalert2.all.min.js'></script>
            <script type='text/javascript'>
                setTimeout(function(){
                    Swal.fire({
                        title: 'Berhasil menghapus catatan',
                        icon: 'success',
                        showConfirmButton: true
                    });
                    window.location.assign('caper.php')
                });
            </script>
        ";
    } else {
        echo "
            <script src='assets/jquery/jquery.min.js'></script>
            <script src='assets/swal2/sweetalert2.all.min.js'></script>
            <script type='text/javascript'>
                setTimeout(function(){
                    Swal.fire({
                        title: 'Gagal menghapus catatan',
                        icon: 'error',
                        showConfirmButton: true
                    });
                });
            </script>
        ";
    }
}


// edit data
if (isset($_POST['edit'])) {
    $no_catatan         = $_POST['no_catatan'];
    $id_pengguna_edit   = $_POST['id_pengguna'];
    $tanggal_edit       = $_POST['tgl'];
    $waktu_edit         = $_POST['waktu'];
    $lokasi_edit        = $_POST['lokasi'];
    $suhu_tubuh_edit    = $_POST['suhu'];

    $query_edit = mysqli_query($connect, "UPDATE tb_catatan SET id_pengguna='$id_pengguna_edit', tgl_catatan='$tanggal_edit', jam='$waktu_edit', lokasi='$lokasi_edit', suhu_tubuh='$suhu_tubuh_edit' WHERE no_catatan='$no_catatan' ");

    if ($query_edit) {
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
        header("location: caper.php");
    } else {
        echo "
            <script src='assets/jquery/jquery.min.js'></script>
            <script src='assets/swal2/sweetalert2.all.min.js'></script>
            <script type='text/javascript'>
                setTimeout(function(){
                    Swal.fire({
                        title: 'Gagal mengedit data',
                        icon: 'error',
                        showConfirmButton: true
                    });
                });
                window.location.asign('caper.php')
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

    <!-- Data Tables -->
    <link rel="stylesheet" href="assets/DataTables/DataTables-1.11.5/css/jquery.dataTables.min.css">
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
                <img src="img/PEDULI DIRI.png" width="45" height="45" alt="">
                Peduli Diri
            </a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link link mt-1" href="home.php">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link link mt-1" href="caper.php">Catatan Perjalanan</a>
                    </li>
        <?php if($_SESSION['role'] != 'admin'):?>
            
            <li class="nav-item">
                <a class="nav-link link mt-1" href="#" data-toggle="modal" data-target="#isicaper">Isi Data</a>
            </li>
            <?php endif ?>
                    <li>
                        <div class="dropdown show">
                            <a class="btn bg-primary text-white dropdown-toggle ml-3" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?php foreach ($results1 as $result1) : ?>
                                    <?php echo $result1['username']; ?> |
                                    <?php if ($_SESSION['foto'] == "") { ?>
                                        <img src="img/user/user.png" alt="" width="40" height="40" class="rounded-circle">
                                    <?php } else { ?>
                                        <img src="foto/<?php echo $result1['foto']; ?>" alt="" width="40" height="40" class="rounded-circle">
                                    <?php } ?>
                                <?php endforeach; ?>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#profil">Profil Pengguna <i class="fa-solid fa-user ml-2 mt-1" style="float: right;"></i></a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" onclick="logout();">Log out<i class="fa-solid fa-power-off ml-2 mt-1" style="float: right;"></i></a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>



    <div class="container">
        <!-- Nav Urut -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark mt-5 mb-3">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Urutkan Berdasarkan <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item ml-5">
                        <div class="input-group" style="width: 400px;">
                            <select class="custom-select" name="pilihan" id="urut">
                                <!-- <option selected>Choose...</option> -->
                                <option value="0">Tanggal</option>
                                <option value="1">Waktu</option>
                                <option value="2">Lokasi</option>
                                <option value="3">Suhu Tubuh</option>
                            </select>
                            <div class="input-group-append">
                                <button class="btn btn-outline-light" type="submit" onclick="urutkan(urut)" name="urutkan">Urutkan</button>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Table -->
        <table class="table table-striped table-bordered mt-3 " id="myTable">
            <thead class="thead bg-dark text-white text-center">
                <tr>
                    <?php if($_SESSION['role'] == 'admin'):?>
                    <th scope="col" style="cursor:pointer;">Username</th>
                    <?php endif ?>
                    <th scope="col" style="cursor:pointer;">Tanggal</th>

                    <th scope="col" style="cursor:pointer;">Waktu</th>
                    
                    <th scope="col" style="cursor:pointer;">Lokasi</th>

                    <th scope="col" style="cursor:pointer;">Suhu Tubuh</th>
                    <?php if($_SESSION['role'] == 'admin'):?>
                    <th scope="col" style="cursor:pointer;">Action</th>
                    <?php endif ?>
                    <?php if($_SESSION['role'] != 'admin'):?>
                    <th scope="col" style="cursor:pointer;">Print</th>
                    <?php endif ?>
                </tr>
            </thead>
            <tbody class="text-center bg-white">
                <?php foreach ($results as $result) : ?>
                    <tr>
                        <?php if($_SESSION['role'] == 'admin'):?>
                        <td><?php echo $result['username']; ?></td>
                        <?php endif ?>
                        <td><?php echo $result['tgl_catatan']; ?></td>
                        <td><?php echo $result['jam']; ?></td>
                        <td style="text-transform: capitalize;" id="isilokasi"><?php echo $result['lokasi']; ?></td>
                        <td><?php echo $result['suhu_tubuh']; ?> °C</td>
                        <?php if($_SESSION['role'] != 'admin'):?>
                            <td>
                            <a type="button" class="btn btn-outline-dark mt-3 bg-white" href="cetak.php?id_catatan=<?=$result['no_catatan']?>"><i class="fa-solid fa-print mr-2"></i>Cetak</a>
                            </td>
                        <?php endif ?>
                        <?php if($_SESSION['role'] == 'admin'):?>
                            <td>
                                <button type="button" class="btn btn-outline-dark mt-3 bg-white" data-toggle="modal" data-target="#edit<?php echo $result['no_catatan']; ?>"><i class="fa-solid fa-pen mr-2"></i>edit</button>
                                <form method="post" action="" class="d-inline" id="formhapus" >
                                    <input type="hidden" name="id" value="<?php echo $result['no_catatan']; ?>">
                                    <button type="button"  onclick="hapusf(this)" class="btn btn-outline-white mt-3 bg-danger text-white" >
                                        <i class="fa-solid fa-trash mr-2"></i>hapus
                                    </button>
                                    <input type="hidden" name="hapus" class="d-none"></input>
                                </form>
                            </td>
                            <?php endif ?>
                        </tr>
                    <?php if($_SESSION['role'] == 'admin'):?>
                    <div class="modal fade" id="edit<?php echo $result['no_catatan']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class=" modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Isi Catatan Perjalanan</h5>
                                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="" method="post">
                                        <?php
                                        $no = $result['no_catatan'];
                                        $edit = mysqli_query($connect, "SELECT * FROM tb_catatan WHERE no_catatan='$no' ");
                                        $update = mysqli_fetch_all($edit, MYSQLI_ASSOC);
                                        ?>
                                        <?php foreach ($update as $rubah) : ?>
                                            <div class="form-group">
                                                <input type="text" hidden class="form-control" id="no_catatan" name="no_catatan" value="<?php echo $rubah['no_catatan']; ?>">
                                            </div>
                                            <div class="form-group">
                                                <input type="text" hidden class="form-control" id="id_pengguna" name="id_pengguna" value="<?php echo $_SESSION['id_pengguna']; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="tgl">Tanggal</label>
                                                <input type="date" class="form-control" id="tgl" name="tgl" value="<?php echo $rubah['tgl_catatan']; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="waktu">Waktu</label>
                                                <input type="time" class="form-control" id="waktu" name="waktu" value="<?php echo $rubah['jam']; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="lokasi">Lokasi</label>
                                                <input type="text" class="form-control" id="lokasi" name="lokasi" value="<?php echo $rubah['lokasi']; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="suhu">Suhu Tubuh</label>
                                                <input type="text" class="form-control" id="suhu" name="suhu" value="<?php echo $rubah['suhu_tubuh']; ?>">
                                            </div>
                                        </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-dark" data-dismiss="modal"><i class="fa-solid fa-circle-xmark mr-2"></i>Close</button>
                                    <button type="submit" class="btn btn-primary" name="edit"><i class="fa-solid fa-pen-to-square mr-2"></i>Edit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>  
                    <?php endif ?>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php if($_SESSION['role'] != 'admin'):?>
        <div class="d-flex align-items-end flex-column mb-5 ">
            <button type="button" class="btn btn-outline-dark mt-3 bg-white" data-toggle="modal" data-target="#isicaper"><i class="fa-solid fa-circle-plus mr-2"></i>Isi Catatan Perjalanan</button>
        </div>
        <?php else:?>
        <div class="d-flex align-items-start flex-column mb-5 ">
            <a type="button" class="btn btn-outline-dark mt-3 bg-white" href="cetak.php"><i class="fa-solid fa-circle-plus mr-2"></i>Cetak</a>
        </div>
        <?php endif ?>
    </div>



    <?php if($_SESSION['role'] != 'admin'):?>
         
    <!-- Modal Isi Caper -->
    <div  class="modal fade" id="isicaper" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class=" modal-content" >
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Isi Catatan Perjalanan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <div class="form-group">
                            <input type="text" hidden class="form-control" id="id_pengguna" name="id_pengguna" value="<?php echo $_SESSION['id_pengguna']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="tgl">Tanggal</label>
                            <input type="date" class="form-control" id="tgl" name="tgl" autocomplete="off"  required>
                        </div>
                        <div class="form-group">
                            <label for="waktu">Waktu</label>
                            <input type="time" class="form-control" id="waktu" name="waktu" autocomplete="off" required>
                        </div>
                        <div class="form-group">
                            <label for="lokasi">Lokasi</label>
                            <input type="text" class="form-control" id="lokasi" name="lokasi" placeholder="Masukkan Lokasi" autocomplete="off" required>
                        </div>
                        <div class="form-group info">
                            <label for="suhu">Temperature</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" class="suhu" name="suhu" id="suhu" placeholder="Masukkan Suhu Tubuh" autocomplete="off" required>
                                <div class="input-group-append mb-3">
                                    <span class="input-group-text">°C</span>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-dismiss="modal"><i class="fa-solid fa-circle-xmark mr-2"></i>Close</button>
                    <button type="submit" class="btn btn-primary" name="tambah"><i class="fa-solid fa-circle-plus mr-2"></i>Tambah</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php endif ?>

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
                                <img src="foto/<?php echo $result1['foto']; ?>" alt="" width="380px" height="450px">
                                <div class="form-group mt-3">
                                    <label for="foto">Foto</label>
                                    <input type="file" class="form-control-file" id="foto" name="foto" value="foto/<?php echo $result1['foto']; ?>">
                                    <small>Maksimal 10 MB. Tipe PNG, JPG, JPEG</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" hidden class="form-control" id="nik" name="id_pengguna" placeholder="Masukkan id pengguna" required autofocus onkeypress="return hanyaAngka(event);" value="<?php echo $result1['id_pengguna']; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="nik">NIK</label>
                                    <input type="text" class="form-control" id="nik" name="nik" placeholder="Masukkan NIK" required autofocus onkeypress="return hanyaAngka(event);" value="<?php echo $result1['nik'] ?>">
                                </div>
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="username" class="form-control" id="username" name="username" placeholder="Masukkan Username" value="<?php echo $result1['username'] ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="nama_pengguna">Nama Pengguna</label>
                                    <input type="nama_pengguna" class="form-control" id="nama_pengguna" name="nama_pengguna" placeholder="Masukkan Nama Pengguna" required onkeypress="return hanyaHuruf(event);" value="<?php echo $result1['nama_pengguna'] ?>">
                                </div>
                                <div class="form-group">
                                    <label for="alamat_pengguna">Alamat Pengguna</label>
                                    <textarea class="form-control" id="alamat_pengguna" name="alamat_pengguna" rows="3" required><?php echo $result1['alamat_pengguna'] ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="jk">Jenis Kelamin</label>
                                    <select class="form-control" name="jk" id="jk" required>
                                        <?php
                                        if ($result1['jenis_kelamin'] == 'laki-laki') {
                                            echo "<option value='laki-laki' selected>Laki-laki</option>";
                                            echo "<option value='perempuan'>Perempuan</option>";
                                        } elseif ($result1['jenis_kelamin'] == 'perempuan') {
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
                    <button type="button" class="btn btn-dark" data-dismiss="modal"><i class="fa-solid fa-circle-xmark mr-2"></i>Close</button>
                    <button type="submit" class="btn btn-primary" name="update"><i class="fa-solid fa-user-pen mr-2"></i>Perbarui Profil</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="assets/jquery/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/5d1717637c.js" crossorigin="anonymous"></script>
    <script src="main.js"></script>
    <script src="assets/swal2/sweetalert2.all.min.js"></script>
    <script src="assets/DataTables/DataTables-1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    

    <script>
        // function hapus
        function hapusf(e) {
            const formhapus = e.parentElement
            Swal.fire({
                title: 'Yakin Ingin hapus?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yakin'
            }).then((result) => {
                if (result.isConfirmed) {
                    setTimeout(function() {
                        Swal.fire({
                            title: 'Berhasil hapus data',
                            icon: 'success',
                            showConfirmButton: false
                        });
                    });
                    window.setTimeout(function() {
                        formhapus.submit()
                    }, 1000);
                }
            })
        }
    </script>


    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        });

        
        
        function sortTable(n) {
            var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
            table = document.getElementById("myTable");
            switching = true;
            //Set the sorting direction to ascending:
            dir = "asc";
            /*Make a loop that will continue until
            no switching has been done:*/
            while (switching) {
                //start by saying: no switching is done:
                switching = false;
                rows = table.rows;
                /*Loop through all table rows (except the
                first, which contains table headers):*/
                for (i = 1; i < (rows.length - 1); i++) {
                    //start by saying there should be no switching:
                    shouldSwitch = false;
                    /*Get the two elements you want to compare,
                    one from current row and one from the next:*/
                    x = rows[i].getElementsByTagName("TD")[n];
                    y = rows[i + 1].getElementsByTagName("TD")[n];
                    /*check if the two rows should switch place,
                    based on the direction, asc or desc:*/
                    if (dir == "asc") {
                        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                            //if so, mark as a switch and break the loop:
                            shouldSwitch = true;
                            break;
                        }
                    } else if (dir == "desc") {
                        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                            //if so, mark as a switch and break the loop:
                            shouldSwitch = true;
                            break;
                        }
                    }
                }
                if (shouldSwitch) {
                    /*If a switch has been marked, make the switch
                    and mark that a switch has been done:*/
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;
                    //Each time a switch is done, increase this count by 1:
                    switchcount++;
                } else {
                    /*If no switching has been done AND the direction is "asc",
                    set the direction to "desc" and run the while loop again.*/
                    if (switchcount == 0 && dir == "asc") {
                        dir = "desc";
                        switching = true;
                    }
                }
            }
        }
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
        // function filter
        var state = false;

        function filter_tgl() {
            if (state) {
                $("#filter_tgl").removeClass('fa-solid fa-caret-down mt-1');
                $("#filter_tgl").addClass('fa-solid fa-caret-up mt-2');
                span = document.getElementsByTagName('th');
                for (let c = 0; c < span.length; c++) {
                    span[c].addEventListener('click', item(c));
                }

                function item(c) {
                    return function() {
                        sortTable(c);
                    }
                }
                state = false;
            } else {
                $("#filter_tgl").removeClass('fa-solid fa-caret-up mt-2');
                $("#filter_tgl").addClass('fa-solid fa-caret-down mt-1');
                state = true;
            }
        }

        function filter_jam() {
            if (state) {
                $("#filter_jam").removeClass('fa-solid fa-caret-down mt-1');
                $("#filter_jam").addClass('fa-solid fa-caret-up mt-2');
                span = document.getElementsByTagName('th');
                for (let c = 0; c < span.length; c++) {
                    span[c].addEventListener('click', item(c));
                }

                function item(c) {
                    return function() {
                        sortTable(c);
                    }
                }
                state = false;
            } else {
                $("#filter_jam").removeClass('fa-solid fa-caret-up mt-2');
                $("#filter_jam").addClass('fa-solid fa-caret-down mt-1');
                state = true;
            }
        }

        function filter_lokasi() {
            if (state) {
                $("#filter_lokasi").removeClass('fa-solid fa-caret-down mt-1');
                $("#filter_lokasi").addClass('fa-solid fa-caret-up mt-2');
                span = document.getElementsByTagName('th');
                for (let c = 0; c < span.length; c++) {
                    span[c].addEventListener('click', item(c));
                }

                function item(c) {
                    return function() {
                        sortTable(c);
                    }
                }
                state = false;
            } else {
                $("#filter_lokasi").removeClass('fa-solid fa-caret-up mt-2');
                $("#filter_lokasi").addClass('fa-solid fa-caret-down mt-1');
                state = true;
            }
        }

        function filter_suhu() {
            if (state) {
                $("#filter_suhu").removeClass('fa-solid fa-caret-down mt-1');
                $("#filter_suhu").addClass('fa-solid fa-caret-up mt-2');
                span = document.getElementsByTagName('th');
                for (let c = 0; c < span.length; c++) {
                    span[c].addEventListener('click', item(c));
                }

                function item(c) {
                    return function() {
                        sortTable(c);
                    }
                }
                state = false;
            } else {
                $("#filter_suhu").removeClass('fa-solid fa-caret-up mt-2');
                $("#filter_suhu").addClass('fa-solid fa-caret-down mt-1');
                state = true;
            }
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
                        window.location.replace('index.php');
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
<!-- <span><i class="fa-solid fa-caret-down mt-1" id="filter_tgl" onclick="filter_tgl();" style="float: right; cursor:pointer;" onclick="sortTable(0)"></i></span>
<span><i class="fa-solid fa-caret-down mt-1" id="filter_jam" onclick="filter_jam();" style="float: right; cursor:pointer;" onclick="sortTable(1)"></i></span>
<span><i class="fa-solid fa-caret-down mt-1" id="filter_lokasi" onclick="filter_lokasi();" style="float: right; cursor:pointer;" onclick="sortTable(2)"></i></span>
<span><i class="fa-solid fa-caret-down mt-1" id="filter_suhu" onclick="filter_suhu();" style="float: right; cursor:pointer;" onclick="sortTable(3)"></i></span> -->

</html>