<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['username'])) {
    // Jika pengguna sudah login, tampilkan tombol "Logout"
    header("Location: index.php?page=loginUser");
    exit;
}

if (isset($_POST['simpan'])) {
    if (isset($_POST['id'])) {
        // Jika terdapat parameter 'id' pada POST, maka ini adalah proses ubah data poli
        $ubah = mysqli_query($mysqli, "UPDATE poli SET 
            -- nama_poli = '" . $_POST['nama_poli'] . "',
            id_poli = '" . $_POST['id_poli'] . "'
            keterangan = '" . $_POST['keterangan'] . "'
            WHERE
            id = '" . $_POST['id'] . "'");
    } else {
         // Jika data pasien baru, jalankan query INSERT
        $tambah = mysqli_query($mysqli, "INSERT INTO poli (nama_poli, keterangan) 
            VALUES (
                '" . $_POST['nama_poli'] . "',
                '" . $_POST['keterangan'] . "'
            )");
    }
    echo "<script> 
            Swal.fire({
            title: 'Sukses!',
            text: 'Data Poli Tersimpan!',
            icon: 'success'
            });
        </script>";
}
if (isset($_GET['aksi'])) {
    if ($_GET['aksi'] == 'hapus') {
        $hapus = mysqli_query($mysqli, "DELETE FROM poli WHERE id = '" . $_GET['id'] . "'");
    }

    echo "<script> 
            document.location='index.php?page=poli';
        </script>";
}
?>

<br>
<div class="container">
    <div class="d-flex justify-content-between">

        <div class="row">
            <div class="col-md-6">
                <div class="card" style="width: 25rem;">
                    <div class="card-header text-center fw-bold" style="font-size: 2rem;">Poli</div>
                    <div class="card-body">
                        <form class="form row" method="POST" style="width: 25rem;" action="" name="myForm" onsubmit="return(validate());">
                            <!-- Kode php untuk menghubungkan form dengan database -->
                            <?php
                            // inisialisasi variabel untuk menyimpan data poli yang akan diubah
                            $nama_poli = '';
                            $keterangan = '';
                            if (isset($_GET['id'])) {
                                // Jika terdapat parameter 'id' pada URL, ambil data poli tersebut dari database
                                $ambil = mysqli_query($mysqli, "SELECT * FROM poli 
                                    WHERE id='" . $_GET['id'] . "'");
                                // Menggunakan loop while untuk mengekstrak data poli yang dihasilkan oleh query
                                while ($row = mysqli_fetch_array($ambil)) {
                                // Menyimpan data poli ke dalam variabel
                                    $nama_poli = $row['nama_poli'];
                                    $keterangan = $row['keterangan'];
                                }
                            ?>
                                <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
                            <?php
                            }
                            ?>
                            <div class="row">
                                <label for="nama_poli" class="form-label fw-bold">
                                    Nama Poli
                                </label>
                                <div>
                                    <select class="form-select" aria-label="nama_poli" name="nama_poli" >
                                        <option selected>Pilih Poli...</option>
                                        <?php 
                                            // Menjalankan query SELECT untuk mendapatkan data poli dari database
                                            $result = mysqli_query($mysqli, "SELECT * FROM poli");
    
                                            // Menggunakan loop while untuk menampilkan opsi-opsi poli
                                            while ($data = mysqli_fetch_assoc($result)) {
                                                // Menentukan opsi mana yang harus dipilih
                                                $selected = ($data['nama_poli'] == $nama_poli) ? 'selected' : '';
                                                echo "<option $selected value='" . $data['nama_poli'] . "'>". $data['nama_poli'] . "</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <!-- <div class="row">
                                <label for="inputNama" class="form-label fw-bold">
                                    Nama Poli
                                </label>
                                <div>
                                    <input type="text" class="form-control" name="nama_poli" id="inputNama" placeholder="Nama poli" value="<?php echo $nama_poli ?>"required htmlspecialchars>
                                </div>
                            </div> -->
                            <div class="row mt-1">
                                <label for="inputketerangan" class="form-label fw-bold">
                                    keterangan
                                </label>
                                <div>
                                    <input type="text" class="form-control" name="keterangan" id="inputketerangan" placeholder="keterangan" value="<?php echo $keterangan ?>" required htmlspecialchars>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class=col>
                                    <button type="submit" class="btn btn-primary rounded-pill px-3 mt-auto" name="simpan">Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="overflow-y-auto" style="width: 65%; height: 580px;">

            <!-- Table-->
            <table class="table table-bordered table-striped table-hover">
                <!--thead atau baris judul-->
                <thead>
                    <tr class="text-center">
                        <th scope="col">No</th>
                        <th scope="col">Nama</th>
                        <th scope="col">keterangan</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <!--tbody berisi isi tabel sesuai dengan judul atau head-->
                <tbody>
                    <!-- Kode PHP untuk menampilkan semua isi dari tabel urut-->
                    <?php
                    // Mengambil data poli dari database
                    $result = mysqli_query($mysqli, "SELECT * FROM poli");
                    $no = 1;
                    // Looping untuk menampilkan data poli dalam tabel
                    while ($data = mysqli_fetch_array($result)) {
                    ?>
                        <tr>
                            <th scope="row" class="text-center"><?php echo $no++ ?></th>
                            <td><?php echo $data['nama_poli'] ?></td>
                            <td><?php echo $data['keterangan'] ?></td>
                            <td class="d-flex justify-content-center ">
                                <div class="d-flex gap-2 mb-3">
                                    <a type="button" class="btn btn-success rounded-pill px-3" href="index.php?page=poli&id=<?php echo $data['id'] ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                        </svg>
                                            
                                    </a>
                                    <a type="button" class="btn btn-danger rounded-pill px-3" href="index.php?page=poli&id=<?php echo $data['id'] ?>&aksi=hapus">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                            <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"/>
                                        </svg>
                                            
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
            <!--Form Input Data-->
        </div>
    </div>
</div>
<br>
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