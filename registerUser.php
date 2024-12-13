<?php
if (!isset($_SESSION)) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password === $confirm_password) {
        $query = "SELECT * FROM user WHERE username = '$username'";
        $result = $mysqli->query($query);

        if ($result === false) {
            die("Query error: " . $mysqli->error);
        }

        if ($result->num_rows == 0) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $insert_query = "INSERT INTO user (username, password) VALUES ('$username', '$hashed_password')";
            if (mysqli_query($mysqli, $insert_query)) {
                echo "<script>
                alert('Pendaftaran Berhasil'); 
                document.location='index.php?page=loginUser';
                </script>";
            } else {
                $error = "Pendaftaran gagal";
            }
        } else {
            $error = "Username sudah digunakan";
        }
    } else {
        $error = "Password tidak cocok";
    }
}
?>
//simpan
<div class="container" style="margin-top: 4.1rem;">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center fw-bold" style="font-size: 2rem;">Pendaftaran Pasien</div>
                    <div class="card-body">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="about_section pt-3">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-5 ">
                                    <div class="img-box">
                                        <img src="img/about1.png" alt="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="detail-box">
                                        <div class="heading_container">
                                            <h3>
                                                Poliklinik Sehat Bahagia! <span></span>
                                            </h3>
                                        </div>
                                        <p class="aboutpoli">
                                            Kami adalah pusat layanan kesehatan yang berkomitmen untuk memberikan pelayanan terbaik kepada pasien kami. 
                                            Dengan staf medis yang berpengalaman dan fasilitas terkini, Poliklinik Sehat Bahagia menjadi pilihan utama untuk perawatan kesehatan Anda.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center" style="font-weight: bold; font-size: 32px;">Register</div>
                <div class="card-body">
                    <form method="POST" action="index.php?page=registerUser">
                        <?php
                        if (isset($error)) {
                            echo '<div class="alert alert-danger">' . $error . '
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>';
                        }
                        ?>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" name="username" class="form-control" required placeholder="Masukkan nama anda">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" class="form-control" required placeholder="Masukkan password">
                        </div>
                        <div class="form-group">
                            <label for="confirm_password">Confirm Password</label>
                            <input type="password" name="confirm_password" class="form-control" required placeholder="Masukkan password konfirmasi">
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-block">Register</button>
                        </div>
                    </form>
                    <div class="text-center">
                        <p class="mt-3">Sudah Punya Akun? <a href="index.php?page=loginUser">Login</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>