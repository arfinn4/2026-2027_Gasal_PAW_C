-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 01 Nov 2026 pada 23.50
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `basdat`
--
CREATE DATABASE IF NOT EXISTS `basdat` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `basdat`;

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang`
--

CREATE TABLE `barang` (
  `Kode` varchar(20) NOT NULL,
  `Nama` varchar(100) NOT NULL,
  `Satuan` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `barang`
--

INSERT INTO `barang` (`Kode`, `Nama`, `Satuan`) VALUES
('BRG-001', 'Kertas HVS A4 80gr', 'Rim'),
('BRG-002', 'Tinta Printer Hitam', 'Botol'),
('BRG-003', 'Mouse Wireless', 'Pcs'),
('BRG-004', 'Keyboard USB', 'Pcs'),
('BRG-005', 'Kabel LAN Cat6', 'Roll'),
('BRG-006', 'Flashdisk 32GB', 'Pcs'),
('BRG-007', 'Spidol Whiteboard', 'Box'),
('BRG-008', 'Lakban Bening', 'Pcs'),
('[value-1]', '[value-2]', '[value-3]');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pod`
--

CREATE TABLE `pod` (
  `PONo` varchar(20) NOT NULL,
  `KodeBarang` varchar(20) NOT NULL,
  `Jumlah` int(11) NOT NULL DEFAULT 0,
  `Harga` decimal(15,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pod`
--

INSERT INTO `pod` (`PONo`, `KodeBarang`, `Jumlah`, `Harga`) VALUES
('PO-2024-001', 'BRG-001', 20, 55000.00),
('PO-2024-001', 'BRG-007', 10, 45000.00),
('PO-2025-001', 'BRG-001', 30, 54000.00),
('PO-2025-001', 'BRG-008', 50, 12000.00),
('PO-2025-002', 'BRG-001', 40, 56000.00),
('PO-2025-002', 'BRG-002', 5, 35000.00),
('PO-2025-003', 'BRG-003', 25, 85000.00),
('PO-2025-003', 'BRG-004', 20, 120000.00),
('PO-2025-003', 'BRG-006', 30, 70000.00),
('PO-2025-004', 'BRG-005', 4, 950000.00),
('PO-2025-004', 'BRG-008', 100, 11500.00),
('PO-2025-005', 'BRG-003', 3, 88000.00),
('PO-2025-005', 'BRG-004', 15, 125000.00),
('PO-2025-006', 'BRG-001', 60, 55500.00),
('PO-2025-006', 'BRG-002', 12, 36000.00),
('PO-2025-006', 'BRG-007', 8, 46000.00),
('PO-2025-007', 'BRG-005', 6, 940000.00),
('PO-2025-007', 'BRG-006', 40, 69000.00),
('PO-2025-008', 'BRG-003', 40, 84000.00),
('PO-2025-008', 'BRG-004', 30, 118000.00),
('PO-2025-009', 'BRG-007', 5, 47000.00),
('PO-2025-009', 'BRG-008', 80, 12500.00),
('PO-2025-010', 'BRG-001', 25, 54500.00),
('PO-2025-011', 'BRG-002', 20, 34000.00),
('PO-2025-011', 'BRG-005', 3, 960000.00),
('PO-2026-001', 'BRG-003', 10, 86000.00),
('PO-2026-001', 'BRG-006', 50, 68000.00);

-- --------------------------------------------------------

--
-- Struktur dari tabel `poh`
--

CREATE TABLE `poh` (
  `PONo` varchar(20) NOT NULL,
  `Tgl` date NOT NULL,
  `KodeSupplier` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `poh`
--

INSERT INTO `poh` (`PONo`, `Tgl`, `KodeSupplier`) VALUES
('PO-2024-001', '2024-11-12', 'WD-001/01'),
('PO-2025-001', '2025-02-10', 'SP-002/01'),
('PO-2025-002', '2025-04-18', 'WD-001/01'),
('PO-2025-003', '2025-05-05', 'MJ-003/01'),
('PO-2025-004', '2025-05-20', 'WD-001/02'),
('PO-2025-005', '2025-05-20', 'MJ-003/01'),
('PO-2025-006', '2025-06-03', 'WD-001/01'),
('PO-2025-007', '2025-06-15', 'BS-004/01'),
('PO-2025-008', '2025-07-08', 'MJ-003/01'),
('PO-2025-009', '2025-07-22', 'TK-005/01'),
('PO-2025-010', '2025-09-01', 'SP-002/01'),
('PO-2025-011', '2025-12-15', 'WD-001/02'),
('PO-2026-001', '2026-01-09', 'BS-004/01');

-- --------------------------------------------------------

--
-- Struktur dari tabel `supplier`
--

CREATE TABLE `supplier` (
  `Kode` varchar(20) NOT NULL,
  `Nama` varchar(100) NOT NULL,
  `Alamat` varchar(150) DEFAULT NULL,
  `Kota` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `supplier`
--

INSERT INTO `supplier` (`Kode`, `Nama`, `Alamat`, `Kota`) VALUES
('BS-004/01', 'CV Berkah Sentosa', 'Jl. Gajah Mada No. 23', 'Gresik'),
('MJ-003/01', 'PT Maju Jaya Elektronik', 'Jl. Diponegoro No. 101', 'Malang'),
('SP-002/01', 'UD Sumber Pangan', 'Jl. Pahlawan No. 8', 'Surabaya'),
('TK-005/01', 'Toko Kencana', 'Jl. Pemuda No. 77', 'Bangkalan'),
('WD-001/01', 'CV Wijaya Abadi', 'Jl. Rungkut Industri No. 12', 'Surabaya'),
('WD-001/02', 'PT Wijaya Karya Plastik', 'Jl. Ahmad Yani No. 45', 'Sidoarjo');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`Kode`);

--
-- Indeks untuk tabel `pod`
--
ALTER TABLE `pod`
  ADD PRIMARY KEY (`PONo`,`KodeBarang`),
  ADD KEY `idx_pod_barang` (`KodeBarang`);

--
-- Indeks untuk tabel `poh`
--
ALTER TABLE `poh`
  ADD PRIMARY KEY (`PONo`),
  ADD KEY `idx_poh_supplier` (`KodeSupplier`);

--
-- Indeks untuk tabel `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`Kode`);

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `pod`
--
ALTER TABLE `pod`
  ADD CONSTRAINT `fk_pod_barang` FOREIGN KEY (`KodeBarang`) REFERENCES `barang` (`Kode`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pod_poh` FOREIGN KEY (`PONo`) REFERENCES `poh` (`PONo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `poh`
--
ALTER TABLE `poh`
  ADD CONSTRAINT `fk_poh_supplier` FOREIGN KEY (`KodeSupplier`) REFERENCES `supplier` (`Kode`) ON UPDATE CASCADE;
--
-- Database: `db_arfin`
--
CREATE DATABASE IF NOT EXISTS `db_arfin` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `db_arfin`;

-- --------------------------------------------------------

--
-- Struktur dari tabel `db_160`
--

CREATE TABLE `db_160` (
  `NIM` varchar(10) NOT NULL,
  `Nama` varchar(12) DEFAULT NULL,
  `Alamat` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `db_160`
--

INSERT INTO `db_160` (`NIM`, `Nama`, `Alamat`) VALUES
('2504111000', 'santak', 'gihihihi'),
('2504111001', 'Arfin', 'huhijoohyu'),
('2504111007', 'messi', 'jiojijoj'),
('2537788', 'pablo escoba', 'brazil');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `db_160`
--
ALTER TABLE `db_160`
  ADD PRIMARY KEY (`NIM`);
--
-- Database: `db_mahasiswa`
--
CREATE DATABASE IF NOT EXISTS `db_mahasiswa` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `db_mahasiswa`;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_mahasiswa`
--

CREATE TABLE `tb_mahasiswa` (
  `id` int(11) NOT NULL,
  `nim` varchar(20) NOT NULL,
  `nama` varchar(20) NOT NULL,
  `prodi` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_mahasiswa`
--

INSERT INTO `tb_mahasiswa` (`id`, `nim`, `nama`, `prodi`) VALUES
(1, '250411100160', 'arfin', 'teknik informatika'),
(9, '250411100190', 'joko', 'mesin'),
(10, '250411100101', 'nanda', 'nuklir');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tb_mahasiswa`
--
ALTER TABLE `tb_mahasiswa`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tb_mahasiswa`
--
ALTER TABLE `tb_mahasiswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- Database: `db_paw`
--
CREATE DATABASE IF NOT EXISTS `db_paw` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `db_paw`;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_mhs`
--

CREATE TABLE `tbl_mhs` (
  `id_mhs` int(11) NOT NULL,
  `nim_mhs` varchar(20) DEFAULT NULL,
  `nama_mhs` varchar(20) DEFAULT NULL,
  `alamat_mhs` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tbl_mhs`
--
ALTER TABLE `tbl_mhs`
  ADD PRIMARY KEY (`id_mhs`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tbl_mhs`
--
ALTER TABLE `tbl_mhs`
  MODIFY `id_mhs` int(11) NOT NULL AUTO_INCREMENT;
--
-- Database: `db_penjualan`
--
CREATE DATABASE IF NOT EXISTS `db_penjualan` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `db_penjualan`;

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang`
--

CREATE TABLE `barang` (
  `id` int(11) NOT NULL,
  `kode_barang` varchar(30) DEFAULT NULL,
  `nama_barang` varchar(100) DEFAULT NULL,
  `harga` decimal(12,2) DEFAULT NULL,
  `stok` int(11) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `barang`
--

INSERT INTO `barang` (`id`, `kode_barang`, `nama_barang`, `harga`, `stok`, `supplier_id`) VALUES
(1, 'BRG001', 'Buku Tulis', 5000.00, 100, 1),
(2, 'BRG002', 'Pulpen', 3000.00, 150, 2),
(3, 'BRG003', 'Pensil', 2500.00, 120, 3),
(4, 'BRG004', 'Penghapus', 2000.00, 90, 4),
(5, 'BRG005', 'Penggaris', 4000.00, 80, 5),
(6, 'BRG006', 'Spidol', 7000.00, 70, 6),
(7, 'BRG007', 'Map Plastik', 3500.00, 110, 7),
(8, 'BRG008', 'Kertas A4', 45000.00, 40, 8),
(9, 'BRG009', 'Tinta Printer', 65000.00, 25, 9),
(10, 'BRG010', 'Stapler', 18000.00, 30, 10);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `jenis_kelamin` enum('L','P') DEFAULT NULL,
  `telp` varchar(20) DEFAULT NULL,
  `alamat` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pelanggan`
--

INSERT INTO `pelanggan` (`id`, `nama`, `jenis_kelamin`, `telp`, `alamat`) VALUES
(1, 'Andi Saputra', 'L', '081234560001', 'Surabaya'),
(2, 'Budi Santoso', 'L', '081234560002', 'Bangkalan'),
(3, 'Citra Lestari', 'P', '081234560003', 'Sidoarjo'),
(4, 'Dewi Anggraini', 'P', '081234560004', 'Madura'),
(5, 'Eko Prasetyo', 'L', '081234560005', 'Gresik'),
(6, 'Fitri Handayani', 'P', '081234560006', 'Malang'),
(7, 'Gilang Ramadhan', 'L', '081234560007', 'Lamongan'),
(8, 'Hana Safitri', 'P', '081234560008', 'Surabaya'),
(9, 'Indra Wijaya', 'L', '081234560009', 'Pasuruan'),
(10, 'Jihan Putri', 'P', '081234560010', 'Mojokerto');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id` int(11) NOT NULL,
  `waktu_bayar` datetime DEFAULT NULL,
  `total` decimal(12,2) DEFAULT NULL,
  `metode` enum('Tunai','Transfer','EDC') DEFAULT NULL,
  `transaksi_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pembayaran`
--

INSERT INTO `pembayaran` (`id`, `waktu_bayar`, `total`, `metode`, `transaksi_id`) VALUES
(1, '2026-10-01 09:05:00', 10000.00, 'Tunai', 1),
(2, '2026-10-02 10:05:00', 6000.00, 'Transfer', 2),
(3, '2026-10-03 11:05:00', 5000.00, 'EDC', 3),
(4, '2026-10-04 12:05:00', 6000.00, 'Tunai', 4),
(5, '2026-10-05 13:05:00', 8000.00, 'Transfer', 5),
(6, '2026-10-06 14:05:00', 14000.00, 'EDC', 6),
(7, '2026-10-07 15:05:00', 7000.00, 'Tunai', 7),
(8, '2026-10-08 09:35:00', 45000.00, 'Transfer', 8),
(9, '2026-10-09 10:35:00', 65000.00, 'EDC', 9),
(10, '2026-10-10 11:35:00', 36000.00, 'Tunai', 10);

-- --------------------------------------------------------

--
-- Struktur dari tabel `supplier`
--

CREATE TABLE `supplier` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `telp` varchar(20) DEFAULT NULL,
  `alamat` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `supplier`
--

INSERT INTO `supplier` (`id`, `nama`, `telp`, `alamat`) VALUES
(1, 'PT Sumber Makmur', '0317000001', 'Surabaya'),
(2, 'CV Berkah Jaya', '0317000002', 'Sidoarjo'),
(3, 'PT Elektronik Kita', '0317000003', 'Gresik'),
(4, 'CV Maju Bersama', '0317000004', 'Bangkalan'),
(5, 'PT Niaga Sentosa', '0317000005', 'Madura'),
(6, 'CV Karya Utama', '0317000006', 'Surabaya'),
(7, 'PT Cipta Produk', '0317000007', 'Malang'),
(8, 'CV Mitra Dagang', '0317000008', 'Lamongan'),
(9, 'PT Aneka Usaha', '0317000009', 'Pasuruan'),
(10, 'CV Sinar Abadi', '0317000010', 'Mojokerto');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int(11) NOT NULL,
  `waktu_transaksi` datetime DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `total` decimal(12,2) DEFAULT NULL,
  `pelanggan_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `transaksi`
--

INSERT INTO `transaksi` (`id`, `waktu_transaksi`, `keterangan`, `total`, `pelanggan_id`) VALUES
(1, '2026-10-01 09:00:00', 'Pembelian buku tulis', 10000.00, 1),
(2, '2026-10-02 10:00:00', 'Pembelian pulpen', 6000.00, 2),
(3, '2026-10-03 11:00:00', 'Pembelian pensil', 5000.00, 3),
(4, '2026-10-04 12:00:00', 'Pembelian penghapus', 6000.00, 4),
(5, '2026-10-05 13:00:00', 'Pembelian penggaris', 8000.00, 5),
(6, '2026-10-06 14:00:00', 'Pembelian spidol', 14000.00, 6),
(7, '2026-10-07 15:00:00', 'Pembelian map plastik', 7000.00, 7),
(8, '2026-10-08 09:30:00', 'Pembelian kertas A4', 45000.00, 8),
(9, '2026-10-09 10:30:00', 'Pembelian tinta printer', 65000.00, 9),
(10, '2026-10-10 11:30:00', 'Pembelian stapler', 36000.00, 10);

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi_detail`
--

CREATE TABLE `transaksi_detail` (
  `transaksi_id` int(11) NOT NULL,
  `barang_id` int(11) NOT NULL,
  `harga` decimal(12,2) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `transaksi_detail`
--

INSERT INTO `transaksi_detail` (`transaksi_id`, `barang_id`, `harga`, `qty`) VALUES
(1, 1, 5000.00, 2),
(2, 2, 3000.00, 2),
(3, 3, 2500.00, 2),
(4, 4, 2000.00, 3),
(5, 5, 4000.00, 2),
(6, 6, 7000.00, 2),
(7, 7, 3500.00, 2),
(8, 8, 45000.00, 1),
(9, 9, 65000.00, 1),
(10, 10, 18000.00, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `hp` varchar(20) DEFAULT NULL,
  `level` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `nama`, `alamat`, `hp`, `level`) VALUES
(1, 'admin1', 'admin123', 'Admin Utama', 'Surabaya', '082100000001', 'admin'),
(2, 'kasir1', 'kasir123', 'Kasir Satu', 'Bangkalan', '082100000002', 'kasir'),
(3, 'kasir2', 'kasir123', 'Kasir Dua', 'Surabaya', '082100000003', 'kasir'),
(4, 'staff1', 'staff123', 'Staff Gudang 1', 'Sidoarjo', '082100000004', 'staff'),
(5, 'staff2', 'staff123', 'Staff Gudang 2', 'Gresik', '082100000005', 'staff'),
(6, 'admin2', 'admin123', 'Admin Cabang', 'Madura', '082100000006', 'admin'),
(7, 'kasir3', 'kasir123', 'Kasir Tiga', 'Malang', '082100000007', 'kasir'),
(8, 'staff3', 'staff123', 'Staff Gudang 3', 'Lamongan', '082100000008', 'staff'),
(9, 'kasir4', 'kasir123', 'Kasir Empat', 'Pasuruan', '082100000009', 'kasir'),
(10, 'staff4', 'staff123', 'Staff Gudang 4', 'Mojokerto', '082100000010', 'staff');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Indeks untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaksi_id` (`transaksi_id`);

--
-- Indeks untuk tabel `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pelanggan_id` (`pelanggan_id`);

--
-- Indeks untuk tabel `transaksi_detail`
--
ALTER TABLE `transaksi_detail`
  ADD PRIMARY KEY (`transaksi_id`,`barang_id`),
  ADD KEY `barang_id` (`barang_id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `barang`
--
ALTER TABLE `barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `barang_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`id`);

--
-- Ketidakleluasaan untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`transaksi_id`) REFERENCES `transaksi` (`id`);

--
-- Ketidakleluasaan untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`pelanggan_id`) REFERENCES `pelanggan` (`id`);

--
-- Ketidakleluasaan untuk tabel `transaksi_detail`
--
ALTER TABLE `transaksi_detail`
  ADD CONSTRAINT `transaksi_detail_ibfk_1` FOREIGN KEY (`transaksi_id`) REFERENCES `transaksi` (`id`),
  ADD CONSTRAINT `transaksi_detail_ibfk_2` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`id`);
--
-- Database: `db_utm`
--
CREATE DATABASE IF NOT EXISTS `db_utm` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `db_utm`;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_dosen`
--

CREATE TABLE `tbl_dosen` (
  `ID_DOSEN` int(11) NOT NULL,
  `Nama_dosen` varchar(20) NOT NULL,
  `minat` varchar(20) NOT NULL,
  `Email` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_dosen`
--

INSERT INTO `tbl_dosen` (`ID_DOSEN`, `Nama_dosen`, `minat`, `Email`) VALUES
(1, 'khozaimi', 'komputasi', 'khozaimi@gmail.com'),
(2, 'Arfin Nur Fattahilla', 'RPL', 'arfin@gmail.com'),
(6, 'abs', 'rpl', 'abc@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tbl_dosen`
--
ALTER TABLE `tbl_dosen`
  ADD PRIMARY KEY (`ID_DOSEN`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tbl_dosen`
--
ALTER TABLE `tbl_dosen`
  MODIFY `ID_DOSEN` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- Database: `phpmyadmin`
--
CREATE DATABASE IF NOT EXISTS `phpmyadmin` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE `phpmyadmin`;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pma__bookmark`
--

CREATE TABLE `pma__bookmark` (
  `id` int(10) UNSIGNED NOT NULL,
  `dbase` varchar(255) NOT NULL DEFAULT '',
  `user` varchar(255) NOT NULL DEFAULT '',
  `label` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `query` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Bookmarks';

-- --------------------------------------------------------

--
-- Struktur dari tabel `pma__central_columns`
--

CREATE TABLE `pma__central_columns` (
  `db_name` varchar(64) NOT NULL,
  `col_name` varchar(64) NOT NULL,
  `col_type` varchar(64) NOT NULL,
  `col_length` text DEFAULT NULL,
  `col_collation` varchar(64) NOT NULL,
  `col_isNull` tinyint(1) NOT NULL,
  `col_extra` varchar(255) DEFAULT '',
  `col_default` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Central list of columns';

-- --------------------------------------------------------

--
-- Struktur dari tabel `pma__column_info`
--

CREATE TABLE `pma__column_info` (
  `id` int(5) UNSIGNED NOT NULL,
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `column_name` varchar(64) NOT NULL DEFAULT '',
  `comment` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `mimetype` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `transformation` varchar(255) NOT NULL DEFAULT '',
  `transformation_options` varchar(255) NOT NULL DEFAULT '',
  `input_transformation` varchar(255) NOT NULL DEFAULT '',
  `input_transformation_options` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Column information for phpMyAdmin';

-- --------------------------------------------------------

--
-- Struktur dari tabel `pma__designer_settings`
--

CREATE TABLE `pma__designer_settings` (
  `username` varchar(64) NOT NULL,
  `settings_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Settings related to Designer';

-- --------------------------------------------------------

--
-- Struktur dari tabel `pma__export_templates`
--

CREATE TABLE `pma__export_templates` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL,
  `export_type` varchar(10) NOT NULL,
  `template_name` varchar(64) NOT NULL,
  `template_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved export templates';

-- --------------------------------------------------------

--
-- Struktur dari tabel `pma__favorite`
--

CREATE TABLE `pma__favorite` (
  `username` varchar(64) NOT NULL,
  `tables` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Favorite tables';

-- --------------------------------------------------------

--
-- Struktur dari tabel `pma__history`
--

CREATE TABLE `pma__history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL DEFAULT '',
  `db` varchar(64) NOT NULL DEFAULT '',
  `table` varchar(64) NOT NULL DEFAULT '',
  `timevalue` timestamp NOT NULL DEFAULT current_timestamp(),
  `sqlquery` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='SQL history for phpMyAdmin';

-- --------------------------------------------------------

--
-- Struktur dari tabel `pma__navigationhiding`
--

CREATE TABLE `pma__navigationhiding` (
  `username` varchar(64) NOT NULL,
  `item_name` varchar(64) NOT NULL,
  `item_type` varchar(64) NOT NULL,
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Hidden items of navigation tree';

-- --------------------------------------------------------

--
-- Struktur dari tabel `pma__pdf_pages`
--

CREATE TABLE `pma__pdf_pages` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `page_nr` int(10) UNSIGNED NOT NULL,
  `page_descr` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='PDF relation pages for phpMyAdmin';

-- --------------------------------------------------------

--
-- Struktur dari tabel `pma__recent`
--

CREATE TABLE `pma__recent` (
  `username` varchar(64) NOT NULL,
  `tables` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Recently accessed tables';

--
-- Dumping data untuk tabel `pma__recent`
--

INSERT INTO `pma__recent` (`username`, `tables`) VALUES
('root', '[{\"db\":\"db_penjualan\",\"table\":\"supplier\"},{\"db\":\"db_penjualan\",\"table\":\"pelanggan\"},{\"db\":\"db_penjualan\",\"table\":\"pembayaran\"},{\"db\":\"db_penjualan\",\"table\":\"transaksi_detail\"},{\"db\":\"db_penjualan\",\"table\":\"transaksi\"},{\"db\":\"db_penjualan\",\"table\":\"barang\"},{\"db\":\"db_penjualan\",\"table\":\"user\"},{\"db\":\"db_paw\",\"table\":\"tbl_mhs\"},{\"db\":\"basdat\",\"table\":\"Supplier\"},{\"db\":\"basdat\",\"table\":\"poh\"}]');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pma__relation`
--

CREATE TABLE `pma__relation` (
  `master_db` varchar(64) NOT NULL DEFAULT '',
  `master_table` varchar(64) NOT NULL DEFAULT '',
  `master_field` varchar(64) NOT NULL DEFAULT '',
  `foreign_db` varchar(64) NOT NULL DEFAULT '',
  `foreign_table` varchar(64) NOT NULL DEFAULT '',
  `foreign_field` varchar(64) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Relation table';

-- --------------------------------------------------------

--
-- Struktur dari tabel `pma__savedsearches`
--

CREATE TABLE `pma__savedsearches` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL DEFAULT '',
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `search_name` varchar(64) NOT NULL DEFAULT '',
  `search_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved searches';

-- --------------------------------------------------------

--
-- Struktur dari tabel `pma__table_coords`
--

CREATE TABLE `pma__table_coords` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `pdf_page_number` int(11) NOT NULL DEFAULT 0,
  `x` float UNSIGNED NOT NULL DEFAULT 0,
  `y` float UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table coordinates for phpMyAdmin PDF output';

-- --------------------------------------------------------

--
-- Struktur dari tabel `pma__table_info`
--

CREATE TABLE `pma__table_info` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `display_field` varchar(64) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table information for phpMyAdmin';

-- --------------------------------------------------------

--
-- Struktur dari tabel `pma__table_uiprefs`
--

CREATE TABLE `pma__table_uiprefs` (
  `username` varchar(64) NOT NULL,
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL,
  `prefs` text NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Tables'' UI preferences';

-- --------------------------------------------------------

--
-- Struktur dari tabel `pma__tracking`
--

CREATE TABLE `pma__tracking` (
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL,
  `version` int(10) UNSIGNED NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `schema_snapshot` text NOT NULL,
  `schema_sql` text DEFAULT NULL,
  `data_sql` longtext DEFAULT NULL,
  `tracking` set('UPDATE','REPLACE','INSERT','DELETE','TRUNCATE','CREATE DATABASE','ALTER DATABASE','DROP DATABASE','CREATE TABLE','ALTER TABLE','RENAME TABLE','DROP TABLE','CREATE INDEX','DROP INDEX','CREATE VIEW','ALTER VIEW','DROP VIEW') DEFAULT NULL,
  `tracking_active` int(1) UNSIGNED NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Database changes tracking for phpMyAdmin';

-- --------------------------------------------------------

--
-- Struktur dari tabel `pma__userconfig`
--

CREATE TABLE `pma__userconfig` (
  `username` varchar(64) NOT NULL,
  `timevalue` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `config_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User preferences storage for phpMyAdmin';

--
-- Dumping data untuk tabel `pma__userconfig`
--

INSERT INTO `pma__userconfig` (`username`, `timevalue`, `config_data`) VALUES
('root', '2026-11-01 22:48:50', '{\"Console\\/Mode\":\"show\",\"lang\":\"id\"}');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pma__usergroups`
--

CREATE TABLE `pma__usergroups` (
  `usergroup` varchar(64) NOT NULL,
  `tab` varchar(64) NOT NULL,
  `allowed` enum('Y','N') NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User groups with configured menu items';

-- --------------------------------------------------------

--
-- Struktur dari tabel `pma__users`
--

CREATE TABLE `pma__users` (
  `username` varchar(64) NOT NULL,
  `usergroup` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Users and their assignments to user groups';

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pma__central_columns`
--
ALTER TABLE `pma__central_columns`
  ADD PRIMARY KEY (`db_name`,`col_name`);

--
-- Indeks untuk tabel `pma__column_info`
--
ALTER TABLE `pma__column_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `db_name` (`db_name`,`table_name`,`column_name`);

--
-- Indeks untuk tabel `pma__designer_settings`
--
ALTER TABLE `pma__designer_settings`
  ADD PRIMARY KEY (`username`);

--
-- Indeks untuk tabel `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_user_type_template` (`username`,`export_type`,`template_name`);

--
-- Indeks untuk tabel `pma__favorite`
--
ALTER TABLE `pma__favorite`
  ADD PRIMARY KEY (`username`);

--
-- Indeks untuk tabel `pma__history`
--
ALTER TABLE `pma__history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`,`db`,`table`,`timevalue`);

--
-- Indeks untuk tabel `pma__navigationhiding`
--
ALTER TABLE `pma__navigationhiding`
  ADD PRIMARY KEY (`username`,`item_name`,`item_type`,`db_name`,`table_name`);

--
-- Indeks untuk tabel `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  ADD PRIMARY KEY (`page_nr`),
  ADD KEY `db_name` (`db_name`);

--
-- Indeks untuk tabel `pma__recent`
--
ALTER TABLE `pma__recent`
  ADD PRIMARY KEY (`username`);

--
-- Indeks untuk tabel `pma__relation`
--
ALTER TABLE `pma__relation`
  ADD PRIMARY KEY (`master_db`,`master_table`,`master_field`),
  ADD KEY `foreign_field` (`foreign_db`,`foreign_table`);

--
-- Indeks untuk tabel `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_savedsearches_username_dbname` (`username`,`db_name`,`search_name`);

--
-- Indeks untuk tabel `pma__table_coords`
--
ALTER TABLE `pma__table_coords`
  ADD PRIMARY KEY (`db_name`,`table_name`,`pdf_page_number`);

--
-- Indeks untuk tabel `pma__table_info`
--
ALTER TABLE `pma__table_info`
  ADD PRIMARY KEY (`db_name`,`table_name`);

--
-- Indeks untuk tabel `pma__table_uiprefs`
--
ALTER TABLE `pma__table_uiprefs`
  ADD PRIMARY KEY (`username`,`db_name`,`table_name`);

--
-- Indeks untuk tabel `pma__tracking`
--
ALTER TABLE `pma__tracking`
  ADD PRIMARY KEY (`db_name`,`table_name`,`version`);

--
-- Indeks untuk tabel `pma__userconfig`
--
ALTER TABLE `pma__userconfig`
  ADD PRIMARY KEY (`username`);

--
-- Indeks untuk tabel `pma__usergroups`
--
ALTER TABLE `pma__usergroups`
  ADD PRIMARY KEY (`usergroup`,`tab`,`allowed`);

--
-- Indeks untuk tabel `pma__users`
--
ALTER TABLE `pma__users`
  ADD PRIMARY KEY (`username`,`usergroup`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pma__column_info`
--
ALTER TABLE `pma__column_info`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pma__history`
--
ALTER TABLE `pma__history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  MODIFY `page_nr` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Database: `tbl_mhs`
--
CREATE DATABASE IF NOT EXISTS `tbl_mhs` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `tbl_mhs`;
--
-- Database: `test`
--
CREATE DATABASE IF NOT EXISTS `test` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `test`;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
