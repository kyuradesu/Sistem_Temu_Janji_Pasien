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
        // Jika terdapat parameter 'id' pada POST, maka ini adalah proses ubah data obat
        $ubah = mysqli_query($mysqli, "UPDATE obat SET 
            nama_obat = '" . $_POST['nama_obat'] . "',
            kemasan = '" . $_POST['kemasan'] . "',
            harga = '" . $_POST['harga'] . "',
            stok = '" . $_POST['stok'] . "'
            WHERE
            id = '" . $_POST['id'] . "'");

    } else {
        // Jika data obat baru, jalankan query INSERT
        $tambah = mysqli_query($mysqli, "INSERT INTO obat (nama_obat, kemasan, harga, stok) 
            VALUES (
                '" . $_POST['nama_obat'] . "',
                '" . $_POST['kemasan'] . "',
                '" . $_POST['harga'] . "',
                '" . $_POST['stok'] . "'
            )");
    }
    echo "<script> 
            Swal.fire({
            title: 'Sukses!',
            text: 'Data Obat Tersimpan!',
            icon: 'success'
            });
        </script>";
    
    // echo "<script> 
    //     document.location='index.php?page=obat';
    //     </script>";
    
}
if (isset($_GET['aksi'])) {
    if ($_GET['aksi'] == 'hapus') {
        $hapus = mysqli_query($mysqli, "DELETE FROM obat WHERE id = '" . $_GET['id'] . "'");
        
        echo "<script> 
            Swal.fire({
            title: 'Are you sure?',
            text: 'You won't be able to revert this!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                title: 'Deleted!',
                text: 'Your file has been deleted.',
                icon: 'success'
                });
            }
            });
            </script>";
        }
        
    echo "<script>
            document.location='index.php?page=obat';
        </script>";
}
?>
<br>
<div class="container">
    <div class="d-flex justify-content-between">
        
        <!--Form Input Data-->
        <div class="row">
            <div class="col-md-6">
                <div class="card" style="width: 30rem;">
                    <div class="card-header text-center fw-bold" style="font-size: 2rem;">Obat</div>
                    <div class="card-body">
                        <form class="form row" style="width: 30rem;" method="POST" action="" name="myForm" onsubmit="return(validate());">
                            <!-- Kode php untuk menghubungkan form dengan database -->
                            <?php
                            // inisialisasi variabel untuk menyimpan data obat yang akan diubah
                            $nama_obat = '';
                            $kemasan = '';
                            $harga = '';
                            $stok = '';
                            // Jika terdapat parameter 'id' pada URL, ambil data obat tersebut dari database
                            if (isset($_GET['id'])) {
                                // Jika terdapat parameter 'id', menjalankan query SELECT untuk mengambil data obat berdasarkan id
                                $ambil = mysqli_query($mysqli, "SELECT * FROM obat 
                                    WHERE id='" . $_GET['id'] . "'");
                                // Menggunakan loop while untuk mengekstrak data obat yang dihasilkan oleh query
                                while ($row = mysqli_fetch_array($ambil)) {
                                    // Menyimpan data obat ke dalam variabel
                                    $nama_obat = $row['nama_obat'];
                                    $kemasan = $row['kemasan'];
                                    $harga = $row['harga'];
                                    $stok = $row['stok'];
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
                                    <input type="text" class="form-control" name="nama_obat" id="inputNama" placeholder="Nama" value="<?php echo $nama_obat ?>" required htmlspecialchars>
                                </div>
                            </div>
                            <div class="row mt-1">
                                <label for="inputKemasan" class="form-label fw-bold">
                                    Kemasan
                                </label>
                                <div>
                                    <input type="text" class="form-control" name="kemasan" id="inputKemasan" placeholder="Kemasan" value="<?php echo $kemasan ?>" required htmlspecialchars>
                                </div>
                            </div>
                            <div class="row mt-1">
                                <label for="inputHarga" class="form-label fw-bold">
                                    Harga (Rp)
                                </label>
                                <div>
                                    <input type="text" class="form-control" name="harga" id="inputHarga" placeholder="Harga (Rp)" value="<?php echo $harga ?>" required htmlspecialchars>
                                </div>
                            </div>
                            <div class="row mt-1">
                                <label for="inputStok" class="form-label fw-bold">
                                    Stok
                                </label>
                                <div>
                                    <input type="text" class="form-control" name="stok" id="inputStok" placeholder="Stok" value="<?php echo $stok ?>" required htmlspecialchars>
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
            <table class="table table-bordered table-striped table-hover">
                <!--thead atau baris judul-->
                <thead>
                    <tr class="text-center">
                        <th scope="col">No</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Kemasan</th>
                        <th scope="col">Harga</th>
                        <th scope="col">Stok</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <!--tbody berisi isi tabel sesuai dengan judul atau head-->
                <tbody>
                    <!-- Kode PHP untuk menampilkan semua isi dari tabel urut-->
                    <?php
                    // Mengambil data obat dari database
                    $result = mysqli_query($mysqli, "SELECT * FROM obat");
                    $no = 1;
                    // Looping untuk menampilkan data obat dalam tabel
                    while ($data = mysqli_fetch_array($result)) {
                    ?>
                        <tr>
                            <th scope="row" class="text-center"><?php echo $no++ ?></th>
                            <td><?php echo $data['nama_obat'] ?></td>
                            <td class="text-center"><?php echo $data['kemasan'] ?></td>
                            <td class="text-justify"><?php echo "Rp. ", number_format($data['harga'],0,',','.') ?></td>
                            <td class="text-center"><?php echo $data['stok'] ?></td>
                            <td class="d-flex justify-content-center ">
                                <div class="d-flex gap-2 mb-3">
                                    <a type="button" class="btn btn-success rounded-pill px-3" href="index.php?page=obat&id=<?php echo $data['id'] ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                        </svg>
                                            
                                    </a>
                                    <a type="button" class="btn btn-danger rounded-pill px-3" href="index.php?page=obat&id=<?php echo $data['id'] ?>&aksi=hapus">
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
            <!-- Table-->
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

<script src="sweetalert/sweetalert2.all.min.js"></script>
