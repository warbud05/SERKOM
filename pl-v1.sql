-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql105.infinityfree.com
-- Waktu pembuatan: 09 Jul 2025 pada 21.18
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
-- Database: `if0_39434032_v1`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` varchar(11) NOT NULL,
  `no_meter` varchar(50) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `tenggang` varchar(2) DEFAULT NULL,
  `id_tarif` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `no_meter`, `nama`, `alamat`, `tenggang`, `id_tarif`) VALUES
('PLG-47206', '250709139552', 'Muhammad Rohman Syah', 'JAKARTA TIMUR', '09', 1),
('PLG-51727', '250709478062', 'wq', 'q1', '09', 1),
('PLG-68448', '250709439807', 'Miselsa Anisdria Susanto', 'JAKARTA TIMUR', '09', 5);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_pembayaran` int(11) NOT NULL,
  `id_tagihan` varchar(11) NOT NULL,
  `id_penggunaan` int(11) NOT NULL,
  `id_petugas` int(11) NOT NULL,
  `id_pelanggan` varchar(11) NOT NULL,
  `no_meter` varchar(50) NOT NULL,
  `meter_awal` int(11) NOT NULL,
  `meter_akhir` int(11) NOT NULL,
  `kode_tarif` varchar(50) NOT NULL,
  `bulan` int(11) NOT NULL,
  `tahun` int(11) NOT NULL,
  `nama_pelanggan` varchar(255) NOT NULL,
  `jumlah_meter` int(11) NOT NULL,
  `tarif_perkwh` decimal(10,2) NOT NULL,
  `tagihan_listrik` decimal(10,2) NOT NULL,
  `biaya_admin` decimal(10,2) NOT NULL,
  `denda` decimal(10,2) NOT NULL,
  `total_bayar` decimal(10,2) NOT NULL,
  `jumlah_uang` decimal(10,2) NOT NULL,
  `uang_kembali` decimal(10,2) NOT NULL,
  `tanggal_pembayaran` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `penggunaan`
--

CREATE TABLE `penggunaan` (
  `id_penggunaan` int(11) NOT NULL,
  `id_pelanggan` varchar(11) NOT NULL,
  `bulan` int(11) NOT NULL,
  `tahun` int(11) NOT NULL,
  `meter_awal` decimal(10,0) NOT NULL,
  `meter_akhir` decimal(10,0) NOT NULL,
  `tgl_cek` date NOT NULL,
  `id_petugas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `penggunaan`
--

INSERT INTO `penggunaan` (`id_penggunaan`, `id_pelanggan`, `bulan`, `tahun`, `meter_awal`, `meter_akhir`, `tgl_cek`, `id_petugas`) VALUES
(6, 'PLG-47206', 1, 2025, '12', '912', '2025-07-09', 1),
(7, 'PLG-68448', 1, 2025, '80', '6680', '2025-07-09', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `petugas`
--

CREATE TABLE `petugas` (
  `id_petugas` int(11) NOT NULL,
  `nama_petugas` varchar(100) NOT NULL,
  `alamat` varchar(200) NOT NULL,
  `no_telepon` varchar(20) NOT NULL,
  `jk` enum('Laki-laki','Perempuan') NOT NULL,
  `foto_profil` varchar(200) DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `biaya_admin` decimal(10,2) NOT NULL DEFAULT 0.00,
  `akses` enum('Petugas','Agen') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `petugas`
--

INSERT INTO `petugas` (`id_petugas`, `nama_petugas`, `alamat`, `no_telepon`, `jk`, `foto_profil`, `username`, `password`, `biaya_admin`, `akses`) VALUES
(1, 'John Smith', '123 Main St, New York', '1234567890', 'Laki-laki', NULL, 'admin', '$2y$10$GUh1SGflTPmfZrU3uYVRpOGY0ody85Vw5C3tNVfVc2JOMojjLxrem', '0.00', 'Petugas'),
(2, 'Emily Johnson', '456 Elm St, Los Angeles', '0987654321', 'Perempuan', NULL, 'agen', '$2y$10$RtnHn0IXTrwQ1sQKL8RnuedmzFGOkCdZ.7ysDBgnxx779H/mhXry6', '10000.00', 'Agen');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tagihan`
--

CREATE TABLE `tagihan` (
  `id_tagihan` varchar(20) NOT NULL,
  `id_pelanggan` varchar(11) NOT NULL,
  `bulan` varchar(2) NOT NULL,
  `tahun` year(4) NOT NULL,
  `jumlah_meter` int(11) NOT NULL,
  `tarif_perkwh` decimal(10,0) NOT NULL,
  `jumlah_bayar` decimal(10,0) NOT NULL,
  `status` varchar(15) NOT NULL,
  `id_petugas` int(11) NOT NULL,
  `id_penggunaan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tagihan`
--

INSERT INTO `tagihan` (`id_tagihan`, `id_pelanggan`, `bulan`, `tahun`, `jumlah_meter`, `tarif_perkwh`, `jumlah_bayar`, `status`, `id_petugas`, `id_penggunaan`) VALUES
('BYR-41851', 'PLG-68448', '1', 2025, 6600, '1700', '11220000', 'Belum Dibayar', 1, 7),
('BYR-88870', 'PLG-47206', '1', 2025, 900, '1352', '1216800', 'Belum Dibayar', 1, 6);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tarif`
--

CREATE TABLE `tarif` (
  `id_tarif` int(11) NOT NULL,
  `kode_tarif` varchar(50) NOT NULL,
  `golongan` varchar(50) NOT NULL,
  `daya` varchar(20) NOT NULL,
  `tarif_perkwh` decimal(15,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tarif`
--

INSERT INTO `tarif` (`id_tarif`, `kode_tarif`, `golongan`, `daya`, `tarif_perkwh`) VALUES
(1, 'TR-900VA', 'R-1', '900', '1352'),
(2, 'TR-1300VA', 'R-1', '1300', '1444'),
(3, 'TR-2200VA', 'R-1', '2200', '1441'),
(4, 'TR-3500-5500VA', 'R-2', '5500', '1700'),
(5, 'TR-6600VA', 'R-3', '6600', '1700');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`),
  ADD KEY `id_tarif` (`id_tarif`);

--
-- Indeks untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`),
  ADD KEY `id_tagihan` (`id_tagihan`),
  ADD KEY `id_penggunaan` (`id_penggunaan`),
  ADD KEY `id_petugas` (`id_petugas`),
  ADD KEY `id_pelanggan` (`id_pelanggan`);

--
-- Indeks untuk tabel `penggunaan`
--
ALTER TABLE `penggunaan`
  ADD PRIMARY KEY (`id_penggunaan`),
  ADD KEY `id_pelanggan` (`id_pelanggan`),
  ADD KEY `id_petugas` (`id_petugas`);

--
-- Indeks untuk tabel `petugas`
--
ALTER TABLE `petugas`
  ADD PRIMARY KEY (`id_petugas`),
  ADD UNIQUE KEY `uk_username` (`username`),
  ADD KEY `idx_akses` (`akses`);

--
-- Indeks untuk tabel `tagihan`
--
ALTER TABLE `tagihan`
  ADD PRIMARY KEY (`id_tagihan`),
  ADD KEY `id_pelanggan` (`id_pelanggan`),
  ADD KEY `id_petugas` (`id_petugas`),
  ADD KEY `id_penggunaan` (`id_penggunaan`);

--
-- Indeks untuk tabel `tarif`
--
ALTER TABLE `tarif`
  ADD PRIMARY KEY (`id_tarif`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id_pembayaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `penggunaan`
--
ALTER TABLE `penggunaan`
  MODIFY `id_penggunaan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `petugas`
--
ALTER TABLE `petugas`
  MODIFY `id_petugas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `tarif`
--
ALTER TABLE `tarif`
  MODIFY `id_tarif` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD CONSTRAINT `pelanggan_ibfk_1` FOREIGN KEY (`id_tarif`) REFERENCES `tarif` (`id_tarif`);

--
-- Ketidakleluasaan untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`id_tagihan`) REFERENCES `tagihan` (`id_tagihan`) ON DELETE CASCADE,
  ADD CONSTRAINT `pembayaran_ibfk_2` FOREIGN KEY (`id_penggunaan`) REFERENCES `penggunaan` (`id_penggunaan`) ON DELETE CASCADE,
  ADD CONSTRAINT `pembayaran_ibfk_3` FOREIGN KEY (`id_petugas`) REFERENCES `petugas` (`id_petugas`),
  ADD CONSTRAINT `pembayaran_ibfk_4` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`);

--
-- Ketidakleluasaan untuk tabel `penggunaan`
--
ALTER TABLE `penggunaan`
  ADD CONSTRAINT `penggunaan_ibfk_1` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`),
  ADD CONSTRAINT `penggunaan_ibfk_2` FOREIGN KEY (`id_petugas`) REFERENCES `petugas` (`id_petugas`);

--
-- Ketidakleluasaan untuk tabel `tagihan`
--
ALTER TABLE `tagihan`
  ADD CONSTRAINT `tagihan_ibfk_1` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`),
  ADD CONSTRAINT `tagihan_ibfk_2` FOREIGN KEY (`id_petugas`) REFERENCES `petugas` (`id_petugas`),
  ADD CONSTRAINT `tagihan_ibfk_3` FOREIGN KEY (`id_penggunaan`) REFERENCES `penggunaan` (`id_penggunaan`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
