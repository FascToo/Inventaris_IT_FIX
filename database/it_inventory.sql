-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 23, 2025 at 11:24 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `it_inventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `inventaris`
--

CREATE TABLE `inventaris` (
  `id` int(11) NOT NULL,
  `kode_barang` varchar(50) DEFAULT NULL,
  `nama_barang` varchar(100) DEFAULT NULL,
  `jenis_barang` varchar(100) DEFAULT NULL,
  `merk_barang` varchar(100) DEFAULT NULL,
  `kondisi_barang` varchar(50) DEFAULT NULL,
  `spesifikasi_barang` text DEFAULT NULL,
  `foto_barang` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventaris`
--

INSERT INTO `inventaris` (`id`, `kode_barang`, `nama_barang`, `jenis_barang`, `merk_barang`, `kondisi_barang`, `spesifikasi_barang`, `foto_barang`) VALUES
(2, 'LTP/9157', 'Laptop Lenovo', 'Laptop', 'Lenovo', 'Baik', 'Processor : i7-2716\r\nRAM : 8GB\r\nSSD : 1TB', 'dell.jpg'),
(3, 'LTP/91123', 'Laptop Acer', 'Laptop', 'Acer', 'Baik', 'Processor I7-1736\r\nRAM 8 GB\r\nSSD 1TB', ''),
(4, 'LTP/91156', 'Laptop Lenovo', 'Laptop', 'Lenovo', 'Baik', 'wdaaw', '');

-- --------------------------------------------------------

--
-- Table structure for table `jenis_perangkat`
--

CREATE TABLE `jenis_perangkat` (
  `id_jenis` int(11) NOT NULL,
  `nama_jenis` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jenis_perangkat`
--

INSERT INTO `jenis_perangkat` (`id_jenis`, `nama_jenis`) VALUES
(1, 'Laptop'),
(2, 'PC'),
(3, 'Printer'),
(4, 'Scanner'),
(5, 'Access Point'),
(6, 'Router'),
(7, 'Switch'),
(8, 'Monitor');

-- --------------------------------------------------------

--
-- Table structure for table `kategori_stok`
--

CREATE TABLE `kategori_stok` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori_stok`
--

INSERT INTO `kategori_stok` (`id_kategori`, `nama_kategori`) VALUES
(1, 'RAM'),
(2, 'Harddisk'),
(3, 'SSD'),
(4, 'Keyboard'),
(5, 'Mouse'),
(6, 'Monitor'),
(7, 'Kabel LAN'),
(8, 'Power Supply');

-- --------------------------------------------------------

--
-- Table structure for table `maintenance`
--

CREATE TABLE `maintenance` (
  `id` int(11) NOT NULL,
  `id_pengaduan` int(11) DEFAULT NULL,
  `kode_barang` varchar(50) DEFAULT NULL,
  `tanggal_maintenance` date DEFAULT curdate(),
  `masalah` text DEFAULT NULL,
  `solusi` text DEFAULT NULL,
  `teknisi` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `maintenance`
--

INSERT INTO `maintenance` (`id`, `id_pengaduan`, `kode_barang`, `tanggal_maintenance`, `masalah`, `solusi`, `teknisi`) VALUES
(16, NULL, 'LTP/9157', '2025-05-20', 'dfa', 'd', 'Tang'),
(17, NULL, 'LTP/9157', '2025-05-20', 'ks', 'o', 'k');

-- --------------------------------------------------------

--
-- Table structure for table `master_divisi`
--

CREATE TABLE `master_divisi` (
  `kode_divisi` varchar(25) NOT NULL,
  `nama_divisi` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `master_divisi`
--

INSERT INTO `master_divisi` (`kode_divisi`, `nama_divisi`) VALUES
('AC', 'Accounting'),
('AF', 'Account & Finance'),
('ALOG', 'Admin Logistic'),
('AM', 'Admin & Marketing'),
('APPE', 'Application Engineer'),
('APPS', 'Application Specialist'),
('AR', 'Account Receivable'),
('AS', 'Application Specialist'),
('ASM', 'Assistant Manager'),
('CSA', 'Customer Support Admin'),
('CSU', 'CS User'),
('DM', 'Digital Marketing'),
('DRKTR', 'Direktur'),
('DS', 'Desain Grafis'),
('GA', 'General Affair'),
('HRD', 'HRD'),
('LOG', 'Logistic'),
('LS', 'Logistic Supervisor'),
('MACC', 'Manager ACC DTI'),
('MS', 'Marketing Specialist'),
('PI', 'Purch Import'),
('PJM', 'Project Manager'),
('PL', 'Purch & Logistic'),
('PPMS', 'PPM Staff'),
('PR', 'Purching'),
('PRI', 'Purching Import'),
('RA', 'Regular Affairs'),
('RSP', 'Resepsionis'),
('SEP', 'Sales Engineer Private'),
('SF', 'Staff Finance'),
('SL', 'Sales'),
('SLOG', 'Staff Logistic'),
('SLS', 'Sales Support'),
('SLSA', 'Sales Admin'),
('SLSM', 'Sales Manager'),
('SMS', 'Sales Marketing Support'),
('SRVA', 'Servis Admin'),
('STF', 'Staff'),
('TA', 'Talent Acquisition'),
('TAHRD', 'Talent Acquisition HRD'),
('TKS', 'Teknisi'),
('TKSL', 'Technical Sales'),
('TS', 'Tax Staff'),
('TSG', 'Technical Sales Government'),
('TX', 'Tax');

-- --------------------------------------------------------

--
-- Table structure for table `master_pt`
--

CREATE TABLE `master_pt` (
  `id_pt` int(11) NOT NULL,
  `nama_pt` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `master_pt`
--

INSERT INTO `master_pt` (`id_pt`, `nama_pt`) VALUES
(1, 'PT Dynatech International'),
(2, 'PT Genecraft labs'),
(3, 'PT Usaha Tiga Bersaudara'),
(4, 'PT Infinity Bionalitika Solusindo'),
(5, 'PT Wiralabs Analitika Solusindo'),
(6, 'PT Labindonesia'),
(7, 'PT Usaha Tiga Bersaudara'),
(8, 'PT Dynatech International'),
(9, 'PT Genecraft labs'),
(10, 'PT Usaha Tiga Bersaudara'),
(11, 'PT Infinity Bionalitika Solusindo'),
(12, 'PT Wiralabs Analitika Solusindo'),
(13, 'PT Labindonesia'),
(14, 'PT Usaha Tiga Bersaudara'),
(15, 'PT Novatech Integre Solusindo'),
(16, 'PT Ascentia Arsya Analitika'),
(17, 'PT Quantus Systema Integra');

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `tanggal_pinjam` date NOT NULL,
  `tanggal_kembali` date DEFAULT NULL,
  `status` enum('Pending','Disetujui','Ditolak') DEFAULT 'Pending',
  `dibaca_admin` tinyint(1) DEFAULT 0,
  `keterangan` text DEFAULT NULL,
  `kondisi_sekarang` text DEFAULT NULL,
  `tanggal_cek` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `perusahaan` varchar(100) DEFAULT NULL,
  `jabatan` varchar(100) DEFAULT NULL,
  `jenis_barang` varchar(100) DEFAULT NULL,
  `spesifikasi` text DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `kondisi_pinjam` varchar(50) DEFAULT NULL,
  `file_formulir` varchar(255) DEFAULT NULL,
  `kode_barang` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `peminjaman`
--

INSERT INTO `peminjaman` (`id`, `id_user`, `tanggal_pinjam`, `tanggal_kembali`, `status`, `dibaca_admin`, `keterangan`, `kondisi_sekarang`, `tanggal_cek`, `created_at`, `perusahaan`, `jabatan`, `jenis_barang`, `spesifikasi`, `jumlah`, `kondisi_pinjam`, `file_formulir`, `kode_barang`) VALUES
(1, 2, '2025-05-15', NULL, '', 0, 'Kameranya mati', 'Rusak Ringan', '2025-05-21', '2025-05-14 14:49:00', 'DTI', 'HRD', 'Laptop', 'Core i5', 1, 'Baik', '../uploads/6825723c2e6dd.jpg', NULL),
(2, 2, '2025-05-15', NULL, '', 0, 'Buat Kerja', 'Baik', '2025-05-24', '2025-05-14 15:05:42', 'DTI', 'HRD', 'Laptop', '8 GB', 1, 'Baik', '../uploads/68257626cc44b.jpg', NULL),
(3, 2, '2025-05-08', NULL, 'Disetujui', 1, 'Kerja', 'Baik', '2025-05-15', '2025-05-14 15:12:05', 'DTI', 'HRD', 'Laptop', '18 GB Ram', 1, 'Baik', '../uploads/682577a5b3a8d.jpg', NULL),
(4, 2, '2025-05-31', NULL, 'Disetujui', 1, 'Kerja', 'Baik', '2025-06-05', '2025-05-14 16:05:10', 'ACT', 'IT', 'Laptop', 'Dell', 1, 'Baik', '../uploads/formulir_682586abcc535.jpeg', NULL),
(5, 2, '2025-05-15', NULL, 'Ditolak', 1, 'Mati Total', 'Rusak', '2026-06-16', '2025-05-14 17:22:04', 'DTI', 'HRD', 'Laptop', 'sadas', 1, 'Baik', '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pengaduan`
--

CREATE TABLE `pengaduan` (
  `id_pengaduan` int(25) NOT NULL,
  `id_user` int(25) NOT NULL,
  `nama_pt` varchar(100) DEFAULT NULL,
  `divisi` varchar(100) NOT NULL,
  `lantai` varchar(10) DEFAULT NULL,
  `jenis_perangkat` varchar(50) NOT NULL,
  `deskripsi_masalah` text NOT NULL,
  `tindakan` text DEFAULT NULL,
  `tanggal_pengaduan` datetime DEFAULT current_timestamp(),
  `status` enum('Pending','Diproses','Diperbaiki','Tidak Bisa Diperbaiki') DEFAULT 'Diproses',
  `tindakan_perbaikan` text DEFAULT NULL,
  `pic_it` varchar(100) DEFAULT NULL,
  `tanggal_perbaikan` datetime DEFAULT NULL,
  `kode_barang` varchar(50) DEFAULT NULL,
  `spesifikasi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengaduan`
--

INSERT INTO `pengaduan` (`id_pengaduan`, `id_user`, `nama_pt`, `divisi`, `lantai`, `jenis_perangkat`, `deskripsi_masalah`, `tindakan`, `tanggal_pengaduan`, `status`, `tindakan_perbaikan`, `pic_it`, `tanggal_perbaikan`, `kode_barang`, `spesifikasi`) VALUES
(8, 2, NULL, 'HRD', NULL, 'Laptop', 'fwf', NULL, '2025-05-16 06:32:48', 'Diperbaiki', NULL, NULL, NULL, NULL, NULL),
(10, 2, NULL, 'HRD', NULL, 'Laptop', 'wddq', NULL, '2025-05-16 08:34:03', 'Diperbaiki', NULL, NULL, NULL, NULL, NULL),
(11, 2, NULL, 'SE', NULL, 'Laptop', 'wfqfq', NULL, '2025-05-16 08:43:50', 'Tidak Bisa Diperbaiki', NULL, NULL, NULL, NULL, NULL),
(12, 2, NULL, 'SE', NULL, 'Laptop', 'sdadas', NULL, '2025-05-16 08:50:05', 'Diperbaiki', NULL, NULL, NULL, NULL, NULL),
(13, 2, NULL, 'HRD', NULL, 'Laptop', 'fewf', 'Ganti Ip address karena bentrok', '2025-05-16 09:01:17', 'Diperbaiki', NULL, NULL, NULL, NULL, NULL),
(14, 2, NULL, 'wfe', NULL, 'Laptop', 'wfwe', NULL, '2025-05-16 09:01:43', 'Diperbaiki', NULL, NULL, NULL, NULL, NULL),
(16, 2, NULL, 'HRD', NULL, 'Laptop', 'wadaw', NULL, '2025-05-17 09:07:05', 'Diperbaiki', NULL, NULL, NULL, NULL, NULL),
(17, 2, NULL, 'SE', NULL, 'Laptop', 'Mati', NULL, '2025-05-17 10:07:02', 'Tidak Bisa Diperbaiki', NULL, NULL, NULL, NULL, NULL),
(18, 2, NULL, 'HRD', NULL, 'Laptop', 'Mati', 'cas', '2025-05-17 10:07:09', 'Diperbaiki', NULL, NULL, NULL, NULL, NULL),
(19, 2, NULL, 'HRD', NULL, 'wer', 'wer', NULL, '2025-05-17 10:27:19', 'Tidak Bisa Diperbaiki', NULL, NULL, NULL, NULL, NULL),
(20, 2, NULL, '3wr', NULL, '3wr', 'w3r', NULL, '2025-05-17 10:27:23', 'Tidak Bisa Diperbaiki', NULL, NULL, NULL, NULL, NULL),
(21, 2, NULL, '3wr', NULL, '3rw', 'w3r', 'wadawd', '2025-05-17 10:27:25', 'Diperbaiki', NULL, NULL, NULL, NULL, NULL),
(22, 2, NULL, 'w3r', NULL, 'w3r', 'w3r', NULL, '2025-05-17 10:27:29', 'Tidak Bisa Diperbaiki', NULL, NULL, NULL, NULL, NULL),
(23, 2, NULL, '3wr', NULL, 'w3r', 'w3r', 'Mantap', '2025-05-17 10:27:32', 'Diperbaiki', NULL, NULL, NULL, NULL, NULL),
(24, 2, NULL, 'wda', NULL, 'awd', 'awd', NULL, '2025-05-17 11:00:09', 'Tidak Bisa Diperbaiki', NULL, NULL, NULL, NULL, NULL),
(26, 2, NULL, 'HRD', NULL, 'awd', 'ad', NULL, '2025-05-17 11:07:51', 'Tidak Bisa Diperbaiki', NULL, NULL, NULL, NULL, NULL),
(28, 2, NULL, 'awd', NULL, 'adw', 'awd', 'sad', '2025-05-17 11:15:34', 'Diperbaiki', NULL, NULL, NULL, NULL, NULL),
(29, 3, NULL, 'HRD', NULL, 'ad', 'ad', NULL, '2025-05-17 11:26:09', 'Tidak Bisa Diperbaiki', NULL, NULL, NULL, NULL, NULL),
(30, 2, NULL, 'HRD', NULL, 'Laptop', 'smksm', 'nfsk', '2025-05-19 11:48:25', 'Diperbaiki', NULL, NULL, NULL, 'LTP/91123', NULL),
(31, 2, NULL, 'HRD', NULL, 'Laptop', 'jsj', 'jsk', '2025-05-20 09:29:48', 'Diperbaiki', NULL, NULL, NULL, 'LTP/91123', NULL),
(32, 2, NULL, 'HRD', NULL, 'Laptop', 'jnadn', 'jksakj', '2025-05-20 12:42:28', 'Diperbaiki', NULL, NULL, NULL, 'LTP/91123', NULL),
(33, 2, NULL, 'HRD', NULL, 'Laptop', 'kdmla', 'kjn', '2025-05-20 13:19:43', 'Diperbaiki', NULL, NULL, NULL, 'LTP/91123', NULL),
(34, 2, NULL, 'HRD', NULL, 'Laptop', 'oij', NULL, '2025-05-20 16:17:50', 'Tidak Bisa Diperbaiki', NULL, NULL, NULL, 'LTP/91123', NULL),
(35, 2, NULL, 'HRD', NULL, 'Laptop', 'k', 'dca', '2025-05-20 16:56:14', 'Diperbaiki', NULL, NULL, NULL, 'LTP/9157', NULL),
(36, 2, NULL, 'HRD', NULL, 'Laptop', 'sca', 'faf', '2025-05-20 16:56:39', 'Diperbaiki', NULL, NULL, NULL, 'LTP/91156', NULL),
(37, 2, NULL, 'HRD', NULL, 'Laptop', 'km', 'df', '2025-05-21 08:47:33', 'Diperbaiki', NULL, NULL, NULL, 'LTP/91123', NULL),
(38, 2, NULL, 'HRD', NULL, 'Laptop', 'dsf', NULL, '2025-05-21 09:00:06', 'Tidak Bisa Diperbaiki', NULL, NULL, NULL, 'LTP/9157', NULL),
(39, 2, NULL, 'HRD', NULL, 'Laptop', 'sa', NULL, '2025-05-21 11:00:07', 'Diperbaiki', 'Ganti RAM', '1', NULL, 'LTP/91123', NULL),
(40, 2, 'DTI', 'HRD', '4', 'Laptop', 'Nggak tau nih kenapa ', 'cas', '2025-05-21 15:52:44', 'Diperbaiki', NULL, NULL, NULL, NULL, NULL),
(41, 2, 'DTI', 'HRD', '4', 'Laptop', 'sxa', 'Ganti RAM', '2025-05-23 09:00:33', 'Diperbaiki', NULL, NULL, NULL, NULL, NULL),
(42, 2, 'DTI', 'HRD', '4', 'Laptop', 'Lemot', NULL, '2025-05-23 10:21:20', 'Diperbaiki', 'Nambah RAM', '1', NULL, NULL, NULL),
(43, 2, 'DTI', 'HRD', '4', 'Laptop', 'Lemot ', NULL, '2025-05-23 10:40:16', 'Diperbaiki', 'Nambah RAM', 'Bintang', NULL, NULL, NULL),
(44, 2, 'DTI', 'HRD', '4', 'Laptop', 'Penyimpanan Penuh', NULL, '2025-05-23 10:51:44', 'Diperbaiki', 'Nambah penyimpanan', 'Bintang', NULL, NULL, NULL),
(45, 2, 'DTI', 'HRD', '4', 'Laptop', 'Lemot\r\n', NULL, '2025-05-23 11:11:44', 'Diperbaiki', 'Ganti ke SSD', 'Bintang', NULL, NULL, NULL),
(47, 2, 'DTI', 'HRD', '4', 'Laptop', 'SSD', NULL, '2025-05-23 13:30:28', 'Diperbaiki', 'Nambah SSD', 'Bintang', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pengeluaran_stok`
--

CREATE TABLE `pengeluaran_stok` (
  `id` int(11) NOT NULL,
  `id_pengaduan` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `tanggal_keluar` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengeluaran_stok`
--

INSERT INTO `pengeluaran_stok` (`id`, `id_pengaduan`, `id_barang`, `jumlah`, `keterangan`, `tanggal_keluar`) VALUES
(1, 39, 3, 1, '', '2025-05-23 02:26:04'),
(2, 42, 4, 1, '', '2025-05-23 03:21:56'),
(3, 43, 5, 1, 'Digunakan dalam penanganan pengaduan ID 43', '2025-05-23 03:41:19'),
(10, 47, 8, 1, 'Digunakan dalam penanganan pengaduan ID 47', '2025-05-23 06:31:40');

-- --------------------------------------------------------

--
-- Table structure for table `permintaan`
--

CREATE TABLE `permintaan` (
  `id` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `tanggal_permintaan` date DEFAULT NULL,
  `perusahaan` varchar(100) DEFAULT NULL,
  `jabatan` varchar(100) DEFAULT NULL,
  `jenis_barang` varchar(100) DEFAULT NULL,
  `spesifikasi` text DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `file_formulir` varchar(255) DEFAULT NULL,
  `status` enum('Pending','Disetujui','Ditolak') DEFAULT 'Pending',
  `tanggal_cek` date DEFAULT NULL,
  `kondisi_sekarang` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `dibaca_admin` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `permintaan`
--

INSERT INTO `permintaan` (`id`, `id_user`, `tanggal_permintaan`, `perusahaan`, `jabatan`, `jenis_barang`, `spesifikasi`, `jumlah`, `keterangan`, `file_formulir`, `status`, `tanggal_cek`, `kondisi_sekarang`, `created_at`, `dibaca_admin`) VALUES
(1, 2, '2025-05-15', 'ACT', 'HRD', 'Laptop', 'Dell', 1, 'kerja', '../uploads/68258caea1fad.jpg', 'Ditolak', NULL, NULL, '2025-05-14 16:41:50', 1),
(2, 2, '2025-05-16', 'ACT', 'HRD', 'Laptop', 'Dell', 2, 'Kerja', '../uploads/68258da6a4e1f.jpg', 'Disetujui', NULL, NULL, '2025-05-14 16:45:58', 1),
(3, 2, '2025-05-16', 'DTI', 'HRD', 'Laptop', 'wadad', 1, 'cdssc', '../uploads/682592366417b.jpg', 'Disetujui', NULL, NULL, '2025-05-14 17:05:26', 1),
(4, 2, '2025-05-21', 'DTI', 'HRD', 'Laptop', 'adsd', 1, 'asdada', '../uploads/68259a5a90a5a.jpg', 'Disetujui', NULL, NULL, '2025-05-14 17:40:10', 1),
(5, 3, '2025-05-17', 'DTI', 'HRD', 'Laptop', 'daw', 1, 'kerja', '', 'Disetujui', NULL, NULL, '2025-05-17 03:11:43', 1),
(6, 2, '2025-05-18', 'DTI', 'HRD', 'Laptop', '-', 1, 'Kerja', '', 'Disetujui', NULL, NULL, '2025-05-17 23:59:37', 1),
(7, 3, '2025-05-19', 'AAA', 'SEP', 'Printer', 'Printer', 1, 'Kerja', '', 'Disetujui', NULL, NULL, '2025-05-19 03:11:59', 1);

-- --------------------------------------------------------

--
-- Table structure for table `review_pengaduan`
--

CREATE TABLE `review_pengaduan` (
  `id_review` int(11) NOT NULL,
  `id_pengaduan` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `puas` enum('Ya','Tidak') NOT NULL,
  `komentar` text DEFAULT NULL,
  `tanggal_review` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `review_pengaduan`
--

INSERT INTO `review_pengaduan` (`id_review`, `id_pengaduan`, `id_user`, `puas`, `komentar`, `tanggal_review`) VALUES
(1, 26, 2, 'Ya', 'Mantap', '2025-05-17 16:56:38'),
(2, 29, 3, 'Ya', '', '2025-05-17 17:05:06');

-- --------------------------------------------------------

--
-- Table structure for table `riwayat_perbaikan`
--

CREATE TABLE `riwayat_perbaikan` (
  `id` int(11) NOT NULL,
  `inventaris_id` int(11) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `masalah` text DEFAULT NULL,
  `solusi` text DEFAULT NULL,
  `teknisi` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `satuan_barang`
--

CREATE TABLE `satuan_barang` (
  `id_satuan` int(11) NOT NULL,
  `nama_satuan` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `satuan_barang`
--

INSERT INTO `satuan_barang` (`id_satuan`, `nama_satuan`) VALUES
(1, 'pcs'),
(2, 'unit'),
(3, 'set'),
(4, 'meter'),
(5, 'roll');

-- --------------------------------------------------------

--
-- Table structure for table `stok_barang`
--

CREATE TABLE `stok_barang` (
  `id_barang` int(25) NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `satuan` varchar(20) DEFAULT 'pcs',
  `jumlah` int(11) NOT NULL DEFAULT 0,
  `keterangan` text DEFAULT NULL,
  `tanggal_input` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stok_barang`
--

INSERT INTO `stok_barang` (`id_barang`, `nama_barang`, `kategori`, `satuan`, `jumlah`, `keterangan`, `tanggal_input`) VALUES
(3, 'RAM', 'Sparepart', 'pcs', 0, 'Sparepart', '2025-05-22 07:27:14'),
(4, 'RAM', 'RAM', 'pcs', 0, 'DDR3', '2025-05-23 02:47:23'),
(5, 'RAM', 'RAM', 'pcs', 0, 'DDR4', '2025-05-23 03:40:43'),
(8, 'SSD', 'Penyimpanan', 'pcs', 0, '512 GB', '2025-05-23 06:29:42');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Admin','Manajer','Karyawan') NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `timestamp`) VALUES
(1, 'admin', '123', 'Admin', '2025-05-13 14:50:59'),
(2, 'bintang', '123', 'Karyawan', '2025-05-14 14:30:30'),
(3, 'raihan', '123', 'Karyawan', '2025-05-17 02:25:45');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `inventaris`
--
ALTER TABLE `inventaris`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_barang` (`kode_barang`),
  ADD UNIQUE KEY `kode_barang_2` (`kode_barang`);

--
-- Indexes for table `jenis_perangkat`
--
ALTER TABLE `jenis_perangkat`
  ADD PRIMARY KEY (`id_jenis`);

--
-- Indexes for table `kategori_stok`
--
ALTER TABLE `kategori_stok`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `maintenance`
--
ALTER TABLE `maintenance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pengaduan` (`id_pengaduan`),
  ADD KEY `kode_barang` (`kode_barang`);

--
-- Indexes for table `master_divisi`
--
ALTER TABLE `master_divisi`
  ADD PRIMARY KEY (`kode_divisi`),
  ADD UNIQUE KEY `kode_divisi` (`kode_divisi`);

--
-- Indexes for table `master_pt`
--
ALTER TABLE `master_pt`
  ADD PRIMARY KEY (`id_pt`);

--
-- Indexes for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_kode_barang` (`kode_barang`);

--
-- Indexes for table `pengaduan`
--
ALTER TABLE `pengaduan`
  ADD PRIMARY KEY (`id_pengaduan`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `fk_pengaduan_kode_barang` (`kode_barang`);

--
-- Indexes for table `pengeluaran_stok`
--
ALTER TABLE `pengeluaran_stok`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pengaduan` (`id_pengaduan`),
  ADD KEY `id_barang` (`id_barang`);

--
-- Indexes for table `permintaan`
--
ALTER TABLE `permintaan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `review_pengaduan`
--
ALTER TABLE `review_pengaduan`
  ADD PRIMARY KEY (`id_review`),
  ADD KEY `id_pengaduan` (`id_pengaduan`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `riwayat_perbaikan`
--
ALTER TABLE `riwayat_perbaikan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inventaris_id` (`inventaris_id`);

--
-- Indexes for table `satuan_barang`
--
ALTER TABLE `satuan_barang`
  ADD PRIMARY KEY (`id_satuan`);

--
-- Indexes for table `stok_barang`
--
ALTER TABLE `stok_barang`
  ADD PRIMARY KEY (`id_barang`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `inventaris`
--
ALTER TABLE `inventaris`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `jenis_perangkat`
--
ALTER TABLE `jenis_perangkat`
  MODIFY `id_jenis` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `kategori_stok`
--
ALTER TABLE `kategori_stok`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `maintenance`
--
ALTER TABLE `maintenance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `master_pt`
--
ALTER TABLE `master_pt`
  MODIFY `id_pt` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pengaduan`
--
ALTER TABLE `pengaduan`
  MODIFY `id_pengaduan` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `pengeluaran_stok`
--
ALTER TABLE `pengeluaran_stok`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `permintaan`
--
ALTER TABLE `permintaan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `review_pengaduan`
--
ALTER TABLE `review_pengaduan`
  MODIFY `id_review` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `riwayat_perbaikan`
--
ALTER TABLE `riwayat_perbaikan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `satuan_barang`
--
ALTER TABLE `satuan_barang`
  MODIFY `id_satuan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `stok_barang`
--
ALTER TABLE `stok_barang`
  MODIFY `id_barang` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `maintenance`
--
ALTER TABLE `maintenance`
  ADD CONSTRAINT `maintenance_ibfk_1` FOREIGN KEY (`id_pengaduan`) REFERENCES `pengaduan` (`id_pengaduan`) ON DELETE CASCADE,
  ADD CONSTRAINT `maintenance_ibfk_2` FOREIGN KEY (`kode_barang`) REFERENCES `inventaris` (`kode_barang`) ON DELETE SET NULL;

--
-- Constraints for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `fk_kode_barang` FOREIGN KEY (`kode_barang`) REFERENCES `inventaris` (`kode_barang`),
  ADD CONSTRAINT `fk_peminjaman_kode_barang` FOREIGN KEY (`kode_barang`) REFERENCES `inventaris` (`kode_barang`) ON DELETE SET NULL;

--
-- Constraints for table `pengaduan`
--
ALTER TABLE `pengaduan`
  ADD CONSTRAINT `fk_pengaduan_kode_barang` FOREIGN KEY (`kode_barang`) REFERENCES `inventaris` (`kode_barang`) ON DELETE SET NULL,
  ADD CONSTRAINT `pengaduan_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);

--
-- Constraints for table `pengeluaran_stok`
--
ALTER TABLE `pengeluaran_stok`
  ADD CONSTRAINT `pengeluaran_stok_ibfk_1` FOREIGN KEY (`id_pengaduan`) REFERENCES `pengaduan` (`id_pengaduan`) ON DELETE CASCADE,
  ADD CONSTRAINT `pengeluaran_stok_ibfk_2` FOREIGN KEY (`id_barang`) REFERENCES `stok_barang` (`id_barang`) ON DELETE CASCADE;

--
-- Constraints for table `review_pengaduan`
--
ALTER TABLE `review_pengaduan`
  ADD CONSTRAINT `review_pengaduan_ibfk_1` FOREIGN KEY (`id_pengaduan`) REFERENCES `pengaduan` (`id_pengaduan`),
  ADD CONSTRAINT `review_pengaduan_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);

--
-- Constraints for table `riwayat_perbaikan`
--
ALTER TABLE `riwayat_perbaikan`
  ADD CONSTRAINT `riwayat_perbaikan_ibfk_1` FOREIGN KEY (`inventaris_id`) REFERENCES `inventaris` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
