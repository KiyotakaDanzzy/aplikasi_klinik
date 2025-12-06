-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 06, 2025 at 01:20 AM
-- Server version: 8.0.30
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aplikasi_klinik`
--

-- --------------------------------------------------------

--
-- Table structure for table `adm_grup_hak_akses`
--

CREATE TABLE `adm_grup_hak_akses` (
  `id` int NOT NULL,
  `nama_grup_hak_akses` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `adm_grup_hak_akses`
--

INSERT INTO `adm_grup_hak_akses` (`id`, `nama_grup_hak_akses`) VALUES
(1, 'Dashboard'),
(2, 'Master Data'),
(3, 'Kepegawaian'),
(4, 'Resepsionis'),
(5, 'Antrian'),
(6, 'Poli'),
(7, 'Transaksi'),
(8, 'Keuangan'),
(9, 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `adm_hak_akses`
--

CREATE TABLE `adm_hak_akses` (
  `id` int NOT NULL,
  `nama_hak_akses` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `link` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_grup_hak_akses` int DEFAULT NULL,
  `nama_grup_hak_akses` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `adm_hak_akses`
--

INSERT INTO `adm_hak_akses` (`id`, `nama_hak_akses`, `link`, `id_grup_hak_akses`, `nama_grup_hak_akses`) VALUES
(1, 'Home', 'welcome', 1, 'Dashboard'),
(2, 'Poli', 'master_data/poli', 2, 'Master Data'),
(3, 'Tindakan', 'master_data/tindakan', 2, 'Master Data'),
(4, 'Diagnosa', 'master_data/diagnosa', 2, 'Master Data'),
(5, 'Jabatan', 'kepegawaian/jabatan', 3, 'Kepegawaian'),
(6, 'Pegawai', 'kepegawaian/pegawai', 3, 'Kepegawaian'),
(7, 'Dokter', 'kepegawaian/jadwal_dokter', 3, 'Kepegawaian'),
(8, 'Jadwal Dokter', 'kepegawaian/jadwal_dokter/index_jadwal', 3, 'Kepegawaian'),
(9, 'Pasien', 'master_data/pasien', 4, 'Resepsionis'),
(10, 'Booking', 'resepsionis/booking', 4, 'Resepsionis'),
(11, 'Pendaftaran', 'resepsionis/registrasi', 4, 'Resepsionis'),
(12, 'Panel Antrian', 'antrian/panel_antrian', 5, 'Antrian'),
(13, 'Panel Dokter', 'antrian/panel_dokter', 5, 'Antrian'),
(14, 'Poli Gigi', 'poli/gigi', 6, 'Poli'),
(15, 'Pembayaran', 'transaksi/pembayaran', 7, 'Transaksi'),
(16, 'Riwayat Pembayaran', 'transaksi/riwayat_pembayaran', 7, 'Transaksi'),
(17, 'Jenis Biaya', 'keuangan/jenis_biaya', 8, 'Keuangan'),
(18, 'Pemasukan', 'keuangan/pemasukan', 8, 'Keuangan'),
(19, 'Pengeluaran', 'keuangan/pengeluaran', 8, 'Keuangan'),
(20, 'Level', 'admin/level', 9, 'Admin'),
(21, 'User', 'admin/user', 9, 'Admin'),
(22, 'Hak Akses', 'admin/hak_akses', 9, 'Admin'),
(24, 'Grup Hak Akses', 'admin/grup_hak_akses', 9, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `adm_level`
--

CREATE TABLE `adm_level` (
  `id` int NOT NULL,
  `nama_level` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `adm_level`
--

INSERT INTO `adm_level` (`id`, `nama_level`) VALUES
(4, 'Dokter'),
(8, 'Resepsionis'),
(9, 'Administrator');

-- --------------------------------------------------------

--
-- Table structure for table `adm_level_akses`
--

CREATE TABLE `adm_level_akses` (
  `id` int NOT NULL,
  `id_level` int NOT NULL,
  `id_hak_akses` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `adm_level_akses`
--

INSERT INTO `adm_level_akses` (`id`, `id_level`, `id_hak_akses`) VALUES
(61, 4, 13),
(62, 4, 14),
(86, 8, 9),
(87, 8, 10),
(88, 8, 11),
(89, 8, 15),
(90, 8, 16),
(91, 8, 17),
(92, 8, 18),
(93, 8, 19),
(94, 9, 1),
(95, 9, 2),
(96, 9, 3),
(97, 9, 4),
(98, 9, 5),
(99, 9, 6),
(100, 9, 7),
(101, 9, 8),
(102, 9, 9),
(103, 9, 10),
(104, 9, 11),
(105, 9, 12),
(106, 9, 13),
(107, 9, 14),
(108, 9, 15),
(109, 9, 16),
(110, 9, 17),
(111, 9, 18),
(112, 9, 19),
(113, 9, 20),
(114, 9, 21),
(115, 9, 22),
(116, 9, 24);

-- --------------------------------------------------------

--
-- Table structure for table `adm_user`
--

CREATE TABLE `adm_user` (
  `id` int NOT NULL,
  `id_pegawai` int DEFAULT NULL,
  `nama_pegawai` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_level` int DEFAULT NULL,
  `nama_level` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` enum('Aktif','Nonaktif') COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `adm_user`
--

INSERT INTO `adm_user` (`id`, `id_pegawai`, `nama_pegawai`, `username`, `password`, `id_level`, `nama_level`, `status`) VALUES
(2, 11, 'dr. Fikri Ramadhan', 'FikriDokter', '$2y$10$ZicqRcVVXd6sloS4ON8U6uNCgy7oxtiYvMAFVVV4poc1iU3HyzgFe', 4, 'Dokter', 'Aktif'),
(3, 28, 'Mukhamad Wildan', 'WildanAdmin', '$2y$10$Ko6sE0SVp/Yndy99x0fCkOdsD.kleOpnElWdOcT07zfTcwv6ArYgG', 9, 'Administrator', 'Aktif'),
(4, 8, 'Charisa', 'CharisaResep', '$2y$10$rZxSQ6S.hdTn73.Eita1juw.LNsNGzbyAPZKFtSCxIK86v7FDNgUG', 8, 'Resepsionis', 'Aktif');

-- --------------------------------------------------------

--
-- Table structure for table `apt_barang`
--

CREATE TABLE `apt_barang` (
  `id` int UNSIGNED NOT NULL,
  `id_jenis_barang` int UNSIGNED DEFAULT NULL,
  `nama_barang` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `apt_barang`
--

INSERT INTO `apt_barang` (`id`, `id_jenis_barang`, `nama_barang`) VALUES
(1, 1, 'Paracetamol 500mg'),
(2, 1, 'Amoxicillin 500mg'),
(3, 1, 'Cetirizine 10mg'),
(4, 1, 'Ibuprofen 400mg'),
(5, 2, 'Vitamin C 500mg'),
(6, 2, 'Vitamin B Complex'),
(7, 2, 'Calcium D'),
(8, 3, 'Antasida DOEN'),
(9, 3, 'Promag'),
(10, 3, 'Mylanta'),
(11, 4, 'Tolak Angin Cair'),
(12, 4, 'Kapsul Jahe'),
(13, 5, 'Povidone Iodine'),
(14, 5, 'Hansaplast'),
(15, 5, 'Kapas Steril'),
(16, 6, 'Omeprazole 21mg'),
(17, 6, 'Metformin 500mg'),
(18, 6, 'Amlodipine 3mg'),
(19, 7, 'Termometer Digital'),
(20, 7, 'Tensimeter'),
(21, 7, 'Stetoskop'),
(22, 8, 'Sabun Antiseptik'),
(23, 8, 'Hand Sanitizer'),
(24, 9, 'Tetes Mata'),
(25, 9, 'Tetes Telinga'),
(26, 10, 'Salep Antibiotik'),
(27, 10, 'Krim Antijamur'),
(28, 11, 'Obat Batuk Hitam'),
(29, 11, 'Sirup Paracetamol'),
(30, 12, 'Diazepam 5mg'),
(31, 13, 'Morphine 10mg'),
(32, 1, 'CTM 4mg'),
(33, 1, 'Ranitidine 150mg'),
(34, 2, 'Zinc Tablet'),
(35, 2, 'Vitamin E 400IU'),
(36, 3, 'Antasida Tablet'),
(37, 4, 'Madu Herbal'),
(38, 5, 'Perban Elastis'),
(39, 6, 'Simvastatin 20mg'),
(40, 6, 'Losartan 500mg');

-- --------------------------------------------------------

--
-- Table structure for table `apt_barang_detail`
--

CREATE TABLE `apt_barang_detail` (
  `id` int NOT NULL,
  `id_barang` int UNSIGNED DEFAULT NULL,
  `kode_barang` varchar(255) DEFAULT NULL,
  `nama_barang` varchar(255) DEFAULT NULL,
  `id_satuan_barang` int UNSIGNED DEFAULT NULL,
  `satuan_barang` varchar(255) DEFAULT NULL,
  `isi_satuan_turunan` varchar(255) DEFAULT NULL,
  `urutan_satuan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `apt_barang_detail`
--

INSERT INTO `apt_barang_detail` (`id`, `id_barang`, `kode_barang`, `nama_barang`, `id_satuan_barang`, `satuan_barang`, `isi_satuan_turunan`, `urutan_satuan`) VALUES
(1, 1, 'PAR500-BOX', 'Paracetamol 500mg', 1, 'Box', '1', '1'),
(2, 1, 'PAR500-STP', 'Paracetamol 500mg', 2, 'Strip', '10', '2'),
(3, 1, 'PAR500-TAB', 'Paracetamol 500mg', 3, 'Tablet', '10', '3'),
(7, 3, 'CET10-BOX', 'Cetirizine 10mg', 1, 'Box', '1', '1'),
(8, 3, 'CET10-STP', 'Cetirizine 10mg', 2, 'Strip', '10', '2'),
(9, 3, 'CET10-TAB', 'Cetirizine 10mg', 3, 'Tablet', '10', '3'),
(10, 4, 'IBU400-BOX', 'Ibuprofen 400mg', 1, 'Box', '1', '1'),
(11, 4, 'IBU400-STP', 'Ibuprofen 400mg', 2, 'Strip', '10', '2'),
(12, 4, 'IBU400-TAB', 'Ibuprofen 400mg', 3, 'Tablet', '10', '3'),
(13, 5, 'VITC500-BOX', 'Vitamin C 500mg', 1, 'Box', '1', '1'),
(14, 5, 'VITC500-STP', 'Vitamin C 500mg', 2, 'Strip', '10', '2'),
(15, 5, 'VITC500-TAB', 'Vitamin C 500mg', 3, 'Tablet', '10', '3'),
(16, 6, 'VITB-BOX', 'Vitamin B Complex', 1, 'Box', '1', '1'),
(17, 6, 'VITB-STP', 'Vitamin B Complex', 2, 'Strip', '10', '2'),
(18, 6, 'VITB-TAB', 'Vitamin B Complex', 3, 'Tablet', '10', '3'),
(19, 7, 'CALD-BOX', 'Calcium D', 1, 'Box', '1', '1'),
(20, 7, 'CALD-STP', 'Calcium D', 2, 'Strip', '10', '2'),
(21, 7, 'CALD-TAB', 'Calcium D', 3, 'Tablet', '10', '3'),
(25, 9, 'PROMAG-BOX', 'Promag', 1, 'Box', '1', '1'),
(26, 9, 'PROMAG-STP', 'Promag', 2, 'Strip', '10', '2'),
(27, 9, 'PROMAG-TAB', 'Promag', 3, 'Tablet', '10', '3'),
(28, 10, 'MYLANTA-BTL', 'Mylanta', 5, 'Botol', '1', '1'),
(29, 10, 'MYLANTA-SCT', 'Mylanta', NULL, NULL, '12', '2'),
(30, 11, 'TOLAKANGIN-BTL', 'Tolak Angin Cair', 5, 'Botol', '1', '1'),
(31, 11, 'TOLAKANGIN-SCT', 'Tolak Angin Cair', NULL, NULL, '12', '2'),
(32, 12, 'JAHE-BOX', 'Kapsul Jahe', 1, 'Box', '1', '1'),
(33, 12, 'JAHE-STP', 'Kapsul Jahe', 2, 'Strip', '10', '2'),
(34, 12, 'JAHE-CAP', 'Kapsul Jahe', 4, 'Kapsul', '10', '3'),
(35, 13, 'BETADINE-BTL', 'Povidone Iodine', 5, 'Botol', '1', '1'),
(36, 13, 'BETADINE-SCT', 'Povidone Iodine', NULL, NULL, '20', '2'),
(37, 14, 'HANSPLST-BOX', 'Hansaplast', 1, 'Box', '1', '1'),
(38, 14, 'HANSPLST-PCS', 'Hansaplast', 7, 'Pcs', '100', '2'),
(39, 15, 'KAPAS-BOX', 'Kapas Steril', 1, 'Box', '1', '1'),
(40, 15, 'KAPAS-PACK', 'Kapas Steril', 8, 'Pack', '10', '2'),
(44, 17, 'MET500-BOX', 'Metformin 500mg', 1, 'Box', '1', '1'),
(45, 17, 'MET500-STP', 'Metformin 500mg', 2, 'Strip', '10', '2'),
(46, 17, 'MET500-TAB', 'Metformin 500mg', 3, 'Tablet', '10', '3'),
(50, 19, 'TERMO-PCS', 'Termometer Digital', 7, 'Pcs', '1', '1'),
(51, 20, 'TENSI-PCS', 'Tensimeter', 7, 'Pcs', '1', '1'),
(52, 21, 'STETO-PCS', 'Stetoskop', 7, 'Pcs', '1', '1'),
(53, 22, 'SABUN-PCS', 'Sabun Antiseptik', 7, 'Pcs', '1', '1'),
(54, 23, 'HSANITZ-BTL', 'Hand Sanitizer', 5, 'Botol', '1', '1'),
(55, 24, 'TETESMATA-BTL', 'Tetes Mata', 5, 'Botol', '1', '1'),
(56, 25, 'TETESTELINGA-BTL', 'Tetes Telinga', 5, 'Botol', '1', '1'),
(57, 26, 'SALEP-TUBE', 'Salep Antibiotik', 9, 'Tube', '1', '1'),
(58, 27, 'KRIM-TUBE', 'Krim Antijamur', 9, 'Tube', '1', '1'),
(59, 28, 'BATUKHITAM-BTL', 'Obat Batuk Hitam', 5, 'Botol', '1', '1'),
(60, 29, 'SIRUPPARACET-BTL', 'Sirup Paracetamol', 5, 'Botol', '1', '1'),
(61, 30, 'DIAZ5-BOX', 'Diazepam 5mg', 1, 'Box', '1', '1'),
(62, 30, 'DIAZ5-STP', 'Diazepam 5mg', 2, 'Strip', '10', '2'),
(63, 30, 'DIAZ5-TAB', 'Diazepam 5mg', 3, 'Tablet', '10', '3'),
(64, 31, 'MORPH10-BOX', 'Morphine 10mg', 1, 'Box', '1', '1'),
(65, 31, 'MORPH10-AMP', 'Morphine 10mg', 10, 'Ampul', '10', '2'),
(66, 32, 'CTM4-BOX', 'CTM 4mg', 1, 'Box', '1', '1'),
(67, 32, 'CTM4-STP', 'CTM 4mg', 2, 'Strip', '10', '2'),
(68, 32, 'CTM4-TAB', 'CTM 4mg', 3, 'Tablet', '10', '3'),
(69, 33, 'RAN150-BOX', 'Ranitidine 150mg', 1, 'Box', '1', '1'),
(70, 33, 'RAN150-STP', 'Ranitidine 150mg', 2, 'Strip', '10', '2'),
(71, 33, 'RAN150-TAB', 'Ranitidine 150mg', 3, 'Tablet', '10', '3'),
(72, 34, 'ZINC-BOX', 'Zinc Tablet', 1, 'Box', '1', '1'),
(73, 34, 'ZINC-STP', 'Zinc Tablet', 2, 'Strip', '10', '2'),
(74, 34, 'ZINC-TAB', 'Zinc Tablet', 3, 'Tablet', '10', '3'),
(75, 35, 'VITE400-BOX', 'Vitamin E 400IU', 1, 'Box', '1', '1'),
(76, 35, 'VITE400-STP', 'Vitamin E 400IU', 2, 'Strip', '10', '2'),
(77, 35, 'VITE400-CAP', 'Vitamin E 400IU', 4, 'Kapsul', '10', '3'),
(81, 37, 'MADU-BTL', 'Madu Herbal', 5, 'Botol', '1', '1'),
(82, 38, 'PERBAN-PCS', 'Perban Elastis', 7, 'Pcs', '1', '1'),
(83, 39, 'SIMVA20-BOX', 'Simvastatin 20mg', 1, 'Box', '1', '1'),
(84, 39, 'SIMVA20-STP', 'Simvastatin 20mg', 2, 'Strip', '10', '2'),
(85, 39, 'SIMVA20-TAB', 'Simvastatin 20mg', 3, 'Tablet', '10', '3'),
(98, 40, 'LOS50-BOX', 'Losartan 500mg', 1, 'Box', '1', '1'),
(99, 40, 'LOS50-STP', 'Losartan 500mg', 2, 'Strip', '1', '2'),
(100, 40, 'LOS50-TAB', 'Losartan 500mg', 3, 'Tablet', '10', '3'),
(104, 16, 'OMEP20-BOX', 'Omeprazole 21mg', 1, 'Box', '1', '1'),
(105, 16, 'OMEP20-STP', 'Omeprazole 21mg', 2, 'Strip', '10', '2'),
(106, 16, 'OMEP20-CAP', 'Omeprazole 21mg', 4, 'Kapsul', '10', '3'),
(122, 8, 'ANTDOEN-BOX', 'Antasida DOEN', 1, 'Box', '1', '1'),
(123, 8, 'ANTDOEN-STP', 'Antasida DOEN', 2, 'Strip', '10', '2'),
(124, 8, 'ANTDOEN-TAB', 'Antasida DOEN', 3, 'Tablet', '10', '3'),
(131, 36, 'ANTASIDA-BOX', 'Antasida Tablet', 1, 'Box', '1', '1'),
(132, 36, 'ANTASIDA-STP', 'Antasida Tablet', 2, 'Strip', '10', '2'),
(133, 36, 'ANTASIDA-TAB', 'Antasida Tablet', 3, 'Tablet', '10', '3'),
(137, 18, 'AML5-BOX', 'Amlodipine 3mg', 1, 'Box', '1', '1'),
(138, 18, 'AML5-STP', 'Amlodipine 3mg', 2, 'Strip', '10', '2'),
(139, 18, 'AML5-TAB', 'Amlodipine 3mg', 10, 'Ampul', '10', '3'),
(146, 2, 'AMO500-BOX', 'Amoxicillin 500mg', 1, 'Box', '1', '1'),
(147, 2, 'AMO500-STP', 'Amoxicillin 500mg', 2, 'Strip', '10', '2'),
(148, 2, 'AMO500-CAP', 'Amoxicillin 500mg', 4, 'Kapsul', '10', '3');

-- --------------------------------------------------------

--
-- Table structure for table `apt_jenis_barang`
--

CREATE TABLE `apt_jenis_barang` (
  `id` int UNSIGNED NOT NULL,
  `nama_jenis` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `apt_jenis_barang`
--

INSERT INTO `apt_jenis_barang` (`id`, `nama_jenis`) VALUES
(1, 'Obat Bebas'),
(2, 'Vitamin & Suplemen'),
(3, 'Obat Maag'),
(4, 'Obat Herbal'),
(5, 'Alat Kesehatan'),
(6, 'Obat Kera'),
(7, 'Alat Medis'),
(8, 'Perlengkapan Kebersihan'),
(9, 'Obat Tetes'),
(10, 'Obat Oles'),
(11, 'Obat Sirup'),
(12, 'Psikotropika'),
(13, 'Narkotika');

-- --------------------------------------------------------

--
-- Table structure for table `apt_satuan_barang`
--

CREATE TABLE `apt_satuan_barang` (
  `id` int UNSIGNED NOT NULL,
  `nama_satuan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `apt_satuan_barang`
--

INSERT INTO `apt_satuan_barang` (`id`, `nama_satuan`) VALUES
(1, 'Box'),
(2, 'Strip'),
(3, 'Tablet'),
(4, 'Kapsul'),
(5, 'Botol'),
(7, 'Pcs'),
(8, 'Pack'),
(9, 'Tube'),
(10, 'Ampul');

-- --------------------------------------------------------

--
-- Table structure for table `apt_stok`
--

CREATE TABLE `apt_stok` (
  `id` int UNSIGNED NOT NULL,
  `id_barang` int UNSIGNED DEFAULT NULL,
  `id_barang_detail` int DEFAULT NULL,
  `stok` varchar(255) DEFAULT NULL,
  `harga_awal` varchar(255) DEFAULT NULL,
  `harga_jual` varchar(255) DEFAULT NULL,
  `laba` varchar(255) DEFAULT NULL,
  `kadaluarsa` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `apt_stok`
--

INSERT INTO `apt_stok` (`id`, `id_barang`, `id_barang_detail`, `stok`, `harga_awal`, `harga_jual`, `laba`, `kadaluarsa`) VALUES
(204, 36, 131, '15.77', '23000', '30000', '7000', '2026-03-06'),
(205, 36, 132, '157.7', '2300', '3000', '700', '2026-03-06'),
(206, 36, 133, '1577', '230', '300', '70', '2026-03-06'),
(207, 18, 137, '11', '24000', '30000', '6000', '2026-08-01'),
(208, 18, 138, '110', '2400', '3000', '600', '2026-08-01'),
(209, 18, 139, '1100', '240', '300', '60', '2026-08-01'),
(210, 7, 19, '41.99', '25000', '32000', '7000', '2027-02-13'),
(211, 7, 20, '419.9', '2500', '3200', '700', '2027-02-13'),
(212, 7, 21, '4199', '250', '320', '70', '2027-02-13'),
(213, 30, 61, '17', '18000', '23000', '5000', '2026-10-02'),
(214, 30, 62, '170', '1800', '2300', '500', '2026-10-02'),
(215, 30, 63, '1700', '180', '230', '50', '2026-10-02'),
(216, 32, 66, '60', '23000', '30000', '7000', '2028-10-12'),
(217, 32, 67, '600', '2300', '3000', '700', '2028-10-12'),
(218, 32, 68, '6000', '230', '300', '70', '2028-10-12'),
(219, 14, 37, '35', '18000', '22000', '4000', '2026-03-27'),
(220, 14, 38, '3500', '180', '220', '40', '2026-03-27'),
(221, 6, 16, '35', '19000', '24000', '5000', '2026-06-25'),
(222, 6, 17, '350', '1900', '2400', '500', '2026-06-25'),
(223, 6, 18, '3500', '190', '240', '50', '2026-06-25'),
(224, 35, 75, '30', '14000', '20000', '6000', '2019-10-30'),
(225, 35, 76, '300', '1400', '2000', '600', '2019-10-30'),
(226, 35, 77, '3000', '140', '200', '60', '2019-10-30');

-- --------------------------------------------------------

--
-- Table structure for table `contoh`
--

CREATE TABLE `contoh` (
  `id` int NOT NULL,
  `contoh` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contoh_multiple`
--

CREATE TABLE `contoh_multiple` (
  `id` int NOT NULL,
  `contoh` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contoh_multiple_detail`
--

CREATE TABLE `contoh_multiple_detail` (
  `id` int NOT NULL,
  `id_contoh_multiple` varchar(255) DEFAULT NULL,
  `contoh_multiple` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kpg_dokter`
--

CREATE TABLE `kpg_dokter` (
  `id` int UNSIGNED NOT NULL,
  `id_pegawai` varchar(255) DEFAULT NULL,
  `nama_pegawai` varchar(255) DEFAULT NULL,
  `id_poli` int DEFAULT NULL,
  `nama_poli` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `kpg_dokter`
--

INSERT INTO `kpg_dokter` (`id`, `id_pegawai`, `nama_pegawai`, `id_poli`, `nama_poli`) VALUES
(17, '11', 'dr. Fikri Ramadhan', 4, 'Poli Gigi'),
(43, '13', 'dr. Abdul', 4, 'Poli Gigi'),
(44, '10', 'dr. Ahmad', 4, 'Poli Gigi'),
(45, '27', 'dr. Ikram', 17, 'Poli Umum');

-- --------------------------------------------------------

--
-- Table structure for table `kpg_jabatan`
--

CREATE TABLE `kpg_jabatan` (
  `id` int NOT NULL,
  `nama` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `kpg_jabatan`
--

INSERT INTO `kpg_jabatan` (`id`, `nama`) VALUES
(1, 'Dokter'),
(3, 'Resepsionis'),
(5, 'Administrator');

-- --------------------------------------------------------

--
-- Table structure for table `kpg_pegawai`
--

CREATE TABLE `kpg_pegawai` (
  `id` int UNSIGNED NOT NULL,
  `id_jabatan` int DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `no_telp` varchar(255) DEFAULT NULL,
  `nama_jabatan` varchar(255) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `kpg_pegawai`
--

INSERT INTO `kpg_pegawai` (`id`, `id_jabatan`, `nama`, `no_telp`, `nama_jabatan`, `alamat`) VALUES
(8, 3, 'Charisa', '0988279202', 'Resepsionis', 'Bekasi'),
(10, 1, 'dr. Ahmad', '078234758395', 'Dokter', 'Tempeh'),
(11, 1, 'dr. Fikri Ramadhan', '079284924829', 'Dokter', 'Karangsari'),
(13, 1, 'dr. Abdul', '087689927367', 'Dokter', 'Kota Malang'),
(27, 1, 'dr. Ikram', '078198762541', 'Dokter', 'Sumbersuko'),
(28, 5, 'Mukhamad Wildan', '0827635674652', 'Administrator', 'Purworejo');

-- --------------------------------------------------------

--
-- Table structure for table `mst_diagnosa`
--

CREATE TABLE `mst_diagnosa` (
  `id` int UNSIGNED NOT NULL,
  `nama_diagnosa` varchar(100) DEFAULT NULL,
  `id_poli` int DEFAULT NULL,
  `nama_poli` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `mst_diagnosa`
--

INSERT INTO `mst_diagnosa` (`id`, `nama_diagnosa`, `id_poli`, `nama_poli`) VALUES
(5, 'Gigi berlubang', 4, 'Poli Gigi'),
(6, 'Karang Gigi', 4, 'Poli Gigi'),
(7, 'Sariawan', 4, 'Poli Gigi'),
(8, 'Infeksi Jamur', 4, 'Poli Gigi'),
(9, 'Dislokasi Rahang', 4, 'Poli Gigi'),
(12, 'Lubang Besar di Gigi dan Sisa Akar', 4, 'Poli Gigi'),
(13, 'Kanker Mulut', 4, 'Poli Gigi'),
(14, 'Tumor Mulut', 4, 'Poli Gigi'),
(15, 'Periodontitis', 4, 'Poli Gigi'),
(16, 'Gingivitis', 4, 'Poli Gigi'),
(17, 'Erosi Gigi', 4, 'Poli Gigi'),
(18, 'Glositis', 4, 'Poli Gigi'),
(19, 'Tumbuh Gigi Bungsu', 4, 'Poli Gigi'),
(20, 'Gigi Hipersensitif', 4, 'Poli Gigi'),
(21, 'Periodontitis', 4, 'Poli Gigi'),
(23, 'Cacar Air', 19, 'Poli Anak');

-- --------------------------------------------------------

--
-- Table structure for table `mst_pasien`
--

CREATE TABLE `mst_pasien` (
  `id` int NOT NULL,
  `no_rm` varchar(255) NOT NULL,
  `nama_pasien` varchar(255) NOT NULL,
  `nik` varchar(255) NOT NULL,
  `jenis_kelamin` varchar(255) NOT NULL,
  `tanggal_lahir` varchar(255) NOT NULL,
  `umur` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `pekerjaan` varchar(255) NOT NULL,
  `no_telp` varchar(255) NOT NULL,
  `status_perkawinan` varchar(255) NOT NULL,
  `nama_wali` varchar(255) NOT NULL,
  `golongan_darah` varchar(255) NOT NULL,
  `alergi` varchar(255) NOT NULL,
  `status_operasi` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mst_pasien`
--

INSERT INTO `mst_pasien` (`id`, `no_rm`, `nama_pasien`, `nik`, `jenis_kelamin`, `tanggal_lahir`, `umur`, `alamat`, `pekerjaan`, `no_telp`, `status_perkawinan`, `nama_wali`, `golongan_darah`, `alergi`, `status_operasi`, `username`, `password`) VALUES
(27, 'RM00027', 'Sasa', '3789478937648974', 'Perempuan', '23-03-2008', '17', 'Kota Malang', 'Siswa', '083826942852', 'Belum Kawin', 'Angelica', 'O', 'Tidak ada', 'Tidak ada', '', ''),
(28, 'RM00028', 'Chelyine', '2846789374651234', 'Perempuan', '16-07-2009', '16', 'Tangerang', 'Siswa', '087983647827', 'Belum Kawin', 'Dior', 'O', 'Tidak ada', 'Tidak ada', '', ''),
(29, 'RM00029', 'Keyla', '8729785967289374', 'Perempuan', '14-07-2005', '20', 'Kota Malang', 'Mahasiswa', '083647894758', 'Belum Kawin', 'Anas', 'O', 'Tidak ada', 'Tidak ada', '', ''),
(30, 'RM00030', 'Alicia', '9846783987462536', 'Perempuan', '26-11-2009', '15', 'Surabaya', 'Siswa', '085678394785', 'Belum Kawin', 'Ali', 'O', 'Tidak ada', 'Tidak ada', '', ''),
(31, 'RM00031', 'Angelyn', '2093784985789304', 'Perempuan', '21-03-2008', '17', 'Kota Kediri', 'Siswa', '083883607725', 'Belum Kawin', 'Budi', 'A', 'Tidak ada', 'Tidak ada', '', ''),
(33, 'RM00033', 'Ilham', '4790578498737485', 'Laki-laki', '13-06-2000', '25', 'Lumajang', 'Buruh Tani', '084758374859', 'Belum Kawin', 'Sugeng', 'B', 'Tidak ada', 'Tidak ada', '', ''),
(34, 'RM00034', 'Lily', '8944567898743674', 'Perempuan', '15-07-2009', '16', 'Jember', 'Siswa', '085678465738', 'Belum Kawin', 'Ana', 'O', 'Tidak ada', 'Tidak ada', '', ''),
(35, 'RM00035', 'Afif', '1893678495867849', 'Laki-laki', '01-02-2000', '25', 'Karanganyar', 'Mahasiswa', '084678374658', 'Belum Kawin', 'Rahmad', 'B', 'Tidak ada', 'Tidak ada', '', ''),
(36, 'RM00036', 'Adi', '8947589374657893', 'Laki-laki', '15-06-2004', '21', 'Klaten', 'Buruh Tani', '089673928375', 'Belum Kawin', 'Anis', 'AB', 'Tidak ada', 'Tidak ada', '', ''),
(37, 'RM00037', 'Karina', '7849576839586783', 'Perempuan', '25-07-2009', '16', 'Malang', 'Siswa', '084756893874', 'Belum Kawin', 'Arul', 'O', 'Tidak ada', 'Tidak ada', '', ''),
(38, 'RM00038', 'Riki', '2839485768909876', 'Laki-laki', '31-12-2009', '15', 'Candipuro', 'Siswa', '087893746586', 'Belum Kawin', 'Ageng', 'B', 'Tidak ada', 'Tidak ada', '', ''),
(39, 'RM00039', 'Violita', '9749758679837485', 'Perempuan', '17-07-2008', '17', 'Lumajang', 'Siswa', '086783746778', 'Belum Kawin', 'Nata', 'O', 'Tidak ada', 'Tidak ada', '', ''),
(40, 'RM00040', 'Anisa', '8903748576893784', 'Perempuan', '14-07-2005', '20', 'Kedungjajang', 'Wirausaha', '086789374675', 'Belum Kawin', 'Untung', 'B', 'Tidak ada', 'Tidak ada', '', ''),
(41, 'RM00041', 'Ajeng', '3678479878947857', 'Perempuan', '16-07-2015', '10', 'Lumajang', 'Siswa', '084678598763', 'Belum Kawin', 'Albert', 'A', 'Tidak ada', 'Tidak ada', '', ''),
(42, 'RM00042', 'Wahyu', '8479567856729374', 'Laki-laki', '23-10-2007', '17', 'Ranuyoso', 'Siswa', '086784987873', 'Belum Kawin', 'Anang', 'AB', 'Tidak ada', 'Tidak ada', '', ''),
(43, 'RM00043', 'Andin', '37489578928737458', 'Perempuan', '15-06-2004', '21', 'Babakan', 'Mahasiswa', '086738475689', 'Belum Kawin', 'Siti', 'AB', 'Tidak ada', 'Tidak ada', '', ''),
(45, 'RM00045', 'Johan', '3847569786372893', 'Laki-laki', '08-03-2001', '24', 'Karangasem', 'Mahasiswa', '082763973846', 'Belum Kawin', 'Albertus', 'O', 'Tidak ada', 'Tidak ada', '', ''),
(46, 'RM00046', 'Gibran', '8467485789376475', 'Laki-laki', '12-07-2005', '20', 'Probolinggo', 'Mahasiswa', '084789374682', 'Belum Kawin', 'Andi', 'AB', 'Tidak ada', 'Operasi Kaki', '', ''),
(47, 'RM00047', 'Adista', '7392836493881209', 'Perempuan', '10-06-2009', '16', 'Jember', 'Siswa', '086792637485', 'Belum Kawin', 'Putri', 'A', 'Alergi Telur', 'Tidak ada', '', ''),
(50, 'RM00050', 'Maria', '8376467298374659', 'Perempuan', '30-08-2006', '18', 'Karanganyar', 'Mahasiwa', '082637849763', 'Belum Kawin', 'Agung', 'O', 'Tidak ada', 'Tidak ada', '', ''),
(51, 'RM00051', 'Clara', '7293746598273684', 'Perempuan', '05-02-2008', '17', 'Batu', 'Siswa', '082637847284', 'Belum Kawin', 'Justine', 'O', 'Tidak ada', 'Tidak ada', '', ''),
(52, 'RM00052', 'Handy', '8209817468026783', 'Laki-laki', '14-07-2009', '16', 'Lumajang', 'Siswa', '082673846918', 'Belum Kawin', 'Saifullah', 'AB', 'Tidak ada', 'Tidak ada', '', ''),
(59, 'RM00053', 'Noelle', '8291765639827367', 'Perempuan', '16-07-2009', '16', 'Malang', 'Siswa', '082673894675', 'Belum Kawin', 'Acier', 'O', 'Tidak ada', 'Tidak ada', '', ''),
(60, 'RM00060', 'Aira', '9263764785682722', 'Perempuan', '11-03-2010', '15', 'Senduro', 'Siswa', '082637487783', 'Belum Kawin', 'Kukuh', 'AB', 'Tidak ada', 'Tidak ada', '', ''),
(61, 'RM00061', 'Caca', '3546789567845673', 'Perempuan', '12-05-2009', '16', 'Lumajang', 'Siswa', '084673908734', 'Belum Kawin', 'Putri', 'O', 'Tidak ada', 'Tidak ada', '', ''),
(66, 'RM00066', 'Joy', '1111333355557777', 'Perempuan', '14-07-2005', '20', 'Bandung', 'Teknikal IT', '081725673652', 'Belum Kawin', 'Ahmed', 'A', '-', '-', '', ''),
(67, 'RM00067', 'Qwen', '8918276354672893', 'Perempuan', '17-06-2003', '22', 'Olman', 'Saddam', '091872563541', 'Belum Kawin', 'Hussein', '-', '-', '-', '', ''),
(74, 'RM00068', 'Fitria', '8475872273642637', 'Perempuan', '08-02-2000', '25', 'Karangsari', 'Guru', '083746738764', 'Kawin', 'Andina', 'O', 'Alergi Telur', '-', '', ''),
(75, 'RM00075', 'Dini', '9302328323920428', 'Perempuan', '15-07-2009', '16', 'Sentul', 'Siswa', '082673874652', 'Belum Kawin', 'Fina', 'A', '-', '-', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `mst_poli`
--

CREATE TABLE `mst_poli` (
  `id` int UNSIGNED NOT NULL,
  `kode` varchar(100) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `mst_poli`
--

INSERT INTO `mst_poli` (`id`, `kode`, `nama`) VALUES
(4, 'POG', 'Poli Gigi'),
(17, 'POU', 'Poli Umum'),
(18, 'POCA', 'Poli Kecantikan'),
(19, 'PONK', 'Poli Anak');

-- --------------------------------------------------------

--
-- Table structure for table `mst_tindakan`
--

CREATE TABLE `mst_tindakan` (
  `id` int UNSIGNED NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `harga` varchar(100) DEFAULT NULL,
  `id_poli` int DEFAULT NULL,
  `nama_poli` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `mst_tindakan`
--

INSERT INTO `mst_tindakan` (`id`, `nama`, `harga`, `id_poli`, `nama_poli`) VALUES
(14, 'Rantai Gigi', '1200000', 4, 'Poli Gigi'),
(15, 'Pasang gigi', '2300000', 4, 'Poli Gigi'),
(17, 'Pembersihan Karang Gigi', '860000', 4, 'Poli Gigi'),
(18, 'Perawatan Saluran Akar', '2350000', 4, 'Poli Gigi'),
(20, 'Konsultasi Medis', '175000', 4, 'Poli Gigi'),
(25, 'Pembersihkan plak gigi', '780000', 4, 'Poli Gigi'),
(31, 'Sealant celah gigi', '998000', 4, 'Poli Gigi'),
(32, 'Implan Gigi', '5600000', 4, 'Poli Gigi'),
(33, 'Veneer', '4250000', 4, 'Poli Gigi'),
(34, 'Dental bridge', '1500000', 4, 'Poli Gigi'),
(35, 'Penanganan Gangguan Sendi', '1675000', 4, 'Poli Gigi'),
(36, 'Penanganan Trauma Maksilofasial', '2500000', 4, 'Poli Gigi'),
(37, 'Kuretase', '1700000', 4, 'Poli Gigi'),
(38, 'Scaling', '1250000', 4, 'Poli Gigi'),
(52, 'Pembenaran Posisi Rahang', '750000', 4, 'Poli Gigi');

-- --------------------------------------------------------

--
-- Table structure for table `pol_anak`
--

CREATE TABLE `pol_anak` (
  `id` int UNSIGNED NOT NULL,
  `kode_invoice` varchar(225) DEFAULT NULL,
  `id_pasien` int DEFAULT NULL,
  `nik` varchar(255) DEFAULT NULL,
  `nama_pasien` varchar(225) DEFAULT NULL,
  `id_dokter` int DEFAULT NULL,
  `nama_dokter` varchar(225) DEFAULT NULL,
  `keluhan` varchar(225) DEFAULT NULL,
  `berat_badan` varchar(225) DEFAULT NULL,
  `tinggi_badan` varchar(225) DEFAULT NULL,
  `suhu` varchar(225) DEFAULT NULL,
  `status_imunisasi` varchar(225) DEFAULT NULL,
  `catatan` varchar(225) DEFAULT NULL,
  `tanggal` varchar(225) DEFAULT NULL,
  `waktu` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pol_anak_diagnosa`
--

CREATE TABLE `pol_anak_diagnosa` (
  `id` int UNSIGNED NOT NULL,
  `id_rm_anak` int DEFAULT NULL,
  `id_diagnosa` int DEFAULT NULL,
  `diagnosa` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pol_anak_tindakan`
--

CREATE TABLE `pol_anak_tindakan` (
  `id` int UNSIGNED NOT NULL,
  `id_pol_anak` int DEFAULT NULL,
  `id_tindakan` int DEFAULT NULL,
  `tindakan` varchar(255) DEFAULT NULL,
  `harga` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pol_gigi`
--

CREATE TABLE `pol_gigi` (
  `id` int UNSIGNED NOT NULL,
  `kode_invoice` varchar(225) DEFAULT NULL,
  `id_pasien` int DEFAULT NULL,
  `nik` varchar(255) DEFAULT NULL,
  `nama_pasien` varchar(225) DEFAULT NULL,
  `id_dokter` int DEFAULT NULL,
  `nama_dokter` varchar(225) DEFAULT NULL,
  `keluhan` varchar(225) DEFAULT NULL,
  `catatan` varchar(225) DEFAULT NULL,
  `tanggal` varchar(225) DEFAULT NULL,
  `waktu` varchar(225) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pol_gigi`
--

INSERT INTO `pol_gigi` (`id`, `kode_invoice`, `id_pasien`, `nik`, `nama_pasien`, `id_dokter`, `nama_dokter`, `keluhan`, `catatan`, `tanggal`, `waktu`) VALUES
(70, 'KI291125-001', 66, '1111333355557777', 'Joy', 43, 'dr. Abdul', 'Gusi sakit', '-', '29-11-2025', '09:15:52'),
(71, 'KI291125-002', 67, '8918276354672893', 'Qwen', 17, 'dr. Fikri Ramadhan', NULL, NULL, '29-11-2025', '09:16:03'),
(72, 'KI291125-004', 46, '8467485789376475', 'Gibran', 17, 'dr. Fikri Ramadhan', 'Gigi sakit sehabis makan/minum yang dingin', '-', '29-11-2025', '09:49:59'),
(73, 'KI021225-001', 52, '8209817468026783', 'Handy', 17, 'dr. Fikri Ramadhan', 'Sakit', '-', '02-12-2025', '15:22:53'),
(74, 'KI031225-001', 74, '8475872273642637', 'Fitria', 17, 'dr. Fikri Ramadhan', 'Sakit Gigi', '-', '03-12-2025', '13:29:11'),
(75, 'KI031225-002', 50, '8376467298374659', 'Maria', 17, 'dr. Fikri Ramadhan', 'Gusi Bengkak', '-', '03-12-2025', '13:29:30'),
(76, 'KI031225-003', 75, '9302328323920428', 'Dini', 17, 'dr. Fikri Ramadhan', 'Sakit Gigi', '-', '03-12-2025', '13:30:24'),
(77, 'KI031225-004', 36, '8947589374657893', 'Adi', 17, 'dr. Fikri Ramadhan', 'Sakit', '-', '03-12-2025', '14:38:57'),
(78, 'KI031225-005', 35, '1893678495867849', 'Afif', 17, 'dr. Fikri Ramadhan', 'Sakittt', '-', '03-12-2025', '14:39:10'),
(79, 'KI031225-006', 31, '2093784985789304', 'Angelyn', 17, 'dr. Fikri Ramadhan', 'Sakit Mulut', '-', '03-12-2025', '14:39:21'),
(80, 'KI031225-007', 39, '9749758679837485', 'Violita', 17, 'dr. Fikri Ramadhan', 'Sakit gusi', '-', '03-12-2025', '14:39:36'),
(81, 'KI031225-008', 43, '37489578928737458', 'Andin', 17, 'dr. Fikri Ramadhan', 'Pasang Gigi', '-', '03-12-2025', '14:39:52'),
(82, 'KI031225-009', 52, '8209817468026783', 'Handy', 44, 'dr. Ahmad', NULL, NULL, '03-12-2025', '18:09:17');

-- --------------------------------------------------------

--
-- Table structure for table `pol_gigi_diagnosa`
--

CREATE TABLE `pol_gigi_diagnosa` (
  `id` int UNSIGNED NOT NULL,
  `id_pol_gigi` int DEFAULT NULL,
  `id_diagnosa` int DEFAULT NULL,
  `diagnosa` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pol_gigi_diagnosa`
--

INSERT INTO `pol_gigi_diagnosa` (`id`, `id_pol_gigi`, `id_diagnosa`, `diagnosa`) VALUES
(83, 70, 19, 'Tumbuh Gigi Bungsu'),
(84, 72, 20, 'Gigi Hipersensitif'),
(85, 73, 20, 'Gigi Hipersensitif'),
(86, 74, 17, 'Erosi Gigi'),
(87, 75, 19, 'Tumbuh Gigi Bungsu'),
(88, 75, 5, 'Gigi berlubang'),
(89, 76, 12, 'Lubang Besar di Gigi dan Sisa Akar'),
(90, 77, 21, 'Periodontitis'),
(91, 78, 17, 'Erosi Gigi'),
(92, 79, 16, 'Gingivitis'),
(93, 80, 20, 'Gigi Hipersensitif'),
(94, 80, 19, 'Tumbuh Gigi Bungsu'),
(95, 81, 18, 'Glositis'),
(96, 81, 12, 'Lubang Besar di Gigi dan Sisa Akar');

-- --------------------------------------------------------

--
-- Table structure for table `pol_gigi_tindakan`
--

CREATE TABLE `pol_gigi_tindakan` (
  `id` int UNSIGNED NOT NULL,
  `id_pol_gigi` int DEFAULT NULL,
  `id_tindakan` int DEFAULT NULL,
  `tindakan` varchar(255) DEFAULT NULL,
  `harga` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pol_gigi_tindakan`
--

INSERT INTO `pol_gigi_tindakan` (`id`, `id_pol_gigi`, `id_tindakan`, `tindakan`, `harga`) VALUES
(98, 70, 38, 'Scaling', '1250000'),
(99, 72, 18, 'Perawatan Saluran Akar', '2350000'),
(100, 73, 36, 'Penanganan Trauma Maksilofasial', '2500000'),
(101, 74, 31, 'Sealant celah gigi', '998000'),
(102, 75, 32, 'Implan Gigi', '5600000'),
(103, 76, 25, 'Pembersihkan plak gigi', '780000'),
(104, 76, 38, 'Scaling', '1250000'),
(105, 76, 35, 'Penanganan Gangguan Sendi', '1675000'),
(106, 76, 36, 'Penanganan Trauma Maksilofasial', '2500000'),
(107, 76, 15, 'Pasang gigi', '2300000'),
(108, 76, 14, 'Rantai Gigi', '1200000'),
(109, 76, 20, 'Konsultasi Medis', '175000'),
(110, 76, 18, 'Perawatan Saluran Akar', '2350000'),
(111, 77, 37, 'Kuretase', '1700000'),
(112, 78, 34, 'Dental bridge', '1500000'),
(113, 79, 35, 'Penanganan Gangguan Sendi', '1675000'),
(114, 80, 34, 'Dental bridge', '1500000'),
(115, 81, 15, 'Pasang gigi', '2300000');

-- --------------------------------------------------------

--
-- Table structure for table `pol_kecantikan`
--

CREATE TABLE `pol_kecantikan` (
  `id` int UNSIGNED NOT NULL,
  `kode_invoice` varchar(225) DEFAULT NULL,
  `id_pasien` int DEFAULT NULL,
  `nik` varchar(255) DEFAULT NULL,
  `nama_pasien` varchar(225) DEFAULT NULL,
  `id_dokter` int DEFAULT NULL,
  `nama_dokter` varchar(225) DEFAULT NULL,
  `keluhan` varchar(225) DEFAULT NULL,
  `jenis_treatment` varchar(225) DEFAULT NULL,
  `riwayat_alergi` varchar(225) DEFAULT NULL,
  `produk_digunakan` varchar(225) DEFAULT NULL,
  `hasil_perawatan` varchar(225) DEFAULT NULL,
  `tanggal` varchar(225) DEFAULT NULL,
  `waktu` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pol_kecantikan_detail`
--

CREATE TABLE `pol_kecantikan_detail` (
  `id` int UNSIGNED NOT NULL,
  `id_pol_kecantikan` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pol_kecantikan_diagnosa`
--

CREATE TABLE `pol_kecantikan_diagnosa` (
  `id` int UNSIGNED NOT NULL,
  `id_pol_kecantikan` int DEFAULT NULL,
  `id_diagnosa` int DEFAULT NULL,
  `diagnosa` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pol_kecantikan_tindakan`
--

CREATE TABLE `pol_kecantikan_tindakan` (
  `id` int UNSIGNED NOT NULL,
  `id_rm_kecantikan` int DEFAULT NULL,
  `id_tindakan` int DEFAULT NULL,
  `tindakan` varchar(255) DEFAULT NULL,
  `harga` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pol_resep`
--

CREATE TABLE `pol_resep` (
  `id` int UNSIGNED NOT NULL,
  `kode_invoice` varchar(255) DEFAULT NULL,
  `kode_resep` varchar(100) DEFAULT NULL,
  `id_pasien` int DEFAULT NULL,
  `nik` varchar(255) DEFAULT NULL,
  `nama_pasien` varchar(255) DEFAULT NULL,
  `id_dokter` int DEFAULT NULL,
  `total_harga` varchar(255) DEFAULT NULL,
  `tanggal` varchar(255) DEFAULT NULL,
  `waktu` varchar(255) DEFAULT NULL,
  `nama_dokter` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pol_resep`
--

INSERT INTO `pol_resep` (`id`, `kode_invoice`, `kode_resep`, `id_pasien`, `nik`, `nama_pasien`, `id_dokter`, `total_harga`, `tanggal`, `waktu`, `nama_dokter`) VALUES
(53, 'KI291125-004', 'RSP291125-002', 46, '8467485789376475', 'Gibran', 17, '154000', '29-11-2025', '09:51:50', 'dr. Fikri Ramadhan'),
(54, 'KI021225-001', 'RSP021225-001', 52, '8209817468026783', 'Handy', 17, '25440', '02-12-2025', '15:24:33', 'dr. Fikri Ramadhan'),
(55, 'KI031225-001', 'RSP031225-001', 74, '8475872273642637', 'Fitria', 17, '9230', '03-12-2025', '13:32:19', 'dr. Fikri Ramadhan'),
(56, 'KI031225-002', 'RSP031225-002', 50, '8376467298374659', 'Maria', 17, '3760', '03-12-2025', '13:34:22', 'dr. Fikri Ramadhan'),
(58, 'KI031225-004', 'RSP031225-003', 36, '8947589374657893', 'Adi', 17, '64100', '03-12-2025', '14:41:21', 'dr. Fikri Ramadhan'),
(59, 'KI031225-005', 'RSP031225-004', 35, '1893678495867849', 'Afif', 17, '192000', '03-12-2025', '14:42:07', 'dr. Fikri Ramadhan'),
(60, 'KI031225-006', 'RSP031225-005', 31, '2093784985789304', 'Angelyn', 17, '410000', '03-12-2025', '14:42:54', 'dr. Fikri Ramadhan'),
(61, 'KI031225-007', 'RSP031225-006', 39, '9749758679837485', 'Violita', 17, '76000', '03-12-2025', '14:43:46', 'dr. Fikri Ramadhan'),
(62, 'KI031225-008', 'RSP031225-007', 43, '37489578928737458', 'Andin', 17, '125130000', '03-12-2025', '14:45:00', 'dr. Fikri Ramadhan');

-- --------------------------------------------------------

--
-- Table structure for table `pol_resep_obat`
--

CREATE TABLE `pol_resep_obat` (
  `id` int UNSIGNED NOT NULL,
  `id_pol_resep` int DEFAULT NULL,
  `id_barang` int DEFAULT NULL,
  `id_barang_detail` varchar(255) DEFAULT NULL,
  `nama_barang` varchar(255) DEFAULT NULL,
  `id_satuan_barang` varchar(255) DEFAULT NULL,
  `satuan_barang` varchar(255) DEFAULT NULL,
  `urutan_satuan` varchar(255) DEFAULT NULL,
  `jumlah` varchar(255) DEFAULT NULL,
  `harga` varchar(255) DEFAULT NULL,
  `aturan_pakai` varchar(255) DEFAULT NULL,
  `sub_total_harga` varchar(255) DEFAULT NULL,
  `laba` varchar(255) DEFAULT NULL,
  `sub_total_laba` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pol_resep_obat`
--

INSERT INTO `pol_resep_obat` (`id`, `id_pol_resep`, `id_barang`, `id_barang_detail`, `nama_barang`, `id_satuan_barang`, `satuan_barang`, `urutan_satuan`, `jumlah`, `harga`, `aturan_pakai`, `sub_total_harga`, `laba`, `sub_total_laba`) VALUES
(70, 53, 6, '16', 'Vitamin B Complex', '1', 'Box', '1', '1', '19000', '', '19000', '5000', '5000'),
(71, 54, 6, '16', 'Vitamin B Complex', '1', 'Box', '1', '1', '19000', '', '19000', '5000', '5000'),
(72, 55, 30, '62', 'Diazepam 5mg', '2', 'Strip', '2', '1', '1800', '', '1800', '500', '500'),
(73, 56, 32, '67', 'CTM 4mg', '2', 'Strip', '2', '1', '2300', '2x sehari sampai obat habis', '2300', '700', '700'),
(75, 58, 18, '137', 'Amlodipine 3mg', '1', 'Box', '1', '2', '24000', '', '48000', '6000', '12000'),
(76, 59, 7, '19', 'Calcium D', '1', 'Box', '1', '1', '25000', '', '25000', '7000', '7000'),
(77, 60, 18, '137', 'Amlodipine 3mg', '1', 'Box', '1', '1', '24000', '', '24000', '6000', '6000'),
(78, 61, 30, '61', 'Diazepam 5mg', '1', 'Box', '1', '1', '18000', '-', '18000', '5000', '5000'),
(79, 62, 18, '137', 'Amlodipine 3mg', '1', 'Box', '1', '1', '24000', '-', '24000', '6000', '6000');

-- --------------------------------------------------------

--
-- Table structure for table `pol_resep_racikan`
--

CREATE TABLE `pol_resep_racikan` (
  `id` int UNSIGNED NOT NULL,
  `id_pol_resep` int DEFAULT NULL,
  `nama_racikan` varchar(255) DEFAULT NULL,
  `jumlah` varchar(255) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `harga` varchar(255) DEFAULT NULL,
  `sub_total_harga` varchar(255) DEFAULT NULL,
  `laba` varchar(255) DEFAULT NULL,
  `sub_total_laba` varchar(255) DEFAULT NULL,
  `aturan_pakai` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pol_resep_racikan`
--

INSERT INTO `pol_resep_racikan` (`id`, `id_pol_resep`, `nama_racikan`, `jumlah`, `keterangan`, `harga`, `sub_total_harga`, `laba`, `sub_total_laba`, `aturan_pakai`) VALUES
(60, 53, 'Pereda', '5', '-', '19500', '97500', '6500', '32500', 'Diminum 2x sehari'),
(61, 54, 'Racikan Ampuh', '2', '-', '530', '1060', '190', '380', '1x sehari'),
(62, 55, 'Penawar Sakit', '3', '-', '1800', '5400', '510', '1530', '1x sehari'),
(63, 56, 'Racikan A', '1', '-', '580', '580', '180', '180', 'Langung diminum hari ini semua'),
(65, 58, 'Racikan A', '5', '-', '620', '3100', '200', '1000', '-'),
(66, 59, 'Racikan b', '2', '-', '60000', '120000', '20000', '40000', '-'),
(67, 60, 'Racikan c', '5', '-', '60000', '300000', '16000', '80000', '-'),
(68, 61, 'Racikan d', '1', '-', '41000', '41000', '12000', '12000', '-'),
(69, 62, 'Racikan e', '3', '-', '32300000', '96900000', '9400000', '28200000', '-');

-- --------------------------------------------------------

--
-- Table structure for table `pol_resep_racikan_detail`
--

CREATE TABLE `pol_resep_racikan_detail` (
  `id` int UNSIGNED NOT NULL,
  `id_pol_resep_racikan` int DEFAULT NULL,
  `id_barang` int DEFAULT NULL,
  `id_barang_detail` varchar(255) DEFAULT NULL,
  `nama_barang` varchar(255) DEFAULT NULL,
  `id_satuan_barang` varchar(255) DEFAULT NULL,
  `satuan_barang` varchar(255) DEFAULT NULL,
  `urutan_satuan` varchar(255) DEFAULT NULL,
  `jumlah` varchar(255) DEFAULT NULL,
  `harga` varchar(255) DEFAULT NULL,
  `sub_total_harga` varchar(255) DEFAULT NULL,
  `laba` varchar(255) DEFAULT NULL,
  `sub_total_laba` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pol_resep_racikan_detail`
--

INSERT INTO `pol_resep_racikan_detail` (`id`, `id_pol_resep_racikan`, `id_barang`, `id_barang_detail`, `nama_barang`, `id_satuan_barang`, `satuan_barang`, `urutan_satuan`, `jumlah`, `harga`, `sub_total_harga`, `laba`, `sub_total_laba`) VALUES
(121, 60, 7, '20', 'Calcium D', '2', 'Strip', '2', '5', '2500', '12500', '700', '3500'),
(122, 60, 35, '76', 'Vitamin E 400IU', '2', 'Strip', '2', '5', '1400', '7000', '600', '3000'),
(123, 61, 7, '21', 'Calcium D', '3', 'Tablet', '3', '1', '250', '250', '70', '70'),
(124, 61, 35, '77', 'Vitamin E 400IU', '4', 'Kapsul', '3', '2', '140', '280', '60', '120'),
(125, 62, 6, '18', 'Vitamin B Complex', '3', 'Tablet', '3', '3', '190', '570', '50', '150'),
(126, 62, 30, '63', 'Diazepam 5mg', '3', 'Tablet', '3', '3', '180', '540', '50', '150'),
(127, 62, 36, '133', 'Antasida Tablet', '3', 'Tablet', '3', '3', '230', '690', '70', '210'),
(128, 63, 6, '18', 'Vitamin B Complex', '3', 'Tablet', '3', '1', '190', '190', '50', '50'),
(129, 63, 7, '21', 'Calcium D', '3', 'Tablet', '3', '1', '250', '250', '70', '70'),
(130, 63, 35, '77', 'Vitamin E 400IU', '4', 'Kapsul', '3', '1', '140', '140', '60', '60'),
(135, 65, 7, '21', 'Calcium D', '3', 'Tablet', '3', '1', '250', '250', '70', '70'),
(136, 65, 35, '77', 'Vitamin E 400IU', '4', 'Kapsul', '3', '1', '140', '140', '60', '60'),
(137, 65, 36, '133', 'Antasida Tablet', '3', 'Tablet', '3', '1', '230', '230', '70', '70'),
(138, 66, 35, '75', 'Vitamin E 400IU', '1', 'Box', '1', '1', '14000', '14000', '6000', '6000'),
(139, 66, 36, '131', 'Antasida Tablet', '1', 'Box', '1', '1', '23000', '23000', '7000', '7000'),
(140, 66, 32, '66', 'CTM 4mg', '1', 'Box', '1', '1', '23000', '23000', '7000', '7000'),
(141, 67, 36, '131', 'Antasida Tablet', '1', 'Box', '1', '1', '23000', '23000', '7000', '7000'),
(142, 67, 14, '37', 'Hansaplast', '1', 'Box', '1', '1', '18000', '18000', '4000', '4000'),
(143, 67, 6, '16', 'Vitamin B Complex', '1', 'Box', '1', '1', '19000', '19000', '5000', '5000'),
(144, 68, 30, '61', 'Diazepam 5mg', '1', 'Box', '1', '1', '18000', '18000', '5000', '5000'),
(145, 68, 36, '131', 'Antasida Tablet', '1', 'Box', '1', '1', '23000', '23000', '7000', '7000'),
(146, 69, 32, '66', 'CTM 4mg', '1', 'Box', '1', '700', '23000', '16100000', '7000', '4900000'),
(147, 69, 30, '61', 'Diazepam 5mg', '1', 'Box', '1', '900', '18000', '16200000', '5000', '4500000');

-- --------------------------------------------------------

--
-- Table structure for table `pol_umum`
--

CREATE TABLE `pol_umum` (
  `id` int UNSIGNED NOT NULL,
  `kode_invoice` varchar(225) DEFAULT NULL,
  `id_pasien` int DEFAULT NULL,
  `nik` varchar(225) DEFAULT NULL,
  `nama_pasien` varchar(255) DEFAULT NULL,
  `id_dokter` int DEFAULT NULL,
  `nama_dokter` varchar(225) DEFAULT NULL,
  `keluhan` varchar(225) DEFAULT NULL,
  `tekanan_darah` varchar(225) DEFAULT NULL,
  `suhu` varchar(225) DEFAULT NULL,
  `nadi` varchar(225) DEFAULT NULL,
  `catatan` varchar(225) DEFAULT NULL,
  `tanggal` varchar(225) DEFAULT NULL,
  `waktu` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pol_umum_diagnosa`
--

CREATE TABLE `pol_umum_diagnosa` (
  `id` int UNSIGNED NOT NULL,
  `id_pol_umum` int DEFAULT NULL,
  `id_diagnosa` int DEFAULT NULL,
  `diagnosa` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pol_umum_tindakan`
--

CREATE TABLE `pol_umum_tindakan` (
  `id` int UNSIGNED NOT NULL,
  `id_pol_umum` int DEFAULT NULL,
  `id_tindakan` int DEFAULT NULL,
  `tindakan` varchar(255) DEFAULT NULL,
  `harga` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rsp_antrian`
--

CREATE TABLE `rsp_antrian` (
  `id` int UNSIGNED NOT NULL,
  `id_registrasi` int DEFAULT NULL,
  `id_pasien` int DEFAULT NULL,
  `id_dokter` int DEFAULT NULL,
  `kode_invoice` varchar(255) DEFAULT NULL,
  `no_antrian` varchar(50) DEFAULT NULL,
  `id_poli` int DEFAULT NULL,
  `nama_poli` varchar(255) DEFAULT NULL,
  `tanggal_antri` varchar(255) DEFAULT NULL,
  `waktu_antri` varchar(255) DEFAULT NULL,
  `tanggal_dipanggil` varchar(255) DEFAULT NULL,
  `waktu_dipanggil` varchar(255) DEFAULT NULL,
  `lama_menunggu` varchar(255) DEFAULT NULL,
  `status_antrian` varchar(255) DEFAULT NULL,
  `tanggal` varchar(255) DEFAULT NULL,
  `waktu` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `rsp_antrian`
--

INSERT INTO `rsp_antrian` (`id`, `id_registrasi`, `id_pasien`, `id_dokter`, `kode_invoice`, `no_antrian`, `id_poli`, `nama_poli`, `tanggal_antri`, `waktu_antri`, `tanggal_dipanggil`, `waktu_dipanggil`, `lama_menunggu`, `status_antrian`, `tanggal`, `waktu`) VALUES
(130, 142, 66, 43, 'KI291125-001', 'POG-001', 4, 'Poli Gigi', '29-11-2025', '09:15:53', '29-11-2025', '09:16:13', '00:00:20', 'Dikonfirmasi', '29-11-2025', '09:15:53'),
(131, 143, 67, 17, 'KI291125-002', 'POG-002', 4, 'Poli Gigi', '29-11-2025', '09:16:03', '29-11-2025', '09:24:39', '00:08:36', 'Dikonfirmasi', '29-11-2025', '09:16:03'),
(132, 144, 61, 45, 'KI291125-003', 'POU-001', 17, 'Poli Umum', '29-11-2025', '09:23:05', '29-11-2025', '09:23:40', '00:00:35', 'Dikonfirmasi', '29-11-2025', '09:23:05'),
(133, 145, 46, 17, 'KI291125-004', 'POG-003', 4, 'Poli Gigi', '29-11-2025', '09:49:59', '29-11-2025', '09:50:08', '00:00:09', 'Dikonfirmasi', '29-11-2025', '09:49:59'),
(134, 146, 52, 17, 'KI021225-001', 'POG-001', 4, 'Poli Gigi', '02-12-2025', '15:22:53', '02-12-2025', '15:23:12', '00:00:19', 'Dikonfirmasi', '02-12-2025', '15:22:53'),
(135, 147, 74, 17, 'KI031225-001', 'POG-001', 4, 'Poli Gigi', '03-12-2025', '13:29:11', '03-12-2025', '13:30:40', '00:01:29', 'Dikonfirmasi', '03-12-2025', '13:29:11'),
(136, 148, 50, 17, 'KI031225-002', 'POG-002', 4, 'Poli Gigi', '03-12-2025', '13:29:30', '03-12-2025', '13:32:46', '00:03:16', 'Dikonfirmasi', '03-12-2025', '13:29:30'),
(137, 149, 75, 17, 'KI031225-003', 'POG-003', 4, 'Poli Gigi', '03-12-2025', '13:30:24', '03-12-2025', '13:56:48', '00:26:24', 'Dikonfirmasi', '03-12-2025', '13:30:24'),
(138, 150, 36, 17, 'KI031225-004', 'POG-004', 4, 'Poli Gigi', '03-12-2025', '14:38:57', '03-12-2025', '14:40:02', '00:01:05', 'Dikonfirmasi', '03-12-2025', '14:38:57'),
(139, 151, 35, 17, 'KI031225-005', 'POG-005', 4, 'Poli Gigi', '03-12-2025', '14:39:10', '03-12-2025', '14:41:27', '00:02:17', 'Dikonfirmasi', '03-12-2025', '14:39:10'),
(140, 152, 31, 17, 'KI031225-006', 'POG-006', 4, 'Poli Gigi', '03-12-2025', '14:39:21', '03-12-2025', '14:42:12', '00:02:51', 'Dikonfirmasi', '03-12-2025', '14:39:21'),
(141, 153, 39, 17, 'KI031225-007', 'POG-007', 4, 'Poli Gigi', '03-12-2025', '14:39:36', '03-12-2025', '14:42:59', '00:03:23', 'Dikonfirmasi', '03-12-2025', '14:39:36'),
(142, 154, 43, 17, 'KI031225-008', 'POG-008', 4, 'Poli Gigi', '03-12-2025', '14:39:52', '03-12-2025', '14:43:51', '00:03:59', 'Dikonfirmasi', '03-12-2025', '14:39:52'),
(143, 155, 52, 44, 'KI031225-009', 'POG-009', 4, 'Poli Gigi', '03-12-2025', '18:09:17', '03-12-2025', '18:10:57', '00:01:40', 'Dikonfirmasi', '03-12-2025', '18:09:17'),
(144, 156, 59, 44, 'KI031225-010', 'POG-010', 4, 'Poli Gigi', '03-12-2025', '18:09:48', NULL, NULL, NULL, 'Menunggu', '03-12-2025', '18:09:48'),
(145, 157, 61, 44, 'KI031225-011', 'POG-011', 4, 'Poli Gigi', '03-12-2025', '18:10:00', NULL, NULL, NULL, 'Menunggu', '03-12-2025', '18:10:00');

-- --------------------------------------------------------

--
-- Table structure for table `rsp_booking`
--

CREATE TABLE `rsp_booking` (
  `id` int UNSIGNED NOT NULL,
  `id_pasien` int DEFAULT NULL,
  `nik` varchar(255) DEFAULT NULL,
  `nama_pasien` varchar(255) DEFAULT NULL,
  `id_poli` int DEFAULT NULL,
  `nama_poli` varchar(255) DEFAULT NULL,
  `id_dokter` int DEFAULT NULL,
  `nama_dokter` varchar(255) DEFAULT NULL,
  `kode_booking` varchar(255) DEFAULT NULL,
  `tanggal_booking` varchar(255) DEFAULT NULL,
  `waktu_booking` varchar(255) DEFAULT NULL,
  `tanggal` varchar(255) DEFAULT NULL,
  `waktu` varchar(255) DEFAULT NULL,
  `status_booking` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `rsp_booking`
--

INSERT INTO `rsp_booking` (`id`, `id_pasien`, `nik`, `nama_pasien`, `id_poli`, `nama_poli`, `id_dokter`, `nama_dokter`, `kode_booking`, `tanggal_booking`, `waktu_booking`, `tanggal`, `waktu`, `status_booking`) VALUES
(119, 67, '8918276354672893', 'Qwen', 4, 'Poli Gigi', 17, 'dr. Fikri Ramadhan', 'KB291125-001', '29-11-2025', '09:15:34', '29-11-2025', '12:00', 'Disetujui'),
(120, 74, '8475872273642637', 'Fitria', 4, 'Poli Gigi', 17, 'dr. Fikri Ramadhan', 'KB031225-001', '03-12-2025', '13:28:29', '03-12-2025', '14:00', 'Disetujui'),
(121, 52, '8209817468026783', 'Handy', 4, 'Poli Gigi', 44, 'dr. Ahmad', 'KB031225-002', '03-12-2025', '18:09:00', '03-12-2025', '19:00', 'Disetujui');

-- --------------------------------------------------------

--
-- Table structure for table `rsp_jadwal_dokter`
--

CREATE TABLE `rsp_jadwal_dokter` (
  `id` int UNSIGNED NOT NULL,
  `id_pegawai` int DEFAULT NULL,
  `nama_pegawai` varchar(150) DEFAULT NULL,
  `hari` varchar(50) DEFAULT NULL,
  `jam_mulai` varchar(50) DEFAULT NULL,
  `jam_selesai` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `rsp_jadwal_dokter`
--

INSERT INTO `rsp_jadwal_dokter` (`id`, `id_pegawai`, `nama_pegawai`, `hari`, `jam_mulai`, `jam_selesai`) VALUES
(55, 9, 'Adolf Hitler Nasution', 'Senin', '12:00:00', '11:25:00'),
(59, 9, 'Adolf Hitler Nasution', 'Selasa', '17:00:01', '20:00:04'),
(61, 11, 'dr. Fikri Ramadhan', 'Senin', '06:00:00', '16:00:00'),
(62, 11, 'dr. Fikri Ramadhan', 'Selasa', '08:00:00', '16:00:00'),
(63, 11, 'dr. Fikri Ramadhan', 'Rabu', '07:00:00', '16:00:00'),
(64, 11, 'dr. Fikri Ramadhan', 'Kamis', '08:00:00', '16:00:00'),
(65, 11, 'dr. Fikri Ramadhan', 'Jumat', '08:00:00', '16:00:00'),
(66, 11, 'dr. Fikri Ramadhan', 'Sabtu', '07:00:00', '15:00:00'),
(67, 11, 'dr. Fikri Ramadhan', 'Minggu', '07:00:00', '15:00:00'),
(68, 10, 'dr. Ahmad', 'Senin', '16:00:00', '22:00:00'),
(69, 10, 'dr. Ahmad', 'Selasa', '16:00:00', '22:00:00'),
(70, 10, 'dr. Ahmad', 'Rabu', '16:00:00', '22:00:00'),
(71, 10, 'dr. Ahmad', 'Kamis', '16:00:00', '22:00:00'),
(72, 10, 'dr. Ahmad', 'Jumat', '15:00:00', '22:00:00'),
(73, 10, 'dr. Ahmad', 'Sabtu', '15:00:00', '22:00:00'),
(74, 10, 'dr. Ahmad', 'Minggu', '15:00:00', '22:00:00'),
(75, 12, 'dr. Husein', 'Senin', '08:00:00', '19:00:00'),
(76, 12, 'dr. Husein', 'Selasa', '07:00:00', '19:00:00'),
(77, 12, 'dr. Husein', 'Rabu', '07:00:00', '19:00:00'),
(78, 12, 'dr. Husein', 'Kamis', '08:00:00', '19:00:00'),
(79, 7, 'Abidin Sari S.Pd', 'Senin', '22:00:00', '08:00:00'),
(80, 7, 'Abidin Sari S.Pd', 'Selasa', '22:00:00', '08:00:00'),
(81, 7, 'Abidin Sari S.Pd', 'Rabu', '22:00:00', '08:00:00'),
(82, 7, 'Abidin Sari S.Pd', 'Kamis', '22:00:00', '08:00:00'),
(83, 7, 'Abidin Sari S.Pd', 'Jumat', '22:00:00', '07:00:00'),
(84, 7, 'Abidin Sari S.Pd', 'Sabtu', '22:00:00', '07:00:00'),
(85, 7, 'Abidin Sari S.Pd', 'Minggu', '22:00:00', '07:00:00'),
(86, 13, 'dr. Abdul', 'Senin', '06:00:00', '16:00:00'),
(87, 13, 'dr. Abdul', 'Selasa', '06:00:00', '16:00:00'),
(88, 13, 'dr. Abdul', 'Rabu', '06:00:00', '16:00:00'),
(89, 13, 'dr. Abdul', 'Kamis', '06:00:00', '16:00:00'),
(90, 13, 'dr. Abdul', 'Jumat', '06:00:00', '16:00:00'),
(91, 13, 'dr. Abdul', 'Sabtu', '07:00:00', '15:00:00'),
(92, 13, 'dr. Abdul', 'Minggu', '07:00:00', '15:00:00'),
(110, 27, 'dr. Ikram', 'Senin', '07:00:00', '15:00:00'),
(111, 27, 'dr. Ikram', 'Selasa', '07:00:00', '15:00:00'),
(112, 27, 'dr. Ikram', 'Rabu', '07:00:00', '15:00:00'),
(113, 27, 'dr. Ikram', 'Kamis', '07:00:00', '15:00:00'),
(114, 27, 'dr. Ikram', 'Jumat', '07:00:00', '15:00:00'),
(115, 27, 'dr. Ikram', 'Sabtu', '07:00:00', '15:00:00'),
(116, 27, 'dr. Ikram', 'Minggu', '07:00:00', '15:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `rsp_jenis_biaya`
--

CREATE TABLE `rsp_jenis_biaya` (
  `id` int NOT NULL,
  `nama` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rsp_jenis_biaya`
--

INSERT INTO `rsp_jenis_biaya` (`id`, `nama`) VALUES
(3, 'Biaya Distribusi'),
(5, 'Biaya Pembelanjaan'),
(6, 'Biaya Pendanaan'),
(7, 'Biaya Pengolahan'),
(8, 'Gaji Pekerja Klinik');

-- --------------------------------------------------------

--
-- Table structure for table `rsp_pemasukan`
--

CREATE TABLE `rsp_pemasukan` (
  `id` int NOT NULL,
  `id_user` varchar(255) DEFAULT NULL,
  `nama_user` varchar(255) DEFAULT NULL,
  `id_jenis_biaya` varchar(255) DEFAULT NULL,
  `nama_jenis_biaya` varchar(255) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `nominal` varchar(255) DEFAULT NULL,
  `tanggal` varchar(255) DEFAULT NULL,
  `waktu` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rsp_pemasukan`
--

INSERT INTO `rsp_pemasukan` (`id`, `id_user`, `nama_user`, `id_jenis_biaya`, `nama_jenis_biaya`, `keterangan`, `nominal`, `tanggal`, `waktu`) VALUES
(6, NULL, NULL, '6', 'Biaya Pendanaan', 'Pendanaan Klinik dari Pemerintah Daerah', '6500000000', '23-08-2025', '03:07:41');

-- --------------------------------------------------------

--
-- Table structure for table `rsp_pembayaran`
--

CREATE TABLE `rsp_pembayaran` (
  `id` int NOT NULL,
  `kode_invoice` varchar(255) DEFAULT NULL,
  `id_pasien` varchar(255) DEFAULT NULL,
  `nik` varchar(255) DEFAULT NULL,
  `nama_pasien` varchar(255) DEFAULT NULL,
  `id_dokter` varchar(255) DEFAULT NULL,
  `nama_dokter` varchar(255) DEFAULT NULL,
  `id_user` varchar(255) DEFAULT NULL,
  `nama_user` varchar(255) DEFAULT NULL,
  `biaya_tindakan` varchar(255) DEFAULT NULL,
  `biaya_resep` varchar(255) DEFAULT NULL,
  `total_invoice` varchar(255) DEFAULT NULL,
  `metode_pembayaran` varchar(255) DEFAULT NULL,
  `bank` varchar(255) DEFAULT NULL,
  `bayar` varchar(255) DEFAULT NULL,
  `kembali` varchar(255) DEFAULT NULL,
  `tanggal` varchar(255) DEFAULT NULL,
  `waktu` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rsp_pembayaran`
--

INSERT INTO `rsp_pembayaran` (`id`, `kode_invoice`, `id_pasien`, `nik`, `nama_pasien`, `id_dokter`, `nama_dokter`, `id_user`, `nama_user`, `biaya_tindakan`, `biaya_resep`, `total_invoice`, `metode_pembayaran`, `bank`, `bayar`, `kembali`, `tanggal`, `waktu`) VALUES
(36, 'KI291125-001', '66', '1111333355557777', 'Joy', '43', 'dr. Abdul', NULL, NULL, '1250000', '107000', '1357000', 'Transfer Bank', 'Mandiri', '1300000', '50000', '29-11-2025', '09:19:35'),
(37, 'KI291125-004', '46', '8467485789376475', 'Gibran', '17', 'dr. Fikri Ramadhan', NULL, NULL, '2350000', '154000', '2504000', NULL, NULL, NULL, NULL, NULL, NULL),
(38, 'KI021225-001', '52', '8209817468026783', 'Handy', '17', 'dr. Fikri Ramadhan', NULL, NULL, '2500000', '25440', '2525440', NULL, NULL, NULL, NULL, NULL, NULL),
(39, 'KI031225-001', '74', '8475872273642637', 'Fitria', '17', 'dr. Fikri Ramadhan', NULL, NULL, '998000', '9230', '1007230', NULL, NULL, NULL, NULL, NULL, NULL),
(40, 'KI031225-002', '50', '8376467298374659', 'Maria', '17', 'dr. Fikri Ramadhan', NULL, NULL, '5600000', '3760', '5603760', 'Transfer Bank', 'BCA', '5600000', '0', '03-12-2025', '13:37:50'),
(41, 'KI031225-003', '75', '9302328323920428', 'Dini', '17', 'dr. Fikri Ramadhan', NULL, NULL, '12230000', '37200', '12267200', 'Cash', '', '12300000', '70000', '03-12-2025', '13:37:19'),
(42, 'KI031225-004', '36', '8947589374657893', 'Adi', '17', 'dr. Fikri Ramadhan', NULL, NULL, '1700000', '64100', '1764100', NULL, NULL, NULL, NULL, NULL, NULL),
(43, 'KI031225-005', '35', '1893678495867849', 'Afif', '17', 'dr. Fikri Ramadhan', NULL, NULL, '1500000', '192000', '1692000', NULL, NULL, NULL, NULL, NULL, NULL),
(44, 'KI031225-006', '31', '2093784985789304', 'Angelyn', '17', 'dr. Fikri Ramadhan', NULL, NULL, '1675000', '410000', '2085000', NULL, NULL, NULL, NULL, NULL, NULL),
(45, 'KI031225-007', '39', '9749758679837485', 'Violita', '17', 'dr. Fikri Ramadhan', NULL, NULL, '1500000', '76000', '1576000', NULL, NULL, NULL, NULL, NULL, NULL),
(46, 'KI031225-008', '43', '37489578928737458', 'Andin', '17', 'dr. Fikri Ramadhan', NULL, NULL, '2300000', '125130000', '127430000', 'Cash', '', '2300000', '0', '03-12-2025', '18:05:01');

-- --------------------------------------------------------

--
-- Table structure for table `rsp_pengeluaran`
--

CREATE TABLE `rsp_pengeluaran` (
  `id` int NOT NULL,
  `id_user` varchar(255) DEFAULT NULL,
  `nama_user` varchar(255) DEFAULT NULL,
  `id_jenis_biaya` varchar(255) DEFAULT NULL,
  `nama_jenis_biaya` varchar(255) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `nominal` varchar(255) DEFAULT NULL,
  `tanggal` varchar(255) DEFAULT NULL,
  `waktu` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rsp_pengeluaran`
--

INSERT INTO `rsp_pengeluaran` (`id`, `id_user`, `nama_user`, `id_jenis_biaya`, `nama_jenis_biaya`, `keterangan`, `nominal`, `tanggal`, `waktu`) VALUES
(2, NULL, NULL, '5', 'Biaya Pembelanjaan', 'Penyetokan APD', '100000000', '23-08-2025', '03:25:52'),
(3, NULL, NULL, '8', 'Gaji Pekerja Klinik', 'Gaji bulanan', '100000000', '15-09-2025', '07:26:32');

-- --------------------------------------------------------

--
-- Table structure for table `rsp_registrasi`
--

CREATE TABLE `rsp_registrasi` (
  `id` int UNSIGNED NOT NULL,
  `kode_invoice` varchar(255) DEFAULT NULL,
  `id_poli` int DEFAULT NULL,
  `nama_poli` varchar(255) DEFAULT NULL,
  `id_dokter` int DEFAULT NULL,
  `nama_dokter` varchar(255) DEFAULT NULL,
  `id_pasien` int DEFAULT NULL,
  `nik` varchar(255) DEFAULT NULL,
  `nama_pasien` varchar(255) DEFAULT NULL,
  `tanggal` varchar(100) DEFAULT NULL,
  `waktu` varchar(50) DEFAULT NULL,
  `status_registrasi` varchar(50) DEFAULT NULL,
  `id_booking` int DEFAULT NULL,
  `kode_booking` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `rsp_registrasi`
--

INSERT INTO `rsp_registrasi` (`id`, `kode_invoice`, `id_poli`, `nama_poli`, `id_dokter`, `nama_dokter`, `id_pasien`, `nik`, `nama_pasien`, `tanggal`, `waktu`, `status_registrasi`, `id_booking`, `kode_booking`) VALUES
(142, 'KI291125-001', 4, 'Poli Gigi', 43, 'dr. Abdul', 66, '1111333355557777', 'Joy', '29-11-2025', '09:15:52', 'Sukses', NULL, NULL),
(143, 'KI291125-002', 4, 'Poli Gigi', 17, 'dr. Fikri Ramadhan', 67, '8918276354672893', 'Qwen', '29-11-2025', '09:16:03', 'Sukses', 119, 'KB291125-001'),
(144, 'KI291125-003', 17, 'Poli Umum', 45, 'dr. Ikram', 61, '3546789567845673', 'Caca', '29-11-2025', '09:23:05', 'Sukses', NULL, NULL),
(145, 'KI291125-004', 4, 'Poli Gigi', 17, 'dr. Fikri Ramadhan', 46, '8467485789376475', 'Gibran', '29-11-2025', '09:49:59', 'Sukses', NULL, NULL),
(146, 'KI021225-001', 4, 'Poli Gigi', 17, 'dr. Fikri Ramadhan', 52, '8209817468026783', 'Handy', '02-12-2025', '15:22:53', 'Sukses', NULL, NULL),
(147, 'KI031225-001', 4, 'Poli Gigi', 17, 'dr. Fikri Ramadhan', 74, '8475872273642637', 'Fitria', '03-12-2025', '13:29:11', 'Sukses', 120, 'KB031225-001'),
(148, 'KI031225-002', 4, 'Poli Gigi', 17, 'dr. Fikri Ramadhan', 50, '8376467298374659', 'Maria', '03-12-2025', '13:29:30', 'Sukses', NULL, NULL),
(149, 'KI031225-003', 4, 'Poli Gigi', 17, 'dr. Fikri Ramadhan', 75, '9302328323920428', 'Dini', '03-12-2025', '13:30:24', 'Sukses', NULL, NULL),
(150, 'KI031225-004', 4, 'Poli Gigi', 17, 'dr. Fikri Ramadhan', 36, '8947589374657893', 'Adi', '03-12-2025', '14:38:57', 'Sukses', NULL, NULL),
(151, 'KI031225-005', 4, 'Poli Gigi', 17, 'dr. Fikri Ramadhan', 35, '1893678495867849', 'Afif', '03-12-2025', '14:39:10', 'Sukses', NULL, NULL),
(152, 'KI031225-006', 4, 'Poli Gigi', 17, 'dr. Fikri Ramadhan', 31, '2093784985789304', 'Angelyn', '03-12-2025', '14:39:21', 'Sukses', NULL, NULL),
(153, 'KI031225-007', 4, 'Poli Gigi', 17, 'dr. Fikri Ramadhan', 39, '9749758679837485', 'Violita', '03-12-2025', '14:39:36', 'Sukses', NULL, NULL),
(154, 'KI031225-008', 4, 'Poli Gigi', 17, 'dr. Fikri Ramadhan', 43, '37489578928737458', 'Andin', '03-12-2025', '14:39:52', 'Sukses', NULL, NULL),
(155, 'KI031225-009', 4, 'Poli Gigi', 44, 'dr. Ahmad', 52, '8209817468026783', 'Handy', '03-12-2025', '18:09:17', 'Sukses', 121, 'KB031225-002'),
(156, 'KI031225-010', 4, 'Poli Gigi', 44, 'dr. Ahmad', 59, '8291765639827367', 'Noelle', '03-12-2025', '18:09:48', 'Sukses', NULL, NULL),
(157, 'KI031225-011', 4, 'Poli Gigi', 44, 'dr. Ahmad', 61, '3546789567845673', 'Caca', '03-12-2025', '18:10:00', 'Sukses', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adm_grup_hak_akses`
--
ALTER TABLE `adm_grup_hak_akses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `adm_hak_akses`
--
ALTER TABLE `adm_hak_akses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `adm_level`
--
ALTER TABLE `adm_level`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `adm_level_akses`
--
ALTER TABLE `adm_level_akses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `adm_user`
--
ALTER TABLE `adm_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `apt_barang`
--
ALTER TABLE `apt_barang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_apt_barang_id_jenis_barang` (`id_jenis_barang`);

--
-- Indexes for table `apt_barang_detail`
--
ALTER TABLE `apt_barang_detail`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `fk_apt_barang_detail_id_barang` (`id_barang`),
  ADD KEY `fk_apt_barang_detail_id_satuan_barang` (`id_satuan_barang`);

--
-- Indexes for table `apt_jenis_barang`
--
ALTER TABLE `apt_jenis_barang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `apt_satuan_barang`
--
ALTER TABLE `apt_satuan_barang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `apt_stok`
--
ALTER TABLE `apt_stok`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_apt_stok_id_barang` (`id_barang`),
  ADD KEY `fk_apt_stok_id_barang_detail` (`id_barang_detail`);

--
-- Indexes for table `contoh`
--
ALTER TABLE `contoh`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contoh_multiple`
--
ALTER TABLE `contoh_multiple`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contoh_multiple_detail`
--
ALTER TABLE `contoh_multiple_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kpg_dokter`
--
ALTER TABLE `kpg_dokter`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kpg_jabatan`
--
ALTER TABLE `kpg_jabatan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kpg_pegawai`
--
ALTER TABLE `kpg_pegawai`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mst_diagnosa`
--
ALTER TABLE `mst_diagnosa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mst_pasien`
--
ALTER TABLE `mst_pasien`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `mst_poli`
--
ALTER TABLE `mst_poli`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mst_tindakan`
--
ALTER TABLE `mst_tindakan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pol_anak`
--
ALTER TABLE `pol_anak`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pol_anak_diagnosa`
--
ALTER TABLE `pol_anak_diagnosa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pol_anak_tindakan`
--
ALTER TABLE `pol_anak_tindakan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pol_gigi`
--
ALTER TABLE `pol_gigi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pol_gigi_diagnosa`
--
ALTER TABLE `pol_gigi_diagnosa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pol_gigi_tindakan`
--
ALTER TABLE `pol_gigi_tindakan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pol_kecantikan`
--
ALTER TABLE `pol_kecantikan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pol_kecantikan_detail`
--
ALTER TABLE `pol_kecantikan_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pol_kecantikan_diagnosa`
--
ALTER TABLE `pol_kecantikan_diagnosa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pol_kecantikan_tindakan`
--
ALTER TABLE `pol_kecantikan_tindakan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pol_resep`
--
ALTER TABLE `pol_resep`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pol_resep_obat`
--
ALTER TABLE `pol_resep_obat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pol_resep_racikan`
--
ALTER TABLE `pol_resep_racikan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pol_resep_racikan_detail`
--
ALTER TABLE `pol_resep_racikan_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pol_umum`
--
ALTER TABLE `pol_umum`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pol_umum_diagnosa`
--
ALTER TABLE `pol_umum_diagnosa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pol_umum_tindakan`
--
ALTER TABLE `pol_umum_tindakan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rsp_antrian`
--
ALTER TABLE `rsp_antrian`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rsp_booking`
--
ALTER TABLE `rsp_booking`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rsp_jadwal_dokter`
--
ALTER TABLE `rsp_jadwal_dokter`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rsp_jenis_biaya`
--
ALTER TABLE `rsp_jenis_biaya`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `rsp_pemasukan`
--
ALTER TABLE `rsp_pemasukan`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `rsp_pembayaran`
--
ALTER TABLE `rsp_pembayaran`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `rsp_pengeluaran`
--
ALTER TABLE `rsp_pengeluaran`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `rsp_registrasi`
--
ALTER TABLE `rsp_registrasi`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adm_grup_hak_akses`
--
ALTER TABLE `adm_grup_hak_akses`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `adm_hak_akses`
--
ALTER TABLE `adm_hak_akses`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `adm_level`
--
ALTER TABLE `adm_level`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `adm_level_akses`
--
ALTER TABLE `adm_level_akses`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;

--
-- AUTO_INCREMENT for table `adm_user`
--
ALTER TABLE `adm_user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `apt_barang`
--
ALTER TABLE `apt_barang`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `apt_barang_detail`
--
ALTER TABLE `apt_barang_detail`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=149;

--
-- AUTO_INCREMENT for table `apt_jenis_barang`
--
ALTER TABLE `apt_jenis_barang`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `apt_satuan_barang`
--
ALTER TABLE `apt_satuan_barang`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `apt_stok`
--
ALTER TABLE `apt_stok`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=227;

--
-- AUTO_INCREMENT for table `contoh`
--
ALTER TABLE `contoh`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `contoh_multiple`
--
ALTER TABLE `contoh_multiple`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `contoh_multiple_detail`
--
ALTER TABLE `contoh_multiple_detail`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `kpg_dokter`
--
ALTER TABLE `kpg_dokter`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `kpg_jabatan`
--
ALTER TABLE `kpg_jabatan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `kpg_pegawai`
--
ALTER TABLE `kpg_pegawai`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `mst_diagnosa`
--
ALTER TABLE `mst_diagnosa`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `mst_pasien`
--
ALTER TABLE `mst_pasien`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `mst_poli`
--
ALTER TABLE `mst_poli`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `mst_tindakan`
--
ALTER TABLE `mst_tindakan`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `pol_anak`
--
ALTER TABLE `pol_anak`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pol_anak_diagnosa`
--
ALTER TABLE `pol_anak_diagnosa`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pol_anak_tindakan`
--
ALTER TABLE `pol_anak_tindakan`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pol_gigi`
--
ALTER TABLE `pol_gigi`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `pol_gigi_diagnosa`
--
ALTER TABLE `pol_gigi_diagnosa`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT for table `pol_gigi_tindakan`
--
ALTER TABLE `pol_gigi_tindakan`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT for table `pol_kecantikan`
--
ALTER TABLE `pol_kecantikan`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pol_kecantikan_detail`
--
ALTER TABLE `pol_kecantikan_detail`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pol_kecantikan_diagnosa`
--
ALTER TABLE `pol_kecantikan_diagnosa`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pol_kecantikan_tindakan`
--
ALTER TABLE `pol_kecantikan_tindakan`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pol_resep`
--
ALTER TABLE `pol_resep`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `pol_resep_obat`
--
ALTER TABLE `pol_resep_obat`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `pol_resep_racikan`
--
ALTER TABLE `pol_resep_racikan`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `pol_resep_racikan_detail`
--
ALTER TABLE `pol_resep_racikan_detail`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=148;

--
-- AUTO_INCREMENT for table `pol_umum`
--
ALTER TABLE `pol_umum`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pol_umum_diagnosa`
--
ALTER TABLE `pol_umum_diagnosa`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pol_umum_tindakan`
--
ALTER TABLE `pol_umum_tindakan`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rsp_antrian`
--
ALTER TABLE `rsp_antrian`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=146;

--
-- AUTO_INCREMENT for table `rsp_booking`
--
ALTER TABLE `rsp_booking`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT for table `rsp_jadwal_dokter`
--
ALTER TABLE `rsp_jadwal_dokter`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;

--
-- AUTO_INCREMENT for table `rsp_jenis_biaya`
--
ALTER TABLE `rsp_jenis_biaya`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `rsp_pemasukan`
--
ALTER TABLE `rsp_pemasukan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `rsp_pembayaran`
--
ALTER TABLE `rsp_pembayaran`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `rsp_pengeluaran`
--
ALTER TABLE `rsp_pengeluaran`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `rsp_registrasi`
--
ALTER TABLE `rsp_registrasi`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=158;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `apt_barang`
--
ALTER TABLE `apt_barang`
  ADD CONSTRAINT `fk_apt_barang_id_jenis_barang` FOREIGN KEY (`id_jenis_barang`) REFERENCES `apt_jenis_barang` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `apt_barang_detail`
--
ALTER TABLE `apt_barang_detail`
  ADD CONSTRAINT `fk_apt_barang_detail_id_barang` FOREIGN KEY (`id_barang`) REFERENCES `apt_barang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_apt_barang_detail_id_satuan_barang` FOREIGN KEY (`id_satuan_barang`) REFERENCES `apt_satuan_barang` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `apt_stok`
--
ALTER TABLE `apt_stok`
  ADD CONSTRAINT `fk_apt_stok_id_barang` FOREIGN KEY (`id_barang`) REFERENCES `apt_barang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_apt_stok_id_barang_detail` FOREIGN KEY (`id_barang_detail`) REFERENCES `apt_barang_detail` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
