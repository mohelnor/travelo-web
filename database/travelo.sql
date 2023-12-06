-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 07, 2023 at 07:56 AM
-- Server version: 5.7.17-log
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `travelo`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL COMMENT 'معرف أو المفتاح الرئيسي',
  `user` int(11) NOT NULL COMMENT 'مستخدم التطبيق',
  `fullname` varchar(100) NOT NULL COMMENT 'اسم الزبون',
  `phone` varchar(11) NOT NULL COMMENT 'الهاتف',
  `trip` int(11) NOT NULL COMMENT 'الرحلة',
  `bus` int(11) NOT NULL COMMENT 'الباص',
  `seat` int(11) NOT NULL COMMENT 'رقم المقعد',
  `luggage` int(11) NOT NULL COMMENT 'عدد الأمتعه',
  `price` int(11) NOT NULL COMMENT 'السعر',
  `location` int(11) NOT NULL COMMENT 'الموقع',
  `payed` tinyint(1) NOT NULL COMMENT '[0 لم يدفع ] , [1 تم الدفع] , [2 إلغاء الحجز]',
  `notes` text,
  `due` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'تاريخ الاقلاع',
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'وقت الحجز'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `user`, `fullname`, `phone`, `trip`, `bus`, `seat`, `luggage`, `price`, `location`, `payed`, `notes`, `due`, `created`) VALUES
(1, 1, 'administrator', '222', 6, 5, 1, 1, 24000, 3, 0, '2222', '2023-05-31 00:00:00', '2023-06-07 09:53:29'),
(2, 1, 'administrator', '222', 6, 5, 2, 1, 24000, 3, 0, '2222', '2023-05-31 00:00:00', '2023-06-07 09:53:29'),
(3, 2, 'administrator', '222', 1, 2, 2, 0, 11000, 1, 0, '222222222', '2023-05-21 00:00:00', '2023-06-07 10:20:00');

-- --------------------------------------------------------

--
-- Table structure for table `bus`
--

CREATE TABLE `bus` (
  `id` int(11) NOT NULL COMMENT 'معرف أو المفتاح الرئيسي',
  `name` varchar(50) NOT NULL COMMENT 'اسم الباص',
  `plate` varchar(20) NOT NULL COMMENT 'رقم اللوحة',
  `seats` int(11) NOT NULL COMMENT 'عدد المقاعد',
  `ticketPrice` int(11) NOT NULL COMMENT 'سعر التذكرة',
  `trip` int(11) NOT NULL,
  `status` int(11) NOT NULL COMMENT 'حالة الباص متوفر أم لا',
  `date` datetime NOT NULL COMMENT 'تاريخ التعديل أو الوصول',
  `company` int(11) NOT NULL COMMENT 'الشركة',
  `details` varchar(100) NOT NULL COMMENT 'تفاصيل إضافية'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `bus`
--

INSERT INTO `bus` (`id`, `name`, `plate`, `seats`, `ticketPrice`, `trip`, `status`, `date`, `company`, `details`) VALUES
(1, 'afras 100', 'kh1205', 15, 14000, 1, 1, '2023-05-18 00:00:00', 1, 'تفاصيل أكثر'),
(2, 'afras 200', 'kh1235', 24, 11000, 1, 1, '2023-05-21 00:00:00', 1, 'more'),
(3, 'افراس 300', 'kh1235', 24, 11000, 2, 1, '2023-05-21 00:00:00', 1, 'more'),
(5, 'بخنان 4', '1567', 24, 24000, 6, 2, '2023-05-31 00:00:00', 1, '2023-06-01T15:21'),
(6, 'بخنان 5', '1567', 24, 24000, 6, 2, '2023-05-31 00:00:00', 1, 'لا توجد به خدمات');

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` int(11) NOT NULL COMMENT 'معرف أو المفتاح الرئيسي',
  `name` varchar(100) NOT NULL COMMENT 'المدينة',
  `details` varchar(100) NOT NULL COMMENT 'موقع الميناء أو أي تفاصيل أخرى'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `name`, `details`) VALUES
(1, 'بورتسودان', 'البحر الأحمر'),
(2, 'swakin', 'redsea state'),
(3, 'khartoum', 'الميناء البري'),
(4, 'كسلا', 'السوق الشعبي'),
(5, 'الأبيض', 'الأبيض'),
(6, 'الجزيرة', 'الشعبي');

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `id` int(11) NOT NULL COMMENT 'معرف أو المفتاح الرئيسي',
  `name` varchar(100) NOT NULL COMMENT 'المكتب أو الشركة',
  `phone` varchar(11) NOT NULL COMMENT 'الهاتف'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id`, `name`, `phone`) VALUES
(1, 'بختان', '0111112345');

-- --------------------------------------------------------

--
-- Table structure for table `seats`
--

CREATE TABLE `seats` (
  `id` int(11) NOT NULL COMMENT 'معرف أو المفتاح الرئيسي',
  `bus` int(11) NOT NULL COMMENT 'الباص',
  `seat` int(11) NOT NULL COMMENT 'رقم المقعد',
  `taken` int(1) NOT NULL COMMENT 'محجوز؟؟',
  `date` datetime NOT NULL COMMENT 'تاريخ التعديل'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `seats`
--

INSERT INTO `seats` (`id`, `bus`, `seat`, `taken`, `date`) VALUES
(1, 1, 1, 0, '2023-05-05 00:00:00'),
(2, 2, 2, 1, '2023-05-05 00:00:00'),
(3, 3, 2, 0, '2023-05-05 00:00:00'),
(4, 2, 3, 0, '2023-05-05 00:00:00'),
(5, 3, 4, 0, '2023-05-05 00:00:00'),
(6, 6, 1, 1, '0000-00-00 00:00:00'),
(7, 6, 2, 1, '0000-00-00 00:00:00'),
(8, 5, 1, 1, '0000-00-00 00:00:00'),
(9, 5, 2, 1, '0000-00-00 00:00:00');

--
-- Triggers `seats`
--
DELIMITER $$
CREATE TRIGGER `update_bus` AFTER UPDATE ON `seats` FOR EACH ROW UPDATE `bus` SET `status` = (SELECT COUNT(*) FROM `seats` WHERE bus = new.bus AND taken = 1) WHERE id = new.bus
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `trips`
--

CREATE TABLE `trips` (
  `id` int(11) NOT NULL COMMENT 'معرف أو المفتاح الرئيسي',
  `location` int(11) NOT NULL COMMENT 'موقع السفر',
  `destination` int(11) NOT NULL COMMENT 'الوجهه',
  `time` enum('''day''','''night''') NOT NULL DEFAULT '''day''' COMMENT 'نوع الرحلة, مسائية أو صباحية',
  `due` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'زمن القيام',
  `company` int(11) NOT NULL COMMENT 'مكتب الحجز'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `trips`
--

INSERT INTO `trips` (`id`, `location`, `destination`, `time`, `due`, `company`) VALUES
(1, 3, 2, '\'day\'', '2023-06-14 09:21:48', 1),
(2, 3, 3, '\'day\'', '2023-06-08 09:21:48', 1),
(6, 1, 3, '\'day\'', '2023-06-09 15:14:00', 1),
(7, 4, 5, '\'day\'', '2023-06-14 10:50:00', 1);

-- --------------------------------------------------------

--
-- Stand-in structure for view `tripsv`
-- (See below for the actual view)
--
CREATE TABLE `tripsv` (
`id` int(11)
,`location` varchar(100)
,`destination` varchar(100)
,`time` enum('''day''','''night''')
,`due` datetime
,`company` int(11)
);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL COMMENT 'معرف أو المفتاح الرئيسي',
  `user` varchar(100) NOT NULL COMMENT 'اسم المستخدم',
  `name` varchar(100) NOT NULL COMMENT 'الاسم رباعي',
  `password` varchar(20) NOT NULL COMMENT 'كلمة المرور',
  `phone` varchar(100) NOT NULL COMMENT 'الهاتف',
  `address` varchar(200) NOT NULL COMMENT 'العنوان أو السكن',
  `city` int(11) NOT NULL COMMENT 'المدينة المتواجد بها',
  `role` enum('admin','client') NOT NULL DEFAULT 'client' COMMENT 'نوع الحساب - مدير نظام أو زبون',
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'تاريخ إنشاء الحساب'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user`, `name`, `password`, `phone`, `address`, `city`, `role`, `created`) VALUES
(1, 'admin', 'administrator', '222', '222', '333', 3, 'admin', '2023-04-23 21:13:04'),
(2, '', 'عوض', '999', '999', '999', 1, 'client', '2023-05-30 08:44:21'),
(3, '', 'مجاهد', '123', '444', 'الثوره', 1, 'client', '2023-05-30 13:51:43'),
(4, '', 'xxx', 'xxx', '09155166177', 'xxx', 2, 'client', '2023-05-31 10:11:09'),
(5, '', 'jhg gn gnf nc ', 'gf,,bv,.4', '247355458', 'b,,.bv,.bv,.bv,.bv,.cv,.g,g.', 1, 'client', '2023-06-06 19:44:27');

-- --------------------------------------------------------

--
-- Structure for view `tripsv`
--
DROP TABLE IF EXISTS `tripsv`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `tripsv`  AS  select `trips`.`id` AS `id`,(select `cities`.`name` from `cities` where (`cities`.`id` = `trips`.`location`)) AS `location`,(select `cities`.`name` from `cities` where (`cities`.`id` = `trips`.`destination`)) AS `destination`,`trips`.`time` AS `time`,`trips`.`due` AS `due`,`trips`.`company` AS `company` from `trips` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `location` (`location`),
  ADD KEY `user` (`user`,`trip`,`bus`),
  ADD KEY `seat` (`seat`),
  ADD KEY `trip` (`trip`),
  ADD KEY `bus` (`bus`);

--
-- Indexes for table `bus`
--
ALTER TABLE `bus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `trip` (`trip`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seats`
--
ALTER TABLE `seats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bus` (`bus`);

--
-- Indexes for table `trips`
--
ALTER TABLE `trips`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `location` (`location`,`destination`),
  ADD KEY `location_2` (`location`,`destination`),
  ADD KEY `location_3` (`location`,`destination`),
  ADD KEY `destination` (`destination`),
  ADD KEY `company` (`company`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `phone` (`phone`),
  ADD KEY `id` (`id`),
  ADD KEY `city` (`city`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'معرف أو المفتاح الرئيسي', AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `bus`
--
ALTER TABLE `bus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'معرف أو المفتاح الرئيسي', AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'معرف أو المفتاح الرئيسي', AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'معرف أو المفتاح الرئيسي', AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `seats`
--
ALTER TABLE `seats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'معرف أو المفتاح الرئيسي', AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `trips`
--
ALTER TABLE `trips`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'معرف أو المفتاح الرئيسي', AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'معرف أو المفتاح الرئيسي', AUTO_INCREMENT=6;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`location`) REFERENCES `cities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`trip`) REFERENCES `trips` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `bookings_ibfk_3` FOREIGN KEY (`bus`) REFERENCES `bus` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `bookings_ibfk_4` FOREIGN KEY (`seat`) REFERENCES `seats` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `bookings_ibfk_5` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `seats`
--
ALTER TABLE `seats`
  ADD CONSTRAINT `seats_ibfk_1` FOREIGN KEY (`bus`) REFERENCES `bus` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `trips`
--
ALTER TABLE `trips`
  ADD CONSTRAINT `trips_ibfk_1` FOREIGN KEY (`location`) REFERENCES `cities` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `trips_ibfk_2` FOREIGN KEY (`destination`) REFERENCES `cities` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `trips_ibfk_3` FOREIGN KEY (`company`) REFERENCES `company` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`city`) REFERENCES `cities` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
