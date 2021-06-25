-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 23 Cze 2021, 17:08
-- Wersja serwera: 10.4.19-MariaDB
-- Wersja PHP: 8.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `db_budget`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `expenses`
--

CREATE TABLE `expenses` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `expense_category_assigned_to_user_id` int(11) UNSIGNED NOT NULL,
  `payment_method_assigned_to_user_id` int(11) UNSIGNED NOT NULL,
  `amount` decimal(8,2) NOT NULL DEFAULT 0.00,
  `date_of_expense` date NOT NULL,
  `expense_comment` varchar(100) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `expenses`
--

INSERT INTO `expenses` (`id`, `user_id`, `expense_category_assigned_to_user_id`, `payment_method_assigned_to_user_id`, `amount`, `date_of_expense`, `expense_comment`) VALUES
(1, 1, 10, 2, '11.43', '2021-05-29', 'Pierwszy komentarz						'),
(2, 1, 1, 3, '2.45', '2021-05-31', 'Drugi komentarz					'),
(3, 2, 27, 4, '2.01', '2021-05-31', '	dadasda							'),
(4, 1, 4, 1, '159.25', '2021-05-01', 'Opłata za prąd						'),
(5, 1, 10, 2, '43.21', '2021-05-11', '								'),
(6, 1, 11, 2, '65.54', '2021-06-04', 'wczasy							');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `expenses_category_assigned_to_users`
--

CREATE TABLE `expenses_category_assigned_to_users` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `expenses_category_assigned_to_users`
--

INSERT INTO `expenses_category_assigned_to_users` (`id`, `user_id`, `name`) VALUES
(1, 1, 'Transport'),
(2, 1, 'Books'),
(3, 1, 'Food'),
(4, 1, 'Apartments'),
(5, 1, 'Telecommunication'),
(6, 1, 'Health'),
(7, 1, 'Clothes'),
(8, 1, 'Hygiene'),
(9, 1, 'Kids'),
(10, 1, 'Recreation'),
(11, 1, 'Trip'),
(12, 1, 'Savings'),
(13, 1, 'For Retirement'),
(14, 1, 'Debt Repayment'),
(15, 1, 'Gift'),
(16, 1, 'Another'),
(17, 2, 'Transport'),
(18, 2, 'Books'),
(19, 2, 'Food'),
(20, 2, 'Apartments'),
(21, 2, 'Telecommunication'),
(22, 2, 'Health'),
(23, 2, 'Clothes'),
(24, 2, 'Hygiene'),
(25, 2, 'Kids'),
(26, 2, 'Recreation'),
(27, 2, 'Trip'),
(28, 2, 'Savings'),
(29, 2, 'For Retirement'),
(30, 2, 'Debt Repayment'),
(31, 2, 'Gift'),
(32, 2, 'Another'),
(33, 3, 'Transport'),
(34, 3, 'Books'),
(35, 3, 'Food'),
(36, 3, 'Apartments'),
(37, 3, 'Telecommunication'),
(38, 3, 'Health'),
(39, 3, 'Clothes'),
(40, 3, 'Hygiene'),
(41, 3, 'Kids'),
(42, 3, 'Recreation'),
(43, 3, 'Trip'),
(44, 3, 'Savings'),
(45, 3, 'For Retirement'),
(46, 3, 'Debt Repayment'),
(47, 3, 'Gift'),
(48, 3, 'Another'),
(49, 43, 'Transport'),
(50, 43, 'Books'),
(51, 43, 'Food'),
(52, 43, 'Apartments'),
(53, 43, 'Telecommunication'),
(54, 43, 'Health'),
(55, 43, 'Clothes'),
(56, 43, 'Hygiene'),
(57, 43, 'Kids'),
(58, 43, 'Recreation'),
(59, 43, 'Trip'),
(60, 43, 'Savings'),
(61, 43, 'For Retirement'),
(62, 43, 'Debt Repayment'),
(63, 43, 'Gift'),
(64, 43, 'Another'),
(65, 44, 'Transport'),
(66, 44, 'Books'),
(67, 44, 'Food'),
(68, 44, 'Apartments'),
(69, 44, 'Telecommunication'),
(70, 44, 'Health'),
(71, 44, 'Clothes'),
(72, 44, 'Hygiene'),
(73, 44, 'Kids'),
(74, 44, 'Recreation'),
(75, 44, 'Trip'),
(76, 44, 'Savings'),
(77, 44, 'For Retirement'),
(78, 44, 'Debt Repayment'),
(79, 44, 'Gift'),
(80, 44, 'Another'),
(81, 45, 'Transport'),
(82, 45, 'Books'),
(83, 45, 'Food'),
(84, 45, 'Apartments'),
(85, 45, 'Telecommunication'),
(86, 45, 'Health'),
(87, 45, 'Clothes'),
(88, 45, 'Hygiene'),
(89, 45, 'Kids'),
(90, 45, 'Recreation'),
(91, 45, 'Trip'),
(92, 45, 'Savings'),
(93, 45, 'For Retirement'),
(94, 45, 'Debt Repayment'),
(95, 45, 'Gift'),
(96, 45, 'Another'),
(97, 46, 'Transport'),
(98, 46, 'Books'),
(99, 46, 'Food'),
(100, 46, 'Apartments'),
(101, 46, 'Telecommunication'),
(102, 46, 'Health'),
(103, 46, 'Clothes'),
(104, 46, 'Hygiene'),
(105, 46, 'Kids'),
(106, 46, 'Recreation'),
(107, 46, 'Trip'),
(108, 46, 'Savings'),
(109, 46, 'For Retirement'),
(110, 46, 'Debt Repayment'),
(111, 46, 'Gift'),
(112, 46, 'Another'),
(113, 47, 'Transport'),
(114, 47, 'Books'),
(115, 47, 'Food'),
(116, 47, 'Apartments'),
(117, 47, 'Telecommunication'),
(118, 47, 'Health'),
(119, 47, 'Clothes'),
(120, 47, 'Hygiene'),
(121, 47, 'Kids'),
(122, 47, 'Recreation'),
(123, 47, 'Trip'),
(124, 47, 'Savings'),
(125, 47, 'For Retirement'),
(126, 47, 'Debt Repayment'),
(127, 47, 'Gift'),
(128, 47, 'Another'),
(129, 49, 'Transport'),
(130, 49, 'Books'),
(131, 49, 'Food'),
(132, 49, 'Apartments'),
(133, 49, 'Telecommunication'),
(134, 49, 'Health'),
(135, 49, 'Clothes'),
(136, 49, 'Hygiene'),
(137, 49, 'Kids'),
(138, 49, 'Recreation'),
(139, 49, 'Trip'),
(140, 49, 'Savings'),
(141, 49, 'For Retirement'),
(142, 49, 'Debt Repayment'),
(143, 49, 'Gift'),
(144, 49, 'Another'),
(145, 50, 'Transport'),
(146, 50, 'Books'),
(147, 50, 'Food'),
(148, 50, 'Apartments'),
(149, 50, 'Telecommunication'),
(150, 50, 'Health'),
(151, 50, 'Clothes'),
(152, 50, 'Hygiene'),
(153, 50, 'Kids'),
(154, 50, 'Recreation'),
(155, 50, 'Trip'),
(156, 50, 'Savings'),
(157, 50, 'For Retirement'),
(158, 50, 'Debt Repayment'),
(159, 50, 'Gift'),
(160, 50, 'Another');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `expenses_category_default`
--

CREATE TABLE `expenses_category_default` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `expenses_category_default`
--

INSERT INTO `expenses_category_default` (`id`, `name`) VALUES
(1, 'Transport'),
(2, 'Books'),
(3, 'Food'),
(4, 'Apartments'),
(5, 'Telecommunication'),
(6, 'Health'),
(7, 'Clothes'),
(8, 'Hygiene'),
(9, 'Kids'),
(10, 'Recreation'),
(11, 'Trip'),
(12, 'Savings'),
(13, 'For Retirement'),
(14, 'Debt Repayment'),
(15, 'Gift'),
(16, 'Another');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `incomes`
--

CREATE TABLE `incomes` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `income_category_assigned_to_user_id` int(11) UNSIGNED NOT NULL,
  `amount` decimal(8,2) NOT NULL DEFAULT 0.00,
  `date_of_income` date NOT NULL,
  `income_comment` varchar(100) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `incomes`
--

INSERT INTO `incomes` (`id`, `user_id`, `income_category_assigned_to_user_id`, `amount`, `date_of_income`, `income_comment`) VALUES
(1, 1, 2, '2.00', '2021-05-30', 'Pierwszy komentarz														'),
(2, 1, 3, '2.00', '2021-05-31', 'Pierwszy komentarz														'),
(3, 1, 2, '25.23', '2021-06-09', 'Odsetki bankowe							'),
(4, 1, 2, '23.20', '2021-05-19', 'drugi komentarz						'),
(6, 1, 3, '32.10', '2021-05-20', 'nic							');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `incomes_category_assigned_to_users`
--

CREATE TABLE `incomes_category_assigned_to_users` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `incomes_category_assigned_to_users`
--

INSERT INTO `incomes_category_assigned_to_users` (`id`, `user_id`, `name`) VALUES
(1, 1, 'Salary'),
(2, 1, 'Interest'),
(3, 1, 'Allegro'),
(4, 1, 'Another'),
(5, 2, 'Salary'),
(6, 2, 'Interest'),
(7, 2, 'Allegro'),
(8, 2, 'Another'),
(9, 3, 'Salary'),
(10, 3, 'Interest'),
(11, 3, 'Allegro'),
(12, 3, 'Another'),
(13, 43, 'Salary'),
(14, 43, 'Interest'),
(15, 43, 'Allegro'),
(16, 43, 'Another'),
(17, 44, 'Salary'),
(18, 44, 'Interest'),
(19, 44, 'Allegro'),
(20, 44, 'Another'),
(21, 45, 'Salary'),
(22, 45, 'Interest'),
(23, 45, 'Allegro'),
(24, 45, 'Another'),
(25, 46, 'Salary'),
(26, 46, 'Interest'),
(27, 46, 'Allegro'),
(28, 46, 'Another'),
(29, 47, 'Salary'),
(30, 47, 'Interest'),
(31, 47, 'Allegro'),
(32, 47, 'Another'),
(33, 49, 'Salary'),
(34, 49, 'Interest'),
(35, 49, 'Allegro'),
(36, 49, 'Another'),
(37, 50, 'Salary'),
(38, 50, 'Interest'),
(39, 50, 'Allegro'),
(40, 50, 'Another');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `incomes_category_default`
--

CREATE TABLE `incomes_category_default` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `incomes_category_default`
--

INSERT INTO `incomes_category_default` (`id`, `name`) VALUES
(1, 'Salary'),
(2, 'Interest'),
(3, 'Allegro'),
(4, 'Another');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `payment_methods_assigned_to_users`
--

CREATE TABLE `payment_methods_assigned_to_users` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `payment_methods_assigned_to_users`
--

INSERT INTO `payment_methods_assigned_to_users` (`id`, `user_id`, `name`) VALUES
(1, 1, 'Cash'),
(2, 1, 'Debit Card'),
(3, 1, 'Credit Card'),
(4, 2, 'Cash'),
(5, 2, 'Debit Card'),
(6, 2, 'Credit Card'),
(7, 3, 'Cash'),
(8, 3, 'Debit Card'),
(9, 3, 'Credit Card'),
(10, 43, 'Cash'),
(11, 43, 'Debit Card'),
(12, 43, 'Credit Card'),
(13, 44, 'Cash'),
(14, 44, 'Debit Card'),
(15, 44, 'Credit Card'),
(16, 45, 'Cash'),
(17, 45, 'Debit Card'),
(18, 45, 'Credit Card'),
(19, 46, 'Cash'),
(20, 46, 'Debit Card'),
(21, 46, 'Credit Card'),
(22, 47, 'Cash'),
(23, 47, 'Debit Card'),
(24, 47, 'Credit Card'),
(25, 49, 'Cash'),
(26, 49, 'Debit Card'),
(27, 49, 'Credit Card'),
(28, 50, 'Cash'),
(29, 50, 'Debit Card'),
(30, 50, 'Credit Card');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `payment_methods_default`
--

CREATE TABLE `payment_methods_default` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `payment_methods_default`
--

INSERT INTO `payment_methods_default` (`id`, `name`) VALUES
(1, 'Cash'),
(2, 'Debit Card'),
(3, 'Credit Card');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `remembered_logins`
--

CREATE TABLE `remembered_logins` (
  `token_hash` varchar(64) NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `expiry_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `reset_passwords`
--

CREATE TABLE `reset_passwords` (
  `token_hash` varchar(64) NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `expiry_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `reset_passwords`
--

INSERT INTO `reset_passwords` (`token_hash`, `user_id`, `expiry_date`) VALUES
('110d59322eb0844d3aeab4e3e4e3dbd94bec9bb6548ec3e5f812619403fa4392', 3, '2021-06-22 21:58:00'),
('24a26a46f99c3246e860410a0420dff177c68c55e19f9170fed75030062cf713', 3, '2021-06-22 22:37:36'),
('2ca1d32c923f5ce9ba91a28e47bd130fad72021dd2292017cf065430b29b42bb', 3, '2021-06-22 22:56:39'),
('485da36e223b158c059fd2554d21605cb07dc5430abc8dbdf20d52b832d574c0', 3, '2021-06-22 23:11:30'),
('5ea86e88b4827d624b1e6b3f463ac6ed4d7ecf15a3e9469579fc6d1fd0c947b1', 3, '2021-06-22 23:01:12'),
('717d95e9dbd6554163772adbcfa249d22b106555ae1f55560a2b6579ea859151', 3, '2021-06-22 23:04:32'),
('8459704f5a9af86909b7800fa36b314abb4e925e2e2d46b9bdadf55220d2c238', 3, '2021-06-22 22:58:51'),
('961c403b5e4d78978064d0e30044f62ff83fcd40027a9e96c85ebd1fa8ed5dce', 3, '2021-06-22 23:10:50'),
('f8c234316befb94ad3b78f802479ed763b283cd7e142c2206cba580f2828b7c7', 3, '2021-06-22 22:37:57');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `username` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`) VALUES
(1, 'dan', '$2y$10$8uC4WNpnrEAayLQEHWyNau34nXfifsOGxdRJwyhj/k2mMA3XibrAa', 'dan@gmail.com'),
(2, 'Janek', '$2y$10$53dpN1Kw/FGoKQIGexSDBeMcQTZYECVhoktfk235DjtB2Jjnqge3q', 'jan@gmail.com'),
(3, 'Lukasz', '$2y$10$Rl/NrtP.jKlWnmkUrLc0pO4ySbhXPwoG8tdXlKLCLIT9PQmbKEF/y', 'l16@vp.pl');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `expenses_category_assigned_to_users`
--
ALTER TABLE `expenses_category_assigned_to_users`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `expenses_category_default`
--
ALTER TABLE `expenses_category_default`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `incomes`
--
ALTER TABLE `incomes`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `incomes_category_assigned_to_users`
--
ALTER TABLE `incomes_category_assigned_to_users`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `incomes_category_default`
--
ALTER TABLE `incomes_category_default`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `payment_methods_assigned_to_users`
--
ALTER TABLE `payment_methods_assigned_to_users`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `payment_methods_default`
--
ALTER TABLE `payment_methods_default`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `remembered_logins`
--
ALTER TABLE `remembered_logins`
  ADD PRIMARY KEY (`token_hash`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `user_id_2` (`user_id`);

--
-- Indeksy dla tabeli `reset_passwords`
--
ALTER TABLE `reset_passwords`
  ADD PRIMARY KEY (`token_hash`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT dla tabeli `expenses_category_assigned_to_users`
--
ALTER TABLE `expenses_category_assigned_to_users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=161;

--
-- AUTO_INCREMENT dla tabeli `expenses_category_default`
--
ALTER TABLE `expenses_category_default`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT dla tabeli `incomes`
--
ALTER TABLE `incomes`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT dla tabeli `incomes_category_assigned_to_users`
--
ALTER TABLE `incomes_category_assigned_to_users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT dla tabeli `incomes_category_default`
--
ALTER TABLE `incomes_category_default`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT dla tabeli `payment_methods_assigned_to_users`
--
ALTER TABLE `payment_methods_assigned_to_users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT dla tabeli `payment_methods_default`
--
ALTER TABLE `payment_methods_default`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
