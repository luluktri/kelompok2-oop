<?php 
session_start();

if($_SESSION["level"] != "mahasiswa"){
    header("location:index.php");
}

include 'koneksi.php';

$db = new Database();

if(isset($_POST['submit'])) {
    $id = $_GET['id'];
    $tanggal = $_POST['tanggal'];
    $file = $_FILES['file']['name'];
    $file_tmp = $_FILES['file']['tmp_name'];
    move_uploaded_file($file_tmp, 'file/'.$file);
    $db->tambah_lembar_kerja($tanggal, $file, $id);
    header("location:lembar-kerja.php");

}

$id = $_SESSION['id'];

$lembar = $db->lembar_kerja($id);
$lembar_kerja = mysqli_fetch_array($lembar);

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
                <li class="active">
                    <a href="lembar-kerja.php">Lembar Kerja KP</a>
                </li>
                <li>
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
                    <h5>Tambah Lembar Kerja</h5>
                    <a href="logout.php" class="btn btn-dark">Keluar</a>
                </div>
            </nav>
            <div class="container">
                <form action="lembar-kerja-tambah.php?id=<?php echo $lembar_kerja['anggota_kelompok_id']; ?>" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="nim">NIM</label>
                        <input type="text" class="form-control" id="nim" name="nim" value="<?php echo $lembar_kerja['nim']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Tanggal</label>
                        <input type="date" class="form-control" name="tanggal" value="<?php echo date('Y-m-d');?>">
                    </div>
                    <div class="form-group">
                        <label for="proposal">File</label>
                        <input type="file" class="form-control-file" id="proposal" name="file" required>
                    </div>
                    <button type="submit" class="btn btn-primary" name="submit">Tambah</button>
                </form>
            </div>
        </div>
    </body>

</html>