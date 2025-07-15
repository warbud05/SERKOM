-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: pembayaran_listrik
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `pelanggan`
--

DROP TABLE IF EXISTS `pelanggan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pelanggan` (
  `id_pelanggan` varchar(11) NOT NULL,
  `no_meter` varchar(50) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `tenggang` varchar(2) DEFAULT NULL,
  `id_tarif` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_pelanggan`),
  KEY `id_tarif` (`id_tarif`),
  CONSTRAINT `pelanggan_ibfk_1` FOREIGN KEY (`id_tarif`) REFERENCES `tarif` (`id_tarif`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pelanggan`
--

LOCK TABLES `pelanggan` WRITE;
/*!40000 ALTER TABLE `pelanggan` DISABLE KEYS */;
/*!40000 ALTER TABLE `pelanggan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pembayaran`
--

DROP TABLE IF EXISTS `pembayaran`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pembayaran` (
  `id_pembayaran` int(11) NOT NULL AUTO_INCREMENT,
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
  `tanggal_pembayaran` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_pembayaran`),
  KEY `id_tagihan` (`id_tagihan`),
  KEY `id_penggunaan` (`id_penggunaan`),
  KEY `id_petugas` (`id_petugas`),
  KEY `id_pelanggan` (`id_pelanggan`),
  CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`id_tagihan`) REFERENCES `tagihan` (`id_tagihan`),
  CONSTRAINT `pembayaran_ibfk_2` FOREIGN KEY (`id_penggunaan`) REFERENCES `penggunaan` (`id_penggunaan`),
  CONSTRAINT `pembayaran_ibfk_3` FOREIGN KEY (`id_petugas`) REFERENCES `petugas` (`id_petugas`),
  CONSTRAINT `pembayaran_ibfk_4` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pembayaran`
--

LOCK TABLES `pembayaran` WRITE;
/*!40000 ALTER TABLE `pembayaran` DISABLE KEYS */;
/*!40000 ALTER TABLE `pembayaran` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `penggunaan`
--

DROP TABLE IF EXISTS `penggunaan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `penggunaan` (
  `id_penggunaan` int(11) NOT NULL AUTO_INCREMENT,
  `id_pelanggan` varchar(11) NOT NULL,
  `bulan` int(11) NOT NULL,
  `tahun` int(11) NOT NULL,
  `meter_awal` decimal(10,0) NOT NULL,
  `meter_akhir` decimal(10,0) NOT NULL,
  `tgl_cek` date NOT NULL,
  `id_petugas` int(11) NOT NULL,
  PRIMARY KEY (`id_penggunaan`),
  KEY `id_pelanggan` (`id_pelanggan`),
  KEY `id_petugas` (`id_petugas`),
  CONSTRAINT `penggunaan_ibfk_1` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`),
  CONSTRAINT `penggunaan_ibfk_2` FOREIGN KEY (`id_petugas`) REFERENCES `petugas` (`id_petugas`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `penggunaan`
--

LOCK TABLES `penggunaan` WRITE;
/*!40000 ALTER TABLE `penggunaan` DISABLE KEYS */;
/*!40000 ALTER TABLE `penggunaan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `petugas`
--

DROP TABLE IF EXISTS `petugas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `petugas` (
  `id_petugas` int(11) NOT NULL AUTO_INCREMENT,
  `nama_petugas` varchar(100) DEFAULT NULL,
  `alamat` varchar(200) DEFAULT NULL,
  `no_telepon` varchar(20) DEFAULT NULL,
  `jk` enum('Laki-laki','Perempuan') DEFAULT NULL,
  `foto_profil` varchar(200) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `biaya_admin` decimal(10,0) NOT NULL,
  `akses` enum('Petugas','Agen') DEFAULT NULL,
  `session_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_petugas`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `petugas`
--

LOCK TABLES `petugas` WRITE;
/*!40000 ALTER TABLE `petugas` DISABLE KEYS */;
/*!40000 ALTER TABLE `petugas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tagihan`
--

DROP TABLE IF EXISTS `tagihan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
  `id_penggunaan` int(11) NOT NULL,
  PRIMARY KEY (`id_tagihan`),
  KEY `id_pelanggan` (`id_pelanggan`),
  KEY `id_petugas` (`id_petugas`),
  KEY `id_penggunaan` (`id_penggunaan`),
  CONSTRAINT `tagihan_ibfk_1` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`),
  CONSTRAINT `tagihan_ibfk_2` FOREIGN KEY (`id_petugas`) REFERENCES `petugas` (`id_petugas`),
  CONSTRAINT `tagihan_ibfk_3` FOREIGN KEY (`id_penggunaan`) REFERENCES `penggunaan` (`id_penggunaan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tagihan`
--

LOCK TABLES `tagihan` WRITE;
/*!40000 ALTER TABLE `tagihan` DISABLE KEYS */;
/*!40000 ALTER TABLE `tagihan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tarif`
--

DROP TABLE IF EXISTS `tarif`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tarif` (
  `id_tarif` int(11) NOT NULL AUTO_INCREMENT,
  `kode_tarif` varchar(50) NOT NULL,
  `golongan` varchar(50) NOT NULL,
  `daya` varchar(20) NOT NULL,
  `tarif_perkwh` decimal(15,0) NOT NULL,
  PRIMARY KEY (`id_tarif`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tarif`
--

LOCK TABLES `tarif` WRITE;
/*!40000 ALTER TABLE `tarif` DISABLE KEYS */;
INSERT INTO `tarif` VALUES (1,'T001','R-1/TR','450',415),(2,'T002','R-1/TR','900',605),(3,'T003','R-1/M','1300',1444),(4,'T004','R-1/M','2200',1444),(5,'T005','R-2/M','3500-5500',1699);
/*!40000 ALTER TABLE `tarif` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-01-25 22:25:22
