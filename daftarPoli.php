<?php  
    // Pengecekan apakah request yang diterima adalah POST
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Mengambil data keluhan dan id_jadwal dari formulir POST
        $keluhan = $_POST['keluhan'];
        $id_jadwal = $_POST['id_jadwal'];

        // Pengecekan apakah pasien sudah mendaftar di poli sebelumnya
        $check_query = "SELECT * FROM daftar_poli WHERE id_pasien = '".$_SESSION['id_pasien']."'";
        $check_result = $mysqli->query($check_query);

        // Memeriksa apakah formulir diisi dan menentukan nomor antrian berikutnya.
        $query = "SELECT MAX(no_antrian) as max_no FROM daftar_poli WHERE id_jadwal = '$id_jadwal'";
        $result = $mysqli->query($query);
        $row = $result->fetch_assoc();
        $no_antrian = $row['max_no'] !== null ? $row['max_no'] + 1 : 1;

        // Menyimpan data pendaftaran pasien ke poli dalam tabel daftar_poli 
        $insert_query = "INSERT INTO daftar_poli (id_pasien, id_jadwal, keluhan, no_antrian, tanggal) 
            VALUES ('".$_SESSION['id_pasien']."', '$id_jadwal', '$keluhan', '$no_antrian', NOW())";
        if (mysqli_query($mysqli, $insert_query)) {
            $success = "No antrian anda adalah $no_antrian";
            header("Location: index.php?page=daftarPoli&no_antrian=$no_antrian");
        } else {
            $error = "Pendaftaran gagal";
        }
    }

    // Query SQL untuk mengambil informasi dokter dan jadwal periksa dari tabel dokter dan jadwal_periksa dengan menggunakan JOIN
    $query = "SELECT dokter.id AS dokter_id, dokter.nama AS dokter_nama, jadwal_periksa.id AS jadwal_id, 
        jadwal_periksa.hari AS hari, jadwal_periksa.jam_mulai AS jam_mulai, jadwal_periksa.jam_selesai AS jam_selesai FROM dokter JOIN jadwal_periksa ON dokter.id = jadwal_periksa.id_dokter";
    // Eksekusi query menggunakan objek MySQLi dan menyimpan hasilnya
    $result = $mysqli->query($query);
    // Memeriksa query berhasil dieksekusi
    if (!$result) {
        die("Query error: " . $mysqli->error);
    }
    // Mengambil semua baris hasil query sebagai array asosiatif
    $dokter_schedules = $result->fetch_all(MYSQLI_ASSOC);
?>

<div class="container" style="margin-top: 3rem;">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card" >
                <div class="card-header text-center fw-bold" style="font-size: 2rem;">Pendaftaran Pasien</div>
                <div class="card-body">
                    <form class="form row" method="POST" action="" name="myForm" onsubmit="return(validate());">
                        <!-- Kode php untuk menghubungkan form dengan database -->
                        <?php
                            if (!isset($error) && isset($_GET['no_antrian'])) {
                                echo '
                                    <svg xmlns="http://www.w3.org/2000/svg" class="d-none">
                                        <symbol id="check-circle-fill" viewBox="0 0 16 16">
                                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                        </symbol>
                                    </svg>
                                    <div class="alert alert-success d-flex align-items-center" role="alert">
                                        <svg class="bi flex-shrink-0 me-2" style="width: 20; height: 20;" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
                                        <div>
                                            Nomor antrian anda adalah ' .$_GET['no_antrian']. '
                                        </div>
                                    </div>
                                ';
                            }
                            if (isset($error)) {
                                echo '
                                    <svg xmlns="http://www.w3.org/2000/svg" class="d-none">
                                        <symbol id="exclamation-triangle-fill" viewBox="0 0 16 16">
                                            <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                                        </symbol>
                                    </svg>
                                    <div class="alert alert-danger d-flex align-items-center" role="alert">
                                        <svg class="bi flex-shrink-0 me-2" style="width: 20; height: 20;" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                                        <div>
                                            ' . $error . '
                                        </div>
                                    </div>
                                ';
                            }
                            
                            ?>
                        <div class="row mt-1 mb-3">
                            <label for="id_poli" class="form-label fw-bold">
                                Poli Dokter
                            </label>
                            <div>
                                <select class="form-select" aria-label="id_poli" name="id_poli" >
                                    <option selected>Pilih Poli...</option>
                                    <?php 
                                        $result = mysqli_query($mysqli, "SELECT * FROM poli");

                                        while ($data = mysqli_fetch_assoc($result)) {
                                            echo "<option value='" . $data['id'] . "'>". $data['nama_poli'] . "</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-1 mb-3">
                            <label for="id_dokter" class="form-label fw-bold">
                                Dokter
                            </label>
                            <div>
                                <select class="form-select" aria-label="id_dokter" name="id_dokter" >
                                    <option selected>Pilih Dokter...</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-1 mb-3">
                            <label for="id_jadwal" class="form-label fw-bold">
                                Jadwal 
                            </label>
                            <div>
                                <select class="form-select" aria-label="id_jadwal" name="id_jadwal" >
                                    <option selected>Pilih Jadwal...</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-1 mb-3">
                            <label for="keluhan" class="form-label fw-bold">
                                Keluhan
                            </label>
                            <textarea placeholder="Keluhan anda" class="form-control" name="keluhan" id="keluhan" aria-label="With textarea"></textarea>
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


    <script>
        document.querySelector("select[name='id_poli']").addEventListener('change', function(){
        var id_poli = this.value;
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'ambilDokter.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function(){
            if(this.status == 200){
                var response = JSON.parse(this.responseText);
                var len = response.length;
                var select = document.querySelector("select[name='id_dokter']");
                select.innerHTML = "<option selected>Pilih Poli...</option>";
                for( var i = 0; i<len; i++){
                    var id = response[i]['id'];
                    var nama = response[i]['nama'];
                    select.innerHTML += "<option value='"+id+"'>"+nama+"</option>";
                }
            }
        }
        xhr.send('id_poli='+id_poli);
        })


        document.querySelector("select[name='id_dokter']").addEventListener('change', function(){
        var id_dokter = this.value;
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'ambilJadwal.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function(){
            if(this.status == 200){
                var response = JSON.parse(this.responseText);
                var len = response.length;
                var select = document.querySelector("select[name='id_jadwal']");
                select.innerHTML = "<option selected>Pilih Jadwal...</option>";
                for( var i = 0; i<len; i++){
                    var id = response[i]['id'];
                    var hari = response[i]['hari'];
                    var jam_mulai = response[i]['jam_mulai'];
                    var jam_selesai = response[i]['jam_selesai'];
                    select.innerHTML += "<option value='"+id+"'>"+hari+" , "+jam_mulai+" - "+jam_selesai+"</option>";
                }
            }
        }
        xhr.send('id_dokter='+id_dokter);
        })


    </script>

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