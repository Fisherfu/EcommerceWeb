-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： localhost
-- 產生時間： 2025 年 06 月 12 日 16:55
-- 伺服器版本： 10.4.28-MariaDB
-- PHP 版本： 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `db`
--

-- --------------------------------------------------------

--
-- 資料表結構 `account`
--

CREATE TABLE `account` (
  `id` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `phone` int(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `address` varchar(50) NOT NULL,
  `is_buyer` tinyint(1) DEFAULT 1,
  `is_seller` tinyint(1) DEFAULT 0,
  `is_admin` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `account`
--

INSERT INTO `account` (`id`, `name`, `password`, `phone`, `email`, `address`, `is_buyer`, `is_seller`, `is_admin`) VALUES
(14, 'magicBear1', '$2y$10$UjzNBymDeUTtPn7f26cT0ugCdoISeTKHuV0PgdfmoPT7ZS24hvnW6', 975827260, 'jerry880915@gmail.com', '你心底', 0, 1, 1),
(15, 'jerry880915', '$2y$10$PLi8eh2Csw.QlR8sXr9bZuJ79/tj8tjNqUCKFppDmGbmdZNphAACW', 975827260, 'jerry880915@gmail.com', '1222', 1, 1, 1);

-- --------------------------------------------------------

--
-- 資料表結構 `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '分類名稱'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci COMMENT='商品分類';

--
-- 傾印資料表的資料 `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, '飲料'),
(2, '零食'),
(3, '日用品'),
(4, '3C產品'),
(5, '水果');

-- --------------------------------------------------------

--
-- 資料表結構 `content`
--

CREATE TABLE `content` (
  `id` int(20) NOT NULL,
  `UID` int(20) NOT NULL,
  `value1` varchar(50) NOT NULL,
  `value2` varchar(50) NOT NULL,
  `value3` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '商品名稱',
  `price` decimal(10,2) NOT NULL COMMENT '商品價格',
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '商品圖片路徑',
  `category_id` int(11) DEFAULT NULL COMMENT '分類 ID',
  `stock_quantity` int(11) DEFAULT 0 COMMENT '庫存數量'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci COMMENT='商品資料';

--
-- 傾印資料表的資料 `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `image`, `category_id`, `stock_quantity`) VALUES
(1, '可口可樂 500ml', 25.00, NULL, 1, 100),
(2, '樂事洋芋片（原味）', 35.00, NULL, 2, 50),
(3, '舒潔衛生紙（10包）', 120.00, NULL, 3, 30),
(4, 'iPhone 充電線', 390.00, NULL, 4, 15),
(5, '雪碧 600ml', 35.00, NULL, 1, 100),
(6, 'OREO 巧克力餅乾', 40.00, NULL, 2, 45),
(7, '蘋果', 20.00, 'images/68498e35d269f_16pic_9362569_s.png', 5, 105);

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `content`
--
ALTER TABLE `content`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `account`
--
ALTER TABLE `account`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `content`
--
ALTER TABLE `content`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- 已傾印資料表的限制式
--

--
-- 資料表的限制式 `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
