-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 11, 2024 at 01:37 PM
-- Server version: 5.7.33
-- PHP Version: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `poli1`
--

-- --------------------------------------------------------

--
-- Table structure for table `daftar_poli`
--

CREATE TABLE `daftar_poli` (
  `id` int(11) NOT NULL,
  `id_pasien` int(11) NOT NULL,
  `id_jadwal` int(11) NOT NULL,
  `keluhan` text NOT NULL,
  `no_antrian` int(11) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `daftar_poli`
--

INSERT INTO `daftar_poli` (`id`, `id_pasien`, `id_jadwal`, `keluhan`, `no_antrian`, `tanggal`) VALUES
(4, 5, 3, 'Demam', 1, '2023-12-31 14:17:57'),
(7, 6, 2, 'sakit gigi', 2, '2024-01-04 17:29:33'),
(11, 8, 2, 'Gusi bengkak', 4, '2024-01-05 13:21:37'),
(13, 6, 2, 'Cabut gigi', 6, '2024-01-06 17:34:38'),
(14, 7, 10, 'Nyeri Menstruasi', 1, '2024-01-06 17:41:53'),
(15, 7, 1, 'Gangguan Menstruasi', 4, '2024-01-06 17:42:18'),
(16, 7, 9, 'Nyeri Punggung', 1, '2024-01-06 17:43:26'),
(19, 9, 2, 'Cabut gigi', 8, '2024-01-07 08:06:39'),
(20, 8, 2, 'cabut gigi', 9, '2024-01-07 14:49:40'),
(22, 8, 12, 'Gigi retak', 1, '2024-01-07 17:32:34'),
(24, 13, 5, 'Batuk', 3, '2024-01-08 02:23:48'),
(25, 14, 8, 'Mata merah, gatal, berair, dan terkadang nyeri.', 1, '2024-01-08 02:54:10'),
(26, 15, 4, 'Penglihatan kabur, sulit fokus', 1, '2024-01-08 02:55:42'),
(27, 16, 4, 'Mata merah, iritasi, nanah', 2, '2024-01-08 02:58:00'),
(28, 17, 5, 'flu', 4, '2024-01-08 03:08:59'),
(29, 18, 5, 'flu, batuk, demam', 5, '2024-01-08 03:16:49');

-- --------------------------------------------------------

--
-- Table structure for table `detail_periksa`
--

CREATE TABLE `detail_periksa` (
  `id` int(11) NOT NULL,
  `id_periksa` int(11) NOT NULL,
  `id_obat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `detail_periksa`
--

INSERT INTO `detail_periksa` (`id`, `id_periksa`, `id_obat`) VALUES
(20, 18, 4),
(21, 19, 2),
(23, 21, 1),
(25, 23, 2),
(27, 25, 2),
(30, 28, 3),
(31, 29, 10),
(32, 30, 14),
(33, 31, 15),
(34, 32, 3),
(35, 33, 3);

-- --------------------------------------------------------

--
-- Table structure for table `dokter`
--

CREATE TABLE `dokter` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `no_hp` varchar(50) NOT NULL,
  `id_poli` int(11) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `dokter`
--

INSERT INTO `dokter` (`id`, `nama`, `alamat`, `no_hp`, `id_poli`, `password`) VALUES
(3, 'Farah Aryaresta ', 'Jl. Pemuda No.5, Semarang', '0852365242153', 1, 'farah123'),
(4, 'Cantika Sari', 'Jl. Merpati No.25, Semarang', '0852365324569', 3, 'cantika123'),
(5, 'Bianka Putri', 'Jl. Pahlawan No.125, Surakarta', '0852345612568', 4, 'bianka123'),
(6, 'Andreas Dika Putra', 'Jl. Semangka No.55, Semarang', '0852354216589', 6, 'andreas123'),
(7, 'Adit Saputra', 'Jl. Mekar No.22, Semarang', '0895632542156', 5, 'adit123');

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_periksa`
--

CREATE TABLE `jadwal_periksa` (
  `id` int(11) NOT NULL,
  `id_dokter` int(11) NOT NULL,
  `hari` enum('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu') NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jadwal_periksa`
--

INSERT INTO `jadwal_periksa` (`id`, `id_dokter`, `hari`, `jam_mulai`, `jam_selesai`) VALUES
(1, 7, 'Senin', '22:33:33', '23:33:33'),
(2, 3, 'Kamis', '08:05:00', '12:00:00'),
(3, 4, 'Kamis', '09:14:58', '14:14:58'),
(4, 5, 'Rabu', '09:14:58', '14:14:58'),
(5, 4, 'Selasa', '08:16:49', '15:16:49'),
(6, 3, 'Rabu', '08:36:22', '11:36:22'),
(7, 4, 'Jumat', '13:36:22', '16:36:22'),
(8, 5, 'Jumat', '08:37:39', '12:37:39'),
(9, 6, 'Jumat', '10:37:39', '15:37:39'),
(10, 7, 'Rabu', '12:38:30', '16:38:30'),
(11, 3, 'Senin', '03:47:00', '04:46:00'),
(12, 3, 'Jumat', '07:51:00', '11:51:00'),
(13, 3, 'Sabtu', '07:56:00', '12:56:00'),
(14, 3, 'Kamis', '09:57:00', '15:57:00'),
(15, 3, 'Kamis', '18:28:00', '20:28:00'),
(16, 4, 'Sabtu', '07:09:00', '12:09:00'),
(17, 4, 'Rabu', '08:17:00', '13:17:00');

-- --------------------------------------------------------

--
-- Table structure for table `obat`
--

CREATE TABLE `obat` (
  `id` int(11) NOT NULL,
  `nama_obat` varchar(100) NOT NULL,
  `kemasan` varchar(50) NOT NULL,
  `harga` double NOT NULL,
  `stok` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `obat`
--

INSERT INTO `obat` (`id`, `nama_obat`, `kemasan`, `harga`, `stok`) VALUES
(1, 'Paramex', 'Strip', 5000, 0),
(2, 'Bisolvon Extra Sirup', 'Botol', 20000, 0),
(3, 'Konidin OBH', 'Sachet', 3000, 0),
(4, 'Paracetamol', 'Strip', 15000, 0),
(8, 'Ibuprofen', 'Strip', 5000, 0),
(9, 'Obat kumur antiseptik', 'Botol', 15000, 0),
(10, 'Aspirin', 'Strip', 8000, 0),
(11, 'Naproxen', 'Strip', 10000, 0),
(12, 'Prednisone', 'Strip', 20000, 0),
(14, 'Tobramisin', 'Botol', 20000, 0),
(15, 'Timolol', 'Botol', 8000, 0);

-- --------------------------------------------------------

--
-- Table structure for table `pasien`
--

CREATE TABLE `pasien` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `no_ktp` varchar(255) NOT NULL,
  `no_hp` varchar(50) NOT NULL,
  `no_rm` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pasien`
--

INSERT INTO `pasien` (`id`, `nama`, `alamat`, `no_ktp`, `no_hp`, `no_rm`) VALUES
(5, 'Amanda Sucik', 'Jl. Mekar no.85, Semarang', '0885236589652456', '0852365421896', '202312-5'),
(6, 'Adelya Yahya', 'Jl.Melati no.85, Semarang', '0882541365987525', '0856423589655', '202401-6'),
(7, 'Erin Eriana', 'Jl.Sirsak no.45, Semarang', '0882136542859625', '0895456523215', '202401-7'),
(8, 'Zahra Ratriana ', 'Jl. Solo no.75, Semarang', '0852365214686524', '0854256578956', '202401-8'),
(9, 'pp', 'Jl. Pemuda No 5, Semarang', '2659656', '22611', '202401-9'),
(11, 'Melati', 'Kembar rt 03/ rw 02/, Pandan, Slogohimo, Wonogiri, Jawa Tengah', '0852542365125456', '0853265485752', '202401-10'),
(12, 'Luky Tyas Elyana', 'Jl. Cemara no.66, Semarang', '0882356425687542', '0852136542586', '202401-11'),
(13, 'Anabel', 'Jl. Pahlawan no.0+85, Semarang', '0885235425625752', '085236532425', '202401-12'),
(14, 'lisa', 'Jl. Mekar no.55, Semarang', '0885324523645215', '085236532654', '202401-13'),
(15, 'Maya', 'Jl. Solo no.65, Semarang', '0885236542536525', '085326532456', '202401-14'),
(16, 'Dina putri', 'Jl. Cendana no.16, Semarang', '0852365236542565', '085236548532', '202401-15'),
(17, 'Ferliana', 'Jl. Pahlawan no.35, Semarang', '0852356425652356', '085235695423', '202401-16'),
(18, 'Putri Maria', 'Jl. Mekar no.35, Semarang', '0852365985365236', '085236596235', '202401-17'),
(19, 'Tiiti', 'Pati', '2223333', '1233443546', ' 202412-14 ');

-- --------------------------------------------------------

--
-- Table structure for table `periksa`
--

CREATE TABLE `periksa` (
  `id` int(11) NOT NULL,
  `id_daftar_poli` int(11) NOT NULL,
  `tgl_periksa` datetime NOT NULL,
  `catatan` text NOT NULL,
  `biaya_periksa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `periksa`
--

INSERT INTO `periksa` (`id`, `id_daftar_poli`, `tgl_periksa`, `catatan`, `biaya_periksa`) VALUES
(18, 4, '2024-01-04 21:12:22', 'minum obat teratur', 165000),
(19, 7, '2024-01-05 13:07:09', 'minum obat teratur ', 170000),
(21, 11, '2024-01-05 14:43:42', 'Obat teratur', 155000),
(23, 19, '2024-01-07 15:11:40', 'kompres', 170000),
(25, 20, '2024-01-07 15:50:22', 'minum obat teratur', 170000),
(28, 24, '2024-01-08 03:25:23', 'minum obat teratur', 153000),
(29, 22, '2024-01-08 03:48:40', 'jangan makan keras', 158000),
(30, 26, '2024-01-08 03:59:07', 'Obat tetes dipakai teratur', 170000),
(31, 25, '2024-01-08 03:59:52', 'Obat tetes dipakai teratur', 158000),
(32, 28, '2024-01-08 04:10:41', 'minum obat teratur', 153000),
(33, 29, '2024-01-08 04:18:35', 'minum obat teratur', 153000);

-- --------------------------------------------------------

--
-- Table structure for table `poli`
--

CREATE TABLE `poli` (
  `id` int(11) NOT NULL,
  `nama_poli` varchar(25) NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `poli`
--

INSERT INTO `poli` (`id`, `nama_poli`, `keterangan`) VALUES
(1, 'Poli Gigi', 'Spesialis gigi menangani perawatan gigi, mulut, dan rongga mulut. Pelayanan meliputi pembersihan gigi, penambalan, pencabutan gigi, dan perawatan ortodonti.'),
(3, 'Poli Anak', 'Disediakan untuk perawatan dan konsultasi kesehatan anak-anak. Dokter anak atau pediatri memberikan imunisasi, pemeriksaan tumbuh kembang, dan penanganan penyakit anak.'),
(4, 'Poli Mata', 'Spesialis mata (oftalmolog) menangani pemeriksaan mata dan perawatan berbagai kondisi mata. Pemeriksaan mata, pengukuran kacamata, dan penanganan masalah mata seperti infeksi atau penyakit mata.'),
(5, 'Poli Kandungan', 'Menyediakan perawatan untuk perempuan terkait kehamilan, persalinan, dan masalah reproduksi. Pemeriksaan kehamilan, persalinan, dan perawatan ginekologi umum.'),
(6, 'Poli Syaraf', 'Spesialis syaraf atau neurolog merawat gangguan saraf. Pemeriksaan dan pengelolaan kondisi neurologis seperti migrain, stroke, atau epilepsi.');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `nama`, `username`, `password`) VALUES
(5, 'Fatta', 'fattazaina', '12345');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `daftar_poli`
--
ALTER TABLE `daftar_poli`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pasien_daftar_poli` (`id_pasien`),
  ADD KEY `fk_jadwal_periksa_daftar_poli` (`id_jadwal`);

--
-- Indexes for table `detail_periksa`
--
ALTER TABLE `detail_periksa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_detail_periksa_obat` (`id_obat`),
  ADD KEY `fk_periksa_detail_periksa` (`id_periksa`);

--
-- Indexes for table `dokter`
--
ALTER TABLE `dokter`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_dokter_poli` (`id_poli`);

--
-- Indexes for table `jadwal_periksa`
--
ALTER TABLE `jadwal_periksa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_jadwal_periksa_dokter` (`id_dokter`);

--
-- Indexes for table `obat`
--
ALTER TABLE `obat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pasien`
--
ALTER TABLE `pasien`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `periksa`
--
ALTER TABLE `periksa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_daftar_poli_periksa` (`id_daftar_poli`);

--
-- Indexes for table `poli`
--
ALTER TABLE `poli`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `daftar_poli`
--
ALTER TABLE `daftar_poli`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `detail_periksa`
--
ALTER TABLE `detail_periksa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `dokter`
--
ALTER TABLE `dokter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `jadwal_periksa`
--
ALTER TABLE `jadwal_periksa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `obat`
--
ALTER TABLE `obat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `pasien`
--
ALTER TABLE `pasien`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `periksa`
--
ALTER TABLE `periksa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `poli`
--
ALTER TABLE `poli`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `daftar_poli`
--
ALTER TABLE `daftar_poli`
  ADD CONSTRAINT `fk_jadwal_periksa_daftar_poli` FOREIGN KEY (`id_jadwal`) REFERENCES `jadwal_periksa` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pasien_daftar_poli` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `detail_periksa`
--
ALTER TABLE `detail_periksa`
  ADD CONSTRAINT `fk_detail_periksa_obat` FOREIGN KEY (`id_obat`) REFERENCES `obat` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_periksa_detail_periksa` FOREIGN KEY (`id_periksa`) REFERENCES `periksa` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dokter`
--
ALTER TABLE `dokter`
  ADD CONSTRAINT `fk_dokter_poli` FOREIGN KEY (`id_poli`) REFERENCES `poli` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `jadwal_periksa`
--
ALTER TABLE `jadwal_periksa`
  ADD CONSTRAINT `fk_jadwal_periksa_dokter` FOREIGN KEY (`id_dokter`) REFERENCES `dokter` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `periksa`
--
ALTER TABLE `periksa`
  ADD CONSTRAINT `fk_daftar_poli_periksa` FOREIGN KEY (`id_daftar_poli`) REFERENCES `daftar_poli` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
