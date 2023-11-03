
<?php
        session_start();

?>
<!DOCTYPE html>
<html>

<body onload="window.print()">

    <center>
        <h3>Laporan Catatan Perjalanan</h3>
    </center>

    <table border="1" cellspacing="0" style="width: 100%">
        <tr bgcolor="00FFFF">
            <th width="1%">No</th>
            <?php if($_SESSION['role'] == 'admin'):?>    
            <th>
                Username
            </th>
            <?php endif ?>    

            <th>Tanggal</th>
            <th>Waktu</th>
            <th>Lokasi</th>
            <th>Suhu Tubuh</th>
        </tr>
        <?php
        include('database/koneksi.php');
        
        $sql = "";
        if($_SESSION['role'] != 'admin' && isset($_GET['id_catatan'])){
            $id = $_GET['id_catatan'];
            $sql = "select * from tb_catatan where no_catatan='$id'";
        }elseif($_SESSION['role'] == 'admin'){
            $sql = "select * from tb_catatan inner join tb_pengguna on tb_pengguna.id_pengguna=tb_catatan.id_pengguna";
        }
        if(empty($sql)){
            return;
        }
        $no = 1;
        // $data = file('catatan.txt', FILE_IGNORE_NEW_LINES);
        // $user = $_SESSION['nik'] . "|" . $_SESSION['nama_lengkap'];
        $query = mysqli_query($connect, $sql);
        $data = mysqli_fetch_all($query, MYSQLI_ASSOC);

        foreach ($data as $value) {
            ?>
        <tr align="center">
            <td>
                <?= $no++; ?>
            </td>
        <?php if($_SESSION['role'] == 'admin'):?>    
            <td>
                <?= $value['username']; ?>
            </td>
        <?php endif ?>    
            <td>
                <?= $value['tgl_catatan']; ?>
            </td>
            <td>
                <?= $value['jam']; ?>
            </td>
            <td>
                <?= $value['lokasi']; ?>
            </td>
            <td>
                <?= $value['suhu_tubuh']; ?>
            </td>
        </tr>
        <?php }
        ?>
    </table>
    <script>
    window.onafterprint = () => {
        location.history.back()
    }
    </script>
</body>

</html>