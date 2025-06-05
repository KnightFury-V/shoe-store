-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 05, 2025 at 11:25 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ShoeShopDB`
--
CREATE DATABASE IF NOT EXISTS `ShoeShopDB` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `ShoeShopDB`;

-- --------------------------------------------------------

--
-- Table structure for table `tblAdminLogs`
--

CREATE TABLE `tblAdminLogs` (
  `LogID` int(11) NOT NULL,
  `AdminID` int(11) DEFAULT NULL,
  `Action` varchar(255) DEFAULT NULL,
  `Timestamp` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblAdminLogs`
--

INSERT INTO `tblAdminLogs` (`LogID`, `AdminID`, `Action`, `Timestamp`) VALUES
(14, 2, 'Reset password for user #7', '2025-05-10 09:32:21'),
(15, 2, 'Edited user #3 name to Bhupendra Kadayat', '2025-05-10 09:33:04'),
(16, 2, 'Updated order #8 status to Shipped', '2025-05-12 09:46:33'),
(17, 2, 'Updated order #9 status to Processing', '2025-05-28 09:05:41'),
(18, 2, 'Updated order #10 status to Cancelled', '2025-05-28 09:27:30'),
(19, 2, 'Updated order #10 status to Completed', '2025-05-28 09:27:37'),
(20, 2, 'Updated order #9 status to Shipped', '2025-05-28 09:31:13'),
(21, 2, 'Updated order #11 status to Processing', '2025-05-28 22:11:35'),
(22, 2, 'Edited user #7 name to Kabita Choudhary', '2025-05-28 22:25:28'),
(23, 2, 'Updated order #14 status to Pending', '2025-06-02 10:53:22'),
(24, 2, 'Deleted user #9', '2025-06-03 10:55:49'),
(25, 2, 'Reset password for user #3', '2025-06-03 14:26:07'),
(26, 2, 'Updated order #15 status to Processing', '2025-06-03 15:00:33'),
(27, 2, 'Updated order #15 status to Shipped', '2025-06-03 15:03:25'),
(28, 2, 'Edited user #8 name to Ritika Thapa Magar1', '2025-06-03 15:05:04'),
(29, 2, 'Edited user #8 name to Ritika Thapa Magar', '2025-06-03 15:05:10'),
(30, 2, 'Updated order #15 status to Completed', '2025-06-03 15:22:00'),
(31, 2, 'Updated order #20 status to Shipped', '2025-06-05 14:54:59'),
(32, 2, 'Edited user #8 name to John Snow', '2025-06-05 15:02:48'),
(33, 2, 'Reset password for user #8', '2025-06-05 15:05:43'),
(34, 2, 'Deleted user #8', '2025-06-05 15:07:25'),
(35, 2, 'Updated order #21 status to Shipped', '2025-06-05 22:11:30');

-- --------------------------------------------------------

--
-- Table structure for table `tblAdmins`
--

CREATE TABLE `tblAdmins` (
  `AdminID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `FullName` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblAdmins`
--

INSERT INTO `tblAdmins` (`AdminID`, `UserID`, `FullName`) VALUES
(2, 3, 'Bhupendra Kadayat Admin');

-- --------------------------------------------------------

--
-- Table structure for table `tblCategories`
--

CREATE TABLE `tblCategories` (
  `CategoryID` int(11) NOT NULL,
  `CategoryName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblCategories`
--

INSERT INTO `tblCategories` (`CategoryID`, `CategoryName`) VALUES
(1, 'Sports Shoes'),
(2, 'Boot'),
(3, 'Heels'),
(4, 'Loafer'),
(5, 'Sandal'),
(6, 'Sneakers'),
(7, 'Flip-flops');

-- --------------------------------------------------------

--
-- Table structure for table `tblOrderItems`
--

CREATE TABLE `tblOrderItems` (
  `OrderItemID` int(11) NOT NULL,
  `OrderID` int(11) DEFAULT NULL,
  `ProductID` int(11) DEFAULT NULL,
  `Quantity` int(11) DEFAULT NULL,
  `PriceAtPurchase` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblOrderItems`
--

INSERT INTO `tblOrderItems` (`OrderItemID`, `OrderID`, `ProductID`, `Quantity`, `PriceAtPurchase`) VALUES
(16, 16, 55, 1, 89.99),
(21, 21, 55, 1, 89.99),
(22, 22, 46, 1, 279.99),
(23, 22, 47, 1, 69.99),
(24, 22, 49, 1, 89.99),
(25, 22, 54, 2, 99.99);

-- --------------------------------------------------------

--
-- Table structure for table `tblOrders`
--

CREATE TABLE `tblOrders` (
  `OrderID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `TotalAmount` decimal(10,2) DEFAULT NULL,
  `OrderDate` datetime DEFAULT current_timestamp(),
  `Status` varchar(20) DEFAULT 'Pending',
  `PickupOutlet` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblOrders`
--

INSERT INTO `tblOrders` (`OrderID`, `UserID`, `TotalAmount`, `OrderDate`, `Status`, `PickupOutlet`) VALUES
(16, 7, 89.99, '2025-06-03 13:10:02', 'Pending', 'Nørreport Station, Copenhagen'),
(21, 7, 89.99, '2025-06-05 21:49:49', 'Shipped', 'Østerbro, Copenhagen'),
(22, 7, 639.95, '2025-06-05 22:14:24', 'Pending', 'Frederiksberg, Copenhagen');

-- --------------------------------------------------------

--
-- Table structure for table `tblProducts`
--

CREATE TABLE `tblProducts` (
  `ProductID` int(11) NOT NULL,
  `CategoryID` int(11) NOT NULL,
  `ProductName` varchar(255) NOT NULL,
  `Description` text DEFAULT NULL,
  `Price` decimal(10,2) NOT NULL,
  `Size` varchar(20) DEFAULT NULL,
  `ImagePath` varchar(255) DEFAULT NULL,
  `Stock` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblProducts`
--

INSERT INTO `tblProducts` (`ProductID`, `CategoryID`, `ProductName`, `Description`, `Price`, `Size`, `ImagePath`, `Stock`) VALUES
(12, 1, 'Puma Runner', 'Comfortable shoes for running and sports', 59.99, '10', 'pumarunner.png', 50),
(13, 1, 'Air Sus Runner', 'Comfortable shoes for running and sports', 69.99, '10', 'airsusrunner.png', 70),
(14, 1, 'Adidas Spike Runner', 'Comfortable shoes for running and sports', 259.99, '10', 'adidasspikerunner.png', 40),
(15, 1, 'Reebok Suspencer', 'Comfortable shoes for running and sports', 559.99, '10', 'reeboksuspencer.png', 55),
(16, 1, 'Filla White', 'Comfortable shoes for running and sports', 459.99, '10', 'fillawhite.png', 50),
(17, 1, 'Nike Air Black', 'Comfortable shoes for running and sports', 559.99, '10', 'nikeairblack.png', 62),
(18, 1, 'New Balance Pink', 'Comfortable shoes for running and sports', 359.99, '10', 'newbalancepink.jpg', 51),
(19, 1, 'Nike Runner', 'Comfortable shoes for running and sports', 659.99, '10', 'nikerunner.png', 47),
(20, 1, 'Red White Huraches', 'Comfortable shoes for running and sports', 559.99, '10', 'redwhitehuraches.png', 50),
(21, 1, 'Soloman Red Runner', 'Comfortable shoes for running and sports', 159.99, '10', 'solomanredrunner.png', 68),
(22, 2, 'Hakim Shoes', 'Trendy boots for casual wear', 379.99, '9', 'hakimshoes.jpg', 30),
(23, 2, 'Half Sleeves Boots', 'Trendy boots for casual wear', 387.99, '9', 'halfsleevesboots.png', 30),
(24, 2, 'Ugg Brown', 'Trendy boots for casual wear', 282.99, '9', 'uggbrown.png', 30),
(25, 2, 'Timberland Boots', 'Trendy boots for casual wear', 284.99, '9', 'timberlandboots.jpeg', 50),
(26, 2, 'Chelsea boot', 'Trendy boots for casual wear', 52.99, '9', 'chelseaboot.png', 58),
(27, 2, 'Women Pink Boots', 'Trendy boots for casual wear', 359.99, '9', 'womenpingboots.png', 81),
(28, 2, 'Long Women Boots', 'Trendy boots for casual wear', 257.99, '9', 'longwomenboots.png', 36),
(29, 2, 'Motorcycle Boots', 'Trendy boots for casual wear', 352.99, '9', 'motorcycleboot.png', 28),
(31, 3, 'Black Pencil Heels', 'Elegant high heels for formal occasions', 59.99, '8', 'blackpencilheels.png', 40),
(32, 3, 'High Heel Sandals', 'Elegant high heels for formal occasions', 49.99, '8', 'highheelsandals.png', 40),
(33, 3, 'Pinky Heels', 'Elegant high heels for formal occasions', 69.99, '8', 'pinkyheels.png', 40),
(34, 3, 'Red Pencil Heel', 'Elegant high heels for formal occasions', 52.99, '8', 'redpencilheel.png', 40),
(35, 3, 'Black Heels', 'Elegant high heels for formal occasions', 53.99, '8', 'blackheels.png', 40),
(36, 4, 'Ballet Flats', 'Comfortable loafers for everyday use', 99.99, '10', 'balletflats.png', 60),
(37, 4, 'Leather Loafers', 'Comfortable loafers for everyday use', 49.99, '10', 'leatherloafer.png', 60),
(38, 4, 'Black and White Loafers', 'Comfortable loafers for everyday use', 49.99, '10', 'blackandwhiteloafers.png', 30),
(39, 4, 'Flat Loafers', 'Comfortable loafers for everyday use', 49.99, '10', 'flatloafers.png', 40),
(40, 4, 'Jaipuri Flats', 'Comfortable loafers for everyday use', 149.99, '10', 'jaipuriflats.png', 50),
(41, 6, 'Airjordan Legacy', 'Comfortable and stylish sneakers for everyday use', 272.99, '10', 'airjordanlegacy.jpeg', 50),
(42, 6, 'Airjordan Dior', 'Comfortable and stylish sneakers for everyday use', 388.99, '10', 'airjordandior.png', 50),
(43, 6, 'Airjordan Red', 'Comfortable and stylish sneakers for everyday use', 286.99, '10', 'airjordanred.png', 50),
(44, 6, 'Airjordan Retro Black', 'Comfortable and stylish sneakers for everyday use', 97.99, '10', 'airjordanretroblack.png', 50),
(45, 6, 'AirForce1', 'Comfortable and stylish sneakers for everyday use', 290.99, '10', 'airforce1black.jpg', 50),
(46, 6, 'Nike AirMax Jesus', 'Comfortable and stylish sneakers for everyday use', 279.99, '10', 'nikeairmaxjesus.png', 49),
(47, 6, 'Nike Blazer White', 'Comfortable and stylish sneakers for everyday use', 69.99, '10', 'nikeblazerwhite.png', 49),
(48, 6, 'Transparent Airjordan', 'Comfortable and stylish sneakers for everyday use', 99.99, '10', 'transparentairjordan.png', 50),
(49, 6, 'Vans', 'Comfortable and stylish sneakers for everyday use', 89.99, '10', 'vans.png', 48),
(50, 7, 'Beach Black', 'Comfortable and stylish slippers for everyday use', 59.99, '10', 'beachblack.jpg', 37),
(51, 7, 'Bare Foot Slippers', 'Comfortable and stylish slippers for everyday use', 69.99, '10', 'barefootslippers.jpg', 67),
(52, 7, 'Pressure Slippers', 'Comfortable and stylish slippers for everyday use', 79.99, '10', 'pressureslippers.jpg', 72),
(53, 7, 'Summer Slippers', 'Comfortable and stylish slippers for everyday use', 109.99, '10', 'summerslipper.jpg', 48),
(54, 7, 'Summer Flip', 'Comfortable and stylish slippers for everyday use', 99.99, '10', 'summerflip.jpg', 17),
(55, 7, 'Fam Dam', 'Comfortable and stylish slippers for everyday use', 89.99, '10', 'famdam.jpg', 55),
(56, 7, 'FancyFlipFlop', 'Comfortable and stylish slippers for everyday use', 89.99, '10', 'fancyflipflops.jpg', 41);

-- --------------------------------------------------------

--
-- Table structure for table `tblReviews`
--

CREATE TABLE `tblReviews` (
  `ReviewID` int(11) NOT NULL,
  `ProductID` int(11) DEFAULT NULL,
  `UserID` int(11) DEFAULT NULL,
  `Rating` int(11) DEFAULT NULL CHECK (`Rating` between 1 and 5),
  `ReviewText` text DEFAULT NULL,
  `CreatedAt` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblUsers`
--

CREATE TABLE `tblUsers` (
  `UserID` int(11) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `PasswordHash` varchar(255) NOT NULL,
  `FullName` varchar(100) DEFAULT NULL,
  `CreatedAt` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblUsers`
--

INSERT INTO `tblUsers` (`UserID`, `Email`, `PasswordHash`, `FullName`, `CreatedAt`) VALUES
(3, 'bhupendra@gmail.com', '$2y$10$E3iGQesKoO7Bps9o7orb3elQEb6MVnLK5JZwArem2DNTuEeoBxxXy', 'Bhupendra Kadayat', '2025-05-05 20:13:46'),
(7, 'kab@gmail.com', '$2y$10$Nj/mtCkAib/hMFDX8gC7/OwbxcotpxbvfW6hGTiLN5qfSNWenFw7m', 'Kabita Choudhary', '2025-05-09 10:52:40');

-- --------------------------------------------------------

--
-- Table structure for table `tblWishlist`
--

CREATE TABLE `tblWishlist` (
  `WishlistID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `ProductID` int(11) DEFAULT NULL,
  `CreatedAt` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblWishlist`
--

INSERT INTO `tblWishlist` (`WishlistID`, `UserID`, `ProductID`, `CreatedAt`) VALUES
(10, NULL, 53, '2025-05-16 09:56:09'),
(11, NULL, 53, '2025-05-16 09:56:24'),
(19, NULL, 51, '2025-06-05 22:19:49'),
(20, NULL, 55, '2025-06-05 22:21:47'),
(21, NULL, 55, '2025-06-05 22:21:53');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblAdminLogs`
--
ALTER TABLE `tblAdminLogs`
  ADD PRIMARY KEY (`LogID`),
  ADD KEY `AdminID` (`AdminID`);

--
-- Indexes for table `tblAdmins`
--
ALTER TABLE `tblAdmins`
  ADD PRIMARY KEY (`AdminID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `tblCategories`
--
ALTER TABLE `tblCategories`
  ADD PRIMARY KEY (`CategoryID`);

--
-- Indexes for table `tblOrderItems`
--
ALTER TABLE `tblOrderItems`
  ADD PRIMARY KEY (`OrderItemID`),
  ADD KEY `ProductID` (`ProductID`),
  ADD KEY `tblorderitems_ibfk_1` (`OrderID`);

--
-- Indexes for table `tblOrders`
--
ALTER TABLE `tblOrders`
  ADD PRIMARY KEY (`OrderID`),
  ADD KEY `tblorders_ibfk_1` (`UserID`);

--
-- Indexes for table `tblProducts`
--
ALTER TABLE `tblProducts`
  ADD PRIMARY KEY (`ProductID`),
  ADD KEY `CategoryID` (`CategoryID`);

--
-- Indexes for table `tblReviews`
--
ALTER TABLE `tblReviews`
  ADD PRIMARY KEY (`ReviewID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `tblreviews_ibfk_1` (`ProductID`);

--
-- Indexes for table `tblUsers`
--
ALTER TABLE `tblUsers`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `tblWishlist`
--
ALTER TABLE `tblWishlist`
  ADD PRIMARY KEY (`WishlistID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `ProductID` (`ProductID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblAdminLogs`
--
ALTER TABLE `tblAdminLogs`
  MODIFY `LogID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `tblAdmins`
--
ALTER TABLE `tblAdmins`
  MODIFY `AdminID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tblCategories`
--
ALTER TABLE `tblCategories`
  MODIFY `CategoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `tblOrderItems`
--
ALTER TABLE `tblOrderItems`
  MODIFY `OrderItemID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `tblOrders`
--
ALTER TABLE `tblOrders`
  MODIFY `OrderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `tblProducts`
--
ALTER TABLE `tblProducts`
  MODIFY `ProductID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `tblReviews`
--
ALTER TABLE `tblReviews`
  MODIFY `ReviewID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tblUsers`
--
ALTER TABLE `tblUsers`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tblWishlist`
--
ALTER TABLE `tblWishlist`
  MODIFY `WishlistID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tblAdminLogs`
--
ALTER TABLE `tblAdminLogs`
  ADD CONSTRAINT `tbladminlogs_ibfk_1` FOREIGN KEY (`AdminID`) REFERENCES `tblAdmins` (`AdminID`);

--
-- Constraints for table `tblAdmins`
--
ALTER TABLE `tblAdmins`
  ADD CONSTRAINT `tbladmins_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `tblUsers` (`UserID`);

--
-- Constraints for table `tblOrderItems`
--
ALTER TABLE `tblOrderItems`
  ADD CONSTRAINT `tblorderitems_ibfk_1` FOREIGN KEY (`OrderID`) REFERENCES `tblOrders` (`OrderID`) ON DELETE CASCADE,
  ADD CONSTRAINT `tblorderitems_ibfk_2` FOREIGN KEY (`ProductID`) REFERENCES `tblProducts` (`ProductID`);

--
-- Constraints for table `tblOrders`
--
ALTER TABLE `tblOrders`
  ADD CONSTRAINT `tblorders_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `tblUsers` (`UserID`) ON DELETE CASCADE;

--
-- Constraints for table `tblProducts`
--
ALTER TABLE `tblProducts`
  ADD CONSTRAINT `tblproducts_ibfk_1` FOREIGN KEY (`CategoryID`) REFERENCES `tblCategories` (`CategoryID`);

--
-- Constraints for table `tblReviews`
--
ALTER TABLE `tblReviews`
  ADD CONSTRAINT `tblreviews_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `tblUsers` (`UserID`);

--
-- Constraints for table `tblWishlist`
--
ALTER TABLE `tblWishlist`
  ADD CONSTRAINT `tblwishlist_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `tblUsers` (`UserID`),
  ADD CONSTRAINT `tblwishlist_ibfk_2` FOREIGN KEY (`ProductID`) REFERENCES `tblProducts` (`ProductID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
