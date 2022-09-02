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
    if($file) {
        $file_tmp = $_FILES['file']['tmp_name'];
        move_uploaded_file($file_tmp, 'file/'.$file);
    }
    $db->edit_lembar_kerja($id, $tanggal, $file);
    header("location:lembar-kerja.php");
}

$id = $_GET['id'];
$lembar_kerja = $db->ambil_lembar_kerja($id);

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
                    <h5>Edit Lembar Kerja</h5>
                    <a href="logout.php" class="btn btn-dark">Keluar</a>
                </div>
            </nav>
            <div class="container">
                <form action="lembar-kerja-edit.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Tanggal</label>
                        <input type="date" class="form-control" name="tanggal" value="<?php echo $lembar_kerja['tanggal'];?>">
                    </div>
                    <div class="form-group">
                        <label for="proposal">File</label>
                        <input type="file" class="form-control-file" id="proposal" name="file">
                    </div>
                    <button type="submit" class="btn btn-primary" name="submit">Tambah</button>
                </form>
            </div>
        </div>
    </body>

</html>