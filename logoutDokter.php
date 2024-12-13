<?php
session_start();
if (isset($_SESSION['nama'])) {
    // Hapus session
    session_unset();
    session_destroy();
}

header("Location: index.php?page=loginDokter");
exit();
?>