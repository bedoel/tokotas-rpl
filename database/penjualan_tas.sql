-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 10 Agu 2024 pada 12.02
-- Versi server: 10.4.6-MariaDB
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
-- Database: `penjualan_tas`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang`
--

CREATE TABLE `barang` (
  `kd_barang` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `nama_barang` varchar(100) CHARACTER SET utf8mb4 NOT NULL,
  `harga_barang` int(100) NOT NULL,
  `stok_barang` int(11) NOT NULL,
  `gambar_barang` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `kategori` varchar(20) CHARACTER SET utf8mb4 NOT NULL,
  `id_user` int(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `barang`
--

INSERT INTO `barang` (`kd_barang`, `nama_barang`, `harga_barang`, `stok_barang`, `gambar_barang`, `kategori`, `id_user`) VALUES
('BRG0001', 'Deco Mini Shoulder Bag White', 2500000, 44, '6594ce00068e6.jpg', 'Wanita', 1),
('BRG0003', 'Rockstud Spike Small Shoulder Bag Black', 24300000, 20, 'valentinorockstud.jpg', 'wanita', 2),
('BRG0007', 'Ransel Black', 100000, 100, '6594ceab8f674.jpg', 'Pria', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_users`
--

CREATE TABLE `tbl_users` (
  `id_user` int(200) NOT NULL,
  `name` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `no_telp` varchar(50) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `password` varchar(50) NOT NULL,
  `role` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_users`
--

INSERT INTO `tbl_users` (`id_user`, `name`, `username`, `email`, `no_telp`, `tgl_lahir`, `password`, `role`) VALUES
(1, 'Fadlur', 'seller', 'fadlur123@gmail.com', '089505699702', '2003-08-31', 'seller', 'Seller'),
(2, 'seller', 'seller123', 'seller123@gmail.com', '089887766578', '2024-06-04', 'seller123', 'Seller'),
(13, 'Fajar Reza', 'fajar123', 'fajar123@gmail.com', '089775534278', '2024-01-01', '123123123', 'User'),
(14, 'Admin', 'admin', 'admin@gmail.com', '089786756457', '2024-01-01', 'admin', 'Admin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(200) NOT NULL,
  `jml_barang` float NOT NULL,
  `total_harga` int(100) NOT NULL,
  `tgl_transaksi` varchar(200) NOT NULL,
  `tujuan` varchar(255) NOT NULL,
  `id_user` int(11) NOT NULL,
  `kd_barang` varchar(255) CHARACTER SET utf8mb4 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `jml_barang`, `total_harga`, `tgl_transaksi`, `tujuan`, `id_user`, `kd_barang`) VALUES
(14, 8, 194400000, '03 Jan 2024', 'Jl Jalan', 13, 'BRG0003'),
(17, 6, 15000000, '06 Jun 2024', 'bahari', 13, 'BRG0001');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`kd_barang`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`id_user`);

--
-- Indeks untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `kd_barang` (`kd_barang`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `id_user` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `barang_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `tbl_users` (`id_user`);

--
-- Ketidakleluasaan untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `tbl_users` (`id_user`),
  ADD CONSTRAINT `transaksi_ibfk_2` FOREIGN KEY (`kd_barang`) REFERENCES `barang` (`kd_barang`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
