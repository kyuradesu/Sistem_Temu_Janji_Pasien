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
        // Jika terdapat parameter 'id' pada POST, maka ini adalah proses ubah data dokter
        $ubah = mysqli_query($mysqli, "UPDATE dokter SET 
            nama = '"  . $_POST['nama'] . "',
            alamat = '" . $_POST['alamat'] . "',
            no_hp = '" . $_POST['no_hp'] . "',
            id_poli = '" . $_POST['id_poli'] . "'
            WHERE
            id = '" . $_POST['id'] . "'");
    } else {
        // Jika data dokter baru, jalankan query INSERT
        $tambah = mysqli_query($mysqli, "INSERT INTO dokter (nama, alamat, no_hp, id_poli) 
            VALUES (
                '" . $_POST['nama'] . "',
                '" . $_POST['alamat'] . "',
                '" . $_POST['no_hp'] . "',
                '" . $_POST['id_poli'] . "'
            )");
    }
    // echo "<script> 
    //         document.location='index.php?page=dokter';
    //     </script>";

    echo "<script> 
            Swal.fire({
            title: 'Sukses!',
            text: 'Data Dokter Tersimpan!',
            icon: 'success'
            });
        </script>";
}

if (isset($_GET['aksi'])) {
    if ($_GET['aksi'] == 'hapus') {
        $hapus = mysqli_query($mysqli, "DELETE FROM dokter WHERE id = '" . $_GET['id'] . "'");
    }

    echo "<script> 
            document.location='index.php?page=dokter';
        </script>";
}
?>
<br>
<div class="container">
    <div class="d-flex justify-content-between">

        <div class="row">
            <div class="col-md-6">
                <div class="card" style="width: 30rem;">
                    <div class="card-header text-center fw-bold" style="font-size: 2rem;">Dokter</div>
                    <div class="card-body">
                        <form class="form row" method="POST" style="width: 30rem;" action="" name="myForm" onsubmit="return(validate());">
                        <!-- Kode php untuk menghubungkan form dengan database -->
                            <?php
                            // inisialisasi variabel untuk menyimpan data dokter yang akan diubah
                            $nama = '';
                            $alamat = '';
                            $no_hp = '';
                            $id_poli = '';
                            // Jika terdapat parameter 'id' pada URL, ambil data dokter tersebut dari database
                            if (isset($_GET['id'])) {
                                // Jika terdapat parameter 'id', menjalankan query SELECT untuk mengambil data dokter berdasarkan id
                                $ambil = mysqli_query($mysqli, "SELECT * FROM dokter 
                                    WHERE id='" . $_GET['id'] . "'");
                                // Menggunakan loop while untuk mengekstrak data dokter yang dihasilkan oleh query
                                while ($row = mysqli_fetch_array($ambil)) {
                                    // Menyimpan data dokter ke dalam variabel untuk digunakan dalam form input/edit
                                    $nama = $row['nama'];
                                    $alamat = $row['alamat'];
                                    $no_hp = $row['no_hp'];
                                    $id_poli = $row['id_poli'];
                                }
                            ?>
                                <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
                            <?php
                            }
                            ?>
                            <div class="row">
                                <label for="inputNama" class="form-label fw-bold">
                                    Nama
                                </label>
                                <div>
                                    <input type="text" class="form-control" name="nama" id="inputNama" placeholder="Nama" value="<?php echo $nama ?>" required htmlspecialchars>
                                </div>
                            </div>
                            <div class="row mt-1">
                                <label for="inputAlamat" class="form-label fw-bold">
                                    Alamat
                                </label>
                                <div>
                                    <input type="text" class="form-control" name="alamat" id="inputAlamat" placeholder="Alamat" value="<?php echo $alamat ?>" required htmlspecialchars>
                                </div>
                            </div>
                            <div class="row mt-1">
                                <label for="inputNohp" class="form-label fw-bold">
                                    No Hp
                                </label>
                                <div>
                                    <input type="text" class="form-control" name="no_hp" id="inputNohp" placeholder="No Hp" value="<?php echo $no_hp ?>"required htmlspecialchars>
                                </div>
                            </div>
                            <div class="row mt-1">
                                <label for="id_poli" class="form-label fw-bold">
                                    Poli Dokter
                                </label>
                                <div>
                                    <select class="form-select" aria-label="id_poli" name="id_poli" >
                                        <option selected>Pilih Poli...</option>
                                        <?php 
                                            // Menjalankan query SELECT untuk mendapatkan data poli dari database
                                            $result = mysqli_query($mysqli, "SELECT * FROM poli");
    
                                            // Menggunakan loop while untuk menampilkan opsi-opsi poli
                                            while ($data = mysqli_fetch_assoc($result)) {
                                                // Menentukan opsi mana yang harus dipilih
                                                $selected = ($data['id'] == $id_poli) ? 'selected' : '';
                                                echo "<option $selected value='" . $data['id'] . "'>". $data['nama_poli'] . "</option>";
                                            }
                                        ?>
                                    </select>
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
        
        <div class="overflow-y-auto" style="width: 60%; height: 580px;">

            <!-- Table-->
            <table class="table table-bordered table-striped table-hover">
                <!--thead atau baris judul-->
                <thead>
                    <tr class="text-center">
                        <th scope="col">#</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Alamat</th>
                        <th scope="col">No Hp</th>
                        <th scope="col">Id Poli</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <!--tbody berisi isi tabel sesuai dengan judul atau head-->
                <tbody>
                    <!-- Kode PHP untuk menampilkan semua isi dari tabel urut-->
                    <?php
                    // Mengambil data dokter dari database
                    $result = mysqli_query($mysqli, "SELECT * FROM dokter");
                    $no = 1;
                    // Looping untuk menampilkan data dokter dalam tabel
                    while ($data = mysqli_fetch_array($result)) {
                    ?>
                        <tr>
                            <th scope="row" class="text-center"><?php echo $no++ ?></th>
                            <td><?php echo $data['nama'] ?></td>
                            <td><?php echo $data['alamat'] ?></td>
                            <td><?php echo $data['no_hp'] ?></td>
                            <td class="text-center"><?php echo $data['id_poli'] ?></td>
                            <td  class="d-flex justify-content-center ">
                                <div class="d-flex gap-2 mb-3">
                                    <a type="button" class="btn btn-success rounded-pill px-3" href="index.php?page=dokter&id=<?php echo $data['id'] ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                        </svg>
                                            
                                    </a>
                                    <a type="button" class="btn btn-danger rounded-pill px-3" href="index.php?page=dokter&id=<?php echo $data['id'] ?>&aksi=hapus">
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