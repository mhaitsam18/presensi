-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 07, 2021 at 06:30 PM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `presensi`
--

-- --------------------------------------------------------

--
-- Table structure for table `agama`
--

CREATE TABLE `agama` (
  `id` int(11) NOT NULL,
  `agama` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `agama`
--

INSERT INTO `agama` (`id`, `agama`) VALUES
(1, 'Islam'),
(2, 'Kristen Protestan'),
(3, 'Kristen Katolik'),
(4, 'Budha'),
(5, 'Hindu'),
(6, 'Konghucu');

-- --------------------------------------------------------

--
-- Table structure for table `content`
--

CREATE TABLE `content` (
  `id` int(11) NOT NULL,
  `header` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `footer` varchar(255) NOT NULL,
  `last_updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `content`
--

INSERT INTO `content` (`id`, `header`, `content`, `footer`, `last_updated`) VALUES
(1, 'Illustration', '<p>Add some quality, svg illustrations to your project courtesy of <a\r\n                                            target=\"_blank\" rel=\"nofollow\" href=\"https://undraw.co/\">unDraw</a>, a\r\n                                        constantly updated collection of beautiful svg images that you can use\r\n                                        completely free and without attribution!</p>\r\n                                    <a target=\"_blank\" rel=\"nofollow\" href=\"https://undraw.co/\">Browse Illustrations on\r\n                                        unDraw &rarr;</a>', '', '2021-03-05 03:51:54'),
(2, 'Development Approach', '<p>SB Admin 2 makes extensive use of Bootstrap 4 utility classes in order to reduce\r\n                                        CSS bloat and poor page performance. Custom CSS classes are used to create\r\n                                        custom components and custom utility classes.</p>\r\n                                    <p class=\"mb-0\">Before working with this theme, you should become familiar with the\r\n                                        Bootstrap framework, especially the utility classes.</p>', '', '2021-03-05 03:49:49'),
(3, 'Illustration', '<p>Add some quality, svg illustrations to your project courtesy of <a\r\n                                            target=\"_blank\" rel=\"nofollow\" href=\"https://undraw.co/\">unDraw</a>, a\r\n                                        constantly updated collection of beautiful svg images that you can use\r\n                                        completely free and without attribution!</p>\r\n                                    <a target=\"_blank\" rel=\"nofollow\" href=\"https://undraw.co/\">Browse Illustrations on\r\n                                        unDraw &rarr;</a>', '', '2021-03-05 03:51:44'),
(4, 'Development Approach', '<p>SB Admin 2 makes extensive use of Bootstrap 4 utility classes in order to reduce\r\n                                        CSS bloat and poor page performance. Custom CSS classes are used to create\r\n                                        custom components and custom utility classes.</p>\r\n                                    <p class=\"mb-0\">Before working with this theme, you should become familiar with the\r\n                                        Bootstrap framework, especially the utility classes.</p>', '', '2021-03-05 03:52:18');

-- --------------------------------------------------------

--
-- Table structure for table `dashboard`
--

CREATE TABLE `dashboard` (
  `id` int(11) NOT NULL,
  `header` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `footer` varchar(256) NOT NULL,
  `icon` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dashboard`
--

INSERT INTO `dashboard` (`id`, `header`, `title`, `content`, `footer`, `icon`) VALUES
(1, 'About Application', 'Tubes Firman', '<b>Tubes Firman</b> merupakan aplikasi yang dapat memonitoring performa mahasiswa, memiliki fitur-fitur yang sangat banyak, dan lain-lain.', 'Firman Aldo Saputra', 'fas fa-code');

-- --------------------------------------------------------

--
-- Table structure for table `dosen`
--

CREATE TABLE `dosen` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `kode_dosen` varchar(128) NOT NULL,
  `nidn` varchar(256) NOT NULL,
  `nip` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dosen`
--

INSERT INTO `dosen` (`id`, `id_user`, `kode_dosen`, `nidn`, `nip`) VALUES
(1, 8, 'WHY', '1231423423', '134232421'),
(2, 9, 'PRA', '344234', '235434'),
(3, 10, 'ELR', '091029301923', '123214324'),
(4, 11, 'INE', '23123', '243543'),
(5, 12, 'WWU', '123456', '123456'),
(6, 15, 'MBS', '123456', '123456'),
(7, 17, 'SYN', '0009123', '213920390123'),
(8, 1, 'MHS', '6701180123', '6701180123'),
(9, 13, 'FAS', '6701184012', '6701184012');

-- --------------------------------------------------------

--
-- Table structure for table `fakultas`
--

CREATE TABLE `fakultas` (
  `id` int(11) NOT NULL,
  `kode_fakultas` varchar(255) NOT NULL,
  `nama_fakultas` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fakultas`
--

INSERT INTO `fakultas` (`id`, `kode_fakultas`, `nama_fakultas`) VALUES
(1, 'FTE', 'Fakultas Teknik Elektro'),
(2, 'FIF', 'Fakultas Informatika'),
(3, 'FRI', 'Fakultas Rekayasa Industri'),
(4, 'FEB', 'Fakultas Ekonomi dan Bisnis'),
(5, 'FKB', 'Fakultas Komunikasi dan Bisnis'),
(6, 'FIK', 'Fakultas Industri Kreatif'),
(7, 'FIT', 'Fakultas Ilmu Terapan');

-- --------------------------------------------------------

--
-- Table structure for table `ip_semester`
--

CREATE TABLE `ip_semester` (
  `id` int(11) NOT NULL,
  `id_nilai_mahasiswa` int(11) NOT NULL,
  `semester` int(11) NOT NULL,
  `ip` decimal(3,2) NOT NULL,
  `ipk` decimal(3,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ip_semester`
--

INSERT INTO `ip_semester` (`id`, `id_nilai_mahasiswa`, `semester`, `ip`, `ipk`) VALUES
(1, 1, 1, '4.00', '4.00'),
(2, 1, 2, '0.00', '4.00'),
(3, 1, 3, '0.00', '4.00'),
(4, 1, 4, '0.00', '4.00'),
(5, 1, 5, '0.00', '4.00'),
(6, 1, 6, '0.00', '4.00'),
(7, 2, 1, '4.00', '4.00'),
(8, 2, 2, '0.00', '4.00'),
(9, 2, 3, '0.00', '4.00'),
(10, 2, 4, '0.00', '4.00'),
(11, 2, 5, '0.00', '4.00'),
(12, 2, 6, '0.00', '4.00'),
(13, 3, 1, '0.00', '0.00'),
(14, 3, 2, '3.00', '3.00'),
(15, 3, 3, '0.00', '3.00'),
(16, 3, 4, '0.00', '3.00'),
(17, 3, 5, '0.00', '3.00'),
(18, 3, 6, '3.00', '3.00'),
(19, 4, 1, '0.00', '0.00'),
(20, 4, 2, '0.00', '0.00'),
(21, 4, 3, '0.00', '0.00'),
(22, 4, 4, '4.00', '4.00'),
(23, 4, 5, '0.00', '4.00'),
(24, 4, 6, '0.00', '4.00'),
(25, 5, 1, '4.00', '4.00'),
(26, 5, 2, '0.00', '4.00'),
(27, 5, 3, '0.00', '4.00'),
(28, 5, 4, '0.00', '4.00'),
(29, 5, 5, '0.00', '4.00'),
(30, 5, 6, '0.00', '4.00'),
(31, 6, 1, '0.00', '0.00'),
(32, 6, 2, '4.00', '4.00'),
(33, 6, 3, '0.00', '4.00'),
(34, 6, 4, '0.00', '4.00'),
(35, 6, 5, '0.00', '4.00'),
(36, 6, 6, '0.00', '4.00'),
(37, 7, 1, '3.00', '3.00'),
(38, 7, 2, '0.00', '3.00'),
(39, 7, 3, '4.00', '3.67'),
(40, 7, 4, '0.00', '3.67'),
(41, 7, 5, '0.00', '3.67'),
(42, 7, 6, '0.00', '3.67'),
(43, 8, 1, '0.00', '0.00'),
(44, 8, 2, '3.50', '3.50'),
(45, 8, 3, '4.00', '3.79'),
(46, 8, 4, '0.00', '3.79'),
(47, 8, 5, '0.00', '3.79'),
(48, 8, 6, '0.00', '3.79'),
(49, 9, 1, '4.00', '4.00'),
(50, 9, 2, '0.00', '4.00'),
(51, 9, 3, '0.00', '4.00'),
(52, 9, 4, '0.00', '4.00'),
(53, 9, 5, '0.00', '4.00'),
(54, 9, 6, '0.00', '4.00'),
(55, 10, 1, '0.00', '0.00'),
(56, 10, 2, '0.00', '0.00'),
(57, 10, 3, '0.00', '0.00'),
(58, 10, 4, '0.00', '0.00'),
(59, 10, 5, '0.00', '0.00'),
(60, 10, 6, '0.00', '0.00'),
(61, 11, 1, '0.00', '0.00'),
(62, 11, 2, '0.00', '0.00'),
(63, 11, 3, '0.00', '0.00'),
(64, 11, 4, '0.00', '0.00'),
(65, 11, 5, '0.00', '0.00'),
(66, 11, 6, '0.00', '0.00'),
(67, 12, 1, '3.00', '3.00'),
(68, 12, 2, '3.82', '3.72'),
(69, 12, 3, '3.61', '3.67'),
(70, 12, 4, '0.00', '3.67'),
(71, 12, 5, '0.00', '3.67'),
(72, 12, 6, '0.00', '3.67');

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `id` int(11) NOT NULL,
  `kelas` varchar(255) NOT NULL,
  `nama_ketua_kelas` varchar(255) NOT NULL,
  `nomor_ketua_kelas` varchar(255) NOT NULL,
  `id_dosen_wali` int(11) NOT NULL,
  `id_prodi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`id`, `kelas`, `nama_ketua_kelas`, `nomor_ketua_kelas`, `id_dosen_wali`, `id_prodi`) VALUES
(1, 'D3SI-41-01', 'Firman Aldo Saputra', '082119695948', 1, 39),
(2, 'D3SI-41-02', 'Firza Nasution', '0812818282', 2, 39),
(3, 'D3SI-41-03', 'Septi Maudi Pratiwi', '081213774211', 3, 39),
(4, 'D3SI-41-04', 'Olga Paurenta', '081394688093', 4, 39),
(5, 'D3SI-42-01', 'Naomi D.S Silitonga', '085211964699', 5, 39),
(6, 'D3SI-42-02', 'Muhammad Haitsam', '082117503125', 6, 39),
(7, 'D3SI-42-03', 'Ferdy Erlangga', '0895620526930', 3, 39),
(8, 'D3SI-42-04', 'Muhammad Dhana Syaifullah', '082231811811', 2, 39),
(9, 'D3SI-43-01', 'Rayhan Hafidz', '089506531139', 1, 39),
(10, 'D3SI-43-02', 'Friska Andalusia', '081318271630', 2, 39),
(11, 'D3SI-43-03', 'Siti Nurajijah', '081572788690', 3, 39),
(12, 'D3SI-43-04', 'Faiz', '123213213', 4, 39),
(13, 'D3SI-44-01', 'Melia Antika', '081279370017', 8, 39);

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nim` varchar(255) DEFAULT NULL,
  `id_kelas` int(11) NOT NULL,
  `angkatan` int(11) DEFAULT NULL,
  `nama_wali` varchar(255) NOT NULL,
  `pekerjaan_wali` varchar(255) NOT NULL,
  `pendidikan_wali` int(11) NOT NULL,
  `asal_daerah` varchar(255) NOT NULL,
  `id_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mahasiswa`
--

INSERT INTO `mahasiswa` (`id`, `id_user`, `nim`, `id_kelas`, `angkatan`, `nama_wali`, `pekerjaan_wali`, `pendidikan_wali`, `asal_daerah`, `id_status`) VALUES
(1, 2, '6701184071', 6, 42, 'Paurenta', 'Wiraswasta', 7, 'Medan', 1),
(2, 3, '6701104000', 1, 34, 'Hartono', 'Nelayan', 6, 'Bandung', 1),
(3, 6, '6701180123', 6, 42, 'Mulyanto', 'Karyawan', 9, 'Karawang', 1),
(4, 14, '6701180075', 6, 42, 'Rizqi', 'Presiden', 4, 'Brebes', 1),
(5, 1, '190510170091', 2, 42, 'Fahruroji', 'Wiraswasta', 9, 'Karawang', 1),
(6, 16, '6701183048', 6, 42, 'Dodi', 'Wiraswasta', 5, 'Kediri', 1),
(7, 18, '6701184083', 6, 42, 'Maulana', 'DPR', 8, 'Bogor', 1),
(8, 20, '6701180058', 6, 42, 'Bapak Shibgho', 'Wiraswasta', 2, 'Depok', 1),
(9, 13, '6701184012', 6, 42, 'Bapak', 'Wiraswasta', 8, 'Padang', 1),
(10, 22, '6701184002', 6, 42, 'Bapak Akib', 'Wiraswasta', 7, 'Palembang', 1),
(11, 24, '6701180432', 6, 42, 'Bapak Shibgho', 'Wiraswasta', 4, 'Depok', 1);

-- --------------------------------------------------------

--
-- Table structure for table `mata_kuliah`
--

CREATE TABLE `mata_kuliah` (
  `id` int(11) NOT NULL,
  `kode_mata_kuliah` varchar(255) NOT NULL,
  `nama_mata_kuliah` varchar(255) DEFAULT NULL,
  `sks` int(11) DEFAULT NULL,
  `semester` int(11) NOT NULL,
  `id_prodi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mata_kuliah`
--

INSERT INTO `mata_kuliah` (`id`, `kode_mata_kuliah`, `nama_mata_kuliah`, `sks`, `semester`, `id_prodi`) VALUES
(1, 'DCH1A3', 'Arsitektur dan Sistem Komputer', 3, 1, 39),
(2, 'DHH1A2', 'Pengantar Manajemen', 2, 1, 39),
(3, 'DMH1A3', 'Aplikasi Manajemen Perkantoran', 3, 1, 39),
(4, 'DMH1G2', 'Pengembangan Personal', 2, 1, 39),
(5, 'DPH1A3', 'Logika Matematika', 3, 1, 39),
(6, 'DPH1B4', 'Algoritma dan Pemrograman Komputer', 4, 1, 39),
(7, 'HUH1G3', 'Pancasila dan Kewarganegaraan', 3, 1, 39),
(8, 'DMH1D3', 'Implementasi Desain Antarmuka Pengguna', 4, 2, 39),
(9, 'DMH1D3', 'Proses Bisnis', 3, 2, 39),
(10, 'DMH1E2', 'Proyek I', 2, 2, 39),
(11, 'DMH1K3', 'Perancangan Basis Data', 3, 2, 39),
(12, 'DPH1C4', 'Pemrograman Berorientasi Obyek', 4, 2, 39),
(13, 'DUH1A2', 'Literasi TIK', 2, 2, 39),
(14, 'LUH1B2', 'Bahasa Inggris I', 2, 2, 39),
(15, 'DAH1G2', 'Bahasa Inggris II', 2, 3, 39),
(16, 'DCH2A3', 'Jaringan Komputer', 3, 3, 39),
(17, 'DMH1A2', 'Olahraga', 2, 3, 39),
(18, 'DMH2A3', 'Pengolahan Basis Data', 4, 3, 39),
(19, 'DPH2A2', 'Rekayasa Kebutuhan Perangkat Lunak', 2, 3, 39),
(20, 'DPH2I4', 'Pemrograman Web Dasar', 4, 3, 39),
(21, 'HUH1A2', 'Pendidikan Agama Islam dan Etika', 2, 3, 39),
(22, 'LUH1A2', 'Bahasa Indonesia', 2, 3, 39),
(23, 'DAH2A2', 'Bahasa Inggris III', 2, 4, 39),
(24, 'DMH2A2', 'Kerja Praktik', 2, 4, 39),
(25, 'DMH2B2', 'Perilaku Organisasi', 2, 4, 39),
(26, 'DMH2C3', 'Pemrograman Basis Data', 3, 4, 39),
(27, 'DMH2E2', 'Proyek II', 2, 4, 39),
(28, 'DMH2F3', 'Analisis dan Perancangan Sistem Informasi', 3, 4, 39),
(29, 'DPH2B4', 'Pemrograman Web Lanjut', 4, 4, 39),
(30, 'DPH2C2', 'Pengujian Perangkat Lunak', 2, 4, 39),
(31, 'DUH2A2', 'Kewirausahaan', 2, 4, 39),
(32, 'UWI1D2', 'Literasi Manusia', 2, 5, 39),
(33, 'VPI2G2', 'Pengembangan Profesional', 2, 5, 39),
(34, 'VSI1K3', 'Implementasi User Experience Design', 3, 5, 39),
(35, 'VSI2G2', 'Probabilitas dan Statistik', 2, 5, 39),
(36, 'VSI3D3', 'Metodologi Penelitian', 3, 5, 39),
(37, 'VSI3F4', 'Pemrograman Perangkat Bergerak Lanjut', 4, 5, 39),
(38, 'VPI3GC', 'Magang', 12, 6, 39),
(39, 'VSI3H4', 'Proyek Akhir', 4, 6, 39);

-- --------------------------------------------------------

--
-- Table structure for table `nilai_mahasiswa`
--

CREATE TABLE `nilai_mahasiswa` (
  `id` int(11) NOT NULL,
  `id_mahasiswa` int(11) NOT NULL,
  `ipk` decimal(4,2) NOT NULL,
  `tak` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `nilai_mahasiswa`
--

INSERT INTO `nilai_mahasiswa` (`id`, `id_mahasiswa`, `ipk`, `tak`) VALUES
(1, 1, '4.00', 307),
(2, 3, '4.00', 367),
(3, 4, '3.00', 56),
(4, 6, '4.00', 0),
(5, 7, '4.00', 0),
(6, 5, '4.00', 50),
(7, 8, '3.67', 0),
(8, 9, '3.79', 100),
(9, 2, '4.00', 150),
(11, 10, '0.00', 0),
(12, 11, '0.00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `nilai_mata_kuliah`
--

CREATE TABLE `nilai_mata_kuliah` (
  `id` int(11) NOT NULL,
  `indeks` varchar(128) NOT NULL,
  `presensi` decimal(5,2) NOT NULL,
  `tahun_ajaran` varchar(255) NOT NULL,
  `semester` int(11) NOT NULL,
  `id_nilai_mahasiswa` int(11) NOT NULL,
  `id_pengampu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `nilai_mata_kuliah`
--

INSERT INTO `nilai_mata_kuliah` (`id`, `indeks`, `presensi`, `tahun_ajaran`, `semester`, `id_nilai_mahasiswa`, `id_pengampu`) VALUES
(1, 'A', '1.00', '2018/2019', 1, 1, 1),
(2, 'A', '0.81', '2018/2019', 1, 1, 2),
(3, 'A', '1.00', '2018/2019', 1, 2, 1),
(4, 'A', '1.00', '2018/2019', 1, 2, 2),
(5, 'A', '0.50', '2018/2019', 1, 5, 3),
(6, 'A', '1.00', '2018/2019', 2, 6, 3),
(7, 'B', '0.80', '2018/2019', 1, 7, 1),
(8, 'A', '1.00', '2019/2020', 3, 8, 3),
(9, 'AB', '0.44', '2019/2020', 2, 8, 1),
(10, 'A', '1.00', '2019/2020', 3, 7, 2),
(11, 'A', '1.00', '2020/2021', 3, 7, 3),
(12, 'A', '0.90', '2010/2011', 1, 9, 2),
(13, 'A', '0.69', '2019/2020', 4, 11, 2),
(14, 'B', '1.00', '2018/2019', 2, 3, 3),
(15, 'B', '1.00', '2018/2019', 6, 3, 2),
(16, 'A', '1.00', '2019/2020', 4, 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `pendidikan`
--

CREATE TABLE `pendidikan` (
  `id` int(11) NOT NULL,
  `pendidikan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pendidikan`
--

INSERT INTO `pendidikan` (`id`, `pendidikan`) VALUES
(1, 'Tidak/Belum Tamat SD'),
(2, 'Tamat SD/Sederajat'),
(3, 'Tamat SLTP/Sederajat'),
(4, 'Tamat SLTA/Sederajat'),
(5, 'Tamat D1/D2'),
(6, 'Tamat Akademi/D3'),
(7, 'Tamat D4/S1'),
(8, 'Tamat S2'),
(9, 'Tamat S3');

-- --------------------------------------------------------

--
-- Table structure for table `pengampu`
--

CREATE TABLE `pengampu` (
  `id` int(11) NOT NULL,
  `id_dosen` int(11) NOT NULL,
  `id_mata_kuliah` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pengampu`
--

INSERT INTO `pengampu` (`id`, `id_dosen`, `id_mata_kuliah`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 6, 6),
(4, 2, 12);

-- --------------------------------------------------------

--
-- Table structure for table `pertanyaan_1`
--

CREATE TABLE `pertanyaan_1` (
  `id` int(11) NOT NULL,
  `pertanyaan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pertanyaan_1`
--

INSERT INTO `pertanyaan_1` (`id`, `pertanyaan`) VALUES
(1, 'Apa nama mobil favorit kamu?'),
(2, 'Siapa nama ibu kandung kamu?');

-- --------------------------------------------------------

--
-- Table structure for table `pertanyaan_2`
--

CREATE TABLE `pertanyaan_2` (
  `id` int(11) NOT NULL,
  `pertanyaan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pertanyaan_2`
--

INSERT INTO `pertanyaan_2` (`id`, `pertanyaan`) VALUES
(1, 'Apa warna favorit kamu?'),
(2, 'Apa kutipan kata favorit kamu?');

-- --------------------------------------------------------

--
-- Table structure for table `pertanyaan_keamanan`
--

CREATE TABLE `pertanyaan_keamanan` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_pertanyaan_1` int(11) NOT NULL,
  `jawaban_1` varchar(255) NOT NULL,
  `id_pertanyaan_2` int(11) NOT NULL,
  `jawaban_2` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pertanyaan_keamanan`
--

INSERT INTO `pertanyaan_keamanan` (`id`, `id_user`, `id_pertanyaan_1`, `jawaban_1`, `id_pertanyaan_2`, `jawaban_2`) VALUES
(1, 1, 2, 'Nenden', 1, 'Oranye');

-- --------------------------------------------------------

--
-- Table structure for table `prodi`
--

CREATE TABLE `prodi` (
  `id` int(11) NOT NULL,
  `kode_prodi` varchar(255) NOT NULL,
  `nama_prodi` varchar(255) NOT NULL,
  `id_fakultas` int(11) NOT NULL,
  `id_kaprodi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `prodi`
--

INSERT INTO `prodi` (`id`, `kode_prodi`, `nama_prodi`, `id_fakultas`, `id_kaprodi`) VALUES
(1, 'S1TT', 'S1 Teknik Telekomunikasi', 1, 1),
(2, 'S1TTIC', 'S1 Teknik Telekomunikasi (International Class)', 1, 1),
(3, 'S1TE', 'S1 Teknik Elektro', 1, 1),
(4, 'S1TEIC', 'S1 Teknik Elektro (International Class)', 1, 1),
(5, 'S1TF', 'S1 Teknik Fisika', 1, 1),
(6, 'S1TK', 'S1 Teknik Komputer', 1, 1),
(7, 'S1TB', 'S1 Teknik Biomedis', 1, 1),
(8, 'S2TET', 'S2 Teknik Elektro-Telekomunikasi', 1, 1),
(9, 'S1I', 'S1 Informatika', 2, 2),
(10, 'S1IIC', 'S1 Informatika (International Class)', 2, 2),
(11, 'S1TI', 'S1 Teknologoi Informasi', 2, 2),
(12, 'S1RPL', 'S1 Rekayasa Perangkat Lunak', 2, 2),
(13, 'S2I', 'S2 Informatika', 2, 2),
(14, 'S1TIn', 'S1 Teknik Industri', 3, 3),
(15, 'S1TInIC', 'S1 Teknik Industri (International Class)', 3, 3),
(16, 'S1SI', 'S1 Sistem Informasi', 3, 3),
(17, 'S1SIIC', 'S1 Sistem Informasi (International Class)', 3, 3),
(18, 'S1TL', 'S1 Teknik Logistik', 3, 3),
(19, 'S2TIn', 'S2 Teknik Industri', 3, 3),
(20, 'S1IICTB', 'S1 International ICT Business', 4, 4),
(21, 'S1MBTI', 'S1 Manajemen Bisnis Telekomunikasi dan Informatika', 4, 4),
(22, 'S1A', 'S1 Akuntansi', 4, 4),
(23, 'S1AIC', 'S1 Akuntansi (International Class)', 4, 4),
(24, 'S2M', 'S2 Manajemen', 4, 4),
(25, 'S1AB', 'S1 Administrasi Bisnis', 5, 5),
(26, 'S1ABIC', 'S1 Administrasi Bisnis (International Class)', 5, 5),
(27, 'S1IK', 'S1 Ilmu Komunikasi', 5, 5),
(28, 'S1IKIC', 'S1 Ilmu Komunikasi (International Class)', 5, 5),
(29, 'S1DPR', 'S1 Digital Public Relation', 5, 5),
(30, 'S1DKV', 'S1 Desain Komunikasi Visual', 6, 6),
(31, 'S1DKVIC', 'S1 Desain Komunikasi VIsual (International Class)', 6, 6),
(32, 'S1PIM', 'S1 Product Innovation & Management', 6, 6),
(33, 'S1DI', 'S1 Desain Interior', 6, 6),
(34, 'S1K', 'S1 Kriya (Fashion and Textile Design)', 6, 6),
(35, 'S1VA', 'S1 Visual Arts (Seni Rupa)', 6, 6),
(36, 'S2D', 'S2 Design', 6, 6),
(37, 'D3TT', 'D3 Teknologi Telekomunikasi', 7, 7),
(38, 'D3TI', 'D3 Teknik Informatika', 7, 7),
(39, 'D3SI', 'D3 Sistem Informasi', 7, 9),
(40, 'D3SIA', 'D3 Sistem Informasi Akuntansi', 7, 7),
(41, 'D3TK', 'D3 Teknologi Komputer', 7, 7),
(42, 'D3DM', 'D3 Digital Marketing', 7, 7),
(43, 'D3P', 'D3 Perhotelan', 7, 7),
(44, 'S1TTRM', 'S1 Terapan Teknologi Rekayasa Multimedia', 7, 7);

-- --------------------------------------------------------

--
-- Table structure for table `status_mahasiswa`
--

CREATE TABLE `status_mahasiswa` (
  `id` int(11) NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `status_mahasiswa`
--

INSERT INTO `status_mahasiswa` (`id`, `status`) VALUES
(1, 'Aktif'),
(2, 'Tidak Aktif'),
(3, 'Lulus'),
(4, 'Keluar'),
(5, 'Cuti'),
(6, 'Student Exchange'),
(7, 'Drop Out'),
(8, 'Administrasi Bermasalah');

-- --------------------------------------------------------

--
-- Table structure for table `sub_nilai_mata_kuliah`
--

CREATE TABLE `sub_nilai_mata_kuliah` (
  `id` int(11) NOT NULL,
  `nama_penilaian` varchar(255) NOT NULL,
  `bobot` decimal(5,2) NOT NULL,
  `nilai` decimal(5,2) NOT NULL,
  `id_nilai_mata_kuliah` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sub_nilai_mata_kuliah`
--

INSERT INTO `sub_nilai_mata_kuliah` (`id`, `nama_penilaian`, `bobot`, `nilai`, `id_nilai_mata_kuliah`) VALUES
(1, 'Assessment 1', '0.15', '71.99', '1'),
(3, 'Praktikum', '0.40', '83.50', '1'),
(17, 'Assessment 2', '0.15', '90.00', '1'),
(18, 'UAS', '0.40', '78.00', '2'),
(19, 'UTS', '0.60', '100.00', '2'),
(20, 'Assessment 1', '0.20', '78.00', '5'),
(21, 'Assessment 2', '0.15', '90.00', '5'),
(22, 'Assessment 3 (Tubes)', '0.40', '80.10', '5'),
(23, 'Praktikum', '0.25', '77.00', '5'),
(34, 'Tugas', '0.30', '81.00', '1'),
(35, '6701180123', '0.00', '0.90', '1'),
(61, 'Assessment 1', '0.00', '100.00', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tahun_ajaran`
--

CREATE TABLE `tahun_ajaran` (
  `id` int(11) NOT NULL,
  `tahun_ajaran` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tahun_ajaran`
--

INSERT INTO `tahun_ajaran` (`id`, `tahun_ajaran`) VALUES
(1, '1999/2000'),
(2, '2000/2001'),
(3, '2001/2002'),
(4, '2002/2003'),
(5, '2003/2004'),
(6, '2004/2005'),
(7, '2005/2006'),
(8, '2006/2007'),
(9, '2007/2008'),
(10, '2008/2009'),
(11, '2009/2010'),
(12, '2010/2011'),
(13, '2011/2012'),
(14, '2012/2013'),
(15, '2013/2014'),
(16, '2014/2015'),
(17, '2015/2016'),
(18, '2016/2017'),
(19, '2017/2018'),
(20, '2018/2019'),
(21, '2019/2020'),
(22, '2020/2021'),
(23, '2021/2022'),
(24, '2022/2023'),
(25, '2023/2024'),
(26, '2024/2025');

-- --------------------------------------------------------

--
-- Table structure for table `tak`
--

CREATE TABLE `tak` (
  `id` int(11) NOT NULL,
  `id_nilai_mahasiswa` int(11) NOT NULL,
  `aktivitas` varchar(255) NOT NULL,
  `deskripsi` varchar(255) NOT NULL,
  `semester` int(11) NOT NULL,
  `tahun_ajaran` varchar(128) NOT NULL,
  `poin` int(11) NOT NULL,
  `date_create` int(11) NOT NULL,
  `date_update` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tak`
--

INSERT INTO `tak` (`id`, `id_nilai_mahasiswa`, `aktivitas`, `deskripsi`, `semester`, `tahun_ajaran`, `poin`, `date_create`, `date_update`) VALUES
(1, 6, 'Lomba MHQ', 'mendapatkan Juara I Lomba MHQ seprovinsi Jawa Barat', 1, '2018/2019', 10, 1610533749, 1610536197),
(2, 6, 'Asprak Alpro', 'Asprak Alpro 1 semester', 3, '2019/2020', 15, 1610534820, 1610536193),
(3, 6, 'Asprak AMP', 'Koordinator Asprak AMP', 3, '2019/2020', 25, 1610535241, 1610536134);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `gender` varchar(128) NOT NULL,
  `place_of_birth` varchar(128) NOT NULL,
  `birthday` date DEFAULT NULL,
  `phone_number` varchar(128) NOT NULL,
  `address` varchar(255) NOT NULL,
  `religion_id` int(11) NOT NULL,
  `image` varchar(128) NOT NULL,
  `password` varchar(256) NOT NULL,
  `role_id` int(11) NOT NULL,
  `is_active` int(1) NOT NULL,
  `date_created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `gender`, `place_of_birth`, `birthday`, `phone_number`, `address`, `religion_id`, `image`, `password`, `role_id`, `is_active`, `date_created`) VALUES
(1, 'Muhammad Haitsam', 'haitsam03@gmail.com', 'Laki-laki', 'Madinah', '1999-02-18', '082117503125', 'Jl. Raya Cilamaya, Dusun Kedung Asem, Desa Mekarmaya, Kec. Cilamaya Wetan, Kab. Karawang - Prov. Jawa barat', 1, 'foto.jpg', '$2y$10$5HmjAb/tpIjcvuK8Joxubewp.TPceUrMsaYwdG.ekB3VDwj89ghpG', 1, 1, 1609656473),
(2, 'Olga Paurenta', 'olgapaurenta12@gmail.com', 'Perempuan', 'Medan', '2000-11-26', '082169006807', 'Jl Jahe 13 No 3 Simalingkar, Kelurahan Mangga, Kecamatan Medan Tuntungan, Kota Medan  Kode Pos 20141', 2, 'default.svg', '$2y$10$DCdpAINyOx1J.gReZF1AwOvyvGSSClU9MBoRRB/WAwOtYav0bmKRS', 3, 1, 1609656737),
(3, 'Sandhika Galih', 'sandika@gmail.com', 'Laki-laki', 'Bandung', '1991-11-11', '082117504322', 'Bandung', 1, 'default.svg', '$2y$10$DLCp6ce7jyHem7q/eNcPbOeYeuU8dp3kwtgZ5lz3aVsDaIJsgjPHu', 2, 1, 1609657135),
(6, 'Muhammad Haitsam', 'mhaitsam18@gmail.com', 'Laki-laki', 'Madinah', '1999-02-18', '089118202112', 'Bandung', 1, 'default.svg', '$2y$10$.ixo7mdt30yfQNM2rpo3pOMyYgYV4MzqdX0m.4LqjXaAEFv.mgqk6', 3, 1, 1609925711),
(8, 'Wahyu Hidayat', 'wahyuhidayat@gmail.com', 'Laki-laki', 'Bandung', '1990-01-01', '082112212390', 'Bandung', 1, 'default.svg', '$2y$10$GynSl8Y92FlCUIayOIZDPe8LBpTyFVQN48mCZjL1E9MSK1Vs4tqhC', 4, 1, 1610019862),
(9, 'Pramuko Aji', 'pramuko@gmail.com', 'Laki-laki', 'Bandung', '1980-01-01', '081318189000', 'Bandung', 1, 'default.svg', '$2y$10$Out/o3bhw0QpWxPt46QmSu8DDBq9cm4zOPw8SlAAmTxjgq7oBn36y', 4, 1, 1610019892),
(10, 'Ely Rosely', 'elyrosely@gmail.com', 'Perempuan', 'Bandung', '1982-01-11', '081220747000', 'Bandung', 1, 'default.svg', '$2y$10$qvL8MR6SNSUCjsTGWBsCH.Xul7pP9m1fex4HR8.9kvb1OKN232hge', 4, 1, 1610019940),
(11, 'Inne Gartina Husein', 'inne@gmail.com', 'Perempuan', 'Bandung', '1990-01-02', '081282802091', 'Bandung', 1, 'default.svg', '$2y$10$Fv/rA660Ewip7f7Dh6jaZeDqHcCdxjCYVhbp35XcCa0Q0a3yt3gfO', 4, 1, 1610019985),
(12, 'Wawa Wikusna', 'wawa@gmail.com', 'Laki-laki', 'Bandung', '1999-01-01', '082123913012', 'Bandung', 1, 'default.svg', '$2y$10$.LRiiBJEbO6sV0DZ6Jn0vucY7T4Dy9VeZyKGMbw..GqYvLDJkvIh.', 5, 1, 1610020015),
(13, 'Firman Aldo Saputra', 'fasaldo1999@gmail.com', 'Laki-laki', 'Padang', '1999-09-02', '085672102013', 'Padang', 1, 'default.svg', '$2y$10$KvD7H4qak5C6GDVR8LRh/eFgYa50eGV7rqiWFYjPJL5Qc6MZNFyVu', 1, 1, 1610023446),
(14, 'Vinka Silvia Putri Ananda', 'pinkasilpia@gmail.com', 'Perempuan', 'Brebes', '2000-06-06', '081728283901', 'Brebes', 1, 'default.svg', '$2y$10$z5pUzTo0ionCJiFtvHsuy.phxiCrmWOLjHDn956knC52H54XfGEzu', 3, 1, 1610034285),
(15, 'Muhammad Barja Sanjaya', 'muhammadbarja@gmail.com', 'Laki-laki', 'Bandung', '1990-01-01', '082139831203', 'Ciparay Bandung', 1, 'default.svg', '$2y$10$CWjx/Rx/Tw/rwsBSerdtw.oNfodK/2.jFq2j.SEgWt2.wun7WZXsK', 4, 1, 1610280453),
(16, 'Januarizqi Dwi Mileniantoro', 'januarrizqi5@gmail.com', ':Laki-laki', 'Kediri', '2000-01-17', '082120391023', 'Kediri', 1, 'default.svg', '$2y$10$MiqD99oEXqNIfspNu83nv.iH/Us9b2HIR3xmFM6dxg/s7lotueMja', 3, 1, 1610507816),
(17, 'Suryatiningsih', 'suryatiningsih@gmail.com', 'Perempuan', 'Bandung', '1989-01-01', '0812391283012', 'PBB', 1, 'default.svg', '$2y$10$hv4vvwLyMrP58tSQlYT9PuB6tF8BHD73MxkiApHOdTj7rGu/d1Uka', 4, 1, 1610509684),
(18, 'Ersa Nur Maulana', 'ersanum@gmail.com', 'Perempuan', 'Bogor', '2000-04-29', '0822221231231', 'Cigombong, Bogor', 1, 'default.svg', '$2y$10$e/eTDQMJEqD88Mjm4gTimuRyJ0H8kb0fawIb8hPSD8Le2u6sHi1hi', 3, 1, 1610529882),
(19, 'Haitsam', 'haitsamhaitsam18@yahoo.com', 'Laki-laki', 'Madinah', '1999-02-18', '082117503125', 'Coba', 1, 'default.svg', '$2y$10$znTqQhmeEay4cXSEEnniw./sHxWxBpKJyyF2Us2zcygU07QoVP.2G', 2, 1, 1610556667),
(20, 'Muhammad Shibghotul \'Adalah', 'shibghotul7@gmail.com', 'Laki-laki', 'Tangerang', '1999-08-26', '081812091221', 'Tangerang', 1, 'default.svg', '$2y$10$tr7j8omT8mIgzoOrHP03SuanisUyMLttzZJBl/h2JNIHix5kRwR/O', 3, 1, 1610556792),
(22, 'Akib Dahlan', 'akibdahlan20@gmail.com', 'Laki-laki', 'Palembang', '1999-02-20', '082289412433', 'Palembang', 1, 'default.svg', '$2y$10$54Ajl0R.ArBF45hyXCsJZOnTdLzoegtv9nJbBRs3ICk1QBv1kS5yW', 3, 1, 1614472317),
(23, 'Hariadi Arfah', 'hariadi@gmail.com', 'Laki-laki', 'Makasar', '2021-04-29', '1232413', 'Jl. Anggrek', 1, 'default.svg', '$2y$10$xdBJJL4N9ZQ31E2If1IB9ux4dD4eWuMuwbxuOhm2exkBZv1fzY93a', 3, 0, 1619257734),
(24, 'Albert Frans kevin', 'albert@gmail.com', 'Laki-laki', 'Sumatra', '2021-04-29', '1232413', 'Jl. Anggrek', 2, 'default.svg', '$2y$10$uyuY2u.QNodhhFwliwiqfejbqUFTTSLh9SBLdm0qgapnUIBZS42Eu', 3, 1, 1619258809);

-- --------------------------------------------------------

--
-- Table structure for table `user_access_menu`
--

CREATE TABLE `user_access_menu` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_access_menu`
--

INSERT INTO `user_access_menu` (`id`, `role_id`, `menu_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 2, 2),
(4, 1, 3),
(5, 1, 4),
(6, 1, 5),
(7, 1, 6),
(8, 3, 6),
(9, 4, 4),
(10, 3, 2),
(11, 4, 2),
(12, 1, 7),
(13, 5, 8),
(14, 5, 2),
(15, 5, 4),
(16, 1, 8),
(17, 4, 5),
(18, 5, 5);

-- --------------------------------------------------------

--
-- Table structure for table `user_menu`
--

CREATE TABLE `user_menu` (
  `id` int(11) NOT NULL,
  `menu` varchar(128) NOT NULL,
  `active` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_menu`
--

INSERT INTO `user_menu` (`id`, `menu`, `active`) VALUES
(1, 'Admin', 1),
(2, 'User', 1),
(3, 'Menu', 1),
(4, 'Dosen Wali', 1),
(5, 'Dosen Pengampu', 0),
(6, 'Mahasiswa', 1),
(7, 'DataMaster', 1),
(8, 'Kaprodi', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `id` int(11) NOT NULL,
  `role` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id`, `role`) VALUES
(1, 'administrator'),
(2, 'member'),
(3, 'mahasiswa'),
(4, 'dosen'),
(5, 'kaprodi');

-- --------------------------------------------------------

--
-- Table structure for table `user_sub_menu`
--

CREATE TABLE `user_sub_menu` (
  `id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `title` varchar(128) NOT NULL,
  `url` varchar(128) NOT NULL,
  `icon` varchar(128) NOT NULL,
  `is_active` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_sub_menu`
--

INSERT INTO `user_sub_menu` (`id`, `menu_id`, `title`, `url`, `icon`, `is_active`) VALUES
(1, 1, 'Dashboard', 'admin/', 'fas fa-fw fa-tachometer-alt', 1),
(2, 2, 'My Profile', 'user/', 'fas fa-fw fa-user', 1),
(3, 2, 'Edit Profile', 'user/edit', 'fas fa-fw fa-user-edit', 1),
(4, 3, 'Menu Management', 'menu/', 'fas fa-fw fa-folder', 1),
(5, 3, 'Submenu Management', 'menu/subMenu', 'fas fa-fw fa-folder-open', 1),
(6, 1, 'Role Management', 'admin/role', 'fas fa-fw fa-user-tie', 1),
(7, 2, 'Change Password', 'user/changePassword', 'fas fa-fw fa-key', 1),
(8, 1, 'Data User', 'admin/dataUser/', 'fas fa-fw fa-user-tie', 1),
(9, 4, 'Dashboard Dosen Wali', 'dosen/', 'fas fa-fw fa-tachometer-alt', 1),
(10, 7, 'Data Master', 'DataMaster/', 'fas fa-fw fa-database', 1),
(11, 7, 'Data Fakultas', 'DataMaster/fakultas/', 'fas fa-fw fa-building', 1),
(12, 7, 'Data Prodi', 'DataMaster/prodi/', 'fas fa-fw fa-laptop-house', 1),
(13, 7, 'Data Kelas', 'DataMaster/kelas/', 'fas fa-fw fa-glasses', 1),
(14, 7, 'Data Mata Kuliah', 'DataMaster/mataKuliah/', 'fas fa-fw fa-book-open', 1),
(15, 8, 'Dashboard Kaprodi', 'kaprodi/', 'fas fa-fw fa-tachometer-alt', 1),
(16, 4, 'Performa Mahasiswa', 'Dosen/performa', 'fas fa-fw fa-graduation-cap', 1),
(17, 4, 'Data Nilai Mahasiswa', 'Dosen/nilaiMahasiswa', 'fas fa-fw fa-pen', 1),
(18, 6, 'Performaku', 'mahasiswa/', 'fas fa-fw fa-user-graduate', 1),
(19, 5, 'Pengampu Mata Kuliah', 'dosen/pengampu', 'fas fa-fw fa-university', 0),
(20, 5, 'Data Sub Nilai Mata Kuliah', 'dosen/subNilaiMataKuliah', 'fas fa-fw fa-pencil-ruler', 0),
(21, 6, 'Data TAK', 'mahasiswa/tak', 'fas fa-fw fa-pen-alt', 1),
(22, 7, 'Data Agama', 'DataMaster/agama/', 'fas fa-fw fa-pray', 1),
(23, 2, 'Profil Perkuliahan', 'user/profilPerkuliahan', 'fas fa-fw fa-user-secret', 1),
(24, 7, 'Data Dashboard', 'DataMaster/dashboard/', 'fas fa-fw fa-edit', 1),
(25, 4, 'Data Nilai Mata Kuliah', 'dosen/nilaiMataKuliah', 'fas fa-fw fa-pencil-alt', 1),
(26, 7, 'Data Pendidikan', 'DataMaster/pendidikan/', 'fas fa-fw fa-graduation-cap', 1),
(27, 7, 'Data Status Mahasiswa', 'DataMaster/statusMahasiswa', 'fas fa-fw fa-user-graduate', 1),
(28, 8, 'Data Pengampu Mata Kuliah', 'kaprodi/pengampu', 'fas fa-fw fa-briefcase', 1),
(29, 7, 'Data Tahun Ajaran', 'DataMaster/tahunAjaran/', 'fas fa-fw fa-chalkboard', 1),
(30, 7, 'Data Konten', 'DataMaster/konten', 'far fa-fw fa-newspaper', 1),
(31, 8, 'Data Performa Kelas', 'kaprodi/performaKelas', 'fas fa-fw fa-chalkboard', 1),
(32, 2, 'Keamanan', 'User/keamanan', 'fas fa-fw fa-shield-alt', 1),
(33, 7, 'Data Pertanyaan', 'DataMaster/pertanyaan', 'fas fa-fw fa-question', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_token`
--

CREATE TABLE `user_token` (
  `id` int(11) NOT NULL,
  `email` varchar(128) NOT NULL,
  `token` varchar(255) NOT NULL,
  `date_created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_token`
--

INSERT INTO `user_token` (`id`, `email`, `token`, `date_created`) VALUES
(4, 'haitsam03@gmail.com', 'iscmRCWne+lTCfqz/25n5R8VUX5MUkaN02Bhum3gVsU=', 1609930420),
(5, 'haitsam03@gmail.com', 'n5QKD1D9vUL9QiROw9MO4pgD/fbbdFGYrGd8znIJWe4=', 1609932048),
(6, 'haitsam03@gmail.com', 'wPG+3htmGqTKAArzVlpS/b0eoqor9TKqG16H5cDvMqA=', 1609932054),
(7, 'aa@aa.a', 'oIK0LUztcU02aYAE6HG86eh7Fq5/TcK17wF7B/To+/k=', 1609941391),
(8, 'wahyuhidayat@gmail.com', 'h5OYZb29deEXYS/1Bc69GOaWseVwGEhhSXVKert9Oog=', 1610019862),
(9, 'pramuko@gmail.com', 'ijlFNaUwBrUcqEbANwlEml1FluVkgWAOvEPf3VtE9H4=', 1610019892),
(10, 'elyrosely@gmail.com', 'zLt8OC5aT9LrQaCipRl09/n95aUTUUjwCiVtKM150uA=', 1610019940),
(11, 'inne@gmail.com', '6kl2FFh6027PAQ51K03uIlFz8f3+e59snpxLo3jAOBE=', 1610019985),
(12, 'wawa@gmail.com', '/g7m4I60ysY6Ljs6xsHhye5zWPyA0eR/4qwv7r7czlo=', 1610020015),
(13, 'fasaldo1999@gmail.com', 'fOSWX9UdFnoi7ejSOIkhye7te1tVdT+cXmd1hh0YZCQ=', 1610023446),
(15, 'muhammadbarja@gmail.com', 'VpatS/tgTK/bfTZLlDDoVX9aaD6Kb3YoeS2/ozJOhXI=', 1610280453),
(16, 'januarizqi5@gmail.com', '8QKHOpK1ROQrW679QbREt1fb2wdgcsffl5PLahNGPws=', 1610507816),
(17, 'suryatiningsih@gmail.com', 'IvVR3KjJpnh+lnQgeWOmpht3w235j9Vax2GkkDCzUBE=', 1610509684),
(18, 'ersanum@gmail.com', 'Tst2ygGt8n2wUa+RsqvtHguZMn1KPTaiNE63D4wwehQ=', 1610529882),
(19, 'haitsamhaitsam18@yahoo.com', '06vONmPAIi0hj/xgLH72Ck6FSDDyqs96P9pxA5bOU54=', 1610556667),
(20, 'shibghotul7@gmail.com', 'zLT3U4RCMM6pc1pVBCI3SodKzlAVJmG13PbfY8ijFnU=', 1610556792),
(21, 'haitsam03@gmail.com', 'oVyGSYjGv4lTvFvUKawPJ96cj42FYlkQW8QcyPDghSQ=', 1611588824),
(22, 'akibdahlan20@gmail.com', 'Q5sF4roomYzNnHkIS0zKCHKteza6KwrK5GYaHqlJr8w=', 1614472096),
(23, 'akibdahlan21@gmail.com', 'M23yBdkPPwctLera1YG1Eccpx5PFhn1vNyKEeEqVpT0=', 1614472317),
(24, 'haitsam03@gmail.com', '5qEQkfSN18gV6URb/vT4fGhn2LBf45NCnhP0AvFlF+I=', 1614914638),
(25, 'hariadi@gmail.com', 'YHRFtu0S6Zr+XXofagpGWFUT/ORLU2Ja3NPy8pRjnfg=', 1619257734),
(26, 'albert@gmail.com', 'l4CPFB1haO6eKgRrd3jSqHR1S3JAQD33/xQo9W0AbsI=', 1619258809);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agama`
--
ALTER TABLE `agama`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `content`
--
ALTER TABLE `content`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dashboard`
--
ALTER TABLE `dashboard`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dosen`
--
ALTER TABLE `dosen`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fakultas`
--
ALTER TABLE `fakultas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ip_semester`
--
ALTER TABLE `ip_semester`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mata_kuliah`
--
ALTER TABLE `mata_kuliah`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nilai_mahasiswa`
--
ALTER TABLE `nilai_mahasiswa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nilai_mata_kuliah`
--
ALTER TABLE `nilai_mata_kuliah`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pendidikan`
--
ALTER TABLE `pendidikan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengampu`
--
ALTER TABLE `pengampu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pertanyaan_1`
--
ALTER TABLE `pertanyaan_1`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pertanyaan_2`
--
ALTER TABLE `pertanyaan_2`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pertanyaan_keamanan`
--
ALTER TABLE `pertanyaan_keamanan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prodi`
--
ALTER TABLE `prodi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status_mahasiswa`
--
ALTER TABLE `status_mahasiswa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_nilai_mata_kuliah`
--
ALTER TABLE `sub_nilai_mata_kuliah`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tahun_ajaran`
--
ALTER TABLE `tahun_ajaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tak`
--
ALTER TABLE `tak`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_access_menu`
--
ALTER TABLE `user_access_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_menu`
--
ALTER TABLE `user_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_token`
--
ALTER TABLE `user_token`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agama`
--
ALTER TABLE `agama`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `content`
--
ALTER TABLE `content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `dashboard`
--
ALTER TABLE `dashboard`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `dosen`
--
ALTER TABLE `dosen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `fakultas`
--
ALTER TABLE `fakultas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `ip_semester`
--
ALTER TABLE `ip_semester`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=133;

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `mata_kuliah`
--
ALTER TABLE `mata_kuliah`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `nilai_mahasiswa`
--
ALTER TABLE `nilai_mahasiswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `nilai_mata_kuliah`
--
ALTER TABLE `nilai_mata_kuliah`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `pendidikan`
--
ALTER TABLE `pendidikan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `pengampu`
--
ALTER TABLE `pengampu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pertanyaan_1`
--
ALTER TABLE `pertanyaan_1`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pertanyaan_2`
--
ALTER TABLE `pertanyaan_2`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pertanyaan_keamanan`
--
ALTER TABLE `pertanyaan_keamanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `prodi`
--
ALTER TABLE `prodi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `status_mahasiswa`
--
ALTER TABLE `status_mahasiswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `sub_nilai_mata_kuliah`
--
ALTER TABLE `sub_nilai_mata_kuliah`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `tahun_ajaran`
--
ALTER TABLE `tahun_ajaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `tak`
--
ALTER TABLE `tak`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `user_access_menu`
--
ALTER TABLE `user_access_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `user_menu`
--
ALTER TABLE `user_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `user_token`
--
ALTER TABLE `user_token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
