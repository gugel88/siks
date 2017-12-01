-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 29, 2017 at 06:27 AM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_siks`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_artikel`
--

CREATE TABLE `tbl_artikel` (
  `artikel_id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `artikel_judul` varchar(100) NOT NULL,
  `artikel_tgl` datetime NOT NULL,
  `artikel_img` varchar(100) NOT NULL,
  `artikel_konten` text NOT NULL,
  `artikel_label` varchar(30) NOT NULL,
  `artikel_hitung` int(11) NOT NULL,
  `kategori_id` int(11) NOT NULL,
  `artikel_status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_artikel`
--

INSERT INTO `tbl_artikel` (`artikel_id`, `id_user`, `artikel_judul`, `artikel_tgl`, `artikel_img`, `artikel_konten`, `artikel_label`, `artikel_hitung`, `kategori_id`, `artikel_status`) VALUES
(1, 2, 'Topologi Jaringan Komputer', '2017-11-18 14:17:45', '1510989465_forest-1950402_1920.jpg', '<p>Topologi jaringan adalah sebuah cara dalam menyambungkan jaringan pada komputer</p>\r\n', 'TIK, VII 1', 13, 1, 'unpublish');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_berkas`
--

CREATE TABLE `tbl_berkas` (
  `berkas_id` int(11) NOT NULL,
  `berkas_tgl` datetime NOT NULL,
  `berkas_nama` varchar(100) NOT NULL,
  `berkas_type` varchar(20) NOT NULL,
  `berkas_size` varchar(20) NOT NULL,
  `berkas_lokasi` varchar(255) NOT NULL,
  `id_user` int(11) NOT NULL,
  `berkas_status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_bukutamu`
--

CREATE TABLE `tbl_bukutamu` (
  `buku_id` int(11) NOT NULL,
  `buku_nama` varchar(50) NOT NULL,
  `buku_email` varchar(30) NOT NULL,
  `buku_tlp` varchar(20) NOT NULL,
  `buku_pesan` text NOT NULL,
  `buku_status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_guru`
--

CREATE TABLE `tbl_guru` (
  `guru_id` int(11) NOT NULL,
  `guru_nip` varchar(25) NOT NULL,
  `guru_img` varchar(150) DEFAULT NULL,
  `guru_nama` varchar(50) NOT NULL,
  `guru_alamat` text NOT NULL,
  `guru_tlp` varchar(20) NOT NULL,
  `guru_email` varchar(30) NOT NULL,
  `guru_desk` text NOT NULL,
  `guru_jabatan` varchar(30) NOT NULL,
  `guru_walikelas` varchar(25) NOT NULL,
  `guru_status` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_guru`
--

INSERT INTO `tbl_guru` (`guru_id`, `guru_nip`, `guru_img`, `guru_nama`, `guru_alamat`, `guru_tlp`, `guru_email`, `guru_desk`, `guru_jabatan`, `guru_walikelas`, `guru_status`) VALUES
(1, '2017001', 'default.jpg', 'WHISNU ABDUL LATIEP', 'KP. CIGAWIR CITAMIANG', '085822220000', 'whisnuabdullatiep@siks.sch.id', 'Deskripsiku', 'guru', 'Tidak', 'aktif'),
(2, '2017002', 'default.jpg', 'DENI HERDA', 'KP CISITU CITAMIANG ', '085822221111', 'deniherda@siks.sch.id', 'Deskripsiku', 'guru', 'Tidak', 'aktif'),
(3, '2017003', 'default.jpg', 'NENDA SHOPIYA ASPARI', 'KP ANCOL CITAMIANG', '085822220011', 'nendashopiyaaspari@siks.sch.id', 'Halo ini deskrpisku', 'guru', 'Tidak', 'aktif');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_guru_mapel`
--

CREATE TABLE `tbl_guru_mapel` (
  `guru_id` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `mapel_id` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `kelas_id` int(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_guru_mapel`
--

INSERT INTO `tbl_guru_mapel` (`guru_id`, `mapel_id`, `kelas_id`) VALUES
('1', '1', 1),
('2', '2', 1),
('3', '3', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_jadpel`
--

CREATE TABLE `tbl_jadpel` (
  `mapel_id` int(3) NOT NULL,
  `kelas_id` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `hari` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `jam` varchar(15) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_jadpel`
--

INSERT INTO `tbl_jadpel` (`mapel_id`, `kelas_id`, `hari`, `jam`) VALUES
(3, '1', 'Senin', '09:00 - 10:00'),
(2, '1', 'Selasa', '08:00 - 09:00'),
(1, '1', 'Senin', '07:00 - 08:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_kategori`
--

CREATE TABLE `tbl_kategori` (
  `kategori_id` int(11) NOT NULL,
  `kategori_nama` varchar(30) NOT NULL,
  `kategori_tentang` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_kategori`
--

INSERT INTO `tbl_kategori` (`kategori_id`, `kategori_nama`, `kategori_tentang`) VALUES
(1, 'Materi', 'artikel'),
(2, 'Tugas', 'artikel'),
(3, 'Pengumuman', 'artikel');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_kelas`
--

CREATE TABLE `tbl_kelas` (
  `kelas_id` int(5) NOT NULL,
  `kelas_nama` varchar(25) NOT NULL,
  `kelas_jumlahsiswa` varchar(25) NOT NULL,
  `kelas_thnajaran` varchar(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_kelas`
--

INSERT INTO `tbl_kelas` (`kelas_id`, `kelas_nama`, `kelas_jumlahsiswa`, `kelas_thnajaran`) VALUES
(1, 'VII 1', '40', '2017/2018'),
(2, 'VII 2', '40', '2017/2018'),
(3, 'VII 3', '40', '2017/2018');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_komentar`
--

CREATE TABLE `tbl_komentar` (
  `komentar_id` int(11) NOT NULL,
  `artikel_id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `komentar_tgl` datetime NOT NULL,
  `komentar_konten` text NOT NULL,
  `komentar_status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_komentar`
--

INSERT INTO `tbl_komentar` (`komentar_id`, `artikel_id`, `id_user`, `komentar_tgl`, `komentar_konten`, `komentar_status`) VALUES
(1, 1, 3, '2017-11-18 14:19:59', 'Terima kasih pak sangat membantu', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_mapel`
--

CREATE TABLE `tbl_mapel` (
  `mapel_id` int(11) NOT NULL,
  `mapel_nama` varchar(225) NOT NULL,
  `mapel_keterangan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_mapel`
--

INSERT INTO `tbl_mapel` (`mapel_id`, `mapel_nama`, `mapel_keterangan`) VALUES
(1, 'KIMIA', 'WAJIB'),
(2, 'FISIKA', 'WAJIB'),
(3, 'MTK', 'WAJIB');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_nilai`
--

CREATE TABLE `tbl_nilai` (
  `siswa_id` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `mapel_id` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `semester` enum('Ganjil','Genap') COLLATE utf8_unicode_ci NOT NULL,
  `thn_ajaran` varchar(9) COLLATE utf8_unicode_ci NOT NULL,
  `afektif` int(3) DEFAULT NULL,
  `komulatif` int(3) DEFAULT NULL,
  `psikomotorik` int(3) DEFAULT NULL,
  `rata` int(3) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_nilai`
--

INSERT INTO `tbl_nilai` (`siswa_id`, `mapel_id`, `semester`, `thn_ajaran`, `afektif`, `komulatif`, `psikomotorik`, `rata`) VALUES
('1', '1', 'Ganjil', '2017-2018', 75, 97, 89, 87),
('1', '2', 'Ganjil', '2017-2018', 90, 89, 75, 85),
('1', '3', 'Ganjil', '2017-2018', 78, 87, 80, 82);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pengumuman`
--

CREATE TABLE `tbl_pengumuman` (
  `pengumuman_id` int(5) NOT NULL,
  `pengumuman_isi` text NOT NULL,
  `pengumuman_status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_pengumuman`
--

INSERT INTO `tbl_pengumuman` (`pengumuman_id`, `pengumuman_isi`, `pengumuman_status`) VALUES
(1, 'Aplikasi ini masih dalam tahap evaluasi dan pengembangan', 'unpublish'),
(2, 'UAS tahun pelajaran 2017/2018 akan dilaksanakan pada tanggal 20 s/d 27 Desember 2017', 'publish');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sekolah`
--

CREATE TABLE `tbl_sekolah` (
  `sekolah_id` int(11) NOT NULL,
  `sekolah_profil` text NOT NULL,
  `sekolah_visimisi` text NOT NULL,
  `sekolah_organisasi` text NOT NULL,
  `sekolah_alamat` text NOT NULL,
  `sekolah_tlp` varchar(20) NOT NULL,
  `sekolah_email` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_sekolah`
--

INSERT INTO `tbl_sekolah` (`sekolah_id`, `sekolah_profil`, `sekolah_visimisi`, `sekolah_organisasi`, `sekolah_alamat`, `sekolah_tlp`, `sekolah_email`) VALUES
(1, '<p>&nbsp;Profil SIKS (Sistem Informasi Akademik Sekolah)</p>', '<p>Visi &amp; Misi&nbsp;SIKS (Sistem Informasi Akademik Sekolah)</p>', '<p>Struktur Organisasi&nbsp;SIKS (Sistem Informasi Akademik Sekolah)</p>', 'JL. CIKONTRANG, CITAMIANG KM. 40 SUKABUMI, JAWA BARAT, KODE POS 43187', '(+62) 66-1234-56', 'kontak@sinisa.sch.id');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_siswa`
--

CREATE TABLE `tbl_siswa` (
  `siswa_id` int(11) NOT NULL,
  `siswa_nis` varchar(25) NOT NULL,
  `siswa_img` varchar(150) DEFAULT NULL,
  `siswa_nama` varchar(50) NOT NULL,
  `siswa_kelamin` varchar(10) NOT NULL,
  `siswa_alamat` text NOT NULL,
  `siswa_tlp` varchar(20) NOT NULL,
  `siswa_email` varchar(30) NOT NULL,
  `siswa_kelas` varchar(25) NOT NULL,
  `siswa_status` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_siswa`
--

INSERT INTO `tbl_siswa` (`siswa_id`, `siswa_nis`, `siswa_img`, `siswa_nama`, `siswa_kelamin`, `siswa_alamat`, `siswa_tlp`, `siswa_email`, `siswa_kelas`, `siswa_status`) VALUES
(1, '2017001', 'default.jpg', 'FERI EZWIN', 'LAKI-LAKI', 'KP CIAKAR DS CITAMIANG', '085712349999', 'feriezwin001@siks.sch.id', 'VII 1', 'aktif'),
(2, '2017002', 'default.jpg', 'RISMAN', 'LAKI-LAKI', 'KP. LEMUR SAWAH RT/RW. 01/03 DS. LEMBUR SAWAH PABUARAN', '085612344444', 'risman@siks.sch.id', 'VII 2', 'aktif'),
(3, '2017003', 'default.jpg', 'ABDUL HAMID', 'LAKI-LAKI', 'KP. CIAKAR DS. NEGLASARI PURABAYA', '085766665555', 'abdulhamid@siks.sch.id', 'VII 3', 'aktif');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tenagakerja`
--

CREATE TABLE `tbl_tenagakerja` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `jenis_kelamin` varchar(255) NOT NULL,
  `nip` varchar(255) NOT NULL,
  `nuptk` varchar(255) NOT NULL,
  `npa_pgri` varchar(255) NOT NULL,
  `golongan_ruang` varchar(255) NOT NULL,
  `tempat_lahir` varchar(255) NOT NULL,
  `tanggal_lahir` varchar(20) NOT NULL,
  `status` varchar(255) NOT NULL,
  `jenjang_pendidikan` varchar(255) NOT NULL,
  `jurusan_pendidikan` varchar(255) NOT NULL,
  `tahun_lulusan_pendidikan` double NOT NULL,
  `bidang_sertifikasi` varchar(255) NOT NULL,
  `tahun_lulus_sertifikasi` varchar(4) NOT NULL,
  `mata_pelajaran` varchar(255) NOT NULL,
  `jumlah_jam` double NOT NULL,
  `tenaga_kerja` varchar(255) NOT NULL,
  `nama_pengguna` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_tenagakerja`
--

INSERT INTO `tbl_tenagakerja` (`id`, `nama`, `jenis_kelamin`, `nip`, `nuptk`, `npa_pgri`, `golongan_ruang`, `tempat_lahir`, `tanggal_lahir`, `status`, `jenjang_pendidikan`, `jurusan_pendidikan`, `tahun_lulusan_pendidikan`, `bidang_sertifikasi`, `tahun_lulus_sertifikasi`, `mata_pelajaran`, `jumlah_jam`, `tenaga_kerja`, `nama_pengguna`, `password`) VALUES
(1, 'GURUKU', 'LAKI-LAKI', '123', '321', '123321', '1A', 'SUKABUMI', '23/01/1980', 'AKTIF', 'S1', 'TEKNIK INFORMATIKA', 2009, '-', '-', '2', 8, 'GURU', 'guruku', 'guruku');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id_user` int(11) NOT NULL,
  `nm_pengguna` varchar(25) NOT NULL,
  `nm_tampilan` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `kata_sandi` varchar(32) NOT NULL,
  `sandi_md5` varchar(32) NOT NULL,
  `gambar` varchar(150) DEFAULT NULL,
  `status` varchar(20) NOT NULL,
  `guru_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id_user`, `nm_pengguna`, `nm_tampilan`, `email`, `kata_sandi`, `sandi_md5`, `gambar`, `status`, `guru_id`) VALUES
(1, 'admin', 'ABDUL MUJIB', 'abdulmujib005@ummi.ac.id', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'petugas.jpg', 'admin', 0),
(2, 'guru1', 'WHISNU ABDUL LATIEP', 'whisnuabdullatiep@siks.sch.id', 'guru1', '92afb435ceb16630e9827f54330c59c9', 'default.jpg', 'guru', 1),
(3, '', 'Aku Siswa', 'akusiswa@siks.sch.id', '', '', 'guest4.jpg', 'pengunjung', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_artikel`
--
ALTER TABLE `tbl_artikel`
  ADD PRIMARY KEY (`artikel_id`);

--
-- Indexes for table `tbl_berkas`
--
ALTER TABLE `tbl_berkas`
  ADD PRIMARY KEY (`berkas_id`);

--
-- Indexes for table `tbl_bukutamu`
--
ALTER TABLE `tbl_bukutamu`
  ADD PRIMARY KEY (`buku_id`);

--
-- Indexes for table `tbl_guru`
--
ALTER TABLE `tbl_guru`
  ADD PRIMARY KEY (`guru_id`);

--
-- Indexes for table `tbl_guru_mapel`
--
ALTER TABLE `tbl_guru_mapel`
  ADD PRIMARY KEY (`guru_id`,`mapel_id`,`kelas_id`),
  ADD KEY `fk_tbl_guru_mapel_tbl_mapel` (`mapel_id`),
  ADD KEY `fk_tbl_guru_mapel_tbl_kelas` (`kelas_id`),
  ADD KEY `fk_tbl_guru_mapel_tbl_guru` (`guru_id`);

--
-- Indexes for table `tbl_jadpel`
--
ALTER TABLE `tbl_jadpel`
  ADD PRIMARY KEY (`mapel_id`,`kelas_id`,`hari`),
  ADD KEY `fk_tbl_jadpel_tbl_mape` (`mapel_id`),
  ADD KEY `fk_tbl_jadpel_tbl_kelas` (`kelas_id`);

--
-- Indexes for table `tbl_kategori`
--
ALTER TABLE `tbl_kategori`
  ADD PRIMARY KEY (`kategori_id`);

--
-- Indexes for table `tbl_kelas`
--
ALTER TABLE `tbl_kelas`
  ADD PRIMARY KEY (`kelas_id`);

--
-- Indexes for table `tbl_komentar`
--
ALTER TABLE `tbl_komentar`
  ADD PRIMARY KEY (`komentar_id`);

--
-- Indexes for table `tbl_mapel`
--
ALTER TABLE `tbl_mapel`
  ADD PRIMARY KEY (`mapel_id`);

--
-- Indexes for table `tbl_nilai`
--
ALTER TABLE `tbl_nilai`
  ADD PRIMARY KEY (`siswa_id`,`mapel_id`,`semester`,`thn_ajaran`),
  ADD KEY `fk_tbl_nilai_siswa` (`siswa_id`),
  ADD KEY `fk_tbl_nilai_mapel` (`mapel_id`);

--
-- Indexes for table `tbl_pengumuman`
--
ALTER TABLE `tbl_pengumuman`
  ADD PRIMARY KEY (`pengumuman_id`);

--
-- Indexes for table `tbl_sekolah`
--
ALTER TABLE `tbl_sekolah`
  ADD PRIMARY KEY (`sekolah_id`);

--
-- Indexes for table `tbl_siswa`
--
ALTER TABLE `tbl_siswa`
  ADD PRIMARY KEY (`siswa_id`);

--
-- Indexes for table `tbl_tenagakerja`
--
ALTER TABLE `tbl_tenagakerja`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_artikel`
--
ALTER TABLE `tbl_artikel`
  MODIFY `artikel_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tbl_berkas`
--
ALTER TABLE `tbl_berkas`
  MODIFY `berkas_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_bukutamu`
--
ALTER TABLE `tbl_bukutamu`
  MODIFY `buku_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_guru`
--
ALTER TABLE `tbl_guru`
  MODIFY `guru_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tbl_kategori`
--
ALTER TABLE `tbl_kategori`
  MODIFY `kategori_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tbl_kelas`
--
ALTER TABLE `tbl_kelas`
  MODIFY `kelas_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tbl_komentar`
--
ALTER TABLE `tbl_komentar`
  MODIFY `komentar_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tbl_mapel`
--
ALTER TABLE `tbl_mapel`
  MODIFY `mapel_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tbl_pengumuman`
--
ALTER TABLE `tbl_pengumuman`
  MODIFY `pengumuman_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tbl_sekolah`
--
ALTER TABLE `tbl_sekolah`
  MODIFY `sekolah_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tbl_siswa`
--
ALTER TABLE `tbl_siswa`
  MODIFY `siswa_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tbl_tenagakerja`
--
ALTER TABLE `tbl_tenagakerja`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
