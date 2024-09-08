-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 24 Jun 2024 pada 17.20
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `petfood`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`, `email`, `created_at`) VALUES
(1, 'kiel', '$2y$10$3c7JwnR9XO7Rh7aI5z/dVe.RZiMS.vsVuXnMwErsisoCl9b6rkxmK', 'kiel@gmail.com', '2024-06-24 01:47:27');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cart`
--

CREATE TABLE `cart` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `pid` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(10) NOT NULL,
  `quantity` int(10) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `quantity` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `image`, `category`, `quantity`) VALUES
(16, 'alpo dog food', 'Alpo adult beef liver adalah makanan anjing kering dengan nutrisi lengkap dan seimbang.\r\nTerbuat dari campuran daging sapi & sayuran yang lezat dan sehat untuk memanjakan lidah anjing kesayangan Anda.\r\nDan dilengkapi dengan nutrisi yang sangat penting seperti protein untuk struktur tubuh & pertahanan alami, kalsium untuk perlindungan gigi & tulang, serta Omega 3 & 6 untuk kulit yang sehat dan bulu yang berkilau', 80000.00, 'alpo dog.jfif', 'Dog', 11),
(17, 'Pedigree Puppy Dryfood', 'Pedigree merupakan makanan untuk anak anjing yang terbuat dari aneka macam daging dan sayuran pilihan yang kaya akan nutrisi. Diproses secara higienis sehingga menjaga kandungan nutrisi di dalamnya. Sangat baik untuk dikonsumsi oleh Si Dia yang masih kecil dan membutuhkan nutrisi yang cukup selama masa tumbuh kembangnya.', 75000.00, 'dry-food-dog.jfif', 'Dog', 16),
(18, 'Pedigree Adult Beef 3KG', 'Pedigree Baik untuk kesehatan kulit & membuat bulu bersinar.\r\nMenjaga kesehatan & kekuatan tulang\r\nMenjaga kesehatan pencernaan anjing\r\nMembuat otot lebih kuat\r\nMengandung Nutrisi tepat untuk membangun sistem kekebalan tubuh yang baik', 130000.00, 'pedigre adult dog.jfif', 'Dog', 17),
(19, 'ROYAL LOW FAT DOG 1,5 KG DRY FOOD', 'Makanan kering untuk anjing yang bermasalah pada pencernaannya. Kandungan fat pada makanan ini lebih rendah dibanding varian Gastro lainnya', 275000.00, 'royal-low-food-dog.jfif', 'Dog', 3),
(20, 'ROYAL CANIN Mini Indoor Puppy 1,5kg | RC Dry Dog Food', 'MINI INDOOR PUPPY membantu mendukung pertahanan tubuh alami anak anjing anda terutama berkat kompleks antioksidan yang dipatenkan* termasuk vitamin E.', 216000.00, 'royal-canin-dog.jfif', 'Dog', 6),
(21, 'MAKANAN ANJING BOLT Kemasan 1KG BEEF Dog Food', 'BOLT Beef Dog Food merupakan pakan anjing untuk usia di atas 1 tahun, yang diformulasikan untuk memenuhi nutrisi standar Profil Nutrisi Makanan Anjing yang disahkan oleh AAFCO (Association of American Feed Control Officials).', 18000.00, 'makanan anjing merk bolt.jfif', 'Dog', 6),
(22, 'PEDIGREE Makanan Anjing Basah Kaleng Rasa Beef [700 g]', '• Baik untuk kesehatan kulit membuat bulu bersinar\r\n• Menjaga kesehatan kekuatan tulang\r\n• Menjaga kesehatan pencernaan anjing\r\n• Membuat otot lebih kuat', 40000.00, 'makanan anjing basah1.webp', 'Dog', 10),
(23, 'MAKANAN ANJING POODLE PUPPY - ROYAL CANIN POODLE JUNIOR 1.5KG', '• Baik untuk kesehatan kulit membuat bulu bersinar • Menjaga kesehatan kekuatan tulang • Menjaga kesehatan pencernaan anjing • Membuat otot lebih kuat', 307000.00, 'royal-anjing-puppy.jpg', 'Dog', 15),
(24, 'Makanan Anjing Basah Kaleng Yummy Dog 375gr Dog Wet Food', 'Yummy Canned Dog Wet Food adalah produk makanan anjing yang diproses secara teliti dan bersih, serta menjaga kesegaran bahan alaminya, sangat cocok untuk hewan kesayangan. Memiliki nilai gizi dan protein yang cukup untuk kebutuhan sehari - hari.', 15000.00, 'makanan-anjing-yummy.jfif', 'Dog', 20),
(25, 'Bolt Cat Tuna ikan dan donat 400 gr makanan kucing', '- Membuat kulit sehat dan bulu berkilau\r\n- Mempertajam penglihatan \r\n- Membantu menjaga kesehatan gigi\r\n- Mengurangi resiko FLUTD (penyakit saluran kemih pada kucing)\r\n- Meningkatkan sistem imunitas', 12000.00, 'bolt-cat-tuna.jfif', 'Cat', 90),
(26, 'Felibite Mother & Kitten Repack 400gr - makanan anak kucing', 'Felibite Mother and Kitten adalah makanan kucing multifungsi yang di formulasikan khusus untuk indukan selama hamil dan menyusui serta untuk anakan. Diperkaya dengan minyak salmon dan susu tinggi kalsium untuk masa pertumbuhan anak kucing serta masa hamil dan menyusui bagi induk. Diformulasikan dengan bentuk kibble yang tipis dan renyah agar mudah untuk di konsumsi dan di sukai kucing.', 25000.00, 'felibite-cat.jfif', 'Cat', 33),
(27, 'Makanan Basah Anak Kucing / Wet Food Kitten Whiskas Junior', 'WET FOOD WHISKAS JUNIOR Makanan basah Makanan kucing kitten umur 1-12 bulan, bisa juga diperuntukan kucing dewasa sebagai campuran makanan kering info produk whiskas diperkaya protein untuk memenuhi nutrisi anak kucing / kitten..', 8000.00, 'whiskas-anak-kucing.jfif', 'Cat', 10),
(28, 'Meo Persian 6,8kg – Makanan Kucing Kering', 'Me-o makanan kucing persian adalah makanan yang ideal untuk diberikan kepada kucing persia Anda karena mencegah pembentukan bola rambut.', 342000.00, 'meo-persian-cat.jfif', 'Cat', 10),
(29, 'Makanan Kucing MeO Adult Gourmet 1,1kg', 'Taurine untuk kesehatan mata dan ketajaman penglihatan kucing. Vitamin C meningkatkan sistem imunitas dan membantu mengatasi stres terhadap lingkungan.', 55000.00, 'meo kucing1.jfif', 'Cat', 10),
(30, 'pakan kucing kering Excel rasa ikan tuna kemasan 500g', 'pakan kucing kering Excel rasa ikan tuna kemasan 500g \r\nmodel isi donat', 14000.00, 'excel-kucing.jfif', 'Cat', 10);

-- --------------------------------------------------------

--
-- Struktur dari tabel `shipping_info`
--

CREATE TABLE `shipping_info` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `nomor_telepon` varchar(20) NOT NULL,
  `kode_pos` varchar(10) NOT NULL,
  `metode_pembayaran` enum('cash_on_delivery','credit_card') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `total_amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `shipping_info`
--

INSERT INTO `shipping_info` (`id`, `nama`, `alamat`, `nomor_telepon`, `kode_pos`, `metode_pembayaran`, `created_at`, `total_amount`) VALUES
(12, 'Yehezkiel', 'JL. Matraman', '085782231455', '1310', 'cash_on_delivery', '2024-06-24 08:06:57', 50000.00),
(13, 'natan', 'JL. Matraman', '085782231455', '1310', 'cash_on_delivery', '2024-06-24 08:10:01', 50000.00),
(14, 'kiel', 'JL. Matraman', '085782231455', '1310', 'cash_on_delivery', '2024-06-24 09:48:06', 566000.00);

-- --------------------------------------------------------

--
-- Struktur dari tabel `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_ids` text NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `payment_method` enum('cash_on_delivery','credit_debit_card') NOT NULL,
  `transaction_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `customer_name` varchar(100) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `postal_code` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`) VALUES
(2, 'kiel', '123', 'kiel@gmail.com'),
(3, 'nat', '$2y$10$UqpfR8NAzRrkDKOJ3bo1auAIBd929Rx2c1czPslm8WN2AwMpljSqu', 'nat@gmail.com'),
(4, 'admin', '$2y$10$2QQ5VJzCAr4L758yIsxDKuskntdR1uXBgVlTPRs5RR5qb0tRfDBEO', 'admin@gmail.com'),
(5, 'justin', '$2y$10$z5plNNhe5B0yQVRtMgpYMeojzbnPBR1.pv8f0pGVsOkhsMwgvg9B.', 'justin@gmail.com'),
(8, 'kielr', '$2y$10$2vpb3nfE6bU7InRcQOtOuOR8Ep0QfIVCRs3vH18EYEFOLRB5gv1DC', 'kielr@gmail.com'),
(9, 'justinr', '$2y$10$LOGfEQPhQlcVgi.bD5LCCebkcorI6.CQIO6Chj9SnFGIV1Dpn9tr2', 'justinr@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indeks untuk tabel `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `shipping_info`
--
ALTER TABLE `shipping_info`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT untuk tabel `shipping_info`
--
ALTER TABLE `shipping_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
