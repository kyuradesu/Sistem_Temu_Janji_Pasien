<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['nama'])) {
    // Jika pengguna sudah login, tampilkan tombol "Logout"
    header("Location: berandaDokter.php?page=profilDokter");
    exit;
}

if (isset($_GET['aksi'])) {
    if ($_GET['aksi'] == 'hapus') {
        $hapus = mysqli_query($mysqli, "DELETE FROM periksa WHERE id = '" . $_GET['id'] . "'");
    }

    echo "<script> 
        document.location='index.php?page=riwayatPasien';
    </script>";
}
?>
<br>
<div class="container" >
    <div class="fw-bold" style="font-size: 2rem;">Riwayat Pasien</div>
    <br>

    <!-- Tambahkan form untuk proses print -->
    
    <!-- <button class="btn btn-primary mb-3" name="print"><a target="_blank" class="text-white" href="cetak.php">Print</a></button> -->

    <table class="table table-bordered table-striped table-hover">
        <!--thead atau baris judul-->
        <thead>
            <tr  class="text-center">
                <th scope="col">No</th>
                <th scope="col">Tanggal Periksa</th>
                <th scope="col">Nama Pasien</th>
                <th scope="col">Nomor Antrian</th>
                <th scope="col">Keluhan</th>
                <th scope="col">Catatan</th>
                <th scope="col">Biaya Periksa</th>
                <th scope="col">Nama Obat</th>
                <!-- <th scope="col">Aksi</th> -->
            </tr>
        </thead>
        <!--tbody berisi isi tabel sesuai dengan judul atau head-->
        <tbody>
            <!-- Kode PHP untuk menampilkan semua isi dari tabel urut-->
            <?php
                // Mendapatkan ID dokter dari sesi
                $id_dokter = $_SESSION['id'];
                // Menampilkan data riwayat pasien berdasarkan dokter
                $result = mysqli_query($mysqli, "SELECT daftar_poli.*, pasien.nama AS nama, jadwal_periksa.hari, periksa.tgl_periksa, periksa.catatan, periksa.biaya_periksa, obat.nama_obat AS nama_obat
                FROM daftar_poli
                JOIN jadwal_periksa ON daftar_poli.id_jadwal = jadwal_periksa.id 
                JOIN pasien ON daftar_poli.id_pasien = pasien.id
                LEFT JOIN periksa ON daftar_poli.id = periksa.id_daftar_poli
                LEFT JOIN detail_periksa ON periksa.id = detail_periksa.id_periksa
                LEFT JOIN obat ON detail_periksa.id_obat = obat.id
                WHERE jadwal_periksa.id_dokter = '$id_dokter' AND periksa.id_daftar_poli IS NOT NULL");
                $no = 1;
                // Menampilkan data dalam bentuk tabel
                while ($data = mysqli_fetch_array($result)) {
            ?>
                <tr>
                    <th scope="row"><?php echo $no++ ?></th>
                    <td><?php echo $data['tgl_periksa'] ?></td>
                    <td><?php echo $data['nama'] ?></td>
                    <td  class="text-center"><?php echo $data['no_antrian'] ?></td>
                    <td ><?php echo $data['keluhan'] ?></td>
                    <td><?php echo $data['catatan'] ?></td>
                    <td  class="text-center"><?php echo $data['biaya_periksa'] ?></td>
                    <td><?php echo $data['nama_obat'] ?></td>
                    <!-- <td>
                        <a class="btn btn-success rounded-pill px-3" href="berandaDokter.php?page=periksa&id=<?php echo $data['id'] ?>">Ubah</a>
                    </td> -->
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>
<footer>
    <div class="copyright position-absolute bottom-0 end-0" style="width: 100%;">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
                <div class="copyright-content">
                    <p>© Copyright 2024  |  All Rights Reserved by <a href="index.php" target="_blank">poliklinik UDINUS.com</a> </p>
                </div>
            </div>
        </div>
    </div>
</footer>