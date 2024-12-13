<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['username'])) {
    // Jika pengguna sudah login, tampilkan tombol "Logout"
    header("Location: berandaDokter.php?page=profilDokter");
    exit;
}

// Ambil ID dokter dari parameter URL
if (isset($_GET['id'])) {
    $id_dokter = $_GET['id'];

    // Query untuk mengambil data dokter berdasarkan ID
    $result = mysqli_query($mysqli, "SELECT * FROM dokter WHERE id = '$id_dokter'");
    
    if ($result) {
        // Jika data dokter ditemukan
        $data_dokter = mysqli_fetch_assoc($result);
        $nama = $data_dokter['nama'];
        $alamat = $data_dokter['alamat'];
        $no_hp = $data_dokter['no_hp'];
        $id_poli = $data_dokter['id_poli'];
    } else {
        // Jika terjadi kesalahan dalam query
        echo "Error: " . mysqli_error($mysqli);
        exit;
    }
} else {
    // Jika tidak ada parameter ID dokter
    echo "ID Dokter tidak ditemukan.";
    exit;
}
?>

<!-- Tampilkan informasi dokter dalam bentuk tabel atau sesuai desain yang diinginkan -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center fw-bold" style="font-size: 2rem;">Profil Dokter</div>
                <div class="card-body">
                    <form class="form row" style="width: 30rem;">
                        <div class="row">
                            <label for="inputNama" class="form-label fw-bold">
                                Nama
                            </label>
                            <div>
                                <input type="text" class="form-control" name="nama" id="inputNama" value="<?php echo $nama; ?>" readonly>
                            </div>
                        </div>
                        <div class="row mt-1">
                            <label for="inputAlamat" class="form-label fw-bold">
                                Alamat
                            </label>
                            <div>
                                <input type="text" class="form-control" name="alamat" id="inputAlamat" value="<?php echo $alamat; ?>" readonly>
                            </div>
                        </div>
                        <div class="row mt-1">
                            <label for="inputNohp" class="form-label fw-bold">
                                No Hp
                            </label>
                            <div>
                                <input type="text" class="form-control" name="no_hp" id="inputNohp" value="<?php echo $no_hp; ?>" readonly>
                            </div>
                        </div>
                        <div class="row mt-1">
                            <label for="id_poli" class="form-label fw-bold">
                                Poli Dokter
                            </label>
                            <div>
                                <input type="text" class="form-control" name="id_poli" id="id_poli" value="<?php echo $id_poli; ?>" readonly>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
