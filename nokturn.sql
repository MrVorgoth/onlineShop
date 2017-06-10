-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 10 Cze 2017, 20:32
-- Wersja serwera: 10.1.21-MariaDB
-- Wersja PHP: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `nokturn`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `cart`
--

CREATE TABLE `cart` (
  `id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `total_price` double NOT NULL,
  `order_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `total_price`, `order_date`) VALUES
(1, 12, 100, '2017-01-17'),
(2, 12, 200, '2017-01-18'),
(3, 12, 2400, '2017-01-19'),
(4, 12, 750, '2017-01-19'),
(5, 13, 1800, '2017-01-22'),
(6, 13, 1600, '2017-01-23'),
(7, 13, 200, '2017-01-23'),
(8, 13, 400, '2017-01-23'),
(9, 14, 7500, '2017-06-10'),
(10, 14, 400, '2017-06-10'),
(11, 14, 8150, '2017-06-10');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `cart_item`
--

CREATE TABLE `cart_item` (
  `id` int(10) NOT NULL,
  `item_id` int(10) NOT NULL,
  `cart_id` int(10) NOT NULL,
  `quantity` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `cart_item`
--

INSERT INTO `cart_item` (`id`, `item_id`, `cart_id`, `quantity`) VALUES
(1, 4, 1, 2),
(2, 5, 1, 1),
(3, 6, 1, 1),
(4, 4, 2, 1),
(5, 6, 3, 2),
(6, 5, 3, 2),
(7, 4, 3, 2),
(8, 6, 4, 1),
(9, 7, 4, 1),
(10, 4, 5, 1),
(11, 5, 5, 4),
(12, 4, 6, 2),
(13, 6, 6, 2),
(14, 4, 7, 1),
(15, 5, 8, 1),
(16, 1, 9, 5),
(17, 4, 10, 2),
(18, 7, 11, 1),
(19, 8, 11, 1),
(20, 9, 11, 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `category`
--

CREATE TABLE `category` (
  `id` int(10) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'Computers'),
(2, 'Printers'),
(3, 'Headphones'),
(4, 'Fridges'),
(5, 'Heaters'),
(6, 'Washers');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `item`
--

CREATE TABLE `item` (
  `id` int(10) NOT NULL,
  `category_id` int(10) NOT NULL,
  `name` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `price` double NOT NULL,
  `quantity` int(10) NOT NULL,
  `image_url` text COLLATE utf8_polish_ci NOT NULL,
  `description` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `item`
--

INSERT INTO `item` (`id`, `category_id`, `name`, `price`, `quantity`, `image_url`, `description`) VALUES
(1, 1, 'Computer1', 1500, 15, 'computer1.png', 'Average'),
(2, 1, 'Computer2', 2000, 30, 'computer2.png', 'Normal'),
(3, 1, 'Computer3', 3000, 3, 'computer3.png', 'Best'),
(4, 2, 'Printer1', 200, 8, 'printer1.png', 'Average'),
(5, 2, 'Printer2', 400, 32, 'printer2.png', 'Normal'),
(6, 2, 'Printer3', 600, 40, 'printer3.png', 'Best'),
(7, 3, 'Headphones1', 150, 196, 'headphones1.png', 'Average'),
(8, 4, 'Fridge1', 5000, 29, 'fridge1.png', 'Best'),
(9, 5, 'Heater1', 3000, 49, 'heater1.png', 'Average'),
(10, 6, 'Washer 1', 2300, 35, 'washer1.png', 'Average');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user`
--

CREATE TABLE `user` (
  `id` int(10) NOT NULL,
  `email` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `password` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `type` tinyint(1) NOT NULL,
  `name` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `surname` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `phone` int(50) NOT NULL,
  `street` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `post_code` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `city` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `country` varchar(255) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `type`, `name`, `surname`, `phone`, `street`, `post_code`, `city`, `country`) VALUES
(3, 'admin@gmail.com', '47bce5c74f589f4867dbd57e9ca9f808', 1, 'Admin', 'Admin', 123123123, 'Adminowo', '12-123', 'Adminowo', 'Adminowo'),
(12, 'test@test.test', '47bce5c74f589f4867dbd57e9ca9f808', 0, 'Adam', 'Materac', 123123123, 'Testowska', '12-123', 'Testowo', 'Testlandia'),
(13, 'jack@gmail.com', '47bce5c74f589f4867dbd57e9ca9f808', 0, 'Jacek', 'Placek', 123321123, 'White 12', '23-325', 'Plackowo', 'Plackolandia'),
(14, 'mn@gmail.com', '47bce5c74f589f4867dbd57e9ca9f808', 0, 'Tadeusz', 'Nowak', 589984321, 'Michalowska', '55-555', 'Wroclaw', 'Polska');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `cart_item`
--
ALTER TABLE `cart_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `cart_id` (`cart_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT dla tabeli `cart_item`
--
ALTER TABLE `cart_item`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT dla tabeli `category`
--
ALTER TABLE `category`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT dla tabeli `item`
--
ALTER TABLE `item`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT dla tabeli `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Ograniczenia dla tabeli `cart_item`
--
ALTER TABLE `cart_item`
  ADD CONSTRAINT `cart_item_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `item` (`id`),
  ADD CONSTRAINT `cart_item_ibfk_2` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`id`);

--
-- Ograniczenia dla tabeli `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `item_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
