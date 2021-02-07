-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 19, 2019 at 12:47 PM
-- Server version: 10.1.35-MariaDB
-- PHP Version: 7.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `foodcart_sell`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `id` int(11) NOT NULL,
  `sorting` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(200) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`id`, `sorting`, `username`, `password`, `email`, `image`) VALUES
(1, 0, 'admin', 'admin', '', '98724_user.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_app_home`
--

CREATE TABLE `tbl_app_home` (
  `id` int(250) NOT NULL,
  `title` varchar(10000) NOT NULL,
  `position_order` int(250) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cashback`
--

CREATE TABLE `tbl_cashback` (
  `id` int(11) NOT NULL,
  `u_id` varchar(250) NOT NULL,
  `cashback_amount` varchar(250) NOT NULL,
  `datetime` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_category_type`
--

CREATE TABLE `tbl_category_type` (
  `id` int(250) NOT NULL,
  `name` varchar(10000) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_category_type`
--

INSERT INTO `tbl_category_type` (`id`, `name`) VALUES
(1, 'instock'),
(2, 'advance');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_city`
--

CREATE TABLE `tbl_city` (
  `id` int(250) NOT NULL,
  `city_name` mediumtext NOT NULL,
  `delivery_amount` int(250) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_city`
--

INSERT INTO `tbl_city` (`id`, `city_name`, `delivery_amount`) VALUES
(1, 'Bhilad', 20),
(2, 'Sanjan', 30),
(3, 'Umbergaon', 40);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_city_list`
--

CREATE TABLE `tbl_city_list` (
  `id` int(250) NOT NULL,
  `city_id` int(250) NOT NULL,
  `sub_city` varchar(500) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_city_list`
--

INSERT INTO `tbl_city_list` (`id`, `city_id`, `sub_city`) VALUES
(8, 1, 'bhilad railway station'),
(7, 1, 'Sarigham'),
(9, 2, 'sanjan bazar rd'),
(10, 2, 'sanjan bundar'),
(11, 1, 'gulshan nagar'),
(12, 1, 'dhanoli,Zaroli'),
(13, 1, 'daheli'),
(14, 3, 'timbi'),
(15, 3, 'GIDC RD'),
(16, 3, 'Akromaruti'),
(17, 3, 'Umbergaon town'),
(18, 3, 'gandhi wadi'),
(19, 3, 'GIDC colony'),
(20, 3, 'railway station rd'),
(21, 3, 'sapnalok society rd'),
(22, 3, 'india colony'),
(23, 2, 'ghimsa kankariya'),
(24, 2, 'raiwadi'),
(25, 2, 'amgaon rd'),
(26, 2, 'umbergaon sanjan rd'),
(27, 2, 'khattalwada'),
(28, 1, 'LAXMI VIDHYA PITH'),
(29, 1, 'bhilad EAST Bazaar'),
(30, 1, 'bhilad GIDC'),
(31, 1, 'KANADU'),
(32, 1, 'BHILAD CHECK POST,TALVADA'),
(33, 1, 'ACHCHAD'),
(34, 1, 'BHILAD'),
(35, 3, 'UMBERGAON'),
(36, 2, 'SANJAN....');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_contact`
--

CREATE TABLE `tbl_contact` (
  `id` int(250) NOT NULL,
  `name` varchar(500) NOT NULL,
  `email` varchar(500) NOT NULL,
  `phone` varchar(500) NOT NULL,
  `subject` varchar(1000) NOT NULL,
  `message` mediumtext NOT NULL,
  `status` int(10) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_coupon_code`
--

CREATE TABLE `tbl_coupon_code` (
  `id` int(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `tandc` varchar(100) NOT NULL,
  `min_order` varchar(100) NOT NULL,
  `exp_date` varchar(20) NOT NULL,
  `no_uses` varchar(100) NOT NULL,
  `coupon_code` varchar(100) NOT NULL,
  `coupon_type` varchar(100) NOT NULL,
  `coupon_value` varchar(100) NOT NULL,
  `visibility` varchar(100) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_coupon_code`
--

INSERT INTO `tbl_coupon_code` (`id`, `title`, `tandc`, `min_order`, `exp_date`, `no_uses`, `coupon_code`, `coupon_type`, `coupon_value`, `visibility`) VALUES
(1, 'Get Free Delivery', 'Use Code DELFREE5 & get free delivery on order of Rs. 100 & above.', '100', '2019-08-14', '2', 'DELFREE5', 'amount', '100', '1'),
(2, 'Get 25% OFF', 'Use Code FOODCART25 & get 25% off on orders above Rs. 300.', '300', '2019-07-31', '1', 'FOODCART25', 'percentage', '25', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_coupon_type`
--

CREATE TABLE `tbl_coupon_type` (
  `id` int(100) NOT NULL,
  `type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_coupon_type`
--

INSERT INTO `tbl_coupon_type` (`id`, `type`) VALUES
(1, 'percentage'),
(2, 'amount');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_coupon_users`
--

CREATE TABLE `tbl_coupon_users` (
  `id` int(10) NOT NULL,
  `coupon_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `availability` varchar(10) NOT NULL,
  `amount` varchar(100) NOT NULL,
  `pay_amount` varchar(100) NOT NULL,
  `discount` varchar(100) NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_flavour`
--

CREATE TABLE `tbl_flavour` (
  `f_id` int(11) NOT NULL,
  `flavour_name` varchar(500) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_flavour`
--

INSERT INTO `tbl_flavour` (`f_id`, `flavour_name`) VALUES
(1, 'Black Forest'),
(2, 'Strawberry'),
(3, 'Mango'),
(4, 'Chocolate'),
(5, 'Red Velvet'),
(8, 'Pineapple '),
(7, 'Black Current'),
(9, 'Swiss Choco'),
(10, 'Zebra Torte'),
(11, 'Dutch Marble'),
(12, 'Dutch Choco'),
(13, 'Dutch Brownie'),
(14, 'Blueberry'),
(15, 'Cassata'),
(16, 'pyramid(Choco Chips)');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_home_banner`
--

CREATE TABLE `tbl_home_banner` (
  `id` int(11) NOT NULL,
  `hotelid` int(11) NOT NULL,
  `banner_name` varchar(255) NOT NULL,
  `banner_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_home_banner`
--

INSERT INTO `tbl_home_banner` (`id`, `hotelid`, `banner_name`, `banner_image`) VALUES
(8, 1, '1', '13330_banner.jpeg'),
(9, 1, '2', '38628_banner2.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_menucategory`
--

CREATE TABLE `tbl_menucategory` (
  `cid` int(11) NOT NULL,
  `cat_type` varchar(100) NOT NULL,
  `hotelid` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `category_image` varchar(255) NOT NULL,
  `visibility` int(10) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_menucategory`
--

INSERT INTO `tbl_menucategory` (`cid`, `cat_type`, `hotelid`, `category_name`, `category_image`, `visibility`) VALUES
(1, 'instock', 1, 'Fast Food', '53424_34466_Untitled-1.png', 1),
(2, 'instock', 1, 'Cakes & Pastries', '66385_pastry..png', 1),
(3, 'instock', 1, 'One Dish Meal', '45530_meal.png', 1),
(4, 'advance', 1, 'Grocery', '66418_grocery.png', 1),
(5, 'advance', 1, 'Fruits', '81429_fruits.png', 1),
(6, 'advance', 1, 'Vegetables', '51311_vege.png', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_menuwallpaper`
--

CREATE TABLE `tbl_menuwallpaper` (
  `id` int(11) NOT NULL,
  `food_type` int(10) NOT NULL DEFAULT '1',
  `hotelid` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `f_id` varchar(100) NOT NULL,
  `cat_food_type` varchar(250) NOT NULL,
  `food_opening_time` varchar(250) NOT NULL DEFAULT '0',
  `food_closing_time` varchar(250) NOT NULL DEFAULT '0',
  `name` varchar(50) NOT NULL,
  `des` text NOT NULL,
  `image_date` date NOT NULL,
  `image` varchar(255) NOT NULL,
  `price` varchar(20) NOT NULL,
  `min_kg` varchar(250) NOT NULL,
  `max_kg` varchar(250) NOT NULL,
  `total_views` int(11) NOT NULL DEFAULT '0',
  `visibility` int(10) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_menuwallpaper`
--

INSERT INTO `tbl_menuwallpaper` (`id`, `food_type`, `hotelid`, `cat_id`, `f_id`, `cat_food_type`, `food_opening_time`, `food_closing_time`, `name`, `des`, `image_date`, `image`, `price`, `min_kg`, `max_kg`, `total_views`, `visibility`) VALUES
(1, 1, 1, 1, '', '', '', '', 'SCHEZWAN MAGGI', '<p>MAGGI WITH SCHEZWAN</p>\r\n', '2019-08-03', '29132_52756_schewan maggie.jpg', '60', '', '', 0, 1),
(2, 1, 1, 1, '', '', '', '', 'FINGER CHIPS', '<p>SALTED POTATO CHIPS</p>\r\n', '2019-08-03', '22669_35024_fingar chips.jpg', '60', '', '', 0, 1),
(3, 1, 1, 1, '', '', '', '', 'KANDA BHAJIYA', '<p>BHAJIYA OF ONION</p>\r\n', '2019-08-03', '7520_32276_kanda bhajiya.jpg', '50', '', '', 0, 1),
(4, 1, 1, 1, '', '', '', '', 'VEG BURGER', '<p>MIX VEGETABLE AND ALOO TIKKI</p>\r\n', '2019-08-03', '90558_7114_barger.jpg', '50', '', '', 0, 1),
(5, 1, 1, 1, '', '', '', '', 'CHEESE PIZZA', '<p>CHEESE AND MEDIUM SPICY SAUCES</p>\r\n', '2019-08-03', '9691_22942_cheez pizza.jpg', '100', '', '', 0, 1),
(6, 1, 1, 2, '', '', '', '', 'Lava Cake', '<p>Chocolate Hot Lava Cake</p>\r\n', '2019-08-03', '84617_lava.jpg', '80', '', '', 0, 1),
(7, 1, 1, 2, '', '', '', '', 'Strawberry Pastry', '<p>TASTE OF REAL STRAWBERRY</p>\r\n', '2019-08-03', '49511_straw.jpg', '40', '', '', 0, 1),
(8, 1, 1, 2, '', '', '', '', 'Rainbow Pastry', '<p>Different fruit taste</p>\r\n', '2019-08-03', '35958_rainbow.jpg', '70', '', '', 0, 1),
(9, 1, 1, 2, '', '', '', '', 'Pyramid Pastry', '<p>Choco Chips Pyramid</p>\r\n', '2019-08-03', '2151_pyramid.jpg', '70', '', '', 0, 1),
(10, 1, 1, 2, '', '', '', '', 'Pineapple Pastry', '<p>Taste of Pineapple</p>\r\n', '2019-08-03', '31099_pine.jpg', '50', '', '', 0, 1),
(11, 1, 1, 3, '', '', '', '', 'Pav Bhaji', '<p>Butter bhaji and pav</p>\r\n', '2019-08-03', '87966_pvbhaji.jpg', '120', '', '', 0, 1),
(12, 1, 1, 3, '', '', '12:00', '18:00', 'Dahiwali Roti', '<p>Dahiwali Roti</p>\r\n', '2019-08-03', '34266_dahiroti.jpg', '150', '', '', 0, 1),
(13, 1, 1, 4, '', '', '', '', 'Tomato Ketchup', '<p>Heinz Tomato Ketchup</p>\r\n', '2019-08-03', '74924_ketchup.jpg', '80', '', '', 0, 1),
(14, 1, 1, 4, '', '', '', '', 'Maggi', '<p>Maggi Special Masala</p>\r\n', '2019-08-03', '58532_maggi.jpg', '15', '', '', 0, 1),
(15, 1, 1, 4, '', '', '', '', 'Mccain Fries', '<p>Mccain French Fries</p>\r\n', '2019-08-03', '50589_mccain.jpg', '150', '', '', 0, 1),
(16, 1, 1, 5, '', '', '', '', 'Apple', '<p>Kashmiri Apple</p>\r\n', '2019-08-03', '45754_apple.jpg', '200', '1', '5', 0, 1),
(17, 1, 1, 5, '', '', '', '', 'Custard Apple', '<p>Sweet &amp; Tasty</p>\r\n', '2019-08-03', '99814_custard.jpg', '150', '1', '3', 0, 1),
(18, 1, 1, 5, '', '', '', '', 'Watermelon', '', '2019-08-03', '86251_watermelon.jpg', '60', '1', '10', 0, 1),
(19, 1, 1, 6, '', '', '', '', 'Brinjal', '', '2019-08-03', '46285_brinjal.jpg', '30', '1', '5', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_normal_notification`
--

CREATE TABLE `tbl_normal_notification` (
  `id` int(11) NOT NULL,
  `hotelid` int(11) NOT NULL,
  `notification_title` varchar(255) NOT NULL,
  `notification_msg` text NOT NULL,
  `notification_image` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_normal_notification`
--

INSERT INTO `tbl_normal_notification` (`id`, `hotelid`, `notification_title`, `notification_msg`, `notification_image`) VALUES
(1, 1, 'Update your app for exciting new features!', 'Download Now!', '82591_Google-Play-Store-For-PC-3.png'),
(2, 1, 'Get 20% Caskback on All Fastfoods. ', '10% Cashback on Cakes. Order Now !! ', '29575_FBPOST.png'),
(3, 1, 'Get 20% Caskback on All Fastfoods.', '10% Cashback on Cakes. Order Now !!', '74109_hb.png'),
(4, 1, '10% Cashback on Cakes. Order Now !!', 'Get 20% Caskback on All Fastfoods.', '32371_122121.png'),
(5, 1, ' Happy Monsoon ! Rains + Sunday !!!', 'Order and enjoy Food at your doorstep.', '72959_121212.png');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_reservation`
--

CREATE TABLE `tbl_reservation` (
  `ID` int(11) NOT NULL,
  `hotelid` int(11) NOT NULL,
  `user_id` int(250) NOT NULL,
  `cat_type` varchar(250) NOT NULL,
  `name` varchar(50) NOT NULL,
  `number_of_people` varchar(50) NOT NULL,
  `date_time` varchar(250) NOT NULL,
  `advance_date` varchar(250) NOT NULL,
  `advance_time` varchar(250) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `order_list` text NOT NULL,
  `json_order_list` mediumtext NOT NULL,
  `status` varchar(1) NOT NULL DEFAULT '0',
  `cancel_status` int(11) NOT NULL DEFAULT '0',
  `comment` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `order_type` varchar(20) NOT NULL,
  `address` varchar(500) NOT NULL,
  `mobileid` varchar(100) NOT NULL,
  `city_name` varchar(1000) NOT NULL,
  `sub_city_name` varchar(250) NOT NULL,
  `delivery_time` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_scratch_coupons`
--

CREATE TABLE `tbl_scratch_coupons` (
  `id` int(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `message` varchar(100) NOT NULL,
  `amount` varchar(200) NOT NULL,
  `coupon_text` varchar(1000) NOT NULL,
  `image` varchar(100) NOT NULL,
  `visibility` varchar(122) NOT NULL DEFAULT '1',
  `type` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_scratch_coupons`
--

INSERT INTO `tbl_scratch_coupons` (`id`, `title`, `message`, `amount`, `coupon_text`, `image`, `visibility`, `type`) VALUES
(1, 'Rs. 20 Scratch coupon', 'Get flat 20 wallet amount', '20', '', 'coupon-85543_wallet.png', '1', ''),
(2, 'test', 'Get flat 50 wallet amount', '0', 'Better Luck next time', '', '1', 'text'),
(3, 'test', 'Get flat 50 wallet amount', '50', '', '62560_97224_josefs-star-line-cookies-600x200.jpg', '1', 'image'),
(4, 'Better luck next time', 'Better luck next time', '0', 'Better luck next time', '', '1', 'text');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sc_users`
--

CREATE TABLE `tbl_sc_users` (
  `id` int(100) NOT NULL,
  `sc_id` varchar(100) NOT NULL,
  `user_id` varchar(100) NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` varchar(100) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_settings`
--

CREATE TABLE `tbl_settings` (
  `id` int(11) NOT NULL,
  `hotelid` int(20) NOT NULL,
  `sort` int(11) NOT NULL,
  `app_name` varchar(255) NOT NULL,
  `app_logo` varchar(255) NOT NULL,
  `app_email` varchar(255) NOT NULL,
  `app_version` varchar(255) NOT NULL,
  `app_author` varchar(255) NOT NULL,
  `app_contact` varchar(255) NOT NULL,
  `app_website` varchar(255) NOT NULL,
  `app_description` text NOT NULL,
  `app_developed_by` varchar(255) NOT NULL,
  `app_privacy_policy` text NOT NULL,
  `email_id` varchar(100) NOT NULL,
  `email_desc` mediumtext NOT NULL,
  `phone_no` varchar(100) NOT NULL,
  `message_desc` mediumtext NOT NULL,
  `complete_message_desc` mediumtext NOT NULL,
  `min_amount_rs` varchar(250) NOT NULL,
  `min_amount_msg` longtext NOT NULL,
  `fast_food_name` varchar(1000) NOT NULL,
  `sc_master_title` varchar(250) NOT NULL,
  `sc_master_image` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_settings`
--

INSERT INTO `tbl_settings` (`id`, `hotelid`, `sort`, `app_name`, `app_logo`, `app_email`, `app_version`, `app_author`, `app_contact`, `app_website`, `app_description`, `app_developed_by`, `app_privacy_policy`, `email_id`, `email_desc`, `phone_no`, `message_desc`, `complete_message_desc`, `min_amount_rs`, `min_amount_msg`, `fast_food_name`, `sc_master_title`, `sc_master_image`) VALUES
(1, 1, 1, 'Food Cart', 'ic_launcher.png', 'rndtechnosoft@gmail.com', '1.0.0', 'Food Cart', '+91-7304945823', 'https://www.rndtechnosoft.com', '', 'RnD Technosoft', '', 'rndtechnosoft@gmail.com', '<p>Thank you for order at Food Cart.</p>\r\n', '7304945823', 'Thank you for order at  Food Cart, your order is placed.', 'Thank you for order at Food Cart, your order is delivered.', '100', 'Minimum value of the order must be ₹ 100 !', '20% OFF on all Fast-Foods', 'Total Rewards', 'sc1.png');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `password` varchar(1000) NOT NULL,
  `gender` varchar(100) NOT NULL,
  `wallet` int(250) NOT NULL,
  `image` varchar(1000) NOT NULL,
  `dob` varchar(100) NOT NULL,
  `doa` varchar(100) NOT NULL,
  `latitude` varchar(50) NOT NULL,
  `longitude` varchar(50) NOT NULL,
  `address` varchar(1000) NOT NULL,
  `location` mediumtext NOT NULL,
  `zipcode` varchar(10) NOT NULL,
  `receive_order_notification` int(10) NOT NULL DEFAULT '0',
  `removeAt` int(10) NOT NULL DEFAULT '0',
  `versioncode` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`id`, `name`, `email`, `mobile`, `password`, `gender`, `wallet`, `image`, `dob`, `doa`, `latitude`, `longitude`, `address`, `location`, `zipcode`, `receive_order_notification`, `removeAt`, `versioncode`) VALUES
(1, 'Hiren', '', '9898256173', '', '', 0, '', '11/1/2000', '', '', '', '', '', '', 0, 0, ''),
(2, 'Bhavika', '', '9586084876', '', '', 0, '', '3/12/1997', '', '', '', '', '', '', 0, 0, '1.0');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_token`
--

CREATE TABLE `tbl_user_token` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `mobileno` varchar(20) NOT NULL,
  `emailid` varchar(50) NOT NULL,
  `mobileid` varchar(100) NOT NULL,
  `token` text NOT NULL,
  `receive_order_notification` int(10) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_user_token`
--

INSERT INTO `tbl_user_token` (`id`, `name`, `mobileno`, `emailid`, `mobileid`, `token`, `receive_order_notification`) VALUES
(1, 'Bhavika', '9586084876', '', 'b7ca9ff8a26dc152', 'eduLlkb_vtk:APA91bGzqbN08hoB4G_btBj9MC6PnJoNEAPeUb8mpg0v_2G7ATu-ZKlCpBPTQIRZVUv5orRQaFXAt8M0u_6B1IBNVXvyNxDHQToGorQIAux_ZCSWPIOQ7G6Q_OWySBr1MrHMBGi6uslo', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_uses_coupon`
--

CREATE TABLE `tbl_uses_coupon` (
  `id` int(100) NOT NULL,
  `no_of_uses_coupon` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_uses_coupon`
--

INSERT INTO `tbl_uses_coupon` (`id`, `no_of_uses_coupon`) VALUES
(1, '1'),
(2, '2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_app_home`
--
ALTER TABLE `tbl_app_home`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_cashback`
--
ALTER TABLE `tbl_cashback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_category_type`
--
ALTER TABLE `tbl_category_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_city`
--
ALTER TABLE `tbl_city`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_city_list`
--
ALTER TABLE `tbl_city_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_contact`
--
ALTER TABLE `tbl_contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_coupon_code`
--
ALTER TABLE `tbl_coupon_code`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_coupon_type`
--
ALTER TABLE `tbl_coupon_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_coupon_users`
--
ALTER TABLE `tbl_coupon_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_flavour`
--
ALTER TABLE `tbl_flavour`
  ADD PRIMARY KEY (`f_id`);

--
-- Indexes for table `tbl_home_banner`
--
ALTER TABLE `tbl_home_banner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_menucategory`
--
ALTER TABLE `tbl_menucategory`
  ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `tbl_menuwallpaper`
--
ALTER TABLE `tbl_menuwallpaper`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_normal_notification`
--
ALTER TABLE `tbl_normal_notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_reservation`
--
ALTER TABLE `tbl_reservation`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbl_scratch_coupons`
--
ALTER TABLE `tbl_scratch_coupons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_sc_users`
--
ALTER TABLE `tbl_sc_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_settings`
--
ALTER TABLE `tbl_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_user_token`
--
ALTER TABLE `tbl_user_token`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_uses_coupon`
--
ALTER TABLE `tbl_uses_coupon`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_app_home`
--
ALTER TABLE `tbl_app_home`
  MODIFY `id` int(250) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_cashback`
--
ALTER TABLE `tbl_cashback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_category_type`
--
ALTER TABLE `tbl_category_type`
  MODIFY `id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_city`
--
ALTER TABLE `tbl_city`
  MODIFY `id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_city_list`
--
ALTER TABLE `tbl_city_list`
  MODIFY `id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `tbl_contact`
--
ALTER TABLE `tbl_contact`
  MODIFY `id` int(250) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_coupon_code`
--
ALTER TABLE `tbl_coupon_code`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_coupon_type`
--
ALTER TABLE `tbl_coupon_type`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_coupon_users`
--
ALTER TABLE `tbl_coupon_users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_flavour`
--
ALTER TABLE `tbl_flavour`
  MODIFY `f_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tbl_home_banner`
--
ALTER TABLE `tbl_home_banner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_menucategory`
--
ALTER TABLE `tbl_menucategory`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_menuwallpaper`
--
ALTER TABLE `tbl_menuwallpaper`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tbl_normal_notification`
--
ALTER TABLE `tbl_normal_notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_reservation`
--
ALTER TABLE `tbl_reservation`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_scratch_coupons`
--
ALTER TABLE `tbl_scratch_coupons`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_sc_users`
--
ALTER TABLE `tbl_sc_users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_settings`
--
ALTER TABLE `tbl_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_user_token`
--
ALTER TABLE `tbl_user_token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_uses_coupon`
--
ALTER TABLE `tbl_uses_coupon`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
