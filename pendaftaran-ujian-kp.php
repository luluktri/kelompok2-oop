<?php
session_start();

include 'koneksi.php';

if ($_SESSION["level"] != "mahasiswa") {
    header("location:index.php");
}

$db = new Database();

if(isset($_POST['submit'])) {
    $id_daftarkp = $_GET['id'];
    $file = $_FILES['file']['name'];
    $file_tmp = $_FILES['file']['tmp_name'];
    move_uploaded_file($file_tmp, 'file/'.$file);

    mysqli_query($conn, "INSERT INTO pendaftaran_ujian_kp(laporan_kp,pendaftaran_kp_id) VALUES('$file','$id_daftarkp')");

}

$id = $_SESSION['id'];
$datakp = $db->mahasiswa_kp($id);
$id_kp = $datakp['id'];
$ujian_kp = $db->mahasiswa_ujian($id_kp)

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sistem Informasi</title>
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <div class="wrapper">
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3>Sistem Informasi</h3>
            </div>
            <ul class="list-unstyled components">
                <li>
                    <a href="dashboard-mhs.php">Dashboard</a>
                </li>
                <li>
                    <a href="pendaftaran-kp.php">Pendaftaran KP</a>
                </li>
                <li>
                    <a href="dashboard-mhs.php">Surat Izin KP</a>
                </li>
                <li>
                    <a href="lembar-kerja.php">Lembar Kerja KP</a>
                </li>
                <li class="active">
                    <a href="pendaftaran-ujian-kp.php">Pendaftaran Ujian KP</a>
                </li>
                <li>
                    <a href="dashboard-mhs.php">Jadwal Ujian KP</a>
                </li>
            </ul>
        </nav>
        <div id="content">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <h5>Pendaftaran Ujian KP</h5>
                    <a href="logout.php" class="btn btn-dark">Keluar</a>
                </div>
            </nav>  
            <div class="container">
                <?php if (!$ujian_kp) {?>
                <form action="pendaftaran-ujian-kp.php?id=<?php echo $datakp['id']; ?>" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="nim">NIM</label>
                        <input type="text" class="form-control" id="nim" name="nim" value="<?php echo $datakp['nim']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $datakp['nama']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="proposal">Laporan KP</label>
                        <input type="file" class="form-control-file" id="proposal" name="file" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary" name="submit">Daftar</button>
                </form>
                <?php } else { ?>
                    <h5 class="mb-4">Anda sudah mendaftar.</h5>
                <?php } ?>
            </div>
        </div>
</body>

</html>