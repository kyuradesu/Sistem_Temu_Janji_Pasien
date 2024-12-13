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
    <title>Poliklinik UDINUS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css?v=1.0">
    <script src="sweetalert/sweetalert2.min.js"></script>
    <!-- <link rel="stylesheet" href="sweetalert/sweetalert2.min.css"> -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark pt-2 ps-4 pe-3 shadow-sm fixed-top">    

        <div class="container">
            <a class="navbar-brand" href="index.php">Poliklinik UDINUS</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse text-white" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="index.php">Home</a>
                    </li>
                    
                    <?php
                    if (isset($_SESSION['username'])) {
                        // Jika pengguna sudah login, tampilkan tombol "Logout"
                    ?>

                    <?php
                    } else {
                        // Jika pengguna belum login, tampilkan tombol "Login" dan "Register"
                    ?>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="index.php?page=daftarPasien">Daftar Pasien</a>
                        </li>
                    <?php
                    }
                ?>

                    <?php
                        if (isset($_SESSION['username'])){
                            //menu master jika user sudah login 
                    ?>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="index.php?page=obat">Obat</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="index.php?page=dokter">Dokter</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="index.php?page=poli">Poli</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="index.php?page=pasien">Pasien</a>
                        </li>
                        <!-- <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="index.php?page=jadwalDokterAdmin">Jadwal Dokter</a>
                        </li> -->
                    <?php 
                        } 
                    ?>
                </ul>
                <?php
                    if (isset($_SESSION['username'])) {
                        // Jika pengguna sudah login, tampilkan tombol "Logout"
                    ?>
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="logoutUser.php">Logout (<?php echo $_SESSION['username'] ?>)</a>
                            </li>
                        </ul>
                    <?php
                    } else {
                        // Jika pengguna belum login, tampilkan tombol "Login" dan "Register"
                    ?>
                        <ul class="navbar-nav ms-auto">
                            <!-- <li class="nav-item">
                                <a class="nav-link" href="index.php?page=registerUser">Register</a>
                            </li> -->
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
                if (isset($_SESSION['username'])) {
                    //jika sudah login tampilkan username
                    echo '<section class="slider">
                    <div class="hero-slider">
                        <div class="single-slider">
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-7 pt-5">
                                        <div class="text">
                                            <h1>Selamat Datang Admin</h1>
                                            <h2>Di Poliklinik Kyr~ </h2>
                                            <h2>Hello, '. $_SESSION['username'] .'</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>';
                } else {
                    echo '
                    
                        <section class="slider">
                            <div class="hero-slider">
                                <div class="single-slider">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-lg-7">
                                                <div class="text">
                                                    <h1 style="color: black;">Sistem Temu Janji</h1>
<h2 style="color: black !important;"><strong>Pasien - Dokter</strong></h2>
<p style="color: black;">
    <strong>Selamat datang di Poliklinik Kyr~, pusat perawatan kesehatan yang berkomitmen menyediakan perhatian 
    medis berkualitas dan solusi terkini untuk Mahasiswa. Tim medis berpengalaman kami siap membantu Anda mencapai kesehatan 
    optimal dengan penuh perhatian. Prioritaskan kenyamanan, kesejahteraan, dan kepuasan pasien bersama kami.</strong>
</p>
<span style="color: black;"><strong>Poliklinik Unggul dengan Tim Medis Berpengalaman.</strong></span>


                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section> 

                        <section class="schedule">
                            <div class="container">
                                <div class="schedule-inner">
                                    <div class="row d-flex align-item-center justify-content-center">
                                        <div class="col-lg-4 col-md-6 col-12 ">
                                            <!-- single-schedule -->
                                            <div class="single-schedule first">
                                                <div class="inner">
                                                    <div class="icon">
                                                        <i class="fa fa-ambulance"></i>
                                                    </div>
                                                    <div class="single-content">
                                                        <h4>Login Sebagai Pasien</h4>
                                                        <p>Apabila Anda adalah seorang Pasien, Anda harus hafal minimal 3 lagu dari band Rumah Sakit</p>
                                                        <a href="index.php?page=daftarPasien" class="btn">MASUK<i class="fa fa-long-arrow-right"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-12">
                                            <div class="single-schedule middle">
                                                <div class="inner">
                                                    <div class="icon">
                                                        <i class="icofont-prescription"></i>
                                                    </div>
                                                    <div class="single-content">
                                                        <h4>Login Sebagai Dokter</h4>
                                                        <p>Apabila Anda adalah seorang Dokter, silahkan Login terlebih dahulu untuk memulai melayani pasien</p>
                                                        <a href="index.php?page=loginDokter" class="btn">MASUK<i class="fa fa-long-arrow-right"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <section class="feautes-section mb-5">
                            <div class="container d-flex justify-content-center">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="section-title">
                                            <h2>Kami Selalu Siap Membantu Anda & Keluarga Anda</h2>
                                            <div class="images"><img src="img/section-img.png" alt="#"></div>
                                            <p>Menyediakan layanan terbaik untuk memastikan kesejahteraan dan kebahagiaan keluarga Anda. 
                                            Dengan tim profesional yang berkomitmen, 
                                            kami hadir untuk menjawab setiap kebutuhan dan memberikan solusi terbaik.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>   

                        <div class="copyright">
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-12">
                                        <div class="copyright-content">
                                            <p>© Copyright 2024  |  All Rights Reserved by <a href="index.php" target="_blank">poliklinik UDINUS.com</a> </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                    
                    
                    ';
                }
            }
        ?>
        
    </main>    
   
    
    <script src="sweetalert/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script> -->
</body>
</html>
