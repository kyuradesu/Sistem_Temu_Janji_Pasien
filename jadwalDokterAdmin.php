<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['username'])) {
    // Jika pengguna sudah login, tampilkan tombol "Logout"
    header("Location: index.php?page=jadwalDokterAdmin");
    exit;
}

if (isset($_POST['simpan'])) {
    if (isset($_POST['id'])) {
        $ubah = mysqli_query($mysqli, "UPDATE jadwal_periksa SET 
            hari = '" . $_POST['hari'] . "',
            jam_mulai = '" . $_POST['jam_mulai'] . "',
            jam_selesai = '" . $_POST['jam_selesai'] . "',
            WHERE
            id = '" . $_POST['id'] . "'");
    } else {
        $tambah = mysqli_query($mysqli, "INSERT INTO jadwal_periksa (hari, jam_mulai, jam_selesai) 
            VALUES (
                '" . $_POST['hari'] . "',
                '" . $_POST['jam_mulai'] . "',
                '" . $_POST['jam_selesai'] . "'
            )");
    }
    echo "<script> 
            document.location='index.php?page=jadwalDokterAdmin';
        </script>";
}
?>
<br>

<div class="container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center fw-bold" style="font-size: 2rem;">Jadwal Dokter</div>
                    <div class="card-body">
                        <form class="form row" method="POST" style="width: 30rem;" action="" name="myForm" onsubmit="return(validate());">
                            <!-- Kode php untuk menghubungkan form dengan database -->
                            <?php
                            $id_dokter = '';
                            $hari = '';
                            $jam_mulai = '';
                            $jam_selesai = '';
                            if (isset($_GET['id'])) {
                                $ambil = mysqli_query($mysqli, "SELECT * FROM jadwal_periksa 
                                        WHERE id='" . $_GET['id'] . "'");
                                while ($row = mysqli_fetch_array($ambil)) {
                                    $id_dokter = $row['id_dokter'];
                                    $hari = $row['hari'];
                                    $jam_mulai = $row['jam_mulai'];
                                    $jam_selesai = $row['jam_selesai'];
                                }
                            ?>
                                <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
                            <?php
                            }
                            ?>
                            
                            <div class="row mt-1">
                                <div class="form-group">
                                    <!-- <label for="hari">Hari:</label> -->
                                    <!-- <input type="text" class="form-control" id="hari" name="hari" required> -->
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
    </div>

    <br>
    <br>
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

                <!-- <th scope="col">Status</th>
                <th scope="col">Aktif</th> -->
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <!--tbody berisi isi tabel sesuai dengan judul atau head-->
        <tbody>
            <!-- Kode PHP untuk menampilkan semua isi dari tabel urut-->
            <?php
            
            $result = mysqli_query($mysqli, "SELECT dokter.nama, jadwal_periksa.id, jadwal_periksa.hari, jadwal_periksa.jam_mulai, jadwal_periksa.jam_selesai FROM dokter JOIN jadwal_periksa ON dokter.id = jadwal_periksa.id_dokter");
            $no = 1;
            while ($data = mysqli_fetch_array($result)) {
            ?>
                <tr>
                    <th scope="row"><?php echo $no++ ?></th>
                  
                    <td><?php echo $data['nama'] ?></td>
                    <td class="text-center"><?php echo $data['hari'] ?></td>
                    <td class="text-center"><?php echo $data['jam_mulai'] ?></td>
                    <td class="text-center"><?php echo $data['jam_selesai'] ?></td>
                    <!-- <td>
                        <a class="btn btn-success rounded-pill px-3" href="index.php?page=jadwalDokter&id=<?php echo $data['id'] ?>">Aktif</a>
                    </td>
                    <td>
                        <a class="btn btn-success rounded-pill px-3" href="index.php?page=jadwalDokter&id=<?php echo $data['id'] ?>">Non Aktifkan</a>
                    </td> -->
                    <td class="d-flex justify-content-center ">
                        <div class="d-flex gap-2 mb-3">
                            <a type="button" class="btn btn-success rounded-pill px-3" href="index.php?page=obat&id=<?php echo $data['id'] ?>">
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
