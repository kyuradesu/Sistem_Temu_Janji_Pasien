<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['nama'])) {
    // Jika pengguna sudah login, tampilkan tombol "Logout"
    header("Location: berandaDokter.php?page=jadwalDokter");
    exit;
}

if (isset($_POST['simpan'])) {
    // Cek apakah ada data 'id' dalam $_POST
    if (isset($_POST['id'])) {
        // Jika ada, jalankan query UPDATE untuk mengubah data jadwal periksa
        $ubah = mysqli_query($mysqli, "UPDATE jadwal_periksa SET 
            id_dokter = '".$_SESSION['id']."',
            hari = '" . $_POST['hari'] . "',
            jam_mulai = '" . $_POST['jam_mulai'] . "',
            jam_selesai = '" . $_POST['jam_selesai'] . "',
            status = '" . (isset($_POST['status']) ? $_POST['status'] : 0) . "'
            WHERE 
            id = '" . $_POST['id'] . "'");
    } else { 
        // Jika tidak ada, jalankan query INSERT untuk menambahkan data jadwal periksa baru
        $tambah = mysqli_query($mysqli, "INSERT INTO jadwal_periksa (id_dokter, hari, jam_mulai, jam_selesai, status) 
            VALUES (
                '".$_SESSION['id']."',
                '" . $_POST['hari'] . "',
                '" . $_POST['jam_mulai'] . "',
                '" . $_POST['jam_selesai'] . "',
                '" . (isset($_POST['status']) ? $_POST['status'] : 0) . "'
            )");
    }
    echo "<script> 
            document.location='berandaDokter.php?page=jadwalDokter';
        </script>";
}


?>
<br>

<div class="container">
    <div class="d-flex justify-content-between">
        <div class="row">
            <div class="col-md-6">
                <div class="card" style="width: 30rem;">
                    <div class="card-header text-center fw-bold" style="font-size: 2rem;">Jadwal Dokter</div>
                    <div class="card-body">
                        <form class="form row" method="POST" style="width: 30rem;" action="" name="myForm" onsubmit="return(validate());">
                            <!-- Kode php untuk menghubungkan form dengan database -->
                            <?php
                            // inisialisasi variabel
                            $id_dokter = '';
                            $hari = '';
                            $jam_mulai = '';
                            $jam_selesai = '';
                            $status = '0';

                            // Cek apakah terdapat parameter 'id' pada URL (query string)
                            if (isset($_GET['id'])) {
                                // Jika ada, jalankan query SELECT untuk mengambil data jadwal periksa berdasarkan id
                                $ambil = mysqli_query($mysqli, "SELECT * FROM jadwal_periksa 
                                        WHERE id='" . $_GET['id'] . "'");
                                
                                // Gunakan loop while untuk mengekstrak data jadwal periksa dari hasil query
                                while ($row = mysqli_fetch_array($ambil)) {
                                    // Menyimpan data jadwal periksa ke dalam variabel yang sesuai
                                    $id_dokter = $row['id_dokter'];
                                    $hari = $row['hari'];
                                    $jam_mulai = $row['jam_mulai'];
                                    $jam_selesai = $row['jam_selesai'];
                                    // $status = $row['status'];
                                }
                            ?>
                                <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
                            <?php
                            }
                            ?>
                            
                            <div class="row mt-1">
                                <div class="form-group">
                                    <div class="row mt-1 mb-3">
                                        <label for="hari" class="form-label fw-bold">
                                            Hari
                                        </label>
                                        <div>
                                            <select class="form-select" aria-label="hari" name="hari" >
                                                <option selected>Pilih Hari...</option>
                                                <option>Senin</option>
                                                <option>Selasa</option>
                                                <option>Rabu</option>
                                                <option>Kamis</option>
                                                <option>Jumat</option>
                                                <option>Sabtu</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="jam_mulai">Jam Mulai:</label>
                                    <input value="<?php echo $jam_mulai ?>" type="time" class="form-control" id="jam_mulai" name="jam_mulai" required >
                                </div>

                                <div class="form-group">
                                    <label for="jam_selesai">Jam Selesai:</label>
                                    <input value="<?php echo $jam_selesai ?>" type="time" class="form-control" id="jam_selesai" name="jam_selesai" required>
                                </div>

                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select class="form-select" aria-label="status" name="status" >
                                        <option selected>Pilih Status...</option>
                                        <?php 
                                            $sts = ['0' => 'aktif', '1' => 'tidak aktif'];
                                            // Looping melalui array untuk membuat opsi dropdown
                                            foreach ($sts as $statuses => $namastatus ) {
                                                // Menentukan apakah opsi saat ini harus dipilih (selected)
                                                $selected = ($statuses == $status ) ? 'selected' : '';
                                                // Tampil dropdown
                                                echo "<option value='$statuses' $selected>$namastatus</option>";
                                            };
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
                        <th scope="col">No</th>
                        <th scope="col">Dokter</th>
                        <th scope="col">Hari</th>
                        <th scope="col">Mulai</th>
                        <th scope="col">Selesai</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <!--tbody berisi isi tabel sesuai dengan judul atau head-->
                <tbody>
                    <!-- Kode PHP untuk menampilkan semua isi dari tabel urut-->
                    <?php
                    $id_dokter = $_SESSION['id'];
                    // Menjalankan query untuk mendapatkan jadwal periksa dokter tertentu
                    // $result = mysqli_query($mysqli, "SELECT dokter.nama, jadwal_periksa.id, jadwal_periksa.hari, jadwal_periksa.hari, 
                    //     jadwal_periksa.jam_mulai, jadwal_periksa.jam_selesai, jadwal_periksa.status FROM dokter JOIN jadwal_periksa ON dokter.id = jadwal_periksa.id_dokter WHERE dokter.id = $id_dokter");
                    $result = mysqli_query($mysqli, "SELECT dokter.nama, jadwal_periksa.id, jadwal_periksa.hari,jadwal_periksa.jam_mulai, jadwal_periksa.jam_selesai FROM dokter JOIN jadwal_periksa ON dokter.id = jadwal_periksa.id_dokter WHERE dokter.id = $id_dokter");
                    $no = 1;
                    while ($data = mysqli_fetch_array($result)) {
                    ?>
                        <tr>
                            <th scope="row" class="text-center"><?php echo $no++ ?></th>
                            <td><?php echo $data['nama'] ?></td>
                            <td class="text-center"><?php echo $data['hari'] ?></td>
                            <td class="text-center"><?php echo $data['jam_mulai'] ?></td>
                            <td class="text-center"><?php echo $data['jam_selesai'] ?></td>
                            <!-- <td class="d-flex gap-2 mb-3 d-flex justify-content-center">
                                <?php 
                                    echo ($data['status'] == 0 ) ? 
                                    ' <a class="btn btn-success rounded-pill px-3">Aktif</a>' : 
                                    ' <a class="btn btn-danger rounded-pill px-3">Tidak Aktif</a>';
                                ?>
                            </td> -->
                            <td>
                                <div class="d-flex gap-2 mb-3 d-flex justify-content-center">
                                    <a type="button" class="btn btn-success rounded-pill px-3" href="berandaDokter.php?page=jadwalDokter&id=<?php echo $data['id'] ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
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