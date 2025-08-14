-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql203.infinityfree.com
-- Waktu pembuatan: 14 Agu 2025 pada 07.48
-- Versi server: 11.4.7-MariaDB
-- Versi PHP: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `if0_39696997_presensi`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `hari_libur`
--

CREATE TABLE `hari_libur` (
  `id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `hari_libur`
--

INSERT INTO `hari_libur` (`id`, `tanggal`, `keterangan`) VALUES
(1, '2025-08-18', 'Cuti Bersama Hari Kemerdekaan Republik Indonesia Ke-80'),
(2, '2025-07-01', 'persiapan'),
(3, '2025-07-02', 'persiapan'),
(4, '2025-07-03', 'persiapan'),
(5, '2025-07-04', 'persiapan'),
(6, '2025-07-05', 'persiapan'),
(7, '2025-07-06', 'persiapan'),
(8, '2025-07-07', 'persiapan'),
(9, '2025-07-08', 'persiapan'),
(10, '2025-07-09', 'persiapan'),
(11, '2025-07-10', 'persiapan'),
(12, '2025-07-11', 'persiapan'),
(13, '2025-07-12', 'persiapan'),
(14, '2025-07-13', 'persiapan'),
(15, '2025-07-14', 'persiapan'),
(16, '2025-07-15', 'persiapan'),
(17, '2025-07-16', 'persiapan'),
(18, '2025-07-17', 'persiapan'),
(19, '2025-07-18', 'persiapan'),
(20, '2025-07-19', 'persiapan'),
(21, '2025-07-20', 'persiapan'),
(22, '2025-07-21', 'persiapan'),
(23, '2025-07-22', 'persiapan'),
(24, '2025-07-23', 'persiapan'),
(25, '2025-07-24', 'persiapan'),
(26, '2025-07-25', 'persiapan'),
(27, '2025-07-26', 'persiapan'),
(28, '2025-07-27', 'persiapan'),
(29, '2025-07-28', 'persiapan'),
(30, '2025-07-29', 'persiapan'),
(31, '2025-07-30', 'persiapan'),
(32, '2025-07-31', 'persiapan'),
(33, '2025-08-01', 'persiapan'),
(34, '2025-08-02', 'persiapan'),
(35, '2025-08-03', 'persiapan'),
(36, '2025-08-04', 'persiapan'),
(37, '2025-08-05', 'persiapan'),
(38, '2025-08-06', 'persiapan'),
(39, '2025-08-07', 'persiapan'),
(40, '2025-08-08', 'persiapan'),
(41, '2025-08-09', 'persiapan'),
(42, '2025-08-10', 'persiapan'),
(43, '2025-08-11', 'persiapan'),
(44, '2025-08-12', 'persiapan'),
(46, '2025-08-13', 'Persiapan'),
(47, '2025-01-01', 'Tahap pengembangan'),
(48, '2025-01-02', 'Tahap pengembangan'),
(49, '2025-01-03', 'Tahap pengembangan'),
(50, '2025-01-04', 'Tahap pengembangan'),
(51, '2025-01-05', 'Tahap pengembangan'),
(52, '2025-01-06', 'Tahap pengembangan'),
(53, '2025-01-07', 'Tahap pengembangan'),
(54, '2025-01-08', 'Tahap pengembangan'),
(55, '2025-01-09', 'Tahap pengembangan'),
(56, '2025-01-10', 'Tahap pengembangan'),
(57, '2025-01-11', 'Tahap pengembangan'),
(58, '2025-01-12', 'Tahap pengembangan'),
(59, '2025-01-13', 'Tahap pengembangan'),
(60, '2025-01-14', 'Tahap pengembangan'),
(61, '2025-01-15', 'Tahap pengembangan'),
(62, '2025-01-16', 'Tahap pengembangan'),
(63, '2025-01-17', 'Tahap pengembangan'),
(64, '2025-01-18', 'Tahap pengembangan'),
(65, '2025-01-19', 'Tahap pengembangan'),
(66, '2025-01-20', 'Tahap pengembangan'),
(67, '2025-01-21', 'Tahap pengembangan'),
(68, '2025-01-22', 'Tahap pengembangan'),
(69, '2025-01-23', 'Tahap pengembangan'),
(70, '2025-01-24', 'Tahap pengembangan'),
(71, '2025-01-25', 'Tahap pengembangan'),
(72, '2025-01-26', 'Tahap pengembangan'),
(73, '2025-01-27', 'Tahap pengembangan'),
(74, '2025-01-28', 'Tahap pengembangan'),
(75, '2025-01-29', 'Tahap pengembangan'),
(76, '2025-01-30', 'Tahap pengembangan'),
(77, '2025-01-31', 'Tahap pengembangan'),
(78, '2025-02-01', 'Tahap pengembangan'),
(79, '2025-02-02', 'Tahap pengembangan'),
(80, '2025-02-03', 'Tahap pengembangan'),
(81, '2025-02-04', 'Tahap pengembangan'),
(82, '2025-02-05', 'Tahap pengembangan'),
(83, '2025-02-06', 'Tahap pengembangan'),
(84, '2025-02-07', 'Tahap pengembangan'),
(85, '2025-02-08', 'Tahap pengembangan'),
(86, '2025-02-09', 'Tahap pengembangan'),
(87, '2025-02-10', 'Tahap pengembangan'),
(88, '2025-02-11', 'Tahap pengembangan'),
(89, '2025-02-12', 'Tahap pengembangan'),
(90, '2025-02-13', 'Tahap pengembangan'),
(91, '2025-02-14', 'Tahap pengembangan'),
(92, '2025-02-15', 'Tahap pengembangan'),
(93, '2025-02-16', 'Tahap pengembangan'),
(94, '2025-02-17', 'Tahap pengembangan'),
(95, '2025-02-18', 'Tahap pengembangan'),
(96, '2025-02-19', 'Tahap pengembangan'),
(97, '2025-02-20', 'Tahap pengembangan'),
(98, '2025-02-21', 'Tahap pengembangan'),
(99, '2025-02-22', 'Tahap pengembangan'),
(100, '2025-02-23', 'Tahap pengembangan'),
(101, '2025-02-24', 'Tahap pengembangan'),
(102, '2025-02-25', 'Tahap pengembangan'),
(103, '2025-02-26', 'Tahap pengembangan'),
(104, '2025-02-27', 'Tahap pengembangan'),
(105, '2025-02-28', 'Tahap pengembangan'),
(106, '2025-03-01', 'Tahap pengembangan'),
(107, '2025-03-02', 'Tahap pengembangan'),
(108, '2025-03-03', 'Tahap pengembangan'),
(109, '2025-03-04', 'Tahap pengembangan'),
(110, '2025-03-05', 'Tahap pengembangan'),
(111, '2025-03-06', 'Tahap pengembangan'),
(112, '2025-03-07', 'Tahap pengembangan'),
(113, '2025-03-08', 'Tahap pengembangan'),
(114, '2025-03-09', 'Tahap pengembangan'),
(115, '2025-03-10', 'Tahap pengembangan'),
(116, '2025-03-11', 'Tahap pengembangan'),
(117, '2025-03-12', 'Tahap pengembangan'),
(118, '2025-03-13', 'Tahap pengembangan'),
(119, '2025-03-14', 'Tahap pengembangan'),
(120, '2025-03-15', 'Tahap pengembangan'),
(121, '2025-03-16', 'Tahap pengembangan'),
(122, '2025-03-17', 'Tahap pengembangan'),
(123, '2025-03-18', 'Tahap pengembangan'),
(124, '2025-03-19', 'Tahap pengembangan'),
(125, '2025-03-20', 'Tahap pengembangan'),
(126, '2025-03-21', 'Tahap pengembangan'),
(127, '2025-03-22', 'Tahap pengembangan'),
(128, '2025-03-23', 'Tahap pengembangan'),
(129, '2025-03-24', 'Tahap pengembangan'),
(130, '2025-03-25', 'Tahap pengembangan'),
(131, '2025-03-26', 'Tahap pengembangan'),
(132, '2025-03-27', 'Tahap pengembangan'),
(133, '2025-03-28', 'Tahap pengembangan'),
(134, '2025-03-29', 'Tahap pengembangan'),
(135, '2025-03-30', 'Tahap pengembangan'),
(136, '2025-03-31', 'Tahap pengembangan'),
(137, '2025-04-01', 'Tahap pengembangan'),
(138, '2025-04-02', 'Tahap pengembangan'),
(139, '2025-04-03', 'Tahap pengembangan'),
(140, '2025-04-04', 'Tahap pengembangan'),
(141, '2025-04-05', 'Tahap pengembangan'),
(142, '2025-04-06', 'Tahap pengembangan'),
(143, '2025-04-07', 'Tahap pengembangan'),
(144, '2025-04-08', 'Tahap pengembangan'),
(145, '2025-04-09', 'Tahap pengembangan'),
(146, '2025-04-10', 'Tahap pengembangan'),
(147, '2025-04-11', 'Tahap pengembangan'),
(148, '2025-04-12', 'Tahap pengembangan'),
(149, '2025-04-13', 'Tahap pengembangan'),
(150, '2025-04-14', 'Tahap pengembangan'),
(151, '2025-04-15', 'Tahap pengembangan'),
(152, '2025-04-16', 'Tahap pengembangan'),
(153, '2025-04-17', 'Tahap pengembangan'),
(154, '2025-04-18', 'Tahap pengembangan'),
(155, '2025-04-19', 'Tahap pengembangan'),
(156, '2025-04-20', 'Tahap pengembangan'),
(157, '2025-04-21', 'Tahap pengembangan'),
(158, '2025-04-22', 'Tahap pengembangan'),
(159, '2025-04-23', 'Tahap pengembangan'),
(160, '2025-04-24', 'Tahap pengembangan'),
(161, '2025-04-25', 'Tahap pengembangan'),
(162, '2025-04-26', 'Tahap pengembangan'),
(163, '2025-04-27', 'Tahap pengembangan'),
(164, '2025-04-28', 'Tahap pengembangan'),
(165, '2025-04-29', 'Tahap pengembangan'),
(166, '2025-04-30', 'Tahap pengembangan'),
(167, '2025-05-01', 'Tahap pengembangan'),
(168, '2025-05-02', 'Tahap pengembangan'),
(169, '2025-05-03', 'Tahap pengembangan'),
(170, '2025-05-04', 'Tahap pengembangan'),
(171, '2025-05-05', 'Tahap pengembangan'),
(172, '2025-05-06', 'Tahap pengembangan'),
(173, '2025-05-07', 'Tahap pengembangan'),
(174, '2025-05-08', 'Tahap pengembangan'),
(175, '2025-05-09', 'Tahap pengembangan'),
(176, '2025-05-10', 'Tahap pengembangan'),
(177, '2025-05-11', 'Tahap pengembangan'),
(178, '2025-05-12', 'Tahap pengembangan'),
(179, '2025-05-13', 'Tahap pengembangan'),
(180, '2025-05-14', 'Tahap pengembangan'),
(181, '2025-05-15', 'Tahap pengembangan'),
(182, '2025-05-16', 'Tahap pengembangan'),
(183, '2025-05-17', 'Tahap pengembangan'),
(184, '2025-05-18', 'Tahap pengembangan'),
(185, '2025-05-19', 'Tahap pengembangan'),
(186, '2025-05-20', 'Tahap pengembangan'),
(187, '2025-05-21', 'Tahap pengembangan'),
(188, '2025-05-22', 'Tahap pengembangan'),
(189, '2025-05-23', 'Tahap pengembangan'),
(190, '2025-05-24', 'Tahap pengembangan'),
(191, '2025-05-25', 'Tahap pengembangan'),
(192, '2025-05-26', 'Tahap pengembangan'),
(193, '2025-05-27', 'Tahap pengembangan'),
(194, '2025-05-28', 'Tahap pengembangan'),
(195, '2025-05-29', 'Tahap pengembangan'),
(196, '2025-05-30', 'Tahap pengembangan'),
(197, '2025-05-31', 'Tahap pengembangan'),
(198, '2025-06-01', 'Tahap pengembangan'),
(199, '2025-06-02', 'Tahap pengembangan'),
(200, '2025-06-03', 'Tahap pengembangan'),
(201, '2025-06-04', 'Tahap pengembangan'),
(202, '2025-06-05', 'Tahap pengembangan'),
(203, '2025-06-06', 'Tahap pengembangan'),
(204, '2025-06-07', 'Tahap pengembangan'),
(205, '2025-06-08', 'Tahap pengembangan'),
(206, '2025-06-09', 'Tahap pengembangan'),
(207, '2025-06-10', 'Tahap pengembangan'),
(208, '2025-06-11', 'Tahap pengembangan'),
(209, '2025-06-12', 'Tahap pengembangan'),
(210, '2025-06-13', 'Tahap pengembangan'),
(211, '2025-06-14', 'Tahap pengembangan'),
(212, '2025-06-15', 'Tahap pengembangan'),
(213, '2025-06-16', 'Tahap pengembangan'),
(214, '2025-06-17', 'Tahap pengembangan'),
(215, '2025-06-18', 'Tahap pengembangan'),
(216, '2025-06-19', 'Tahap pengembangan'),
(217, '2025-06-20', 'Tahap pengembangan'),
(218, '2025-06-21', 'Tahap pengembangan'),
(219, '2025-06-22', 'Tahap pengembangan'),
(220, '2025-06-23', 'Tahap pengembangan'),
(221, '2025-06-24', 'Tahap pengembangan'),
(222, '2025-06-25', 'Tahap pengembangan'),
(223, '2025-06-26', 'Tahap pengembangan'),
(224, '2025-06-27', 'Tahap pengembangan'),
(225, '2025-06-28', 'Tahap pengembangan'),
(226, '2025-06-29', 'Tahap pengembangan'),
(227, '2025-06-30', 'Tahap pengembangan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kelas`
--

CREATE TABLE `kelas` (
  `id` int(11) NOT NULL,
  `nama_kelas` varchar(20) NOT NULL,
  `wali_kelas_id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `kelas`
--

INSERT INTO `kelas` (`id`, `nama_kelas`, `wali_kelas_id`) VALUES
(1, 'Kelas I', 5),
(2, 'Kelas II', 8),
(3, 'Kelas IV', 3),
(4, 'Kelas V', 9),
(5, 'Kelas VI', 4),
(6, 'Kelas III', 11);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengaturan`
--

CREATE TABLE `pengaturan` (
  `pengaturan_id` varchar(50) NOT NULL,
  `pengaturan_value` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `pengaturan`
--

INSERT INTO `pengaturan` (`pengaturan_id`, `pengaturan_value`) VALUES
('nama_sekolah', 'SD NEGERI SUKOKERTO 01'),
('kepala_sekolah_id', '1');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengguna`
--

CREATE TABLE `pengguna` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(100) DEFAULT NULL,
  `peran` enum('admin','guru') NOT NULL DEFAULT 'guru'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `pengguna`
--

INSERT INTO `pengguna` (`id`, `username`, `password`, `nama_lengkap`, `peran`) VALUES
(1, '20523318', '$2y$10$y2kEOEHlmTY9184waUrJR.uXdpzRZvPYQ9naxX3IIwWDCPjeer44q', 'Administrator', 'admin'),
(2, 'Guru', '$2y$10$C32a/9EVmKEAr/GcGoI5YO48jF9gfdnqXCLwDKZsy58L.6wn5wg6G', 'Guru', 'guru'),
(3, 'Admin', '$2y$10$IjRLrtymqVTkpPbDGq95qOqY0FlbzGqxRdUEikJGYrA9lGqHNTECO', 'Administrator', 'admin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `presensi`
--

CREATE TABLE `presensi` (
  `id` int(11) NOT NULL,
  `siswa_id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `status` enum('.','S','I','A') NOT NULL,
  `tahun_ajaran` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `siswa`
--

CREATE TABLE `siswa` (
  `id` int(11) NOT NULL,
  `no_induk` varchar(20) NOT NULL,
  `nama_siswa` varchar(100) NOT NULL,
  `kelas_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `siswa`
--

INSERT INTO `siswa` (`id`, `no_induk`, `nama_siswa`, `kelas_id`) VALUES
(1, '1999', 'LOVINA NADYA NOVANIA', 1),
(2, '2022', 'ABDUH TSABIT RAMADANI', 1),
(3, '2023', 'ABDURRAHMAN WAHID', 1),
(4, '2024', 'AMAR DANIS HUSNI ABBASY', 1),
(5, '2025', 'AMELIATUL HASANAH', 1),
(6, '2026', 'ANGEL SYAFA NURAINI', 1),
(7, '2027', 'ANINDIA JANNATUL FAUZIAH', 1),
(8, '2028', 'ANINDITA KEISHA ZAHRA', 1),
(9, '2029', 'CITRA HUSNA AMALINA AFIDA', 1),
(10, '2030', 'FARA ASKA RAMADANI', 1),
(11, '2031', 'FEBI AOFA NIDA ZAQIYAH', 1),
(12, '2032', 'FINA AINUN NAJAH', 1),
(13, '2033', 'IFRA KANAYA MIKAYLA', 1),
(14, '2034', 'LAYLATUL MUSYARROFAH', 1),
(15, '2035', 'MUHAMMAD ALBY RIZKY ILHAMI', 1),
(16, '2036', 'MUHAMMAD ALIFUL HASANI', 1),
(17, '2037', 'MUHAMMAD ANDIKA MAULANA', 1),
(18, '2038', 'MUHAMMAD ARIFIN', 1),
(19, '2039', 'MUHAMMAD GHANDI ROMADON', 1),
(20, '2040', 'MUHAMMAD IKROM', 1),
(21, '2041', 'MUHAMMAD IQBAL HASANI', 1),
(22, '2042', 'MUHAMMAD RENDI ANDIKA AFANDI', 1),
(23, '2043', 'MUHAMMAD SAMSUL ARIFIN', 1),
(24, '2044', 'NAYSILATUL BADRIAH', 1),
(25, '2045', 'NUR HASANAH', 1),
(26, '2046', 'SA\'ADATUL KHAIRIN NIKMAH', 1),
(27, '2047', 'SITI RABBIYA', 1),
(28, '2048', 'ZAHIRA QORINATUL INAYAH', 1),
(29, '1991', 'ADAM MUSTHAFI ILMI', 2),
(30, '1992', 'ADITYA AINUR RACHMAN', 2),
(31, '1993', 'AHMAD WILDAN MAULIDI FARHANSYAH', 2),
(32, '1994', 'AHMAD ZAFIK ISBATUL MAULA', 2),
(33, '1995', 'DEWI ANGGITA VEBI MUWAVIK', 2),
(34, '1996', 'ENDITA CITRA SARIFAH', 2),
(35, '1997', 'FATHIR TAUFIK', 2),
(36, '1998', 'IKLIMA SALSABILA', 2),
(37, '2000', 'MOCH. ADINATA AILEEN CAESAR', 2),
(38, '2001', 'MOH. ARTANABIL RAQILA SHAHBAZ', 2),
(39, '2002', 'MOHAMMAD ROSADI', 2),
(40, '2003', 'MUHAMMAD AGIL HAMIZAN', 2),
(41, '2004', 'MUHAMMAD AQIL SYAFIQ', 2),
(42, '2005', 'MUHAMMAD KEVIN HAMIZAN', 2),
(43, '2006', 'MUHAMMAD RAFI MAHFUDI', 2),
(44, '2007', 'MUHAMMAD REYHAN PUTRA ABRISAM', 2),
(45, '2008', 'MUHAMMAD RISKI HIDAYAT', 2),
(46, '2009', 'MUHAMMAD YAHSUN PRATAMA', 2),
(47, '2010', 'NAURA HASNA ANNIDA', 2),
(48, '2011', 'REZA MAULANA', 2),
(49, '2012', 'RIFATUL ILMIYAH', 2),
(50, '2013', 'SELFIATUL HASANAH', 2),
(51, '2014', 'SHAFA BASIROH', 2),
(52, '2015', 'SITI ALFIATUL FITRIYAH', 2),
(53, '2016', 'SITI HAMIDAH', 2),
(54, '2017', 'USWATUN HASANAH', 2),
(55, '2018', 'ZAENUL', 2),
(56, '2019', 'ZAFRAN AL FAUZAN', 2),
(57, '2020', 'ZAKIYATUNNUFUS', 2),
(58, '1956', 'ACHMAD MAULANA AL FARIZI', 6),
(59, '1957', 'AHMAD AFANDIK', 6),
(60, '1958', 'AZRINA GHAZALA FALIHAH', 6),
(61, '1959', 'BERIEL GANIS RAFSANJAYA', 6),
(62, '1960', 'DINI FAHRISA', 6),
(63, '1961', 'EGA ZALFINA ZYAHRA', 6),
(64, '1963', 'IFATUL KARIMAH', 6),
(65, '1964', 'JULIAN SEZHA AZZAHRA', 6),
(66, '1965', 'MAI SHERLY PUTRI', 6),
(67, '1966', 'MIFTAH AOFAL MUBAROK', 6),
(68, '1967', 'MOCH DAFA IBNU HAFIZ', 6),
(69, '1968', 'MOHAMMAD FARHAN', 6),
(70, '1969', 'MUHAMMAD DAFA AL FARISI', 6),
(71, '1970', 'MUHAMMAD DANIAL HAYDAR ALI', 6),
(72, '1971', 'MUHAMMAD FADIL HASANI', 6),
(73, '1972', 'MUHAMMAD FAHRIL HAMZAH', 6),
(74, '1973', 'MOHAMMAD FAREL MAULANA', 6),
(75, '1974', 'MUHAMMAD HAKIKI', 6),
(76, '1975', 'MUHAMMAD RENDY KURNIAWAN', 6),
(77, '1976', 'MUHAMMAD YUSUF', 6),
(78, '1977', 'NAFISATUL OKTAVIANI', 6),
(79, '1978', 'NAJWA KIRANA ALFIYA HASNA', 6),
(80, '1979', 'QOTRUNNADA NUR AZIZAH', 6),
(81, '1980', 'RAIZA SISILIA', 6),
(82, '1981', 'REFA ARINAL HAEROT', 6),
(83, '1982', 'REFI ARINIL HAEROT', 6),
(84, '1983', 'SAFINATUL FAJRIYAH', 6),
(85, '1984', 'SITI HASHILATUS SABILAH SILMI', 6),
(86, '1985', 'SITI RAEYZA', 6),
(87, '1986', 'SITI VERADATUS SOFIYAH', 6),
(88, '1987', 'SITI ZAQIATUS ZAHIROH', 6),
(89, '1988', 'ZAFQA ZUMAN WIJAYA', 6),
(90, '1928', 'ABDULLAH FAKIH', 3),
(91, '1929', 'ALEX ABRAHAM PRATAMA', 3),
(92, '1930', 'ANDI FRANNATA KUSUMA', 3),
(93, '1931', 'AULIA SA\'ADAH', 3),
(94, '1932', 'CHIKA KANZA KHALIDA', 3),
(95, '1933', 'INDRA ANDRIANSYAH', 3),
(96, '1934', 'IZZATUL HUMAIROH', 3),
(97, '1935', 'M SYAFIRUL HIDAYAT', 3),
(98, '1936', 'MUHAMMAD RADITYA HUSNUL YAKIN', 3),
(99, '1937', 'MOCH FAIS FARHAT ABBAS', 3),
(100, '1938', 'MOHAMMAD AFANDI', 3),
(101, '1939', 'MUHAMMAD DAFA SAPUTRA', 3),
(102, '1940', 'MUHAMMAD DANIL RAHMATULLAH', 3),
(103, '1941', 'MUHAMMAD DHOFIR HUSAIRI', 3),
(104, '1942', 'MUHAMMAD DZULFIKRI', 3),
(105, '1943', 'MUHAMMAD RIZKI AFANDI', 3),
(106, '1944', 'MUHAMMAD SOBRI TAUFIQURROHMAN', 3),
(107, '1945', 'MUHAMMAD ZAINURI RAMADANI', 3),
(108, '1946', 'NAYLA FEBRIANI ALISA PUTRI', 3),
(109, '1947', 'REGA FIRMANSYAH', 3),
(110, '1948', 'RENIA NURFADILA', 3),
(111, '1949', 'RIFDA ARINA DIFAH', 3),
(112, '1950', 'RISKA SUPRIATI', 3),
(113, '1951', 'SALSAFIA FIRDAUSIAH', 3),
(114, '1952', 'SITI NAFISAH', 3),
(115, '1953', 'SITI RATNA SARI', 3),
(116, '1954', 'SITI SULIS', 3),
(117, '1955', 'ZAHIDA QALBI NADHIFA', 3),
(118, '1990', 'MOH ALDI SHAPUTRA SHARIF', 3),
(119, '1898', 'AHMAD SHOLIHIN ALFIN', 4),
(120, '1899', 'ALIYA FAIZATUL AZIZAH', 4),
(121, '1901', 'EVA NIKMATUL LAILI', 4),
(122, '1902', 'FAKHRIE ZHAFRAN SYAWAL', 4),
(123, '1903', 'FATIMATUS ZAHRO', 4),
(124, '1905', 'IVADATUL KHOMALIAH', 4),
(125, '1906', 'LIWAUL AKIFIN', 4),
(126, '1907', 'M HABIBUS SOLIHIN', 4),
(127, '1908', 'MUHAMMAD ZAFRAN AL RIDWAN', 4),
(128, '1909', 'MOCH. NAZRIL MAULIDI', 4),
(129, '1910', 'MOHAMMAD SAUGI ANNAFI', 4),
(130, '1911', 'MUHAMMAD AFTON TAUFIKI', 4),
(131, '1912', 'MUHAMAD ROIHAN ABDILLAH', 4),
(132, '1913', 'MUHAMMAD FIYAN RAMADHANI', 4),
(133, '1914', 'MUHAMMAD HUBAIBILLAH ABD. BARI', 4),
(134, '1915', 'MUHAMMAD SYAIDAL MUKARROMY', 4),
(135, '1916', 'MUHAMMAD ZIONI FAHMI', 4),
(136, '1917', 'NAYLATUL IFROH', 4),
(137, '1918', 'NOVI ANGGITA SARI', 4),
(138, '1919', 'NURUL AINI', 4),
(139, '1920', 'OKTA DWI NAYLA', 4),
(140, '1921', 'OKTAVIA DWI MAHARANI', 4),
(141, '1923', 'SITI AISYSAH ZAHRA ANNAILA', 4),
(142, '1924', 'SITI ROFIKOH', 4),
(143, '1925', 'SITTI NAWERAH', 4),
(144, '1926', 'Andrev Ivo Fitrah Ramadlony', 4),
(145, '1989', 'RISMATUL KHAIROH', 4),
(146, '1872', 'ADIBAH BILQIS ULFA SALSABILA', 5),
(147, '1873', 'AHMAD ARIEF ARIYANTO', 5),
(148, '1874', 'ANGGA SAPUTRA', 5),
(149, '1875', 'ANISATUL MAULIDA', 5),
(150, '1876', 'CAESAR MARADITA PURWANTO', 5),
(151, '1877', 'ILHAM KARIMULLAH', 5),
(152, '1878', 'IMAM KHAIRUL ANNAS', 5),
(153, '1879', 'INTAN YUBSIRUFI', 5),
(154, '1880', 'ISTIANAH', 5),
(155, '1881', 'M. DO\'A SYAFIULLAH', 5),
(156, '1882', 'M. SAIFI ALI', 5),
(157, '1883', 'MAIROFATUSA\'ADEH', 5),
(158, '1884', 'MUHAMMAD IZAD AL KAMIL', 5),
(159, '1885', 'MUHAMMAD RAMADANI', 5),
(160, '1886', 'MUHAMMAD RICO RISKI ANSYAH', 5),
(161, '1887', 'MUHAMMAD ZAKI HAMZAH', 5),
(162, '1888', 'MUHAMMAD ZAKY SHOLEH', 5),
(163, '1889', 'MUHLISATUL HASANAH', 5),
(164, '1890', 'NAJWA ARIVIATUL MAULA', 5),
(165, '1891', 'QIRANI KAFFAH DAIMA', 5),
(166, '1892', 'RAUDATUL ILMIYAH', 5),
(167, '1893', 'SITI ROFIKOH', 5),
(168, '1894', 'SUBHANUL FALAH', 5),
(169, '1895', 'TASYA NUR FADILAH', 5),
(170, '1896', 'ZAHIROTUS SOFIYAH', 5),
(171, '1927', 'SOFIATUL MUNAWAROH', 5);

-- --------------------------------------------------------

--
-- Struktur dari tabel `wali_kelas`
--

CREATE TABLE `wali_kelas` (
  `id` int(11) NOT NULL,
  `nip` varchar(30) DEFAULT NULL,
  `nama_wali` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `wali_kelas`
--

INSERT INTO `wali_kelas` (`id`, `nip`, `nama_wali`) VALUES
(1, '19821209 201412 2 002', 'ANI BUDIARTININGSIH, S.Pd.SD'),
(3, '19840831 201001 2 008', 'ATIKAH NUR ROCHIMA, S.Pd.'),
(4, '19760617 200801 1 013', 'TAUFIK HIDAYAT, S.Pd.'),
(5, '19830207 202121 2 004', 'ANI WAHYU SULISTYONINGSIH, S.Pd.'),
(7, NULL, 'EKA ISLAMIATUL CHAYAT, S.Pd'),
(8, NULL, 'LILIK IRIANI, S.Pd.'),
(9, NULL, 'M. ARIFUR RAHMAN'),
(10, NULL, 'TANZIL KAROMI, S.Pd.'),
(11, NULL, 'AFNANINGSIH, S.Pd.');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `hari_libur`
--
ALTER TABLE `hari_libur`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tanggal` (`tanggal`);

--
-- Indeks untuk tabel `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama_kelas` (`nama_kelas`),
  ADD KEY `wali_kelas_id` (`wali_kelas_id`);

--
-- Indeks untuk tabel `pengaturan`
--
ALTER TABLE `pengaturan`
  ADD PRIMARY KEY (`pengaturan_id`);

--
-- Indeks untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `presensi`
--
ALTER TABLE `presensi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `presensi_unik` (`siswa_id`,`tanggal`);

--
-- Indeks untuk tabel `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `no_induk` (`no_induk`),
  ADD KEY `kelas_id` (`kelas_id`);

--
-- Indeks untuk tabel `wali_kelas`
--
ALTER TABLE `wali_kelas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nip` (`nip`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `hari_libur`
--
ALTER TABLE `hari_libur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=228;

--
-- AUTO_INCREMENT untuk tabel `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `presensi`
--
ALTER TABLE `presensi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT untuk tabel `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=172;

--
-- AUTO_INCREMENT untuk tabel `wali_kelas`
--
ALTER TABLE `wali_kelas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
