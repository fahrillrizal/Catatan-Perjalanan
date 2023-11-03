<?php

include "../database/koneksi.php";

$nik                = $_POST['nik'];
$nm_pengguna        = $_POST['nama_pengguna'];
$alamat_pengguna    = $_POST['alamat_pengguna'];
$jk                 = $_POST['jk'];

$query  = mysqli_query($connect, "INSERT INTO tb_pengguna SET  nik='$nik', nama_pengguna='$nm_pengguna', alamat_pengguna='$alamat_pengguna', jenis_kelamin='$jk' ");

if ($query) {
    echo "
            <html>
                <head>
                    <link rel='stylesheet' href='../assets/swal2/sweetalert2.min.css'>
                </head>
            </html>
            <script src='../assets/jquery/jquery.min.js'></script>
            <script scr='../assets/swal2/sweetalert2.all.min.js'></script>
            <script type='text/javascript'>
                setTimeout(function(){
                    Swal.fire({
                        title: 'Register Berhasil',
                        text: 'Silahkan Login Untuk Melanjutkan',
                        icon: 'success',
                        showConfirmButton: true
                    });
               });
            </script>
        ";
} else {
    echo "
            <script>
                alert('Gagal Menambahkan $nm_pengguna');
                document.location.href = 'index.php';
            </script>
        ";
}
