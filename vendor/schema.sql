SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE pelanggan (
  id_pelanggan varchar(11) NOT NULL,
  no_meter varchar(50) NOT NULL,
  nama varchar(100) NOT NULL,
  alamat text NOT NULL,
  tenggang varchar(2) DEFAULT NULL,
  id_tarif int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE pembayaran (
  id_pembayaran int(11) NOT NULL,
  id_tagihan varchar(11) NOT NULL,
  id_penggunaan int(11) NOT NULL,
  id_petugas int(11) NOT NULL,
  id_pelanggan varchar(11) NOT NULL,
  no_meter varchar(50) NOT NULL,
  meter_awal int(11) NOT NULL,
  meter_akhir int(11) NOT NULL,
  kode_tarif varchar(50) NOT NULL,
  bulan int(11) NOT NULL,
  tahun int(11) NOT NULL,
  nama_pelanggan varchar(255) NOT NULL,
  jumlah_meter int(11) NOT NULL,
  tarif_perkwh decimal(10,2) NOT NULL,
  tagihan_listrik decimal(10,2) NOT NULL,
  biaya_admin decimal(10,2) NOT NULL,
  denda decimal(10,2) NOT NULL,
  total_bayar decimal(10,2) NOT NULL,
  jumlah_uang decimal(10,2) NOT NULL,
  uang_kembali decimal(10,2) NOT NULL,
  tanggal_pembayaran timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE penggunaan (
  id_penggunaan int(11) NOT NULL,
  id_pelanggan varchar(11) NOT NULL,
  bulan int(11) NOT NULL,
  tahun int(11) NOT NULL,
  meter_awal decimal(10,0) NOT NULL,
  meter_akhir decimal(10,0) NOT NULL,
  tgl_cek date NOT NULL,
  id_petugas int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE petugas (
  id_petugas int(11) NOT NULL,
  nama_petugas varchar(100) NOT NULL,
  alamat varchar(200) NOT NULL,
  no_telepon varchar(20) NOT NULL,
  jk enum('Laki-laki','Perempuan') NOT NULL,
  foto_profil varchar(200) DEFAULT NULL,
  username varchar(50) NOT NULL,
  password varchar(255) NOT NULL,
  biaya_admin decimal(10,2) NOT NULL DEFAULT 0.00,
  akses enum('Petugas','Agen') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE tagihan (
  id_tagihan varchar(20) NOT NULL,
  id_pelanggan varchar(11) NOT NULL,
  bulan varchar(2) NOT NULL,
  tahun year(4) NOT NULL,
  jumlah_meter int(11) NOT NULL,
  tarif_perkwh decimal(10,0) NOT NULL,
  jumlah_bayar decimal(10,0) NOT NULL,
  status varchar(15) NOT NULL,
  id_petugas int(11) NOT NULL,
  id_penggunaan int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE tarif (
  id_tarif int(11) NOT NULL,
  kode_tarif varchar(50) NOT NULL,
  golongan varchar(50) NOT NULL,
  daya varchar(20) NOT NULL,
  tarif_perkwh decimal(15,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


ALTER TABLE pelanggan
  ADD PRIMARY KEY (id_pelanggan),
  ADD KEY id_tarif (id_tarif);

ALTER TABLE pembayaran
  ADD PRIMARY KEY (id_pembayaran),
  ADD KEY id_tagihan (id_tagihan),
  ADD KEY id_penggunaan (id_penggunaan),
  ADD KEY id_petugas (id_petugas),
  ADD KEY id_pelanggan (id_pelanggan);

ALTER TABLE penggunaan
  ADD PRIMARY KEY (id_penggunaan),
  ADD KEY id_pelanggan (id_pelanggan),
  ADD KEY id_petugas (id_petugas);

ALTER TABLE petugas
  ADD PRIMARY KEY (id_petugas),
  ADD UNIQUE KEY uk_username (username),
  ADD KEY idx_akses (akses);

ALTER TABLE tagihan
  ADD PRIMARY KEY (id_tagihan),
  ADD KEY id_pelanggan (id_pelanggan),
  ADD KEY id_petugas (id_petugas),
  ADD KEY id_penggunaan (id_penggunaan);

ALTER TABLE tarif
  ADD PRIMARY KEY (id_tarif);


ALTER TABLE pembayaran
  MODIFY id_pembayaran int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE penggunaan
  MODIFY id_penggunaan int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE petugas
  MODIFY id_petugas int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE tarif
  MODIFY id_tarif int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE pelanggan
  ADD CONSTRAINT pelanggan_ibfk_1 FOREIGN KEY (id_tarif) REFERENCES tarif (id_tarif);

ALTER TABLE pembayaran
  ADD CONSTRAINT pembayaran_ibfk_1 FOREIGN KEY (id_tagihan) REFERENCES tagihan (id_tagihan),
  ADD CONSTRAINT pembayaran_ibfk_2 FOREIGN KEY (id_penggunaan) REFERENCES penggunaan (id_penggunaan),
  ADD CONSTRAINT pembayaran_ibfk_3 FOREIGN KEY (id_petugas) REFERENCES petugas (id_petugas),
  ADD CONSTRAINT pembayaran_ibfk_4 FOREIGN KEY (id_pelanggan) REFERENCES pelanggan (id_pelanggan);

ALTER TABLE penggunaan
  ADD CONSTRAINT penggunaan_ibfk_1 FOREIGN KEY (id_pelanggan) REFERENCES pelanggan (id_pelanggan),
  ADD CONSTRAINT penggunaan_ibfk_2 FOREIGN KEY (id_petugas) REFERENCES petugas (id_petugas);

ALTER TABLE tagihan
  ADD CONSTRAINT tagihan_ibfk_1 FOREIGN KEY (id_pelanggan) REFERENCES pelanggan (id_pelanggan),
  ADD CONSTRAINT tagihan_ibfk_2 FOREIGN KEY (id_petugas) REFERENCES petugas (id_petugas),
  ADD CONSTRAINT tagihan_ibfk_3 FOREIGN KEY (id_penggunaan) REFERENCES penggunaan (id_penggunaan);

