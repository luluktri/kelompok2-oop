<?php
session_start();

if (!isset($_SESSION["username"])) {

    header("location:index.php");
}

include 'koneksi.php';

$db = new Database();

// untuk memperbarui nilai mahasiswa diuji
if(isset($_POST['submit'])) {
    $id = $_GET['id'];
    $nilai = $_POST['nilai'];
    $db->ubah_nilai_diuji($id, $nilai);
    header("location:nilai-uji.php");

}

// untuk mengambil data mahasiswa diuji dari database
$id = $_SESSION['id'];
$mahasiswa = $db->nilai_diuji($id);
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
                    <a href="profil-dosen.php">Ubah Profil</a>
                </li>
                <li>
                    <a>Data Mahasiswa</a>
                    <ul class="list-unstyled" id="homeSubmenu">
                        <li>
                            <a href="mhs-bimbingan.php">Mahasiswa Bimbingan</a>
                        </li>
                        <li>
                            <a href="mhs-uji.php">Mahasiswa Diuji</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a>Unggah Nilai</a>
                    <ul class="list-unstyled" id="homeSubmenu">
                        <li>
                            <a href="nilai-bimbingan.php">Mahasiswa Bimbingan</a>
                        </li>
                        <li class="active">
                            <a href="nilai-uji.php">Mahasiswa Diuji</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="content">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <h5>Mahasiswa Diuji</h5>
                    <a href="logout.php" class="btn btn-dark">Keluar</a>
            </nav>
            <div class="container-fluid">
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">NIM</th>
                            <th scope="col">NAMA</th>
                            <th scope="col">KELAS</th>
                            <th scope="col">LAPORAN</th>
                            <th scope="col">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- perulangan untuk menampilakan data mahasiswa diuji -->
                        <?php foreach ($mahasiswa as $mhs) { ?>
                        <tr>
                            <th scope="row"><?php echo $mhs['nim']; ?></th>
                            <td><?php echo $mhs['nama']; ?></td>
                            <td><?php echo $mhs['kelas']; ?></td>
                            <td>
                                <a href="file/<?php echo $mhs['laporan_kp']; ?>" class="btn btn-outline-primary">
                                <?php echo $mhs['laporan_kp']; ?>
                                </a>
                            </td>
                            <!-- untuk tombol nilai -->
                            <td>
                                <button type="button" class="btn btn-success mr-2" data-toggle="modal" data-target="#uji<?php echo $mhs["id"] ?>">Nilai</button>
                                <div class="modal fade" id="uji<?php echo $mhs["id"] ?>" tabindex="-1" aria-labelledby="uji<?php echo $mhs["id"] ?>label" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Pendaftaran KP</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="nilai-uji.php?id=<?php echo $mhs['id']; ?>" method="post">
                                                    <div class="form-group">
                                                        <label for="nilai">Nilai</label>
                                                        <input type="text" class="form-control" id="nilai" name="nilai" value="<?php echo $mhs['nilai_penguji']; ?>" required>
                                                    </div>
                                                    <button type="submit" class="btn btn-success" name="submit">Kirim</button>
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