<?php
if (!isset($_SESSION)) {
    session_start();
}
    include_once("koneksi.php");
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SisFo Poliklinik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark pt-2 ps-4 pe-3 shadow-sm fixed-top">

        <div class="container">
            <a class="navbar-brand" href="#">Poliklinik Sehat Bahagia</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="berandaDokter.php">Home</a>
                    </li>
                    <?php
                        if (isset($_SESSION['nama'])){
                            //menu master jika user sudah login 
                    ?>
                        
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="berandaDokter.php?page=periksa">Periksa</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="berandaDokter.php?page=riwayatPasien">Riwayat Pasien</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="berandaDokter.php?page=jadwalDokter">Jadwal Dokter</a>
                        </li>
                        <!-- <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="berandaDokter.php?page=profilDokter&id=<?php echo $_SESSION['id']; ?>">Profil Dokter</a>
                        </li> -->
                    <?php 
                        } 
                    ?>
                </ul>
                <?php
                    if (isset($_SESSION['nama'])) {
                        // Jika pengguna sudah login, tampilkan tombol "Logout"
                    ?>
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="logoutDokter.php">Logout (<?php echo $_SESSION['nama'] ?>)</a>
                            </li>
                        </ul>
                    <?php
                    } else {
                        // Jika pengguna belum login, tampilkan tombol "Login" dan "Register"
                    ?>
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Login</a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="index.php?page=loginUser">Admin</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="index.php?page=loginDokter">Dokter</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    <?php
                    }
                ?>
            </div>
        </div>
    </nav>

    <main role="main" class="container-fluid">
    <?php
        if (isset($_GET['page'])) {
            include($_GET['page'] . ".php");
        } else {
            echo "";

            if (isset($_SESSION['nama'])) {
                //jika sudah login tampilkan nama
                echo '<section class="slider">
                    <div class="hero-slider">
                        <div class="single-slider">
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-7 pt-5">
                                        <div class="text">
                                            <h1>Selamat Datang Dokter</h1>
                                            <h2>Di Poliklinik Sehat Bahagia</h2>
                                            <h2>Hello, '. $_SESSION['nama'] .'</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>';
            } else {
                echo '
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
                                                Selamat datang di Poliklinik Sehat Bahagia! <span></span>
                                            </h3>
                                        </div>
                                        <p class="aboutpoli" style="font-size: 16px;">
                                            Kami adalah pusat layanan kesehatan yang berkomitmen untuk memberikan pelayanan terbaik kepada pasien kami. 
                                            Dengan staf medis yang berpengalaman dan fasilitas terkini, Poliklinik Sehat Bahagia menjadi pilihan utama untuk perawatan kesehatan Anda.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    ';
            }
        }
    ?>
    </main>  
    
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


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>