-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 11, 2018 at 02:09 AM
-- Server version: 10.1.25-MariaDB
-- PHP Version: 7.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `yourqs`
--

-- --------------------------------------------------------

--
-- Table structure for table `allowances_and_insurance`
--

CREATE TABLE `allowances_and_insurance` (
  `project_id` int(5) NOT NULL,
  `estimated_project_duration` int(100) NOT NULL,
  `all_risk_insurance` varchar(100) NOT NULL,
  `building_guarantee` varchar(100) NOT NULL,
  `approx_project_value` int(100) NOT NULL,
  `administration_costs` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `allowances_and_insurance`
--

INSERT INTO `allowances_and_insurance` (`project_id`, `estimated_project_duration`, `all_risk_insurance`, `building_guarantee`, `approx_project_value`, `administration_costs`) VALUES
(1, 0, 'Yes', 'None', 0, 0),
(2, 1234, 'Yes', 'Basic', 12345, 120),
(3, 10, 'Yes', 'Basic', 1500, 500),
(4, 11, 'No', 'Basic', 3500, 1500),
(5, 11, 'No', 'Basic', 3500, 130),
(6, 14, 'Yes', 'Standard', 5600, 150),
(8, 4, 'Yes', 'Basic', 5600, 560),
(9, 3, 'Yes', 'Standard', 340, 456),
(10, 324, 'Yes', 'Basic', 4324, 34),
(11, 0, 'No', 'None', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `allowance_quality_specification`
--

CREATE TABLE `allowance_quality_specification` (
  `project_id` int(5) NOT NULL,
  `plumbing` text NOT NULL,
  `electrical` text NOT NULL,
  `painting_interior` text NOT NULL,
  `interior_doors` text NOT NULL,
  `door_h/w` text NOT NULL,
  `painting_exterior` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `allowance_quality_specification`
--

INSERT INTO `allowance_quality_specification` (`project_id`, `plumbing`, `electrical`, `painting_interior`, `interior_doors`, `door_h/w`, `painting_exterior`) VALUES
(1, 'Basic', 'Existing', 'Owner', 'Basic', 'Standard', 'In house'),
(2, 'Owner', 'Owner', 'Owner', 'Owner', 'Owner', 'Owner'),
(3, 'Owner', 'Owner', 'Owner', 'Owner', 'Owner', 'Owner'),
(4, 'Standard', 'New', 'Subcontract', 'Basic', 'Standard', 'In house'),
(5, 'Basic', 'Existing', 'In house', 'Basic', 'Premium', 'Subcontract'),
(6, 'Basic', 'New', 'Subcontract', 'Basic', 'Standard', 'In house'),
(8, 'Premium', 'New', 'In house', 'Standard', 'Basic', 'In house'),
(9, 'Premium', 'New', 'Subcontract', 'Standard', 'Standard', 'In house'),
(10, 'Basic', 'Existing', 'Owner', 'Standard', 'Owner', 'In house'),
(11, 'Owner', 'New', 'Owner', 'Owner', 'Owner', 'Owner');

-- --------------------------------------------------------

--
-- Table structure for table `deck`
--

CREATE TABLE `deck` (
  `project_id` int(5) NOT NULL,
  `exterior_id` int(5) NOT NULL,
  `deck_demolation` varchar(20) NOT NULL,
  `deck_renovation` varchar(20) NOT NULL,
  `decking_material` varchar(20) NOT NULL,
  `decking_size` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `deck`
--

INSERT INTO `deck` (`project_id`, `exterior_id`, `deck_demolation`, `deck_renovation`, `decking_material`, `decking_size`) VALUES
(1, 1, 'dwqd', 'wdqwd', 'Pine 150x25', '100x40'),
(4, 2, 'test', 'test', 'Pine 150x25', '100x40'),
(6, 3, 'test', 'test', 'Pine 150x25', '100x40'),
(8, 4, 'test', 'test', 'Pine 200x25', '560'),
(10, 5, 'dewde', 'wdwedwed', 'Pine 150x25', '100x40');

-- --------------------------------------------------------

--
-- Table structure for table `description`
--

CREATE TABLE `description` (
  `project_id` int(100) NOT NULL,
  `room_id` int(100) NOT NULL,
  `walls_demolition` text NOT NULL,
  `walls_renovation` text NOT NULL,
  `ceiliing_demolition` text NOT NULL,
  `ceiling_renovation` text NOT NULL,
  `floor_demolition` text NOT NULL,
  `floor_renovation` text NOT NULL,
  `floor_covering` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `description`
--

INSERT INTO `description` (`project_id`, `room_id`, `walls_demolition`, `walls_renovation`, `ceiliing_demolition`, `ceiling_renovation`, `floor_demolition`, `floor_renovation`, `floor_covering`) VALUES
(1, 1, 'dsad', 'dsa', 'dsa', 'dasd', 'dsa', 'dasd', 'None or Existing'),
(1, 2, 'dwq', 'ddwq', 'dwq', 'ddwqd', 'dwq', 'dwqd', 'Vinyl'),
(4, 3, 'test', 'test', 'test', 'test', 'test', 'test', 'Carpet'),
(4, 4, 'test', 'test', 'test', 'test', 'test', 'test', 'Carpet'),
(6, 5, 'test', 'test', 'test', 'test', 'test', 'test', 'Vinyl'),
(8, 6, 'test', 'test', 'test', 'test', 'test', 'test', 'Tiles'),
(10, 7, 'dwq', 'dwqd', 'dwq', 'dwqd', 'dwqd', 'wdq', 'None or Existing');

-- --------------------------------------------------------

--
-- Table structure for table `downpile`
--

CREATE TABLE `downpile` (
  `project_id` int(5) NOT NULL,
  `exterior_id` int(5) NOT NULL,
  `material` varchar(20) NOT NULL,
  `profile` varchar(20) NOT NULL,
  `work_required` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `downpile`
--

INSERT INTO `downpile` (`project_id`, `exterior_id`, `material`, `profile`, `work_required`) VALUES
(1, 1, 'Plastic', 'Round 80', 'dwqdqd'),
(4, 2, 'Plastic', 'Round 80', 'test'),
(6, 3, 'Steel', 'Round 60', 'test'),
(8, 4, 'Coper', 'Rectangle', 'test'),
(10, 5, 'Plastic', 'Round 80', 'dwedew');

-- --------------------------------------------------------

--
-- Table structure for table `driveway`
--

CREATE TABLE `driveway` (
  `project_id` int(5) NOT NULL,
  `exterior_id` int(5) NOT NULL,
  `type` text NOT NULL,
  `driveway_demolation` varchar(20) NOT NULL,
  `driveway_renovation` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `driveway`
--

INSERT INTO `driveway` (`project_id`, `exterior_id`, `type`, `driveway_demolation`, `driveway_renovation`) VALUES
(1, 1, 'Concrete', 'dqwd', 'wqdqwd'),
(4, 2, 'Concrete', 'test', 'test'),
(6, 3, 'Concrete', 'test', 'test'),
(8, 4, 'Concrete', 'test', 'test'),
(10, 5, 'Concrete', 'dewdew', 'dwedwe');

-- --------------------------------------------------------

--
-- Table structure for table `exterior_scope`
--

CREATE TABLE `exterior_scope` (
  `project_id` int(5) NOT NULL,
  `exterior_id` int(5) NOT NULL,
  `name` text NOT NULL,
  `cladding_type` text NOT NULL,
  `cladding_details` text NOT NULL,
  `work_required` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `exterior_scope`
--

INSERT INTO `exterior_scope` (`project_id`, `exterior_id`, `name`, `cladding_type`, `cladding_details`, `work_required`) VALUES
(1, 1, 'ex2', 'Monolithic', 'dwd', 'wqdwqd'),
(4, 2, 'ex2', 'Weatherboard', 'test', 'test'),
(6, 3, 'new exterior 1', 'Monolithic', 'test', 'test'),
(8, 4, 'ex sample 1', 'Monolithic', 'test', 'test'),
(10, 5, 'ex2', 'Weatherboard', 'dewd', 'wed');

-- --------------------------------------------------------

--
-- Table structure for table `ext_other`
--

CREATE TABLE `ext_other` (
  `project_id` int(5) NOT NULL,
  `exterior_id` int(5) NOT NULL,
  `demolation` varchar(20) NOT NULL,
  `renovation` varchar(20) NOT NULL,
  `comment` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ext_other`
--

INSERT INTO `ext_other` (`project_id`, `exterior_id`, `demolation`, `renovation`, `comment`) VALUES
(1, 1, 'dwqd', 'dwqd', 'wqd'),
(4, 2, 'test', 'test', 'test'),
(6, 3, 'test', 'test', 'test'),
(8, 4, 'test', 'test', 'test'),
(10, 5, 'dwed', 'wedwed', 'ewddew');

-- --------------------------------------------------------

--
-- Table structure for table `fascia`
--

CREATE TABLE `fascia` (
  `project_id` int(5) NOT NULL,
  `exterior_id` int(5) NOT NULL,
  `fascia_type` varchar(20) NOT NULL,
  `work_required` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fascia`
--

INSERT INTO `fascia` (`project_id`, `exterior_id`, `fascia_type`, `work_required`) VALUES
(1, 1, 'Pine 150x25', 'dwqdwqd'),
(4, 2, 'Pine 150x25', 'test'),
(6, 3, 'Pine 150x25', 'test'),
(8, 4, 'Pine 200x25', 'test'),
(10, 5, 'Pine 150x25', 'dewdew');

-- --------------------------------------------------------

--
-- Table structure for table `fencing`
--

CREATE TABLE `fencing` (
  `project_id` int(5) NOT NULL,
  `exterior_id` int(5) NOT NULL,
  `fencing_type` varchar(20) NOT NULL,
  `demolation` varchar(20) NOT NULL,
  `renovation` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fencing`
--

INSERT INTO `fencing` (`project_id`, `exterior_id`, `fencing_type`, `demolation`, `renovation`) VALUES
(1, 1, 'Timber Pailing', 'dwqd', 'wqdqw'),
(4, 2, 'Timber Pailing', 'test', 'test'),
(6, 3, 'Timber Pailing', 'test', 'test'),
(8, 4, 'Timber Pailing', 'test', 'test'),
(10, 5, 'Timber Pailing', 'dwed', 'wedwed');

-- --------------------------------------------------------

--
-- Table structure for table `gutter`
--

CREATE TABLE `gutter` (
  `project_id` int(5) NOT NULL,
  `exterior_id` int(5) NOT NULL,
  `gutter_material` varchar(20) NOT NULL,
  `profile` varchar(20) NOT NULL,
  `comment` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gutter`
--

INSERT INTO `gutter` (`project_id`, `exterior_id`, `gutter_material`, `profile`, `comment`) VALUES
(1, 1, 'Plastic', 'Classic', 'dwqdwqd'),
(4, 2, 'Plastic', 'Classic', 'test'),
(6, 3, 'Coper', 'Quad', 'test'),
(8, 4, 'Coper', 'Box', 'test'),
(10, 5, 'Plastic', 'Classic', 'dewdwe');

-- --------------------------------------------------------

--
-- Table structure for table `handrail`
--

CREATE TABLE `handrail` (
  `project_id` int(5) NOT NULL,
  `exterior_id` int(5) NOT NULL,
  `type` varchar(20) NOT NULL,
  `handrail_demolation` varchar(20) NOT NULL,
  `handrail_renovation` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `handrail`
--

INSERT INTO `handrail` (`project_id`, `exterior_id`, `type`, `handrail_demolation`, `handrail_renovation`) VALUES
(1, 1, 'Timber', 'dwqd', 'dqwdqw'),
(4, 2, 'Timber', 'test', 'test'),
(6, 3, 'Timber', 'test', 'test'),
(8, 4, 'Other', 'test', 'test'),
(10, 5, 'Timber', 'dewd', 'ewdwed');

-- --------------------------------------------------------

--
-- Table structure for table `joinery`
--

CREATE TABLE `joinery` (
  `project_id` int(100) NOT NULL,
  `room_id` int(100) NOT NULL,
  `joinery_demolition` text NOT NULL,
  `joinery_renovation` text NOT NULL,
  `new_type` varchar(500) NOT NULL,
  `allowance` int(100) NOT NULL,
  `comments` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `joinery`
--

INSERT INTO `joinery` (`project_id`, `room_id`, `joinery_demolition`, `joinery_renovation`, `new_type`, `allowance`, `comments`) VALUES
(1, 1, 'dsa', 'dasdasd', 'Laundry', 0, 'dsada'),
(1, 2, 'dwq', 'dqwd', 'Kitchen', 0, 'dwqd'),
(4, 3, 'test', 'test', 'Laundry', 23, 'test1'),
(4, 4, 'test', 'test', 'Laundry', 23, 'test'),
(6, 5, 'test', 'test', 'Wardrobe', 120, 'test'),
(8, 6, 'test', 'test', 'Wardrobe', 445, 'test'),
(10, 7, 'dwq', 'dqwd', 'Kitchen', 12312, 'wqdqwd');

-- --------------------------------------------------------

--
-- Table structure for table `mark-ups`
--

CREATE TABLE `mark-ups` (
  `project_id` int(5) NOT NULL,
  `labour` double NOT NULL,
  `materials` double NOT NULL,
  `subcontractors` double NOT NULL,
  `comment` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mark-ups`
--

INSERT INTO `mark-ups` (`project_id`, `labour`, `materials`, `subcontractors`, `comment`) VALUES
(3, 5, 6, 7, 'test'),
(4, 8, 9, 3, 'test'),
(5, 4, 5, 6, 'test'),
(6, 18, 20, 22, 'test'),
(8, 6, 8, 10, 'test'),
(9, 4, 5, 6, '7'),
(10, 3, 434, 43, 'reger'),
(11, 0, 0, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `other`
--

CREATE TABLE `other` (
  `project_id` int(100) NOT NULL,
  `room_id` int(100) NOT NULL,
  `other_demolition` text NOT NULL,
  `other_renovation` text NOT NULL,
  `allowance` int(100) NOT NULL,
  `comments` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `other`
--

INSERT INTO `other` (`project_id`, `room_id`, `other_demolition`, `other_renovation`, `allowance`, `comments`) VALUES
(1, 1, 'dsa', 'dasdasd', 0, 'ddffffffff'),
(1, 2, 'dwq', 'dqwd', 0, 'dwqd'),
(4, 3, 'test', 'test', 23, 'test'),
(4, 4, 'test', 'test', 23, 'test'),
(6, 5, 'test', 'test', 0, 'test'),
(8, 6, 'test', 'test', 0, 'test'),
(10, 7, 'dwq', 'dqwd', 0, 'dwqd');

-- --------------------------------------------------------

--
-- Table structure for table `paving`
--

CREATE TABLE `paving` (
  `project_id` int(5) NOT NULL,
  `exterior_id` int(5) NOT NULL,
  `paving_type` varchar(20) NOT NULL,
  `paving_demolation` varchar(20) NOT NULL,
  `paving_renovation` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `paving`
--

INSERT INTO `paving` (`project_id`, `exterior_id`, `paving_type`, `paving_demolation`, `paving_renovation`) VALUES
(1, 1, 'Concrete', 'wqd', 'wqdwqd'),
(4, 2, 'Concrete', 'test', 'test'),
(6, 3, 'Concrete', 'test', 'test'),
(8, 4, 'Cobbles', 'test', 'test'),
(10, 5, 'Concrete', 'dew', 'dedwed');

-- --------------------------------------------------------

--
-- Table structure for table `people_and_pricing`
--

CREATE TABLE `people_and_pricing` (
  `project_id` int(5) NOT NULL,
  `no_builders` int(100) NOT NULL,
  `builder_hourly_rate` int(100) NOT NULL,
  `supervision` int(100) NOT NULL,
  `supervision_hourly_rate` int(100) NOT NULL,
  `adminisration` int(100) NOT NULL,
  `administration_hourly_rate` int(100) NOT NULL,
  `travel_distance` varchar(100) NOT NULL,
  `travel_km_rate` int(100) NOT NULL,
  `portable_toilet_hire` varchar(20) NOT NULL,
  `plant_maint_recovery` varchar(100) NOT NULL,
  `meetings` int(100) NOT NULL,
  `no_vehicles` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `people_and_pricing`
--

INSERT INTO `people_and_pricing` (`project_id`, `no_builders`, `builder_hourly_rate`, `supervision`, `supervision_hourly_rate`, `adminisration`, `administration_hourly_rate`, `travel_distance`, `travel_km_rate`, `portable_toilet_hire`, `plant_maint_recovery`, `meetings`, `no_vehicles`) VALUES
(1, 1, 2, 3, 4, 5, 6, '7', 8, 'Yes', '3', 4, 4),
(2, 12, 3, 5, 66, 55, 44, '23', 12, 'Yes', '1345', 0, 0),
(3, 4, 15, 10, 25, 5, 21, '10', 5, 'Yes', '250', 0, 0),
(4, 10, 16, 20, 22, 10, 12, '5', 7, 'Yes', '250', 0, 0),
(5, 0, 14, 15, 16, 17, 18, '19', 20, 'Yes', '250', 0, 0),
(6, 10, 18, 20, 22, 8, 10, '12', 8, 'Yes', '1500', 0, 0),
(8, 10, 12, 30, 12, 15, 10, '23', 10, 'Yes', '5600', 0, 0),
(9, 12, 12, 123, 12, 12, 15, '12', 12, 'Yes', '450', 0, 0),
(10, 2, 43, 45, 45, 23, 43, '23', 4, 'Yes', '23', 0, 0),
(11, 0, 0, 0, 0, 0, 0, '', 0, 'No', '', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `professional_service_allowances`
--

CREATE TABLE `professional_service_allowances` (
  `project_id` int(5) NOT NULL,
  `plans` text NOT NULL,
  `engineer` text NOT NULL,
  `estimating` text NOT NULL,
  `geotechnical` text NOT NULL,
  `surveyor` text NOT NULL,
  `council_fees` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `professional_service_allowances`
--

INSERT INTO `professional_service_allowances` (`project_id`, `plans`, `engineer`, `estimating`, `geotechnical`, `surveyor`, `council_fees`) VALUES
(1, '10', '10', '10', 'test', '10', '10'),
(3, 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes'),
(4, 'Yes', 'No', 'No', 'No', 'Yes', 'No'),
(5, 'Yes', 'No', 'No', 'Yes', 'Yes', 'No'),
(6, 'Yes', 'No', 'Yes', 'Yes', 'Yes', 'No'),
(8, 'Yes', 'Yes', 'Yes', 'No', 'No', 'No'),
(9, 'Yes', 'Yes', 'No', 'Yes', 'No', 'Yes'),
(10, 'Yes', 'Yes', 'Yes', 'No', 'No', 'No'),
(11, 'No', 'No', 'No', 'No', 'No', 'No');

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `project_id` int(5) NOT NULL,
  `project_name` text NOT NULL,
  `user_id` int(5) NOT NULL,
  `date` date NOT NULL,
  `status` varchar(15) NOT NULL,
  `last_updated` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`project_id`, `project_name`, `user_id`, `date`, `status`, `last_updated`) VALUES
(1, 'sample1', 3, '2018-09-17', 'submitted', '2018-09-17'),
(2, 'dwqdwqd', 3, '2018-09-17', 'submitted', '2018-09-27'),
(3, 'Another Project', 3, '2018-09-27', 'pending', '2018-09-27'),
(4, 'Project Sample 2', 3, '2018-09-27', 'submitted', '2018-09-27'),
(5, 'Project Sample 3', 3, '2018-09-27', 'submitted', '2018-09-27'),
(6, 'new project 3', 3, '2018-09-27', 'submitted', '2018-09-27'),
(8, 'Project Sample 5', 3, '2018-09-27', 'submitted', '2018-09-27'),
(9, 'Project Sample 6', 3, '2018-09-27', 'submitted', '2018-09-27'),
(10, 'dsadsad', 3, '2018-10-04', 'submitted', '2018-10-04'),
(11, 'Another Project', 3, '2018-10-10', 'pending', '2018-10-10');

-- --------------------------------------------------------

--
-- Table structure for table `project_address`
--

CREATE TABLE `project_address` (
  `project_id` int(5) NOT NULL,
  `city` varchar(20) NOT NULL,
  `street` varchar(20) NOT NULL,
  `suburb` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `project_address`
--

INSERT INTO `project_address` (`project_id`, `city`, `street`, `suburb`) VALUES
(1, 'Auckland', 'Grand Central Apartm', 'Auckland'),
(2, 'Auckland', 'Grand Central Apartm', 'Auckland'),
(3, 'Auckland', 'beach road', 'Auckland central'),
(4, 'Auckland', 'hobson street', 'Auckland central'),
(5, 'Auckland', 'afsa', 'Auckland central'),
(6, 'Auckland', 'beach road', 'Auckland central'),
(8, 'auckland', 'hobson street', 'auckland central'),
(9, 'test', 'test', 'test'),
(10, 'dewd', 'ded', 'dewd'),
(11, 'Auckland', 'Grand Central Apartm', '10 B');

-- --------------------------------------------------------

--
-- Table structure for table `roof`
--

CREATE TABLE `roof` (
  `project_id` int(5) NOT NULL,
  `exterior_id` int(5) NOT NULL,
  `pitch` varchar(20) NOT NULL,
  `cladding_type` varchar(20) NOT NULL,
  `work_required` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roof`
--

INSERT INTO `roof` (`project_id`, `exterior_id`, `pitch`, `cladding_type`, `work_required`) VALUES
(1, 1, 'dwqd', 'Longrun', 'dwqdwqd'),
(4, 2, 'test', 'Longrun', 'test'),
(6, 3, 'test', 'Masonry Tile', 'test'),
(8, 4, 'test', 'Masonry Tile', 'test'),
(10, 5, 'dewd', 'Longrun', 'wed');

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `project_id` int(100) NOT NULL,
  `room_id` int(100) NOT NULL,
  `room_name` varchar(100) NOT NULL,
  `carpet_protection` varchar(100) NOT NULL,
  `scotia_type` varchar(100) NOT NULL,
  `window_architrave` varchar(100) NOT NULL,
  `skirting_type` varchar(100) NOT NULL,
  `door_architrave` varchar(100) NOT NULL,
  `allow_extra_hours` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`project_id`, `room_id`, `room_name`, `carpet_protection`, `scotia_type`, `window_architrave`, `skirting_type`, `door_architrave`, `allow_extra_hours`) VALUES
(1, 1, 'room1', 'Yes', 'Square Stop', 'dasd', 'dsadasd', 'dsad', '123'),
(1, 2, 'room2', 'No', 'dwqdqwd', 'dwqdqwd', 'None', 'None', '12'),
(4, 3, 'room sample 1', 'Yes', 'None', 'None', 'None', 'None', '10'),
(4, 4, 'room sample 2', 'No', 'None', 'None', 'None', 'None', '12'),
(6, 5, 'new room1', 'No', 'None', 'None', 'None', 'None', '10'),
(8, 6, 'room1', 'Yes', 'Square Stop', 'test', 'test', 'test', '50'),
(10, 7, 'room2', 'Yes', 'None', 'None', 'None', 'None', 'dwqd');

-- --------------------------------------------------------

--
-- Table structure for table `safety_requirements`
--

CREATE TABLE `safety_requirements` (
  `project_id` int(5) NOT NULL,
  `site_sign` varchar(100) NOT NULL,
  `ppe_allowance` varchar(100) NOT NULL,
  `h_&_s_system` varchar(100) NOT NULL,
  `first_aid_kit` varchar(100) NOT NULL,
  `silt_fence` varchar(100) NOT NULL,
  `security_fencing` varchar(100) NOT NULL,
  `scaffolding` varchar(100) NOT NULL,
  `fall_in_protection` varchar(100) NOT NULL,
  `comment` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `safety_requirements`
--

INSERT INTO `safety_requirements` (`project_id`, `site_sign`, `ppe_allowance`, `h_&_s_system`, `first_aid_kit`, `silt_fence`, `security_fencing`, `scaffolding`, `fall_in_protection`, `comment`) VALUES
(1, 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'None', 'None', 'None', 'ancome'),
(2, 'Yes', 'Yes', 'No', 'Yes', 'Yes', 'None', 'None', 'None', 'sss'),
(3, 'Yes', 'Yes', 'Yes', 'Yes', 'No', 'Side 2', 'Side 1', 'Safety Nets', 'test'),
(4, 'No', 'Yes', 'Yes', 'Yes', 'No', 'Front', 'Side 1', 'Bags', 'test'),
(5, 'Yes', 'No', 'Yes', 'No', 'Yes', 'Side 1', 'Side 2', 'Bags', 'test'),
(6, 'Yes', 'Yes', 'No', 'Yes', 'Yes', 'Side 1', 'Side 2', 'Bags', 'test'),
(8, 'Yes', 'Yes', 'No', 'No', 'Yes', 'Front', 'Side 1', 'Bags', 'test'),
(9, 'Yes', 'Yes', 'Yes', 'No', 'No', 'None', 'Side 1', 'Safety Nets', 'test'),
(10, 'Yes', 'No', 'Yes', 'Yes', 'Yes', 'None', 'None', 'None', 'dewd'),
(11, 'No', 'No', 'No', 'No', 'No', 'None', 'None', 'None', '');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `project_id` int(5) NOT NULL,
  `water` text NOT NULL,
  `electrical` text NOT NULL,
  `sewerage` text NOT NULL,
  `storm_water` text NOT NULL,
  `temporary_power` text NOT NULL,
  `temporary_water` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`project_id`, `water`, `electrical`, `sewerage`, `storm_water`, `temporary_power`, `temporary_water`) VALUES
(1, 'Existing', 'Existing', 'Existing', 'Existing', 'No', 'No'),
(2, 'Existing', 'New', 'New', 'New', 'Yes', 'No'),
(3, 'Existing', 'New', 'New', 'Existing', 'No', 'Yes'),
(4, 'Existing', 'New', 'Existing', 'New', 'Yes', 'No'),
(5, 'Existing', 'Existing', 'New', 'New', 'Yes', 'No'),
(6, 'Existing', 'New', 'New', 'New', 'Yes', 'No'),
(8, 'Existing', 'New', 'Existing', 'New', 'Yes', 'No'),
(9, 'Existing', 'New', 'Existing', 'Existing', 'Yes', 'No'),
(10, 'Existing', 'Existing', 'Existing', 'New', 'No', 'No'),
(11, 'New', 'New', 'New', 'New', 'No', 'No');

-- --------------------------------------------------------

--
-- Table structure for table `site_arrangement`
--

CREATE TABLE `site_arrangement` (
  `project_id` int(5) NOT NULL,
  `site_access` varchar(100) NOT NULL,
  `space_for_material_storage` varchar(100) NOT NULL,
  `living_arragements` varchar(100) NOT NULL,
  `comment` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `site_arrangement`
--

INSERT INTO `site_arrangement` (`project_id`, `site_access`, `space_for_material_storage`, `living_arragements`, `comment`) VALUES
(1, 'Good', 'None', 'Vacated', 'dewdwd'),
(2, 'Good', 'None', 'Vacated', ''),
(3, 'Good', 'None', 'Vacated', 'test commnet'),
(4, 'Bad', 'Good', 'Nights at home', 'test'),
(5, 'Bad', 'Good', 'Nights and days at home', 'test'),
(6, 'Bad', 'Good', 'Nights at home', 'test'),
(8, 'Bad', 'Bad', 'Nights at home', 'test'),
(9, 'Good', 'None', 'Vacated', 'test'),
(10, 'Good', 'None', 'Vacated', 'dewdwed'),
(11, 'Good', 'None', 'Vacated', '');

-- --------------------------------------------------------

--
-- Table structure for table `subtrades`
--

CREATE TABLE `subtrades` (
  `project_id` int(100) NOT NULL,
  `room_id` int(100) NOT NULL,
  `lights` text NOT NULL,
  `electrical` text NOT NULL,
  `plumbing` varchar(500) NOT NULL,
  `painting` varchar(500) NOT NULL,
  `paint_prep` varchar(500) NOT NULL,
  `comments` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subtrades`
--

INSERT INTO `subtrades` (`project_id`, `room_id`, `lights`, `electrical`, `plumbing`, `painting`, `paint_prep`, `comments`) VALUES
(1, 1, 'dsad', 'dsad', 'Laundry Tub', 'Windows', 'Minor', 'dsadsad'),
(1, 2, 'dwq', 'dwqd', 'Bath', 'Walls', 'Minor', 'dwqd'),
(4, 3, 'test', 'test', 'Bath', 'Walls', 'Minor', 'test'),
(4, 4, 'test', 'test', 'Bath', 'Walls', 'Minor', 'test'),
(6, 5, 'test', 'test', 'Toilet', 'Windows', 'Moderate', 'test'),
(8, 6, 'test', 'test', 'Toilet', 'Ceiling', 'Significant', 'test'),
(10, 7, 'dwq', 'dwdqd', 'Bath', 'Walls', 'Minor', 'dwqd');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(5) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `password` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `role` varchar(10) NOT NULL,
  `contact_number` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `firstname`, `lastname`, `password`, `email`, `role`, `contact_number`) VALUES
(2, 'Arosha', 'Perera', '123', 'vjarosha@gmail.com', 'admin', 778027173),
(3, 'Arosha', 'Perera', '123', 'janithriarosha@gmail.com', 'general', 778027173),
(4, 'Simon', 'Owen', '123', 'simon@gmail.com', 'general', 223944),
(5, 'jani', 'jani', 'jj', 'jj@gmail.com', 'general', 123123123),
(8, 'dwd', 'dwqd', 'dd', 'dwqdwq@dewdwe.com', 'general', 2234234),
(10, 'dwq', 'dwq', 'dqwd', 'dwqd@dede.com', 'general', 2214234),
(14, 'dwd', 'dwq', 'dew', 'dwq@ded.c', 'general', 0),
(15, 'Arosha', 'Perera', 'dfs', 'janithriaroshadsad@dw.d', 'general', 2147483647),
(16, 'Arosha', 'Perera', '123', 'test@gmail.com', 'general', 225898315),
(18, 'James', 'Jame', '123', 'jame@gmail.com', 'general', 2147483647),
(19, 'ss', 'sss', '123', 'ses@cfrf.com', 'general', 53434334),
(20, 'Arosha', 'Perera', '123', 'hella@gmail.com', 'general', 225898315);

-- --------------------------------------------------------

--
-- Table structure for table `windows_doors`
--

CREATE TABLE `windows_doors` (
  `project_id` int(100) NOT NULL,
  `room_id` int(100) NOT NULL,
  `windows_demolition` text NOT NULL,
  `windows_renovation` text NOT NULL,
  `window_type` varchar(500) NOT NULL,
  `doors_demolition` text NOT NULL,
  `doors_renovation` text NOT NULL,
  `doors_type` varchar(500) NOT NULL,
  `comments` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `windows_doors`
--

INSERT INTO `windows_doors` (`project_id`, `room_id`, `windows_demolition`, `windows_renovation`, `window_type`, `doors_demolition`, `doors_renovation`, `doors_type`, `comments`) VALUES
(1, 1, 'dsad', 'dasd', 'Timber Frame', 'dasd', 'dasdasd', 'Relocated', 'dsadasd'),
(1, 2, 'dwq', 'dwqd', 'Relocated', 'dwqd', 'dwqd', 'Relocated', 'dwqd'),
(4, 3, 'test', 'test', 'Timber Frame', 'test', 'test', 'MDF PQ', 'test'),
(4, 4, 'test', 'test', 'Timber Frame', 'test', 'test', 'MDF PQ', 'test'),
(6, 5, 'test', 'test', 'Timber Frame', 'test', 'test', 'Timber', 'test'),
(8, 6, 'test', 'test', 'Relocated', 'test', 'test', 'Timber', 'test'),
(10, 7, 'dwq', 'dqwd', 'Relocated', 'dwqd', 'dwqd', 'Relocated', 'dwqd');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `allowances_and_insurance`
--
ALTER TABLE `allowances_and_insurance`
  ADD PRIMARY KEY (`project_id`);

--
-- Indexes for table `allowance_quality_specification`
--
ALTER TABLE `allowance_quality_specification`
  ADD PRIMARY KEY (`project_id`);

--
-- Indexes for table `deck`
--
ALTER TABLE `deck`
  ADD PRIMARY KEY (`exterior_id`),
  ADD KEY `fk_dck` (`project_id`);

--
-- Indexes for table `description`
--
ALTER TABLE `description`
  ADD PRIMARY KEY (`room_id`),
  ADD KEY `fk_desc` (`project_id`);

--
-- Indexes for table `downpile`
--
ALTER TABLE `downpile`
  ADD PRIMARY KEY (`exterior_id`),
  ADD KEY `fk_downp` (`project_id`);

--
-- Indexes for table `driveway`
--
ALTER TABLE `driveway`
  ADD PRIMARY KEY (`exterior_id`),
  ADD KEY `fk_dw` (`project_id`);

--
-- Indexes for table `exterior_scope`
--
ALTER TABLE `exterior_scope`
  ADD PRIMARY KEY (`exterior_id`),
  ADD KEY `fk_ext` (`project_id`);

--
-- Indexes for table `ext_other`
--
ALTER TABLE `ext_other`
  ADD PRIMARY KEY (`exterior_id`),
  ADD KEY `fk_extother` (`project_id`);

--
-- Indexes for table `fascia`
--
ALTER TABLE `fascia`
  ADD PRIMARY KEY (`exterior_id`),
  ADD KEY `fk_fasc` (`project_id`);

--
-- Indexes for table `fencing`
--
ALTER TABLE `fencing`
  ADD PRIMARY KEY (`exterior_id`),
  ADD KEY `fk_fenc` (`project_id`);

--
-- Indexes for table `gutter`
--
ALTER TABLE `gutter`
  ADD PRIMARY KEY (`exterior_id`),
  ADD KEY `fk_gtt` (`project_id`);

--
-- Indexes for table `handrail`
--
ALTER TABLE `handrail`
  ADD PRIMARY KEY (`exterior_id`),
  ADD KEY `fk_handr` (`project_id`);

--
-- Indexes for table `joinery`
--
ALTER TABLE `joinery`
  ADD PRIMARY KEY (`room_id`),
  ADD KEY `fk_joi` (`project_id`);

--
-- Indexes for table `mark-ups`
--
ALTER TABLE `mark-ups`
  ADD PRIMARY KEY (`project_id`);

--
-- Indexes for table `other`
--
ALTER TABLE `other`
  ADD PRIMARY KEY (`room_id`),
  ADD KEY `fk_other` (`project_id`);

--
-- Indexes for table `paving`
--
ALTER TABLE `paving`
  ADD PRIMARY KEY (`exterior_id`),
  ADD KEY `fk_pav` (`project_id`);

--
-- Indexes for table `people_and_pricing`
--
ALTER TABLE `people_and_pricing`
  ADD PRIMARY KEY (`project_id`);

--
-- Indexes for table `professional_service_allowances`
--
ALTER TABLE `professional_service_allowances`
  ADD PRIMARY KEY (`project_id`);

--
-- Indexes for table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`project_id`),
  ADD KEY `fk_user` (`user_id`);

--
-- Indexes for table `project_address`
--
ALTER TABLE `project_address`
  ADD PRIMARY KEY (`project_id`);

--
-- Indexes for table `roof`
--
ALTER TABLE `roof`
  ADD PRIMARY KEY (`exterior_id`),
  ADD KEY `fk_rf` (`project_id`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`room_id`),
  ADD KEY `fk_projectid` (`project_id`);

--
-- Indexes for table `safety_requirements`
--
ALTER TABLE `safety_requirements`
  ADD PRIMARY KEY (`project_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`project_id`);

--
-- Indexes for table `site_arrangement`
--
ALTER TABLE `site_arrangement`
  ADD PRIMARY KEY (`project_id`);

--
-- Indexes for table `subtrades`
--
ALTER TABLE `subtrades`
  ADD PRIMARY KEY (`room_id`),
  ADD KEY `fk_subt` (`project_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `windows_doors`
--
ALTER TABLE `windows_doors`
  ADD PRIMARY KEY (`room_id`),
  ADD KEY `fk_wind` (`project_id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `allowances_and_insurance`
--
ALTER TABLE `allowances_and_insurance`
  ADD CONSTRAINT `fk_allowanceins` FOREIGN KEY (`project_id`) REFERENCES `project` (`project_id`) ON DELETE CASCADE;

--
-- Constraints for table `allowance_quality_specification`
--
ALTER TABLE `allowance_quality_specification`
  ADD CONSTRAINT `fk_qs` FOREIGN KEY (`project_id`) REFERENCES `project` (`project_id`) ON DELETE CASCADE;

--
-- Constraints for table `deck`
--
ALTER TABLE `deck`
  ADD CONSTRAINT `fk_dck` FOREIGN KEY (`project_id`) REFERENCES `project` (`project_id`) ON DELETE CASCADE;

--
-- Constraints for table `description`
--
ALTER TABLE `description`
  ADD CONSTRAINT `fk_desc` FOREIGN KEY (`project_id`) REFERENCES `project` (`project_id`) ON DELETE CASCADE;

--
-- Constraints for table `downpile`
--
ALTER TABLE `downpile`
  ADD CONSTRAINT `fk_downp` FOREIGN KEY (`project_id`) REFERENCES `project` (`project_id`) ON DELETE CASCADE;

--
-- Constraints for table `driveway`
--
ALTER TABLE `driveway`
  ADD CONSTRAINT `fk_dw` FOREIGN KEY (`project_id`) REFERENCES `project` (`project_id`) ON DELETE CASCADE;

--
-- Constraints for table `exterior_scope`
--
ALTER TABLE `exterior_scope`
  ADD CONSTRAINT `fk_ext` FOREIGN KEY (`project_id`) REFERENCES `project` (`project_id`) ON DELETE CASCADE;

--
-- Constraints for table `ext_other`
--
ALTER TABLE `ext_other`
  ADD CONSTRAINT `fk_extother` FOREIGN KEY (`project_id`) REFERENCES `project` (`project_id`) ON DELETE CASCADE;

--
-- Constraints for table `fascia`
--
ALTER TABLE `fascia`
  ADD CONSTRAINT `fk_fasc` FOREIGN KEY (`project_id`) REFERENCES `project` (`project_id`) ON DELETE CASCADE;

--
-- Constraints for table `fencing`
--
ALTER TABLE `fencing`
  ADD CONSTRAINT `fk_fenc` FOREIGN KEY (`project_id`) REFERENCES `project` (`project_id`) ON DELETE CASCADE;

--
-- Constraints for table `gutter`
--
ALTER TABLE `gutter`
  ADD CONSTRAINT `fk_gtt` FOREIGN KEY (`project_id`) REFERENCES `project` (`project_id`) ON DELETE CASCADE;

--
-- Constraints for table `handrail`
--
ALTER TABLE `handrail`
  ADD CONSTRAINT `fk_handr` FOREIGN KEY (`project_id`) REFERENCES `project` (`project_id`) ON DELETE CASCADE;

--
-- Constraints for table `joinery`
--
ALTER TABLE `joinery`
  ADD CONSTRAINT `fk_joi` FOREIGN KEY (`project_id`) REFERENCES `project` (`project_id`) ON DELETE CASCADE;

--
-- Constraints for table `mark-ups`
--
ALTER TABLE `mark-ups`
  ADD CONSTRAINT `fk_mk` FOREIGN KEY (`project_id`) REFERENCES `project` (`project_id`) ON DELETE CASCADE;

--
-- Constraints for table `other`
--
ALTER TABLE `other`
  ADD CONSTRAINT `fk_other` FOREIGN KEY (`project_id`) REFERENCES `project` (`project_id`) ON DELETE CASCADE;

--
-- Constraints for table `paving`
--
ALTER TABLE `paving`
  ADD CONSTRAINT `fk_pav` FOREIGN KEY (`project_id`) REFERENCES `project` (`project_id`) ON DELETE CASCADE;

--
-- Constraints for table `people_and_pricing`
--
ALTER TABLE `people_and_pricing`
  ADD CONSTRAINT `fk_pp` FOREIGN KEY (`project_id`) REFERENCES `project` (`project_id`) ON DELETE CASCADE;

--
-- Constraints for table `professional_service_allowances`
--
ALTER TABLE `professional_service_allowances`
  ADD CONSTRAINT `fk_professional` FOREIGN KEY (`project_id`) REFERENCES `project` (`project_id`) ON DELETE CASCADE;

--
-- Constraints for table `project`
--
ALTER TABLE `project`
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `project_address`
--
ALTER TABLE `project_address`
  ADD CONSTRAINT `fk_project_ad` FOREIGN KEY (`project_id`) REFERENCES `project` (`project_id`) ON DELETE CASCADE;

--
-- Constraints for table `roof`
--
ALTER TABLE `roof`
  ADD CONSTRAINT `fk_rf` FOREIGN KEY (`project_id`) REFERENCES `project` (`project_id`) ON DELETE CASCADE;

--
-- Constraints for table `room`
--
ALTER TABLE `room`
  ADD CONSTRAINT `fk_projectid` FOREIGN KEY (`project_id`) REFERENCES `project` (`project_id`) ON DELETE CASCADE;

--
-- Constraints for table `safety_requirements`
--
ALTER TABLE `safety_requirements`
  ADD CONSTRAINT `fk_safety` FOREIGN KEY (`project_id`) REFERENCES `project` (`project_id`) ON DELETE CASCADE;

--
-- Constraints for table `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `fk_serv` FOREIGN KEY (`project_id`) REFERENCES `project` (`project_id`) ON DELETE CASCADE;

--
-- Constraints for table `site_arrangement`
--
ALTER TABLE `site_arrangement`
  ADD CONSTRAINT `fk_sitear` FOREIGN KEY (`project_id`) REFERENCES `project` (`project_id`) ON DELETE CASCADE;

--
-- Constraints for table `subtrades`
--
ALTER TABLE `subtrades`
  ADD CONSTRAINT `fk_subt` FOREIGN KEY (`project_id`) REFERENCES `project` (`project_id`) ON DELETE CASCADE;

--
-- Constraints for table `windows_doors`
--
ALTER TABLE `windows_doors`
  ADD CONSTRAINT `fk_wind` FOREIGN KEY (`project_id`) REFERENCES `project` (`project_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
