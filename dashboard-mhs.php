<?php 
session_start();

if($_SESSION["level"] != "mahasiswa"){
    header("location:index.php");
}

include 'koneksi.php';

$db = new Database();

$id = $_SESSION['id'];
$mahasiswa = $db->data_mahasiswa($id);

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
                <li class="active">
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
                    <h5>Dashboard</h5>
                    <a href="logout.php" class="btn btn-dark">Keluar</a>
                </div>
            </nav>
            <div class="container">
                <h3 class="text-center">Selamat Datang di SIM Politeknik Negeri Banyuwangi</h3>
                <div class="form-group mt-4 mb-4">
                    <div class="form-row">
                        <div class="col-lg-9">
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-md-4">NIM</div>
                                    <div class="col-md-8">: <?php echo $mahasiswa['nim']; ?></div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-4">Nama</div>
                                    <div class="col-md-8">: <?php echo $mahasiswa['nama']; ?></div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-4">Kelas</div>
                                    <div class="col-md-8">: <?php echo $mahasiswa['kelas']; ?></div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-4">Anggota Kelompok</div>
                                    <div class="col-md-8">
                                    <?php if (!is_null($mahasiswa) && !is_null($mahasiswa["nama_anggota"])) { ?>
                                        : <?php echo $mahasiswa['nama_anggota']; ?>
                                    <?php } else { echo ": -"; }?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>

</html>