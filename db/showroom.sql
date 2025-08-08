-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 08, 2025 at 08:22 AM
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
-- Database: `showroom`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `booking_type` varchar(255) NOT NULL,
  `pref_time` varchar(255) NOT NULL,
  `adv_pay` varchar(255) NOT NULL,
  `pay_mode` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`id`, `name`, `contact`, `booking_type`, `pref_time`, `adv_pay`, `pay_mode`) VALUES
(1, 'Faizan Khan', '0355-1212301', 'Car Services/Oil,Filter Change/General Tuning ', '10-AUG-2025', '10,000PKR', 'Card'),
(2, 'Asim Munir', '0333-1115500', 'Vehicle Booked', '10-SEP-2025', '35,000,000', 'Bank Pay Order'),
(3, 'Fahad Sheikh', '0312-9361022', 'Auto/Spare-Part/1:Engine,4:Suspension,2:Carbon-Fibre Side-Skirts,1:Front Body-Kit', '12-AUG-2025', '110,000', 'Cash');

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `model` varchar(50) DEFAULT NULL,
  `engine_cc` varchar(11) DEFAULT NULL,
  `price` varchar(100) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `added_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`id`, `name`, `model`, `engine_cc`, `price`, `image`, `added_on`) VALUES
(1, 'Toyota Prius', '2019', '1800', '7,700,000 PKR', 'El Toyota Prius.jpeg', '2025-08-04 10:20:20'),
(2, 'Honda Civic', '2025', '1500', '8,500,000 PKR', 'BREAKING â€“ First Unit of Honda Civic 11th Gen is in Pakistan.jpeg', '2025-08-04 10:20:20'),
(3, 'Toyota Supra', '2020', '3500', '5,500,000 PKR', 'Toyota Supra MK4 ðŸ¤Ÿ  @mochio80.jpeg', '2025-08-04 10:20:20'),
(6, 'Toyota Land Cruiser (LC-200) ', '2022', '3500', '5,00,00,000 PKR', 'Landing page for Toyota Land Cruiser 200 - Ksenia Anso.jpeg', '2025-08-06 10:58:07'),
(7, 'Honda Civic (Rebirth)', '2016', '1800', '36,00,000 PKR', 'download.jpeg', '2025-08-06 11:04:24'),
(8, 'Toyota Crown Rs-Advance', '2019', '3500', '2,00,00,000 PKR', 'download (1).jpeg', '2025-08-06 11:11:18'),
(9, 'BMW-M5(CS)Limited', '2024', '4.4L V8 Twi', '7,00,00,000 PKR', 'Bmw M5 CS.jpeg', '2025-08-07 06:30:12');

-- --------------------------------------------------------

--
-- Table structure for table `cars_inventory`
--

CREATE TABLE `cars_inventory` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `engine_size` varchar(50) DEFAULT NULL,
  `brand` varchar(100) DEFAULT NULL,
  `model_year` int(11) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `cars_inventory`
--

INSERT INTO `cars_inventory` (`id`, `name`, `engine_size`, `brand`, `model_year`, `price`, `quantity`) VALUES
(1, ' Civic/2021', '2000cc', 'Honda', 2021, 6300000, 5),
(2, 'Corolla/2022', '1500cc', 'Toyota', 2022, 6100000, 2),
(3, 'Land Cruiser/2017', '3500cc', 'Toyota', 2017, 17500000, 4),
(4, 'Honda City', '1300cc', 'Honda', 2021, 4500000, 12);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `name`, `email`, `contact`, `address`) VALUES
(1, 'Sami', 'samikhan24@gmail.com', '0312-4351711', 'Wapda Town Phase1 Multan Pakistan'),
(2, 'Babar Azam', 'booby56@gmail.com', '03213422011', 'Gulberg-Lahore/Pakistan'),
(3, 'Zain Sheikh', 'zain_shk98@gmail.com', '111-10101010', 'DHA Multan'),
(4, 'Muhammad Javed', 'M.Jayyd@gmail.com', '0306-4600289', 'Buch-Villas Multan/Pakistan'),
(5, 'M.Hamza Bhatti', 'hbhatti10@gmail.com', '0312-5342911', 'Buch-Villas Multan/Pakistan');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(100) DEFAULT NULL,
  `car_id` int(11) DEFAULT NULL,
  `order_date` date DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_name`, `car_id`, `order_date`, `status`) VALUES
(1, 'Ali Khan', 1, '2025-08-01', 'Pending'),
(2, 'Sara Ahmed', 2, '2025-08-02', 'Completed');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `date` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `types` varchar(255) NOT NULL,
  `product` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `pay_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `date`, `name`, `types`, `product`, `price`, `pay_type`) VALUES
(1, '04-SEP-2025', 'Asad Sohail', 'Car/spare part', 'Honda Civic Rare Lights', '150,000 PKR', 'Cash/Card/Online Banking '),
(2, '19-Dec-2025', 'Ahsen Khan', 'Car/spare part', 'Toyota Vitz Engine', '102,000 PKR', 'Cash/Card/Online Banking'),
(3, '28-08-2025', 'Arishma Sheikh', 'Car/spare part', 'Toyota Prius Body Kits ', '65,000 PKR', 'Card'),
(4, '10-7-2025', 'Hudair Bin Saeed', 'Car Service', 'Oil Change Filters Change General Tuning Throttle Cleaning', '26,000 PKR', 'Online Banking'),
(5, '10-09-2025', 'Ali Hassan Hiraj', 'Car Booking', 'Toyota Land Cruiser (LC-300) 2024', '6,80,00,000 PKR', 'Bank Pay Order'),
(6, '11-11-2025', 'Hamza Javed', 'Car Delivery', 'Toyota Corolla Altis Grande 1.8X (Black Interior) 2025', '7,500,000 PKR', 'Bank Money Pay Order');

-- --------------------------------------------------------

--
-- Table structure for table `spare_parts`
--

CREATE TABLE `spare_parts` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `price` varchar(11) DEFAULT NULL,
  `stock` varchar(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `spare_parts`
--

INSERT INTO `spare_parts` (`id`, `name`, `category`, `price`, `stock`, `image`) VALUES
(1, 'Transmission', 'Mechanical', '25,000 PKR', '12', 'BMW X5.jpeg'),
(2, 'Tyres', 'Exterior', '80,000 PKR', '4', 'Car Wheel Icon - Service Tires PNG Transparent With Clear Background ID 201298 _ TopPNG.jpeg'),
(4, 'Bonnet', 'Exterior', '25,000 PKR', '65', 'Seibon Carbon Fibre Bonnet - Cw Style - Fits Subaru Impreza Wrx Sti 08-14.jpeg'),
(5, 'Exhaust', 'Exterior', '57,000 PKR', '12', 'm3 exhaust.jpeg'),
(6, 'Suspension', 'Exterior', '3,00,000 PK', '33', 'Find Suspension with ABE for your Car - Ironman 4x4.jpeg'),
(7, 'Fuel Pump', 'Interior', '2000 PKR', '55', 'Electric Fuel Pump Module Assembly With Sending Unit Compatible For Infiniti.jpeg'),
(10, 'Brake Pads', 'Mechanical', '25,000 PKR', '4', 'Brake Replacement & Upgrade Options - Fix My Car (2).jpeg'),
(11, 'Brake Fluid', 'mechanical', '2000 PKR', '100', 'Penrite Dot 5_1 Brake Fluid 500ML.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `name`, `email`, `password`, `role`) VALUES
(1, 'iHamza_fn', 'Hamza Javed Bhatti', 'hbhatti4123@gmail.com', 'HAVAL205', 'CFO-Askari Petroleum Service'),
(2, 'AFK_manaan', 'Abdul Manan', 'Manaan.abd20@gmail.com', 'Evee_0101', 'CEO-Sharafat Rice Mill and Traders Multan'),
(3, 'no_scope.cod', 'Waleed Mahmood ', 'waleed29wmb@gmail.com', 'pakistan47', 'Doctor'),
(4, 'Blaze_ak', 'Ahsen Khan', 'khanahsen19@gmail.com', 'ahsenK010', 'Entrepreneur'),
(5, 'void_zaidi20', 'Atif Zaidi', 'syed_zaidi27@gmail.com', 'ATIF123', ' Advocate'),
(6, 'Bot-Usman', 'Usman Malik', 'usman33_malik@gmail.com', 'gigs_333666', 'Founder-CEO-CardiBox Logistics');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cars_inventory`
--
ALTER TABLE `cars_inventory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `spare_parts`
--
ALTER TABLE `spare_parts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `cars_inventory`
--
ALTER TABLE `cars_inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `spare_parts`
--
ALTER TABLE `spare_parts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
