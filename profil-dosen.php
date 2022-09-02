<?php 
session_start();

if($_SESSION["level"] != "dosen"){
    header("location:index.php");
}

include 'koneksi.php';

$db = new Database();

if(isset($_POST['submit'])) {
    $nik = $_POST['nik'];
    $nama_dosen = $_POST['dosen'];
    $foto = $_FILES['foto']['name'];

    if($foto) {
        $file_tmp = $_FILES['foto']['tmp_name'];
        move_uploaded_file($file_tmp, 'assets/img/'.$foto);
    }

    $db->ubah_profil($nama_dosen, $nik, $foto);
    header("location:dashboard-dosen.php");
}

$id = $_SESSION['id'];
$dosen = $db->data_dosen($id);

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
                <li class="active"><a href="dashboard-dosen.php">Dashboard</a></li>
                <li><a href="profil-dosen.php">Ubah Profil</a></li>
                <li>
                    <a>Data Mahasiswa</a>
                    <ul class="list-unstyled" id="homeSubmenu">
                        <li><a href="mhs-bimbingan.php">Mahasiswa Bimbingan</a></li>
                        <li><a href="mhs-uji.php">Mahasiswa Diuji</a></li>
                    </ul>
                </li>
                <li>
                    <a>Unggah Nilai</a>
                    <ul class="list-unstyled" id="homeSubmenu">
                        <li><a href="nilai-bimbingan.php">Mahasiswa Bimbingan</a></li>
                        <li><a href="nilai-uji.php">Mahasiswa Diuji</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="content">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <h5>Profil Dosen</h5>
                    <a href="logout.php" class="btn btn-dark">Keluar</a>
                </div>
            </nav>
            <div class="container-fluid">
                <form action="profil-dosen.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="nik">NIK</label>
                        <input type="text" class="form-control" id="nik" name="nik" value="<?php echo $dosen['nik']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="dosen">Nama Dosen</label>
                        <input type="text" class="form-control" id="dosen" name="dosen" value="<?php echo $dosen['nama_dosen']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="foto">Foto</label>
                        <input type="file" class="form-control-file" id="foto" name="foto">
                    </div>
                    <button type="submit" class="btn btn-primary" name="submit">Kirim</button>
                </form>
            </div>
        </div>
    </body>
</html>