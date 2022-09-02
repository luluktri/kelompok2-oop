<?php
session_start();

include 'koneksi.php';

if ($_SESSION["level"] != "mahasiswa") {
    header("location:index.php");
}

$db = new Database();

if(isset($_POST['submit'])) {
    $nim = $_POST['nim'];
    $instansi = $_POST['instansi'];
    $alamat = $_POST['alamat'];
    $mulai = $_POST['mulai'];
    $selesai = $_POST['selesai'];
    $dosbim = $_POST['dosen'];
    $file = $_FILES['proposal']['name'];
    
    $db->ubah_anggota_kelompok($nim);

    if($file) {
        $file_tmp = $_FILES['proposal']['tmp_name'];
        move_uploaded_file($file_tmp, 'file/'.$file);
    }

    $db->pendaftaran_kp($instansi, $alamat, $mulai, $selesai, $file, $id_anggota, $dosbim);

}

$id = $_SESSION['id'];
$mahasiswa = $db->data_mahasiswa($id);
$dosen = $db->list_dosen();

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
                <li class="active">
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
                    <h5>Pendaftaran KP</h5>
                    <a href="logout.php" class="btn btn-dark">Keluar</a>
                </div>
            </nav>  
            <div class="container">
                <?php if (!$mahasiswa) {?>
                <form action="pendaftaran-kp.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="nim">NIM</label>
                        <input type="text" class="form-control" id="nim" name="nim" value="<?php echo $mahasiswa['nim']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="instansi">Nama Instansi</label>
                        <input type="text" class="form-control" id="instansi" name="instansi" required>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat Instansi</label>
                        <input type="text" class="form-control" id="alamat" name="alamat" required>
                    </div>
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col">
                                <label for="alamat">Tanggal Mulai</label>
                                <input type="date" class="form-control" name="mulai">
                            </div>
                            <div class="col">
                                <label for="alamat">Tanggal Selesai</label> 
                                <input type="date" class="form-control" name="selesai">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="dosen">Dosen Pembimbing</label>
                        <select class="form-control" id="dosen" name="dosen" required>
                            <option disabled selected value> -- Pilih Dosen Pembimbing -- </option>
                            <?php foreach ($dosen as $dsn) { ?>
                            <option value="<?php echo $dsn['id']; ?>"><?php echo $dsn['nama_dosen']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="proposal">File Proposal</label>
                        <input type="file" class="form-control-file" id="proposal" name="proposal">
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