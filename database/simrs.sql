/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19-11.8.6-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: simrs
-- ------------------------------------------------------
-- Server version	11.8.6-MariaDB-0+deb13u1 from Debian

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*M!100616 SET @OLD_NOTE_VERBOSITY=@@NOTE_VERBOSITY, NOTE_VERBOSITY=0 */;

--
-- Current Database: `simrs`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `simrs` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;

USE `simrs`;

--
-- Table structure for table `appointment`
--

DROP TABLE IF EXISTS `appointment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `appointment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `kode` varchar(15) NOT NULL,
  `pasien_id` int(10) unsigned NOT NULL,
  `dokter_id` int(10) unsigned NOT NULL,
  `tanggal` date NOT NULL,
  `jam` time NOT NULL,
  `keluhan` text DEFAULT NULL,
  `status` enum('booking','dikonfirmasi','datang','selesai','batal') NOT NULL DEFAULT 'booking',
  `pendaftaran_id` int(10) unsigned DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kode` (`kode`),
  KEY `appointment_pasien_id_foreign` (`pasien_id`),
  KEY `appointment_pendaftaran_id_foreign` (`pendaftaran_id`),
  KEY `dokter_id_tanggal` (`dokter_id`,`tanggal`),
  CONSTRAINT `appointment_dokter_id_foreign` FOREIGN KEY (`dokter_id`) REFERENCES `dokter` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `appointment_pasien_id_foreign` FOREIGN KEY (`pasien_id`) REFERENCES `pasien` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `appointment_pendaftaran_id_foreign` FOREIGN KEY (`pendaftaran_id`) REFERENCES `pendaftaran` (`id`) ON DELETE CASCADE ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `appointment`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `appointment` WRITE;
/*!40000 ALTER TABLE `appointment` DISABLE KEYS */;
INSERT INTO `appointment` VALUES
(1,'APT26080001',1,1,'2026-08-21','10:00:00','Kontrol hipertensi','datang',6,'2026-08-21 02:40:18','2026-08-21 02:40:27'),
(2,'APT26080002',2,1,'2026-08-21','10:00:00','Bentrok test','booking',NULL,'2026-08-21 02:40:35','2026-08-21 02:40:35'),
(3,'APT26080003',4,1,'2026-08-22','09:00:00','Pusing','booking',NULL,'2026-08-21 02:55:12','2026-08-21 02:55:12');
/*!40000 ALTER TABLE `appointment` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `dokter`
--

DROP TABLE IF EXISTS `dokter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `dokter` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `kode_dokter` varchar(10) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `spesialisasi` varchar(100) DEFAULT NULL,
  `poli_id` int(10) unsigned DEFAULT NULL,
  `telepon` varchar(20) DEFAULT NULL,
  `jadwal` varchar(100) DEFAULT NULL,
  `tarif_konsultasi` decimal(12,2) NOT NULL DEFAULT 0.00,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kode_dokter` (`kode_dokter`),
  KEY `dokter_poli_id_foreign` (`poli_id`),
  CONSTRAINT `dokter_poli_id_foreign` FOREIGN KEY (`poli_id`) REFERENCES `poli` (`id`) ON DELETE CASCADE ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dokter`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `dokter` WRITE;
/*!40000 ALTER TABLE `dokter` DISABLE KEYS */;
INSERT INTO `dokter` VALUES
(1,'D001','dr. Ahmad Hidayat','Umum',1,'081200000001','Senin-Jumat 08:00-14:00',50000.00,1,NULL,NULL),
(2,'D002','dr. Siti Rahma, Sp.A','Anak',2,'081200000002','Senin-Sabtu 09:00-15:00',75000.00,1,NULL,NULL),
(3,'D003','drg. Budi Santoso','Gigi',3,'081200000003','Selasa-Kamis 10:00-16:00',60000.00,1,NULL,NULL),
(4,'D004','dr. Dewi Lestari, Sp.OG','Kandungan',4,'081200000004','Senin-Rabu 08:00-13:00',100000.00,1,NULL,NULL),
(5,'D005','dr. Eko Prasetyo','Umum (IGD)',5,'081200000005','Shift 24 jam',80000.00,1,NULL,NULL);
/*!40000 ALTER TABLE `dokter` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `icd10`
--

DROP TABLE IF EXISTS `icd10`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `icd10` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `kode` varchar(10) NOT NULL,
  `nama` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kode` (`kode`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `icd10`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `icd10` WRITE;
/*!40000 ALTER TABLE `icd10` DISABLE KEYS */;
INSERT INTO `icd10` VALUES
(1,'A09','Diare dan gastroenteritis'),
(2,'A90','Demam berdarah dengue'),
(3,'B34','Infeksi virus, tidak spesifik'),
(4,'E11','Diabetes mellitus tipe 2'),
(5,'I10','Hipertensi esensial'),
(6,'J00','Nasofaringitis akut (common cold)'),
(7,'J02','Faringitis akut'),
(8,'J06','ISPA (infeksi saluran pernapasan atas)'),
(9,'J18','Pneumonia'),
(10,'J45','Asma'),
(11,'K02','Karies gigi'),
(12,'K21','GERD (gastro-esophageal reflux)'),
(13,'K29','Gastritis dan duodenitis'),
(14,'L03','Selulitis'),
(15,'M54','Dorsalgia (nyeri punggung)'),
(16,'N39','Infeksi saluran kemih'),
(17,'O80','Persalinan spontan'),
(18,'R05','Batuk'),
(19,'R50','Demam, tidak spesifik'),
(20,'Z00','Pemeriksaan kesehatan umum');
/*!40000 ALTER TABLE `icd10` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `kamar`
--

DROP TABLE IF EXISTS `kamar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `kamar` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `kode` varchar(10) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `kelas` enum('VIP','I','II','III') NOT NULL DEFAULT 'III',
  `tarif_per_hari` decimal(12,2) NOT NULL DEFAULT 0.00,
  `kapasitas` int(11) NOT NULL DEFAULT 1,
  `terisi` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kode` (`kode`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kamar`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `kamar` WRITE;
/*!40000 ALTER TABLE `kamar` DISABLE KEYS */;
INSERT INTO `kamar` VALUES
(1,'VIP-1','Melati VIP','VIP',500000.00,1,0,NULL,NULL),
(2,'K1-01','Mawar I','I',300000.00,2,0,NULL,NULL),
(3,'K2-01','Anggrek II','II',200000.00,4,0,NULL,'2026-08-21 01:47:56'),
(4,'K3-01','Flamboyan III','III',100000.00,6,0,NULL,NULL);
/*!40000 ALTER TABLE `kamar` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `lab_hasil`
--

DROP TABLE IF EXISTS `lab_hasil`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `lab_hasil` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lab_order_id` int(10) unsigned NOT NULL,
  `lab_jenis_id` int(10) unsigned NOT NULL,
  `hasil` varchar(100) DEFAULT NULL,
  `keterangan` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lab_hasil_lab_order_id_foreign` (`lab_order_id`),
  KEY `lab_hasil_lab_jenis_id_foreign` (`lab_jenis_id`),
  CONSTRAINT `lab_hasil_lab_jenis_id_foreign` FOREIGN KEY (`lab_jenis_id`) REFERENCES `lab_jenis` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `lab_hasil_lab_order_id_foreign` FOREIGN KEY (`lab_order_id`) REFERENCES `lab_order` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lab_hasil`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `lab_hasil` WRITE;
/*!40000 ALTER TABLE `lab_hasil` DISABLE KEYS */;
INSERT INTO `lab_hasil` VALUES
(1,1,1,'Trombosit rendah','Rendah'),
(2,1,3,'95','Normal');
/*!40000 ALTER TABLE `lab_hasil` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `lab_jenis`
--

DROP TABLE IF EXISTS `lab_jenis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `lab_jenis` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `kode` varchar(10) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `satuan` varchar(30) DEFAULT NULL,
  `nilai_normal` varchar(50) DEFAULT NULL,
  `tarif` decimal(12,2) NOT NULL DEFAULT 0.00,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kode` (`kode`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lab_jenis`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `lab_jenis` WRITE;
/*!40000 ALTER TABLE `lab_jenis` DISABLE KEYS */;
INSERT INTO `lab_jenis` VALUES
(1,'LAB01','Darah Lengkap',NULL,NULL,85000.00,1,NULL,NULL),
(2,'LAB02','Hemoglobin','g/dL','12-16',35000.00,1,NULL,NULL),
(3,'LAB03','Gula Darah Puasa','mg/dL','70-100',40000.00,1,NULL,NULL),
(4,'LAB04','Kolesterol Total','mg/dL','< 200',55000.00,1,NULL,NULL),
(5,'LAB05','Asam Urat','mg/dL','3.5-7.2',45000.00,1,NULL,NULL),
(6,'LAB06','Urinalisa Lengkap',NULL,NULL,60000.00,1,NULL,NULL),
(7,'LAB07','Widal (Tifoid)',NULL,'Negatif',75000.00,1,NULL,NULL);
/*!40000 ALTER TABLE `lab_jenis` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `lab_order`
--

DROP TABLE IF EXISTS `lab_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `lab_order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `no_order` varchar(20) NOT NULL,
  `pemeriksaan_id` int(10) unsigned NOT NULL,
  `tanggal` datetime DEFAULT NULL,
  `status` enum('diminta','selesai') NOT NULL DEFAULT 'diminta',
  `catatan` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `no_order` (`no_order`),
  KEY `lab_order_pemeriksaan_id_foreign` (`pemeriksaan_id`),
  CONSTRAINT `lab_order_pemeriksaan_id_foreign` FOREIGN KEY (`pemeriksaan_id`) REFERENCES `pemeriksaan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lab_order`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `lab_order` WRITE;
/*!40000 ALTER TABLE `lab_order` DISABLE KEYS */;
INSERT INTO `lab_order` VALUES
(1,'LAB20260821001',2,'2026-08-21 02:16:38','selesai','Curiga DBD','2026-08-21 02:16:38','2026-08-21 02:16:47');
/*!40000 ALTER TABLE `lab_order` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES
(1,'2026-08-21-000001','App\\Database\\Migrations\\CreateUsersTable','default','App',1787276454,1),
(2,'2026-08-21-000002','App\\Database\\Migrations\\CreatePasienTable','default','App',1787276454,1),
(3,'2026-08-21-000003','App\\Database\\Migrations\\CreatePoliDokterTable','default','App',1787276454,1),
(4,'2026-08-21-000004','App\\Database\\Migrations\\CreateKamarObatTindakanTable','default','App',1787276454,1),
(5,'2026-08-21-000005','App\\Database\\Migrations\\CreatePendaftaranPemeriksaanTable','default','App',1787276454,1),
(6,'2026-08-21-000006','App\\Database\\Migrations\\CreateRawatInapResepTable','default','App',1787276454,1),
(7,'2026-08-21-000007','App\\Database\\Migrations\\CreateTagihanTable','default','App',1787276454,1),
(8,'2026-08-21-000008','App\\Database\\Migrations\\AddAntrianToPendaftaranTable','default','App',1787277782,2),
(9,'2026-08-21-000009','App\\Database\\Migrations\\CreateLaboratoriumTables','default','App',1787278458,3),
(10,'2026-08-21-000010','App\\Database\\Migrations\\CreateObatMutasiTable','default','App',1787278458,3),
(11,'2026-08-21-000011','App\\Database\\Migrations\\CreateRadiologiTables','default','App',1787279663,4),
(12,'2026-08-21-000012','App\\Database\\Migrations\\CreateIcd10Table','default','App',1787279663,4),
(13,'2026-08-21-000013','App\\Database\\Migrations\\CreateAppointmentTable','default','App',1787280018,5);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `obat`
--

DROP TABLE IF EXISTS `obat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `obat` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `kode` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `kategori` varchar(50) DEFAULT NULL,
  `satuan` varchar(20) NOT NULL DEFAULT 'tablet',
  `harga_beli` decimal(12,2) NOT NULL DEFAULT 0.00,
  `harga_jual` decimal(12,2) NOT NULL DEFAULT 0.00,
  `stok` int(11) NOT NULL DEFAULT 0,
  `expired` date DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kode` (`kode`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `obat`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `obat` WRITE;
/*!40000 ALTER TABLE `obat` DISABLE KEYS */;
INSERT INTO `obat` VALUES
(1,'OBT001','Paracetamol 500mg','Analgesik','tablet',500.00,1000.00,488,NULL,NULL,'2026-08-21 03:25:25'),
(2,'OBT002','Amoxicillin 500mg','Antibiotik','kapsul',1500.00,3000.00,300,NULL,NULL,NULL),
(3,'OBT003','OBH Combi','Batuk','botol',12000.00,20000.00,143,NULL,NULL,'2026-08-21 02:17:50'),
(4,'OBT004','Antasida Doen','Lambung','tablet',800.00,1500.00,200,NULL,NULL,NULL),
(5,'OBT005','Cetirizine 10mg','Antihistamin','tablet',1000.00,2000.00,250,NULL,NULL,NULL),
(6,'OBT006','Infus RL 500ml','Cairan','botol',15000.00,25000.00,80,NULL,NULL,NULL);
/*!40000 ALTER TABLE `obat` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `obat_mutasi`
--

DROP TABLE IF EXISTS `obat_mutasi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `obat_mutasi` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `obat_id` int(10) unsigned NOT NULL,
  `tanggal` datetime DEFAULT NULL,
  `tipe` enum('masuk','keluar','opname') NOT NULL,
  `jumlah` int(11) NOT NULL,
  `stok_sebelum` int(11) NOT NULL DEFAULT 0,
  `stok_sesudah` int(11) NOT NULL DEFAULT 0,
  `referensi` varchar(50) DEFAULT NULL,
  `keterangan` varchar(200) DEFAULT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `obat_mutasi_user_id_foreign` (`user_id`),
  KEY `obat_id_tanggal` (`obat_id`,`tanggal`),
  CONSTRAINT `obat_mutasi_obat_id_foreign` FOREIGN KEY (`obat_id`) REFERENCES `obat` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `obat_mutasi_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `obat_mutasi`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `obat_mutasi` WRITE;
/*!40000 ALTER TABLE `obat_mutasi` DISABLE KEYS */;
INSERT INTO `obat_mutasi` VALUES
(1,3,'2026-08-21 02:17:43','masuk',50,99,149,NULL,'Faktur PB-001 PBF Kimia',1,'2026-08-21 02:17:43'),
(2,3,'2026-08-21 02:17:43','opname',145,149,145,NULL,'Selisih 4 rusak',1,'2026-08-21 02:17:43'),
(3,3,'2026-08-21 02:17:50','keluar',2,145,143,'RSP20260821002','Resep RSP20260821002',1,'2026-08-21 02:17:50'),
(4,1,'2026-08-21 03:25:25','keluar',2,490,488,'RSP20260821003','Resep RSP20260821003',1,'2026-08-21 03:25:25');
/*!40000 ALTER TABLE `obat_mutasi` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `pasien`
--

DROP TABLE IF EXISTS `pasien`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `pasien` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `no_rm` varchar(20) NOT NULL,
  `nik` varchar(20) DEFAULT NULL,
  `nama` varchar(100) NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `tempat_lahir` varchar(50) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `golongan_darah` enum('A','B','AB','O','-') NOT NULL DEFAULT '-',
  `alamat` text DEFAULT NULL,
  `telepon` varchar(20) DEFAULT NULL,
  `penjamin` enum('Umum','BPJS','Asuransi') NOT NULL DEFAULT 'Umum',
  `no_bpjs` varchar(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `no_rm` (`no_rm`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pasien`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `pasien` WRITE;
/*!40000 ALTER TABLE `pasien` DISABLE KEYS */;
INSERT INTO `pasien` VALUES
(1,'RM000001','3201234567890001','Budi Hartono','L','Jakarta','1990-05-12','O','Jl. Merdeka No. 1, Jakarta','081311110001','BPJS','0001234567001','2026-08-21 01:40:55',NULL),
(2,'RM000002','3201234567890002','Sari Wulandari','P','Bandung','1995-08-23','A','Jl. Sudirman No. 45, Bandung','081311110002','Umum',NULL,'2026-08-21 01:40:55',NULL),
(3,'RM000003','3201234567890003','Rina Amelia','P','Bogor','2018-01-15','B','Jl. Kenanga No. 7, Bogor','081311110003','BPJS','0001234567003','2026-08-21 01:40:55',NULL),
(4,'RM000004',NULL,'Joko Santoso','L',NULL,NULL,'-',NULL,'081234567890','Umum',NULL,'2026-08-21 02:55:12','2026-08-21 02:55:12'),
(5,'RM000005',NULL,'Ani Wijaya','P',NULL,NULL,'-',NULL,'08111','Umum',NULL,'2026-08-21 02:55:13','2026-08-21 02:55:13');
/*!40000 ALTER TABLE `pasien` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `pemeriksaan`
--

DROP TABLE IF EXISTS `pemeriksaan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `pemeriksaan` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pendaftaran_id` int(10) unsigned NOT NULL,
  `tanggal` datetime DEFAULT NULL,
  `anamnesis` text DEFAULT NULL,
  `tekanan_darah` varchar(10) DEFAULT NULL,
  `suhu` decimal(4,1) DEFAULT NULL,
  `berat_badan` decimal(5,1) DEFAULT NULL,
  `tinggi_badan` decimal(5,1) DEFAULT NULL,
  `diagnosa` text DEFAULT NULL,
  `icd10_id` int(10) unsigned DEFAULT NULL,
  `tindakan_id` int(10) unsigned DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pemeriksaan_pendaftaran_id_foreign` (`pendaftaran_id`),
  KEY `pemeriksaan_tindakan_id_foreign` (`tindakan_id`),
  CONSTRAINT `pemeriksaan_pendaftaran_id_foreign` FOREIGN KEY (`pendaftaran_id`) REFERENCES `pendaftaran` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `pemeriksaan_tindakan_id_foreign` FOREIGN KEY (`tindakan_id`) REFERENCES `tindakan` (`id`) ON DELETE CASCADE ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pemeriksaan`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `pemeriksaan` WRITE;
/*!40000 ALTER TABLE `pemeriksaan` DISABLE KEYS */;
INSERT INTO `pemeriksaan` VALUES
(1,1,'2026-08-21 01:47:39','Demam 3 hari','120/80',38.2,65.0,170.0,'ISPA',NULL,2,'Istirahat cukup','2026-08-21 01:47:39','2026-08-21 01:47:39'),
(2,4,'2026-08-21 02:03:47',NULL,NULL,NULL,NULL,NULL,'Sehat, kontrol normal',NULL,NULL,NULL,'2026-08-21 02:03:47','2026-08-21 02:03:47'),
(3,7,'2026-08-21 03:25:09',NULL,NULL,NULL,NULL,NULL,'Tes',6,1,NULL,'2026-08-21 03:25:09','2026-08-21 03:25:09');
/*!40000 ALTER TABLE `pemeriksaan` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `pendaftaran`
--

DROP TABLE IF EXISTS `pendaftaran`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `pendaftaran` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `no_registrasi` varchar(20) NOT NULL,
  `no_antrian` varchar(15) DEFAULT NULL,
  `pasien_id` int(10) unsigned NOT NULL,
  `poli_id` int(10) unsigned NOT NULL,
  `dokter_id` int(10) unsigned DEFAULT NULL,
  `tanggal` date NOT NULL,
  `jenis_kunjungan` enum('rawat_jalan','rawat_inap','igd') NOT NULL DEFAULT 'rawat_jalan',
  `keluhan` text DEFAULT NULL,
  `status` enum('menunggu','diperiksa','selesai','batal') NOT NULL DEFAULT 'menunggu',
  `status_antrian` enum('menunggu','dipanggil','dilayani','selesai','dilewati') DEFAULT 'menunggu',
  `waktu_panggil` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `no_registrasi` (`no_registrasi`),
  KEY `pendaftaran_pasien_id_foreign` (`pasien_id`),
  KEY `pendaftaran_poli_id_foreign` (`poli_id`),
  KEY `pendaftaran_dokter_id_foreign` (`dokter_id`),
  KEY `tanggal` (`tanggal`),
  CONSTRAINT `pendaftaran_dokter_id_foreign` FOREIGN KEY (`dokter_id`) REFERENCES `dokter` (`id`) ON DELETE CASCADE ON UPDATE SET NULL,
  CONSTRAINT `pendaftaran_pasien_id_foreign` FOREIGN KEY (`pasien_id`) REFERENCES `pasien` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `pendaftaran_poli_id_foreign` FOREIGN KEY (`poli_id`) REFERENCES `poli` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pendaftaran`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `pendaftaran` WRITE;
/*!40000 ALTER TABLE `pendaftaran` DISABLE KEYS */;
INSERT INTO `pendaftaran` VALUES
(1,'REG20260821001','UMU-001',1,1,1,'2026-08-21','rawat_jalan','Demam dan batuk','selesai','selesai',NULL,'2026-08-21 01:47:32','2026-08-21 01:47:39'),
(2,'REG20260821002','ANA-001',2,2,2,'2026-08-21','rawat_inap','Demam berdarah','menunggu','menunggu',NULL,'2026-08-21 01:47:51','2026-08-21 01:47:51'),
(3,'REG20260821003','UMU-002',1,1,1,'2026-08-21','rawat_jalan','Kontrol rutin','menunggu','menunggu',NULL,'2026-08-21 02:03:15','2026-08-21 02:03:40'),
(4,'REG20260821004','UMU-003',3,1,1,'2026-08-21','rawat_jalan','Kontrol rutin','selesai','selesai','2026-08-21 02:03:40','2026-08-21 02:03:15','2026-08-21 02:03:47'),
(5,'REG20260821005','GIG-001',2,3,3,'2026-08-21','rawat_jalan','Sakit gigi','menunggu','menunggu',NULL,'2026-08-21 02:09:33','2026-08-21 02:09:33'),
(6,'REG20260821006','UMU-004',1,1,1,'2026-08-21','rawat_jalan','Kontrol hipertensi','menunggu','menunggu',NULL,'2026-08-21 02:40:27','2026-08-21 02:40:27'),
(7,'REG20260821007','UMU-005',1,1,1,'2026-08-21','rawat_jalan','Tes alur lengkap','selesai','selesai',NULL,'2026-08-21 03:25:09','2026-08-21 03:25:09');
/*!40000 ALTER TABLE `pendaftaran` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `poli`
--

DROP TABLE IF EXISTS `poli`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `poli` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `kode` varchar(10) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kode` (`kode`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `poli`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `poli` WRITE;
/*!40000 ALTER TABLE `poli` DISABLE KEYS */;
INSERT INTO `poli` VALUES
(1,'UMU','Poli Umum','Pelayanan kesehatan umum'),
(2,'ANA','Poli Anak','Pelayanan kesehatan anak'),
(3,'GIG','Poli Gigi','Pelayanan kesehatan gigi & mulut'),
(4,'OBG','Poli Kandungan','Kebidanan & kandungan'),
(5,'IGD','IGD','Instalasi Gawat Darurat 24 jam');
/*!40000 ALTER TABLE `poli` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `rad_jenis`
--

DROP TABLE IF EXISTS `rad_jenis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `rad_jenis` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `kode` varchar(10) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `modalitas` varchar(50) DEFAULT NULL,
  `tarif` decimal(12,2) NOT NULL DEFAULT 0.00,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kode` (`kode`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rad_jenis`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `rad_jenis` WRITE;
/*!40000 ALTER TABLE `rad_jenis` DISABLE KEYS */;
INSERT INTO `rad_jenis` VALUES
(1,'RAD01','Rontgen Thorax PA','X-Ray',150000.00,1,NULL,NULL),
(2,'RAD02','Rontgen Abdomen','X-Ray',160000.00,1,NULL,NULL),
(3,'RAD03','Rontgen Extremitas','X-Ray',140000.00,1,NULL,NULL),
(4,'RAD04','USG Abdomen','USG',250000.00,1,NULL,NULL),
(5,'RAD05','USG Kehamilan','USG',275000.00,1,NULL,NULL),
(6,'RAD06','CT Scan Kepala','CT',1200000.00,1,NULL,NULL),
(7,'RAD07','MRI Lumbal','MRI',2500000.00,1,NULL,NULL);
/*!40000 ALTER TABLE `rad_jenis` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `rad_order`
--

DROP TABLE IF EXISTS `rad_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `rad_order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `no_order` varchar(20) NOT NULL,
  `pemeriksaan_id` int(10) unsigned NOT NULL,
  `rad_jenis_id` int(10) unsigned NOT NULL,
  `tanggal` datetime DEFAULT NULL,
  `status` enum('diminta','selesai') NOT NULL DEFAULT 'diminta',
  `hasil` text DEFAULT NULL,
  `kesan` text DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `no_order` (`no_order`),
  KEY `rad_order_pemeriksaan_id_foreign` (`pemeriksaan_id`),
  KEY `rad_order_rad_jenis_id_foreign` (`rad_jenis_id`),
  CONSTRAINT `rad_order_pemeriksaan_id_foreign` FOREIGN KEY (`pemeriksaan_id`) REFERENCES `pemeriksaan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `rad_order_rad_jenis_id_foreign` FOREIGN KEY (`rad_jenis_id`) REFERENCES `rad_jenis` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rad_order`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `rad_order` WRITE;
/*!40000 ALTER TABLE `rad_order` DISABLE KEYS */;
INSERT INTO `rad_order` VALUES
(1,'RAD20260821001',2,1,'2026-08-21 02:37:00','selesai','Cor tidak membesar. Infiltrat tidak tampak. Pulmo normal.','Tidak ada kelainan radiologis.','Skrining paru','2026-08-21 02:37:00','2026-08-21 02:37:08');
/*!40000 ALTER TABLE `rad_order` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `rawat_inap`
--

DROP TABLE IF EXISTS `rawat_inap`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `rawat_inap` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pendaftaran_id` int(10) unsigned NOT NULL,
  `kamar_id` int(10) unsigned NOT NULL,
  `tanggal_masuk` datetime NOT NULL,
  `tanggal_keluar` datetime DEFAULT NULL,
  `status` enum('dirawat','pulang') NOT NULL DEFAULT 'dirawat',
  `catatan` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rawat_inap_pendaftaran_id_foreign` (`pendaftaran_id`),
  KEY `rawat_inap_kamar_id_foreign` (`kamar_id`),
  CONSTRAINT `rawat_inap_kamar_id_foreign` FOREIGN KEY (`kamar_id`) REFERENCES `kamar` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `rawat_inap_pendaftaran_id_foreign` FOREIGN KEY (`pendaftaran_id`) REFERENCES `pendaftaran` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rawat_inap`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `rawat_inap` WRITE;
/*!40000 ALTER TABLE `rawat_inap` DISABLE KEYS */;
INSERT INTO `rawat_inap` VALUES
(1,2,3,'2026-08-21 01:47:56','2026-08-21 01:47:56','pulang','Observasi','2026-08-21 01:47:56','2026-08-21 01:47:56');
/*!40000 ALTER TABLE `rawat_inap` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `resep`
--

DROP TABLE IF EXISTS `resep`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `resep` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `no_resep` varchar(20) NOT NULL,
  `pemeriksaan_id` int(10) unsigned NOT NULL,
  `tanggal` datetime DEFAULT NULL,
  `status` enum('menunggu','diproses','selesai') NOT NULL DEFAULT 'menunggu',
  `catatan` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `no_resep` (`no_resep`),
  KEY `resep_pemeriksaan_id_foreign` (`pemeriksaan_id`),
  CONSTRAINT `resep_pemeriksaan_id_foreign` FOREIGN KEY (`pemeriksaan_id`) REFERENCES `pemeriksaan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `resep`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `resep` WRITE;
/*!40000 ALTER TABLE `resep` DISABLE KEYS */;
INSERT INTO `resep` VALUES
(1,'RSP20260821001',1,'2026-08-21 01:47:44','selesai','Habiskan','2026-08-21 01:47:44','2026-08-21 01:47:44'),
(2,'RSP20260821002',2,'2026-08-21 02:17:50','selesai',NULL,'2026-08-21 02:17:50','2026-08-21 02:17:50'),
(3,'RSP20260821003',3,'2026-08-21 03:25:09','selesai',NULL,'2026-08-21 03:25:09','2026-08-21 03:25:25');
/*!40000 ALTER TABLE `resep` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `resep_detail`
--

DROP TABLE IF EXISTS `resep_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `resep_detail` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `resep_id` int(10) unsigned NOT NULL,
  `obat_id` int(10) unsigned NOT NULL,
  `jumlah` int(11) NOT NULL DEFAULT 1,
  `aturan_pakai` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `resep_detail_resep_id_foreign` (`resep_id`),
  KEY `resep_detail_obat_id_foreign` (`obat_id`),
  CONSTRAINT `resep_detail_obat_id_foreign` FOREIGN KEY (`obat_id`) REFERENCES `obat` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `resep_detail_resep_id_foreign` FOREIGN KEY (`resep_id`) REFERENCES `resep` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `resep_detail`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `resep_detail` WRITE;
/*!40000 ALTER TABLE `resep_detail` DISABLE KEYS */;
INSERT INTO `resep_detail` VALUES
(1,1,1,10,'3x sehari'),
(2,1,3,1,'2x sehari'),
(3,2,3,2,'3x sehari'),
(4,3,1,2,'2x');
/*!40000 ALTER TABLE `resep_detail` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `tagihan`
--

DROP TABLE IF EXISTS `tagihan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `tagihan` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `no_invoice` varchar(20) NOT NULL,
  `pendaftaran_id` int(10) unsigned NOT NULL,
  `tanggal` datetime DEFAULT NULL,
  `total` decimal(14,2) NOT NULL DEFAULT 0.00,
  `status` enum('belum_bayar','lunas') NOT NULL DEFAULT 'belum_bayar',
  `metode_bayar` enum('tunai','transfer','bpjs') DEFAULT NULL,
  `kasir_id` int(10) unsigned DEFAULT NULL,
  `paid_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `no_invoice` (`no_invoice`),
  KEY `tagihan_pendaftaran_id_foreign` (`pendaftaran_id`),
  KEY `tagihan_kasir_id_foreign` (`kasir_id`),
  CONSTRAINT `tagihan_kasir_id_foreign` FOREIGN KEY (`kasir_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE SET NULL,
  CONSTRAINT `tagihan_pendaftaran_id_foreign` FOREIGN KEY (`pendaftaran_id`) REFERENCES `pendaftaran` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tagihan`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `tagihan` WRITE;
/*!40000 ALTER TABLE `tagihan` DISABLE KEYS */;
INSERT INTO `tagihan` VALUES
(1,'INV20260821001',1,'2026-08-21 01:47:32',105000.00,'lunas','tunai',1,'2026-08-21 01:47:51','2026-08-21 01:47:32','2026-08-21 01:47:51'),
(2,'INV20260821002',2,'2026-08-21 01:47:51',275000.00,'belum_bayar',NULL,NULL,NULL,'2026-08-21 01:47:51','2026-08-21 01:47:56'),
(3,'INV20260821003',3,'2026-08-21 02:03:15',50000.00,'belum_bayar',NULL,NULL,NULL,'2026-08-21 02:03:15','2026-08-21 02:03:15'),
(4,'INV20260821004',4,'2026-08-21 02:03:15',365000.00,'belum_bayar',NULL,NULL,NULL,'2026-08-21 02:03:15','2026-08-21 02:37:00'),
(5,'INV20260821005',5,'2026-08-21 02:09:33',60000.00,'belum_bayar',NULL,NULL,NULL,'2026-08-21 02:09:33','2026-08-21 02:09:33'),
(6,'INV20260821006',6,'2026-08-21 02:40:27',50000.00,'belum_bayar',NULL,NULL,NULL,'2026-08-21 02:40:27','2026-08-21 02:40:27'),
(7,'INV20260821007',7,'2026-08-21 03:25:09',102000.00,'lunas','transfer',1,'2026-08-21 03:25:09','2026-08-21 03:25:09','2026-08-21 03:25:25');
/*!40000 ALTER TABLE `tagihan` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `tagihan_detail`
--

DROP TABLE IF EXISTS `tagihan_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `tagihan_detail` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tagihan_id` int(10) unsigned NOT NULL,
  `deskripsi` varchar(200) NOT NULL,
  `qty` int(11) NOT NULL DEFAULT 1,
  `harga` decimal(12,2) NOT NULL DEFAULT 0.00,
  `subtotal` decimal(14,2) NOT NULL DEFAULT 0.00,
  PRIMARY KEY (`id`),
  KEY `tagihan_detail_tagihan_id_foreign` (`tagihan_id`),
  CONSTRAINT `tagihan_detail_tagihan_id_foreign` FOREIGN KEY (`tagihan_id`) REFERENCES `tagihan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tagihan_detail`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `tagihan_detail` WRITE;
/*!40000 ALTER TABLE `tagihan_detail` DISABLE KEYS */;
INSERT INTO `tagihan_detail` VALUES
(1,1,'Konsultasi dr. Ahmad Hidayat',1,50000.00,50000.00),
(2,1,'Tindakan: Injeksi',1,25000.00,25000.00),
(3,1,'Obat: Paracetamol 500mg x10',10,1000.00,10000.00),
(4,1,'Obat: OBH Combi x1',1,20000.00,20000.00),
(5,2,'Konsultasi dr. Siti Rahma, Sp.A',1,75000.00,75000.00),
(6,2,'Kamar Anggrek II (1 hari)',1,200000.00,200000.00),
(7,3,'Konsultasi dr. Ahmad Hidayat',1,50000.00,50000.00),
(8,4,'Konsultasi dr. Ahmad Hidayat',1,50000.00,50000.00),
(9,5,'Konsultasi drg. Budi Santoso',1,60000.00,60000.00),
(10,4,'Lab: Darah Lengkap',1,85000.00,85000.00),
(11,4,'Lab: Gula Darah Puasa',1,40000.00,40000.00),
(12,4,'Obat: OBH Combi x2',2,20000.00,40000.00),
(13,4,'Radiologi: Rontgen Thorax PA',1,150000.00,150000.00),
(14,6,'Konsultasi dr. Ahmad Hidayat',1,50000.00,50000.00),
(15,7,'Konsultasi dr. Ahmad Hidayat',1,50000.00,50000.00),
(16,7,'Tindakan: Konsultasi Dokter',1,50000.00,50000.00),
(17,7,'Obat: Paracetamol 500mg x2',2,1000.00,2000.00);
/*!40000 ALTER TABLE `tagihan_detail` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `tindakan`
--

DROP TABLE IF EXISTS `tindakan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `tindakan` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `kode` varchar(10) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `tarif` decimal(12,2) NOT NULL DEFAULT 0.00,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kode` (`kode`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tindakan`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `tindakan` WRITE;
/*!40000 ALTER TABLE `tindakan` DISABLE KEYS */;
INSERT INTO `tindakan` VALUES
(1,'T01','Konsultasi Dokter',50000.00,NULL,NULL),
(2,'T02','Injeksi',25000.00,NULL,NULL),
(3,'T03','Pemasangan Infus',75000.00,NULL,NULL),
(4,'T04','Jahit Luka Ringan',150000.00,NULL,NULL),
(5,'T05','Tambal Gigi',200000.00,NULL,NULL),
(6,'T06','USG',250000.00,NULL,NULL);
/*!40000 ALTER TABLE `tindakan` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `role` enum('admin','pendaftaran','dokter','perawat','farmasi','kasir','laboratorium','radiologi') NOT NULL DEFAULT 'pendaftaran',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES
(1,'admin','$2y$12$U/HxKoNsDgQbMEy7a7M6zev0U0eNAPyZoU/3PFkhkpC2/LDrfRw4e','Administrator','admin@simrs.local','admin',1,'2026-08-21 01:40:54','2026-08-21 02:26:59'),
(2,'pendaftaran','$2y$12$AT4ySvjfyBWkFBxZzywOFO6z4nJYautG0dln/.4JBBGP8cOBCAqjK','Petugas Pendaftaran',NULL,'pendaftaran',1,'2026-08-21 01:40:55',NULL),
(3,'dokter','$2y$12$zqqM/STKrfuRQ4HbpmG9eua0n0Ni9RqLtTGuUlkyNUeyhKW3C6cui','dr. User Dokter',NULL,'dokter',1,'2026-08-21 01:40:55',NULL),
(4,'perawat','$2y$12$HOuUrDna.27yXxEDZXY7B.IGH2xCu0Hpkso3yJfBIcqCRZ5ljY/pa','Perawat Ruangan',NULL,'perawat',1,'2026-08-21 01:40:55',NULL),
(5,'farmasi','$2y$12$UO1wkxOrUWlttbMvbTfWJ.pkwdevl61.3zl4cHC7YmZqWiNFly58i','Apoteker Farmasi',NULL,'farmasi',1,'2026-08-21 01:40:55',NULL),
(6,'kasir','$2y$12$7fp1QForWQ284uJhnIj/l.L4BG8BF6n3Admld2lZExJXf/1wUJ1Fa','Petugas Kasir',NULL,'kasir',1,'2026-08-21 01:40:55',NULL),
(17,'lab','$2y$12$ekvhhA3RuzVddFsGq3ZL4O/yBHZJOVUhDJTO2KRpUy6mj8QaGbnS2','Analis Laboratorium',NULL,'laboratorium',1,'2026-08-21 02:14:41',NULL),
(18,'radiologi','$2y$12$B4ItO1tFxxgeDM5sRz8hm.t19Bbb5XZh85BHk/xLJXZ6tWbqPd73u','Radiografer',NULL,'radiologi',1,'2026-08-21 02:34:23',NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*M!100616 SET NOTE_VERBOSITY=@OLD_NOTE_VERBOSITY */;

-- Dump completed on 2026-08-21  3:28:00
