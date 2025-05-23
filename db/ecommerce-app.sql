-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 23, 2025 at 02:45 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecommerce-app`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `guest_name` varchar(255) DEFAULT NULL,
  `guest_phone` varchar(20) DEFAULT NULL,
  `guest_address` varchar(255) DEFAULT NULL,
  `total` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `guest_name`, `guest_phone`, `guest_address`, `total`, `created_at`, `updated_at`) VALUES
(8, 6, NULL, NULL, NULL, 69542.00, '2025-05-23 11:30:42', '2025-05-23 11:30:42'),
(9, NULL, 'Christian Yongzon', '09280056394', 'Lowe Calajo-an', 69542.00, '2025-05-23 11:55:57', '2025-05-23 11:55:57'),
(10, NULL, 'Christian Yongzon', '09280056394', 'Lowe Calajo-an', 69542.00, '2025-05-23 11:56:25', '2025-05-23 11:56:25'),
(11, 6, NULL, NULL, NULL, 63742.00, '2025-05-23 12:28:34', '2025-05-23 12:28:34'),
(12, 6, NULL, NULL, NULL, 26042.00, '2025-05-23 12:28:58', '2025-05-23 12:28:58'),
(13, NULL, 'Christian Yongzon', '09236589125', 'Lowe Calajo-an', 69542.00, '2025-05-23 12:35:13', '2025-05-23 12:35:13');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`id`, `order_id`, `product_id`, `quantity`, `price`, `subtotal`) VALUES
(14, 8, 8, 1, 69542.00, 69542.00),
(15, 9, 8, 1, 69542.00, 69542.00),
(16, 10, 8, 1, 69542.00, 69542.00),
(17, 11, 9, 1, 63742.00, 63742.00),
(18, 12, 10, 1, 26042.00, 26042.00),
(19, 13, 8, 1, 69542.00, 69542.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `price`, `slug`, `image_path`, `created_at`, `updated_at`) VALUES
(8, 1, 'Samsung Galaxy S23 Ultra', 'A premium flagship smartphone featuring a 200MP camera, 6.8\" AMOLED display, Snapdragon 8 Gen 2 processor, and S Pen support for productivity and creativity.', 69542.00, 'samsung-galaxy-s23-ultra', 'uploads/s-l1200.jpg', '2025-05-23 10:10:46', '2025-05-23 04:10:46'),
(9, 1, 'Apple MacBook Air M2 (13-inch)', 'Ultra-thin and powerful, the MacBook Air M2 offers lightning-fast performance, all-day battery life, and a Liquid Retina display, ideal for both work and entertainment.', 63742.00, 'apple-macbook-air-m2-(13-inch)', 'uploads/M2-macbook-air-lineup.jpg', '2025-05-23 10:11:24', '2025-05-23 04:11:24'),
(10, 1, ' Apple iPad 10th Gen (Wi-Fi, 64GB)', 'A sleek, versatile tablet with a 10.9-inch Liquid Retina display, A14 Bionic chip, and Apple Pencil support, perfect for reading, drawing, or multitasking.', 26042.00, '-apple-ipad-10th-gen-(wi-fi,-64gb)', 'uploads/111840_sp884-ipad-10gen-960.png', '2025-05-23 10:11:51', '2025-05-23 04:11:51'),
(11, 1, 'Fitbit Versa 4 Smartwatch', 'Fitness-focused smartwatch with built-in GPS, heart rate monitoring, sleep tracking, and compatibility with both iOS and Android devices.', 11597.00, 'fitbit-versa-4-smartwatch', 'uploads/FitbitVersa4Feature-750x420.jpg', '2025-05-23 10:12:28', '2025-05-23 04:12:28'),
(13, 1, 'LG 55” 4K UHD Smart TV (WebOS)', 'A stunning 55-inch Smart TV with 4K resolution, HDR support, voice control, and access to popular streaming apps like Netflix, YouTube, and Disney+.', 27839.00, 'lg-55”-4k-uhd-smart-tv-(webos)', 'uploads/3322480_1719300556_LG_Electronics-123067560-md08002175-DZ-01-jpg.jfif', '2025-05-23 10:14:39', '2025-05-23 04:14:39'),
(14, 1, 'Canon EOS R10 Mirrorless Camera', 'A compact mirrorless camera with a 24.2MP sensor, fast autofocus, and 4K video recording, ideal for beginner and intermediate photographers.', 56782.00, 'canon-eos-r10-mirrorless-camera', 'uploads/0826497581.jpg', '2025-05-23 10:18:20', '2025-05-23 04:18:20'),
(16, 4, 'CeraVe Hydrating Facial Cleanser (16 oz)', 'A gentle, non-foaming cleanser designed for normal to dry skin that removes dirt, oil, and makeup while helping to maintain the skin’s natural barrier.', 1218.00, 'cerave-hydrating-facial-cleanser-(16-oz)', 'uploads/71KyxG-GuLL._SL1500_.jpg', '2025-05-23 10:31:57', '2025-05-23 04:31:57'),
(17, 4, 'Neutrogena Hydro Boost Water Gel', 'Lightweight, oil-free moisturizer with hyaluronic acid that instantly quenches dry skin and keeps it hydrated for 48 hours.', 1276.00, 'neutrogena-hydro-boost-water-gel', 'uploads/neutrogena_hydroboostgelde_guanovo.jpg', '2025-05-23 10:34:11', '2025-05-23 04:34:11'),
(18, 4, 'The Ordinary Niacinamide 10% + Zinc 1% (30ml)', 'A bestselling serum that reduces the appearance of blemishes, congestion, and balances visible sebum activity.', 580.00, 'the-ordinary-niacinamide-10%-+-zinc-1%-(30ml)', 'uploads/b52bc638709bbe093eee77864e49db3b.jpg', '2025-05-23 10:36:26', '2025-05-23 04:36:26'),
(19, 4, 'Cetaphil Gentle Skin Cleanser (20 oz)', 'A mild, non-irritating formula that soothes skin as it cleans, ideal for daily use on all skin types, including sensitive skin.', 1508.00, 'cetaphil-gentle-skin-cleanser-(20-oz)', 'uploads/ph-11134207-7quky-lkaf7il0vumk77.jfif', '2025-05-23 10:39:29', '2025-05-23 04:39:29'),
(20, 4, 'Olay Regenerist Micro-Sculpting Cream', 'Anti-aging moisturizer with hyaluronic acid and niacinamide that hydrates, firms, and plumps skin to reduce the look of fine lines.', 2088.00, 'olay-regenerist-micro-sculpting-cream', 'uploads/s-l1200 (1).jpg', '2025-05-23 10:41:16', '2025-05-23 04:41:16'),
(21, 4, 'Maybelline Fit Me Matte + Poreless Foundation (30ml)', 'A lightweight, mattifying foundation that refines pores for a natural, seamless finish, ideal for normal to oily skin.', 464.00, 'maybelline-fit-me-matte-+-poreless-foundation-(30ml)', 'uploads/$_57.jfif', '2025-05-23 10:42:22', '2025-05-23 04:42:22'),
(22, 2, 'Uniqlo Men’s Ultra Light Down Jacket', 'A compact and lightweight down jacket that provides warmth without the bulk, ideal for layering in cold weather.', 3480.00, 'uniqlo-men’s-ultra-light-down-jacket', 'uploads/s-l1200.png', '2025-05-23 10:49:16', '2025-05-23 04:49:16'),
(23, 2, 'Levi’s 511 Slim Fit Men’s Jeans', 'A modern slim fit with room to move, these jeans are versatile for both casual and semi-formal wear.', 3480.00, 'levi’s-511-slim-fit-men’s-jeans', 'uploads/levis-mens-511-slim-jeans-045115849_25_LE_A1_3558X2000.progressive.jpg', '2025-05-23 10:54:52', '2025-05-23 04:54:52'),
(25, 2, ' Mango Quilted Crossbody Bag', 'Trendy and compact crossbody bag with quilted design, chain strap, and magnetic closure – perfect for day-to-night styling.', 2320.00, '-mango-quilted-crossbody-bag', 'uploads/ph-11134207-7r98t-lrb2mgk9e344fd.jfif', '2025-05-23 11:00:20', '2025-05-23 05:00:20'),
(26, 2, 'Zara Men’s Slim Fit Blazer', 'Tailored slim-fit blazer ideal for formal occasions or smart-casual looks, with sharp cuts and modern styling.', 5800.00, 'zara-men’s-slim-fit-blazer', 'uploads/04336231500-000-e1.jpg', '2025-05-23 11:03:16', '2025-05-23 05:03:16'),
(27, 2, 'Ray-Ban Round Metal Sunglasses', 'Timeless round metal frames with UV protection lenses, blending vintage aesthetics with modern flair.', 8700.00, 'ray-ban-round-metal-sunglasses', 'uploads/51meZwVY73L.jpg', '2025-05-23 11:06:31', '2025-05-23 05:06:31'),
(28, 2, 'Herschel Little America Backpack (25L)', 'Stylish and durable backpack with padded laptop sleeve, magnetic straps, and classic mountaineering style.', 4060.00, 'herschel-little-america-backpack-(25l)', 'uploads/df321b30-herschel-supply-co-little-america-backpack-fit-notes.jpg', '2025-05-23 11:07:33', '2025-05-23 05:07:33'),
(31, 5, 'Dyson V8 Cordless Vacuum Cleaner', 'A powerful and lightweight cordless vacuum ideal for cleaning carpets, floors, and hard-to-reach areas with up to 40 minutes of run time.', 23200.00, 'dyson-v8-cordless-vacuum-cleaner', 'uploads/N285K_V8Slim_PPP_gallery01.jpg', '2025-05-23 11:10:59', '2025-05-23 05:10:59'),
(32, 5, ' Instant Pot Duo 7-in-1 Electric Pressure Cooker (6 Qt)', 'Multi-use cooker that functions as a pressure cooker, slow cooker, rice cooker, steamer, sauté pan, yogurt maker, and warmer.', 5800.00, '-instant-pot-duo-7-in-1-electric-pressure-cooker-(6-qt)', 'uploads/1SP4067671-4-5038daee1aa549279186fe591f38ae77.jpg', '2025-05-23 11:12:01', '2025-05-23 05:12:01'),
(33, 5, 'Philips Wake-Up Light Alarm Clock', 'Simulates sunrise to help you wake up naturally and includes nature sounds and FM radio for a more relaxing start to your day.', 4640.00, 'philips-wake-up-light-alarm-clock', 'uploads/71iYjlMI6rL._AC_SL1500_.jpg', '2025-05-23 11:13:01', '2025-05-23 05:13:01'),
(34, 5, 'Brita Ultra Max Water Dispenser with Filter', 'Large-capacity water dispenser that reduces chlorine taste and odor with included long-lasting Brita filters.', 2320.00, 'brita-ultra-max-water-dispenser-with-filter', 'uploads/71ACPnCK0OL.jpg', '2025-05-23 11:15:07', '2025-05-23 05:15:07'),
(35, 5, 'Bedsure Queen Comforter Set (7 Pieces)', 'Complete bed set including comforter, sheets, and pillowcases made from soft microfiber for warmth and comfort.', 3480.00, 'bedsure-queen-comforter-set-(7-pieces)', 'uploads/51dGzqLtCmL._AC_US750_.jpg', '2025-05-23 11:16:03', '2025-05-23 05:16:03'),
(36, 5, 'iRobot Roomba 692 Robot Vacuum', 'Smart robot vacuum with Wi-Fi connectivity, automatic dirt detection, and voice control compatibility with Alexa and Google Assistant.', 14500.00, 'irobot-roomba-692-robot-vacuum', 'uploads/images.jfif', '2025-05-23 11:16:52', '2025-05-23 05:16:52');

-- --------------------------------------------------------

--
-- Table structure for table `product_categories`
--

CREATE TABLE `product_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_categories`
--

INSERT INTO `product_categories` (`id`, `name`, `description`, `slug`, `created_at`, `updated_at`) VALUES
(1, ' Electronics', 'Includes devices and gadgets such as smartphones, laptops, cameras, headphones, and smart home accessories. This category focuses on technology-driven products for personal and professional use.', 'electronics', '2025-05-22 04:14:42', '2025-05-22 04:14:42'),
(2, 'Fashion', 'Covers clothing, accessories, and apparel for men, women, and children. This category includes casual wear, formal outfits, and seasonal fashion trends.', 'fashion', '2025-05-22 04:14:42', '2025-05-22 04:14:42'),
(4, 'Beauty', 'Offers skincare, haircare, cosmetics, grooming tools, and wellness products aimed at enhancing personal appearance and hygiene.', 'beauty-personal-care', '2025-05-22 04:15:34', '2025-05-23 10:30:42'),
(5, 'Home', 'Includes appliances, cookware, utensils, furniture, and decor for home improvement, organization, and kitchen use.', 'home-kitchen', '2025-05-22 04:16:28', '2025-05-23 10:31:03');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `address`, `phone`, `birthdate`, `created_at`, `updated_at`) VALUES
(6, 'Christian Yongzon', 'christianyongzon143@gmail.com', '$2y$10$uN38c1f1q/M/f2XC30jBau.VipA0F7D8SlQL.SDspmiuNl4mY7UXC', 'Lowe Calajo-an', '09280056394', '2004-05-28', '2025-05-23 10:44:27', '2025-05-23 10:45:41');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_order_customer` (`customer_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_order_detail_order` (`order_id`),
  ADD KEY `fk_order_detail_product` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `fk_product_category` (`category_id`);

--
-- Indexes for table `product_categories`
--
ALTER TABLE `product_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `product_categories`
--
ALTER TABLE `product_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_order_customer` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `fk_order_detail_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_order_detail_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_product_category` FOREIGN KEY (`category_id`) REFERENCES `product_categories` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
