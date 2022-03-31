-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 21, 2021 at 09:18 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `l574_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `brand`
--

CREATE TABLE `brand` (
  `BrandID` int(11) NOT NULL,
  `BrandName` varchar(30) NOT NULL,
  `Status` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `brand`
--

INSERT INTO `brand` (`BrandID`, `BrandName`, `Status`) VALUES
(1, 'Adidas', 'Active'),
(2, 'Giordano', 'InActive');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `CategoryID` int(11) NOT NULL,
  `CategoryName` varchar(50) DEFAULT NULL,
  `Status` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`CategoryID`, `CategoryName`, `Status`) VALUES
(1, 'Sport Wear', 'Active'),
(2, 'Casual Wear', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `CustomerID` int(11) NOT NULL,
  `CustomerName` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Password` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`CustomerID`, `CustomerName`, `Email`, `Password`) VALUES
(1, 'Alan Smith', 'alan@gmail.com', 'alan');

-- --------------------------------------------------------

--
-- Table structure for table `orderdetails`
--

CREATE TABLE `orderdetails` (
  `OrderID` varchar(15) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `Price` decimal(10,0) NOT NULL,
  `Quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orderdetails`
--

INSERT INTO `orderdetails` (`OrderID`, `ProductID`, `Price`, `Quantity`) VALUES
('ORD-000001', 1, '100', 1),
('ORD-000002', 1, '100', 1),
('ORD-000002', 2, '150', 2);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `OrderID` varchar(15) NOT NULL,
  `OrderDate` date NOT NULL,
  `CustomerID` int(11) NOT NULL,
  `DeliveryType` varchar(150) NOT NULL,
  `PaymentType` varchar(150) NOT NULL,
  `CustomerName` varchar(50) NOT NULL,
  `Phone` varchar(50) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `Direction` varchar(255) NOT NULL,
  `CardNo` varchar(50) NOT NULL,
  `TotalQuantity` int(11) NOT NULL,
  `TotalAmount` decimal(10,0) NOT NULL,
  `VAT` decimal(10,0) NOT NULL,
  `GrandTotal` decimal(10,0) NOT NULL,
  `Status` varchar(30) NOT NULL,
  `DeliveryStatus` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`OrderID`, `OrderDate`, `CustomerID`, `DeliveryType`, `PaymentType`, `CustomerName`, `Phone`, `Address`, `Direction`, `CardNo`, `TotalQuantity`, `TotalAmount`, `VAT`, `GrandTotal`, `Status`, `DeliveryStatus`) VALUES
('ORD-000001', '2021-09-15', 1, 'SameAddress', 'Card', 'Alex', '095110110', 'No 331, Pyay Road, Sanchaung Township', 'near Maharmyine', '111111111111', 1, '100', '5', '105', 'Confirmed', ''),
('ORD-000002', '2021-09-15', 1, 'OtherAddress', 'COD', 'Hla Hla', '09512115166', '55th Street,', 'Near ABC Store', '', 3, '400', '20', '420', 'Pending', '');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `ProductID` int(11) NOT NULL,
  `ProductName` varchar(50) NOT NULL,
  `ProductType` varchar(100) NOT NULL,
  `Size` varchar(50) NOT NULL,
  `Color` varchar(50) NOT NULL,
  `Price` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `BrandID` int(11) NOT NULL,
  `CategoryID` int(11) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `ProductImage1` varchar(255) NOT NULL,
  `ProductImage2` varchar(255) NOT NULL,
  `ProductImage3` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`ProductID`, `ProductName`, `ProductType`, `Size`, `Color`, `Price`, `Quantity`, `BrandID`, `CategoryID`, `Description`, `ProductImage1`, `ProductImage2`, `ProductImage3`) VALUES
(1, 'Adidas TShirt', 'Sport wear with dark blue color', 'M', 'Dark Blue', 100, 14, 1, 1, 'Made with 100% Cottton', 'ProductImage/_2_http _static.theiconic.com.au_p_adidas-originals-9684-960243-1.jpg', 'ProductImage/_3_http _static.theiconic.com.au_p_adidas-originals-9687-960243-3.jpg', 'ProductImage/_4_http _static.theiconic.com.au_p_adidas-originals-9689-960243-4.jpg'),
(2, 'NB New Balance', 'Sportware NB SHirt', 'M', 'Blue', 150, 13, 1, 1, 'Sport wear new collections', 'ProductImage/_2_http _static.theiconic.com.au_p_new-balance-1058-459663-1.jpg', 'ProductImage/_3_http _static.theiconic.com.au_p_new-balance-1063-459663-3.jpg', 'ProductImage/_4_http _static.theiconic.com.au_p_new-balance-1065-459663-4.jpg'),
(3, 'Test T Shirt', 'Test Type', 'M', 'Red', 1, 1, 1, 1, 'Test', 'ProductImage/20210809080825__4_http _static.theiconic.com.au_p_adidas-originals-9689-960243-4.jpg', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `purchaseorder`
--

CREATE TABLE `purchaseorder` (
  `PurchaseOrderID` varchar(15) NOT NULL,
  `PurchaseOrderDate` date NOT NULL,
  `TotalAmount` int(11) NOT NULL,
  `TotalQuantity` int(11) NOT NULL,
  `TaxAmount` int(11) NOT NULL,
  `GrandTotal` decimal(16,2) NOT NULL,
  `SupplierID` int(11) NOT NULL,
  `StaffID` int(11) NOT NULL,
  `Status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `purchaseorder`
--

INSERT INTO `purchaseorder` (`PurchaseOrderID`, `PurchaseOrderDate`, `TotalAmount`, `TotalQuantity`, `TaxAmount`, `GrandTotal`, `SupplierID`, `StaffID`, `Status`) VALUES
('PUR-000001', '2021-08-18', 5900, 8, 295, '6195.00', 1, 2, 'Confirmed'),
('PUR-000002', '2021-08-24', 6800, 7, 340, '7140.00', 3, 2, 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `purchaseorderdetail`
--

CREATE TABLE `purchaseorderdetail` (
  `PurchaseOrderID` varchar(30) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `PurchaseQuantity` int(11) NOT NULL,
  `PurchasePrice` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `purchaseorderdetail`
--

INSERT INTO `purchaseorderdetail` (`PurchaseOrderID`, `ProductID`, `PurchaseQuantity`, `PurchasePrice`) VALUES
('PUR-000001', 1, 5, 1000),
('PUR-000001', 2, 3, 300),
('PUR-000002', 1, 5, 1000),
('PUR-000002', 2, 2, 900);

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `StaffID` int(11) NOT NULL,
  `StaffName` varchar(50) NOT NULL,
  `Role` varchar(30) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Phone` varchar(30) NOT NULL,
  `Password` varchar(50) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `RegisterDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`StaffID`, `StaffName`, `Role`, `Email`, `Phone`, `Password`, `Address`, `RegisterDate`) VALUES
(1, 'Alex Aung', 'Admin Manager', 'alex@gmail.com', '45678900567', 'alex', 'YANGON', '2021-07-28 06:51:45'),
(2, 'Jan', 'Sales Staff', 'jan@gmail.com', '20290302930', 'jan', 'YANGON', '2021-08-02 06:23:15');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `SupplierID` int(11) NOT NULL,
  `SupplierName` varchar(100) NOT NULL,
  `RegDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `Email` varchar(100) NOT NULL,
  `Password` varchar(20) NOT NULL,
  `Role` varchar(100) NOT NULL,
  `Phone` varchar(30) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `SupplierImage` varchar(255) NOT NULL,
  `Status` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`SupplierID`, `SupplierName`, `RegDate`, `Email`, `Password`, `Role`, `Phone`, `Address`, `SupplierImage`, `Status`) VALUES
(1, 'M9 Group', '2018-11-08 07:30:31', 'alan@gmail.com', 'alan', 'Sales Manager', '656656656', 'YGN', 'SupplierImage/_spy2s.jpg', 'Active'),
(2, 'Jan Jan', '2018-11-18 07:15:28', 'jan@gmail.com', 'jan', 'Web Admin', '5695665', 'YGN', 'SupplierImage/__IT.jpg', 'Active'),
(3, 'Myint Myint', '2018-12-21 05:33:52', 'alex@gmail.com', 'alex', 'Sales Manager', '96569968', 'YGN', 'SupplierImage/_Nine Track Mine.jpg', 'Active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`BrandID`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`CategoryID`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`CustomerID`);

--
-- Indexes for table `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD PRIMARY KEY (`OrderID`,`ProductID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`OrderID`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`ProductID`);

--
-- Indexes for table `purchaseorder`
--
ALTER TABLE `purchaseorder`
  ADD PRIMARY KEY (`PurchaseOrderID`);

--
-- Indexes for table `purchaseorderdetail`
--
ALTER TABLE `purchaseorderdetail`
  ADD PRIMARY KEY (`PurchaseOrderID`,`ProductID`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`StaffID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `CustomerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `ProductID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `StaffID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
