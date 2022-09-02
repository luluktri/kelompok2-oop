<?php

	// membuat kelas database
	class Database {
		var $host = "localhost";
		var $uname = "root";
		var $pass = "";
		var $db = "db_web";

		function __construct()
		{
			$this->koneksi = mysqli_connect($this->host, $this->uname, $this->pass, $this->db);

			if(mysqli_connect_errno())
			{
				echo "Koneksi database gagal! : " .mysqli_connect_error();
			}
		}

		public function login($username, $password)
		{
			$login = mysqli_query($this->koneksi, "SELECT * FROM user INNER JOIN user_role on user.id_role=user_role.id_user WHERE username='$username' AND password='$password'");
			return $login;
		}

		public function data_dosen($id)
		{
			$data = mysqli_query($this->koneksi, "SELECT * FROM dosen WHERE user_id='$id'");
			$dosen = mysqli_fetch_array($data);
			return $dosen;
		}

		public function list_dosen()
		{
			$data = mysqli_query($this->koneksi, "SELECT * FROM dosen");
			return $data;
		}

		public function ubah_profil($nama_dosen, $nik, $foto)
		{
			if ($foto) {
				mysqli_query($this->koneksi, "UPDATE dosen SET nama_dosen='$nama_dosen', nik='$nik', foto='$foto' WHERE nik='$nik'");
			} else {
				mysqli_query($this->koneksi, "UPDATE dosen SET nama_dosen='$nama_dosen', nik='$nik' WHERE nik='$nik'");
			}
		}

		public function mahasiswa_bimbingan($id)
		{
			$data = mysqli_query($this->koneksi, "SELECT * FROM mahasiswa JOIN anggota_kelompok ON mahasiswa.anggota_kelompok_id=anggota_kelompok.id JOIN pendaftaran_kp on anggota_kelompok.id=pendaftaran_kp.anggota_kelompok_id WHERE dosen_id='$id' AND nama_anggota IS NOT NULL");
			return $data;
		}

		public function monitoring_bimbingan($id)
		{
			$data = mysqli_query($this->koneksi, "SELECT * FROM anggota_kelompok JOIN mahasiswa ON anggota_kelompok.id=mahasiswa.anggota_kelompok_id JOIN lembar_kerja ON anggota_kelompok.id=lembar_kerja.anggota_kelompok_id WHERE anggota_kelompok.id='$id'");
			$lembar_kerja = mysqli_fetch_array($data);
			return $data;
		}

		public function revisi($id, $revisi)
		{
			mysqli_query($this->koneksi, "UPDATE lembar_kerja SET revisi='$revisi' WHERE id='$id'");
		}

		public function mahasiswa_diuji($id)
		{
			$data = mysqli_query($this->koneksi, "SELECT mahasiswa.nim,nama,kelas,laporan_kp FROM mahasiswa join anggota_kelompok on mahasiswa.anggota_kelompok_id=anggota_kelompok.id join pendaftaran_kp on anggota_kelompok.id=pendaftaran_kp.anggota_kelompok_id join pendaftaran_ujian_kp on pendaftaran_kp.id=pendaftaran_ujian_kp.pendaftaran_kp_id join acc_ujian on acc_ujian.id=pendaftaran_ujian_kp.acc_ujian_id WHERE dosen_penguji='$id'");
			return $data;
		}

		public function nilai_bimbingan($id)
		{
			$data = mysqli_query($this->koneksi, "SELECT mahasiswa.nim,nama,kelas,laporan_kp,mahasiswa.anggota_kelompok_id,nilai.id,nilai.nilai_pembimbing_kp FROM mahasiswa JOIN anggota_kelompok ON mahasiswa.anggota_kelompok_id=anggota_kelompok.id JOIN pendaftaran_kp on anggota_kelompok.id=pendaftaran_kp.anggota_kelompok_id JOIN pendaftaran_ujian_kp on pendaftaran_kp.id=pendaftaran_ujian_kp.pendaftaran_kp_id JOIN nilai on pendaftaran_ujian_kp.id=nilai.pendaftaran_ujian_kp_id WHERE dosen_id='$id' AND nama_anggota IS NOT NULL");
			return $data;
		}

		public function ubah_nilai_bimbingan($id, $nilai)
		{
			$data = mysqli_query($this->koneksi, "UPDATE nilai SET nilai_pembimbing_kp='$nilai' WHERE id='$id' ");
			return $data;
		}

		public function nilai_diuji($id)
		{
			$data = mysqli_query($this->koneksi, "SELECT mahasiswa.nim,nama,kelas,laporan_kp,mahasiswa.anggota_kelompok_id,nilai.id,nilai.nilai_penguji FROM mahasiswa JOIN anggota_kelompok ON mahasiswa.anggota_kelompok_id=anggota_kelompok.id JOIN pendaftaran_kp on anggota_kelompok.id=pendaftaran_kp.anggota_kelompok_id JOIN pendaftaran_ujian_kp on pendaftaran_kp.id=pendaftaran_ujian_kp.pendaftaran_kp_id JOIN nilai on pendaftaran_ujian_kp.id=nilai.pendaftaran_ujian_kp_id join acc_ujian on acc_ujian.id=pendaftaran_ujian_kp.acc_ujian_id WHERE dosen_penguji='$id' AND nama_anggota IS NOT NULL");
			return $data;
		}

		public function ubah_nilai_diuji($id, $nilai)
		{
			$data = mysqli_query($this->koneksi, "UPDATE nilai SET nilai_penguji='$nilai' WHERE id='$id'");
			return $data;
		}

		public function pendaftar_kp()
		{
			$data = mysqli_query($this->koneksi, "SELECT * FROM mahasiswa JOIN anggota_kelompok ON mahasiswa.anggota_kelompok_id=anggota_kelompok.id JOIN pendaftaran_kp ON mahasiswa.anggota_kelompok_id=pendaftaran_kp.anggota_kelompok_id JOIN dosen ON pendaftaran_kp.dosen_id=dosen.id ORDER BY pendaftaran_kp.id DESC");
			return $data;
		}

		public function ubah_pendaftar_kp($nim, $nama_anggota)
		{
			$data = mysqli_query($this->koneksi, "UPDATE anggota_kelompok SET nama_anggota='$nama_anggota' WHERE nim='$nim'");
			return $data;
		}

		public function pendaftar_ujian()
		{
			$data = mysqli_query($this->koneksi, "SELECT pendaftaran_ujian_kp.id,jadwal_ujian,mahasiswa.nim,nama,kelas,nama_anggota,laporan_kp,nama_dosen,acc_ujian_id FROM mahasiswa JOIN anggota_kelompok ON mahasiswa.anggota_kelompok_id=anggota_kelompok.id JOIN pendaftaran_kp ON mahasiswa.anggota_kelompok_id=pendaftaran_kp.anggota_kelompok_id JOIN dosen ON pendaftaran_kp.dosen_id=dosen.id JOIN pendaftaran_ujian_kp ON pendaftaran_kp.id=pendaftaran_ujian_kp.pendaftaran_kp_id ORDER BY pendaftaran_kp.id DESC");
			return $data;
		}

		public function acc_pendaftar_ujian($id, $dosen, $tanggal)
		{
			mysqli_query($this->koneksi, "INSERT INTO acc_ujian(dosen_penguji,jadwal_ujian) VALUES('$dosen','$tanggal')");
			$id_acc = mysqli_insert_id($this->koneksi);
			mysqli_query($this->koneksi, "UPDATE pendaftaran_ujian_kp SET jadwal_ujian='$tanggal',acc_ujian_id='$id_acc' WHERE id='$id'");
			mysqli_query($this->koneksi, "INSERT INTO nilai(pendaftaran_ujian_kp_id) VALUES('$id')");
		}

		public function tolak_pendaftar_ujian($id)
		{
			mysqli_query($this->koneksi, "DELETE FROM pendaftaran_ujian_kp WHERE id='$id'");
		}

		public function dosen_penguji($id)
		{
			$data = mysqli_query($this->koneksi, "SELECT * FROM acc_ujian JOIN dosen ON acc_ujian.dosen_penguji=dosen.id WHERE acc_ujian.id='$id'");
			$penguji = mysqli_fetch_array($data);
			return $penguji;
		
		}

		public function data_mahasiswa($id)
		{
			$data = mysqli_query($this->koneksi, "SELECT * FROM mahasiswa JOIN anggota_kelompok ON mahasiswa.anggota_kelompok_id=anggota_kelompok.id WHERE user_id='$id'");
			$mahasiswa = mysqli_fetch_array($data);
			return $mahasiswa;
		}

		public function lembar_kerja($id)
		{
			$data = mysqli_query($this->koneksi, "SELECT * FROM anggota_kelompok JOIN mahasiswa ON anggota_kelompok.id=mahasiswa.anggota_kelompok_id JOIN lembar_kerja ON anggota_kelompok.id=lembar_kerja.anggota_kelompok_id WHERE user_id='$id'");
			return $data;
		}

		public function ambil_lembar_kerja($id)
		{
			$data = mysqli_query($this->koneksi, "SELECT * FROM lembar_kerja JOIN mahasiswa ON lembar_kerja.anggota_kelompok_id=mahasiswa.anggota_kelompok_id JOIN anggota_kelompok ON lembar_kerja.anggota_kelompok_id=anggota_kelompok.id WHERE lembar_kerja.id='$id'");
			$lembar_kerja = mysqli_fetch_array($data);
			return $lembar_kerja;
		}

		public function tambah_lembar_kerja($tanggal, $file, $id)
		{
			mysqli_query($this->koneksi, "INSERT INTO lembar_kerja(tanggal,file,anggota_kelompok_id) VALUES('$tanggal','$file','$id')");
		}

		public function edit_lembar_kerja($id, $tanggal, $file)
		{
			if ($file) {
				mysqli_query($this->koneksi, "UPDATE lembar_kerja SET tanggal='$tanggal', file='$file' WHERE id='$id'");
			} else {
				mysqli_query($this->koneksi, "UPDATE lembar_kerja SET tanggal='$tanggal' WHERE id='$id'");
			}
		}

		public function ubah_anggota_kelompok($nim)
		{
			$data = mysqli_query($this->koneksi, "INSERT INTO anggota_kelompok(nim) VALUES('$nim')");
    		$id_anggota = mysqli_insert_id($this->koneksi);
    		mysqli_query($this->koneksi, "UPDATE mahasiswa SET anggota_kelompok_id='$id_anggota' WHERE nim='$nim'");
		}

		public function pendaftaran_kp($instansi, $alamat, $mulai, $selesai, $file, $id_anggota, $dosbim)
		{
			if ($file) {
				mysqli_query($this->koneksi, "INSERT INTO pendaftaran_kp(tempat_kp,alamat_kp,tanggal_mulai,tanggal_selesai,proposal,anggota_kelompok_id,dosen_id) VALUES('$instansi','$alamat','$mulai','$selesai','$file','$id_anggota','$dosbim')");
			} else {
				mysqli_query($this->koneksi, "INSERT INTO pendaftaran_kp(tempat_kp,alamat_kp,tanggal_mulai,tanggal_selesai,anggota_kelompok_id,dosen_id) VALUES('$instansi','$alamat','$mulai','$selesai','$id_anggota','$dosbim')");				
			}
		}

		public function mahasiswa_kp($id)
		{
			$data = mysqli_query($this->koneksi, "SELECT mahasiswa.nim, nama, pendaftaran_kp.id, nama_anggota FROM mahasiswa JOIN anggota_kelompok ON mahasiswa.anggota_kelompok_id=anggota_kelompok.id JOIN pendaftaran_kp ON mahasiswa.anggota_kelompok_id=pendaftaran_kp.anggota_kelompok_id WHERE user_id='$id'");
			$datakp = mysqli_fetch_array($data);
			return $datakp;
		}

		public function mahasiswa_ujian($id)
		{
			$data = mysqli_query($this->koneksi, "SELECT * from pendaftaran_ujian_kp where pendaftaran_kp_id='$id'");
			$ujiankp = mysqli_fetch_array($data);
			return $ujiankp;
		}

	}
	
?>