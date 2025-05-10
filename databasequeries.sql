-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 10, 2025 at 10:14 AM
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
(15, 2, 'Edited user #3 name to Bhupendra Kadayat', '2025-05-10 09:33:04');

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
(3, 5, 4, 1, 49.99);

-- --------------------------------------------------------

--
-- Table structure for table `tblOrders`
--

CREATE TABLE `tblOrders` (
  `OrderID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `TotalAmount` decimal(10,2) DEFAULT NULL,
  `OrderDate` datetime DEFAULT current_timestamp(),
  `Status` varchar(20) DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblOrders`
--

INSERT INTO `tblOrders` (`OrderID`, `UserID`, `TotalAmount`, `OrderDate`, `Status`) VALUES
(5, 7, 49.99, '2025-05-10 10:01:53', 'Pending');

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
(1, 1, 'Running Shoes', 'Comfortable shoes for running and sports', 59.99, '10', 'product1.jpg', 50),
(2, 2, 'Stylish Boots', 'Trendy boots for casual wear', 89.99, '9', 'product2.jpg', 30),
(3, 3, 'High Heels', 'Elegant high heels for formal occasions', 79.99, '8', 'product3.jpg', 40),
(4, 4, 'Loafers', 'Comfortable loafers for everyday use', 49.99, '10', 'product4.jpg', 60),
(11, 2, 'Chelsea Boots', 'New Fashionable Boots and comfortable to wear', 90.00, '8', 'Screenshot 2025-03-02 at 19.35.08.png', 3);

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
(3, 'bhupendra@gmail.com', '$2y$10$91MaFHtaaG/lsIied7UMFugWN5jpsJLcvBTI6p7R.z9ywC2sRw2sq', 'Bhupendra Kadayat', '2025-05-05 20:13:46'),
(7, 'kab@gmail.com', '$2y$10$y6sFRKYramHQGpf079N9XOwsCShfmLya1Mk8Y9GrgC94/s0qsCx/q', 'Kabita Chy', '2025-05-09 10:52:40');

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
  MODIFY `LogID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tblAdmins`
--
ALTER TABLE `tblAdmins`
  MODIFY `AdminID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tblCategories`
--
ALTER TABLE `tblCategories`
  MODIFY `CategoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tblOrderItems`
--
ALTER TABLE `tblOrderItems`
  MODIFY `OrderItemID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tblOrders`
--
ALTER TABLE `tblOrders`
  MODIFY `OrderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tblProducts`
--
ALTER TABLE `tblProducts`
  MODIFY `ProductID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tblReviews`
--
ALTER TABLE `tblReviews`
  MODIFY `ReviewID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tblUsers`
--
ALTER TABLE `tblUsers`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tblWishlist`
--
ALTER TABLE `tblWishlist`
  MODIFY `WishlistID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
