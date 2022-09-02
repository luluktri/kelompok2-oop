<?php
session_start();

if ($_SESSION["level"] != "dosen") {
    header("location:index.php");
}

include 'koneksi.php';

$db = new Database();

// memperbarui revisi dari dosen
if(isset($_POST['submit'])) {
    $id = $_GET['id'];
    $revisi = $_POST['revisi'];
    $db->revisi($id, $revisi);
    header("location:mhs-bimbingan.php");
}

// untuk mengambil data lembar kerja mahasiswa dalam database
$kelompok_id = $_GET['id'];
$lembar_kerja = $db->monitoring_bimbingan($kelompok_id);

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
                    <a href="dashboard-dosen.php">Dashboard</a>
                </li>
                <li>
                    <a>Data Mahasiswa</a>
                    <ul class="list-unstyled" id="homeSubmenu">
                        <li class="active">
                            <a href="mhs-bimbingan.php">Mahasiswa Bimbingan</a>
                        </li>
                        <li>
                            <a href="mhs-uji.php">Mahasiswa Diuji</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="content">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <h5>Monitoring Bimbingan</h5>
                    <a href="logout.php" class="btn btn-dark">Keluar</a>
            </nav>
            <div class="container-fluid">
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">NIM</th>
                            <th scope="col">NAMA</th>
                            <th scope="col">KELAS</th>
                            <th scope="col">KELOMPOK</th>
                            <th scope="col">FILE</th>
                            <th scope="col">TANGGAL</th>
                            <th scope="col">Revisi</th>
                            <th scope="col">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- perulangan untuk menampilkan data lembar kerja -->
                        <?php foreach ($lembar_kerja as $mhs) { ?>
                        <tr>
                            <th scope="row"><?php echo $mhs['nim']; ?></th>
                            <td><?php echo $mhs['nama']; ?></td>
                            <td><?php echo $mhs['kelas']; ?></td>
                            <td><?php echo $mhs['nama_anggota']; ?></td>
                            <td><a href="file/<?php echo $mhs['file']; ?>" class="btn btn-outline-primary"><?php echo $mhs['file']; ?></a></td>
                            <td><?php echo $mhs['tanggal']; ?></td>
                            <td><?php echo $mhs['revisi']; ?></td>
                            <!-- menampilkan tombol untuk revisi -->
                            <td>
                                <button type="button" class="btn btn-primary mr-2" data-toggle="modal" data-target="#lembar<?php echo $mhs["id"] ?>">Revisi</button>
                                <div class="modal fade" id="lembar<?php echo $mhs["id"] ?>" tabindex="-1" aria-labelledby="mhs<?php echo $mhs["id"] ?>label" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Pendaftaran KP</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                            <div class="modal-body">
                                            <form action="monitoring-mhs.php?id=<?php echo $mhs['id']; ?>" method="post">
                                                <div class="form-group">
                                                    <label>Revisi</label>
                                                    <input type="text" class="form-control" name="revisi" value="<?php echo $mhs['revisi']; ?>" required>
                                                </div>
                                                <button type="submit" class="btn btn-primary" name="submit">Kirim</button>
                                            </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="assets/js/jquery.slim.min.js"></script>
    <script src="assets/js/bootstrap.js"></script>
</body>

</html>