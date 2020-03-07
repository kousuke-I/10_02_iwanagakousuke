-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 
-- サーバのバージョン： 10.4.11-MariaDB
-- PHP のバージョン: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `gsacfd05_02`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `client_list`
--

CREATE TABLE `client_list` (
  `id` int(8) NOT NULL,
  `client` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `tel` int(11) NOT NULL,
  `fax` int(11) NOT NULL,
  `postal_code` int(8) NOT NULL,
  `address` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `comment` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- テーブルのデータのダンプ `client_list`
--

INSERT INTO `client_list` (`id`, `client`, `tel`, `fax`, `postal_code`, `address`, `comment`, `created_at`, `updated_at`) VALUES
(5, '', 92, 92, 810, '福岡県福岡市中央区大名1-3-41', 'セカイを変えるＧＥＥＫになろう。', '2020-02-15 13:12:44', '2020-02-15 13:12:44'),
(6, '西部産業', 956228181, 956228181, 857, '佐世保市', 'ああああ', '2020-02-18 18:10:42', '2020-02-18 18:10:42');

-- --------------------------------------------------------

--
-- テーブルの構造 `todo_table`
--

CREATE TABLE `todo_table` (
  `id` int(12) NOT NULL,
  `task` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `deadline` date NOT NULL,
  `comment` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `image` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- テーブルのデータのダンプ `todo_table`
--

INSERT INTO `todo_table` (`id`, `task`, `deadline`, `comment`, `image`, `created_at`, `updated_at`) VALUES
(4, '', '2020-02-06', '2', NULL, '2020-02-05 23:53:33', '2020-02-05 23:53:33'),
(5, 'ううう', '2020-02-08', '123456789', NULL, '2020-02-08 14:54:50', '2020-02-08 14:54:50'),
(6, '課題', '2020-02-15', 'PHP', NULL, '2020-02-15 14:36:46', '2020-02-15 14:36:46'),
(7, '課題２', '2020-02-15', 'ジーズ２', 'upload/20200215081040d41d8cd98f00b204e9800998ecf8427e.png', '2020-02-15 16:10:40', '2020-02-15 16:10:40');

-- --------------------------------------------------------

--
-- テーブルの構造 `users_table`
--

CREATE TABLE `users_table` (
  `id` int(12) NOT NULL,
  `user_id` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `is_admin` int(1) NOT NULL,
  `is_deleted` int(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- テーブルのデータのダンプ `users_table`
--

INSERT INTO `users_table` (`id`, `user_id`, `password`, `is_admin`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'test', 'test', 0, 0, '2020-02-29 15:33:14', '2020-02-29 15:33:14');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `client_list`
--
ALTER TABLE `client_list`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- テーブルのインデックス `todo_table`
--
ALTER TABLE `todo_table`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `users_table`
--
ALTER TABLE `users_table`
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルのAUTO_INCREMENT
--

--
-- テーブルのAUTO_INCREMENT `client_list`
--
ALTER TABLE `client_list`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- テーブルのAUTO_INCREMENT `todo_table`
--
ALTER TABLE `todo_table`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- テーブルのAUTO_INCREMENT `users_table`
--
ALTER TABLE `users_table`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
