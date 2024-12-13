<?php
if (!isset($_SESSION)) {
    session_start();
}

// Memeriksa apakah request yang diterima adalah POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mengambil data nama dan password dari formulir POST
    $nama = $_POST['nama'];
    $password = $_POST['password'];
    // Membuat query untuk mencari user berdasarkan nama
    $query = "SELECT * FROM dokter WHERE nama = '$nama'";
    $result = $mysqli->query($query);

    // Memeriksa apakah query berhasil dieksekusi
    if (!$result) {
        die("Query error: " . $mysqli->error);
    }

    // Memeriksa apakah ada satu baris data dokter yang sesuai dengan nama
    if ($result->num_rows == 1) {
        // Mengambil data dokter dari hasil query
        $row = $result->fetch_assoc();
        // Memeriksa apakah password yang dimasukkan cocok dengan password di database
        if (($password == $row['password'])) {
            // Jika cocok, mengeset session 'id' dan 'nama', dan mengarahkan ke halaman berandaDokter.php
            $_SESSION['id'] = $row['id'];
            $_SESSION['nama'] = $nama;
            header("Location: berandaDokter.php");
        } else {
            $error = "Password salah";
        }
    } else {
        $error = "Dokter tidak ditemukan";
    }
}
?>

<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="row border rounded-5 p-3 bg-white shadow">
<!-------------------- ------ Right Box ---------------------------->
        <div class="col-md-10 right-box align-items-center ">
            <div class="row align-items-center">
                <div class="header-text mb-4">
                    <h2>Hello, Dokter</h2>
                    <p>We are happy to have you back.</p>
                </div>
                <form method="POST" action="index.php?page=loginDokter">
                    <?php
                        if (isset($error)) {
                            echo '<div class="alert alert-danger">' . $error . '
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>';
                        }
                    ?>
                    <div class="form-group mb-3">
                        <label for="nama">Nama</label> 
                        <input type="text" name="nama" class="form-control form-control-lg bg-light fs-6" placeholder="Masukkan nama anda" required>
                    </div>
                    <div class="form-group mb-5 ">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control form-control-lg bg-light fs-6" placeholder="Masukkan password anda" required>
                    </div>
                    
                    <div class="form-group mb-3">
                        <button class="btn btn-lg btn-primary w-100 fs-6" type="submit">Login</button>
                    </div>
                </form>
            </div>
        </div> 
    </div>
</div>
