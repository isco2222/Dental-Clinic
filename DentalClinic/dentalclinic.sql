-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 18, 2024 at 08:59 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dentalclinic`
--
CREATE DATABASE IF NOT EXISTS `dentalclinic` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `dentalclinic`;

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `Cancel_Appointment` (IN `appointment_id` INT)   BEGIN
    UPDATE `appointment`
    SET `AppointmentStatus` = 'Cancelled'
    WHERE `AppointmentID` = appointment_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Record_Dentist_Report` (IN `appointment_id` INT, IN `report` TEXT)   BEGIN
    UPDATE `appointment`
    SET `DentistReport` = report
    WHERE `AppointmentID` = appointment_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Record_Patient_Feedback` (IN `appointment_id` INT, IN `feedback` TEXT)   BEGIN
    UPDATE `appointment`
    SET `PatientFeedback` = feedback
    WHERE `AppointmentID` = appointment_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Record_Prescription` (IN `appointment_id` INT, IN `presc` TEXT)   BEGIN
    UPDATE `appointment`
    SET `Prescription` = presc
    WHERE `AppointmentID` = appointment_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Schedule_Appointment` (IN `dentist_id` INT, IN `patient_id` INT, IN `service_code` CHAR(3), IN `app_date` DATE, IN `app_time` TIME)   BEGIN
    INSERT INTO `appointment` (`PatientID`, `DentistID`, `ServiceCode`, `AppointmentDate`, `AppointmentTime`)
    VALUES (patient_id, dentist_id, service_code, app_date,  app_time);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Update_appointment_Status` (IN `appointment_id` INT, IN `newStatus` VARCHAR(10))   BEGIN
    DECLARE validStatus BOOLEAN;
    DECLARE appointmentExists BOOLEAN;

    -- Initialize flags
    SET validStatus = FALSE;
    SET appointmentExists = FALSE;

    -- Check if the appointment ID exists in the table
    SELECT COUNT(*) INTO appointmentExists
    FROM appointment
    WHERE AppointmentID = appointment_id;

    -- Validate the new status is a valid value
    IF newStatus IN ('Upcoming', 'Completed', 'Missed', 'Cancelled') THEN
        SET validStatus = TRUE;
    END IF;

    -- If both the appointment ID exists and the new status is valid, update the appointment
    IF appointmentExists AND validStatus THEN
        UPDATE appointment
        SET AppointmentStatus = newStatus
        WHERE AppointmentID = appointment_id;
        
        -- Provide feedback indicating the update was successful
        SELECT 'Appointment status updated successfully.' AS Message;
    ELSE
        -- Provide feedback indicating the update was not successful
        SELECT 'Failed to update appointment status. Check appointment ID or status.' AS Message;
    END IF;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `AppointmentID` int(11) NOT NULL,
  `PatientID` int(11) NOT NULL,
  `ServiceCode` char(3) NOT NULL,
  `DentistID` int(11) NOT NULL,
  `AppointmentDate` date NOT NULL,
  `AppointmentTime` time NOT NULL CHECK (`AppointmentTime` between '09:00:00' and '16:00:00'),
  `AppointmentStatus` varchar(10) DEFAULT 'Upcoming' CHECK (`AppointmentStatus` in ('Upcoming','Completed','Missed','Cancelled')),
  `DentistReport` text DEFAULT NULL,
  `Prescription` text DEFAULT NULL,
  `PatientFeedback` text DEFAULT NULL
) ;

--
-- Dumping data for table `appointment`
--

INSERT INTO `appointment` (`AppointmentID`, `PatientID`, `ServiceCode`, `DentistID`, `AppointmentDate`, `AppointmentTime`, `AppointmentStatus`, `DentistReport`, `Prescription`, `PatientFeedback`) VALUES
(1, 1, 'CON', 1, '2024-03-15', '10:00:00', 'Completed', 'Prescription for mouth wash', 'Prescription for medication X', 'Positive feedback: Great Dentist!'),
(2, 2, 'TEX', 2, '2024-03-15', '11:00:00', 'Missed', '', '', ''),
(3, 3, 'PSU', 1, '2024-03-15', '12:00:00', 'Completed', 'Preparation required', NULL, 'Positive feedback: Professional and friendly staff'),
(4, 4, 'FIL', 2, '2024-03-16', '13:00:00', 'Cancelled', NULL, NULL, NULL),
(5, 5, 'DEC', 3, '2024-03-16', '12:00:00', 'Completed', 'No issues reported', NULL, 'Negative feedback: Uncomfortable during treatment'),
(6, 6, 'CON', 1, '2024-03-17', '10:00:00', 'Completed', 'Needs rescheduling', 'Prescription for mouthwash', 'Positive feedback: Dentist was very informative'),
(7, 1, 'TEX', 5, '2024-03-17', '11:00:00', 'Cancelled', NULL, NULL, NULL),
(8, 4, 'DEC', 3, '2024-04-01', '13:00:00', 'Completed', 'Needs rescheduling', 'Prescription for oral hygiene', 'Positive feedback: Staff was helpful and courteous'),
(9, 7, 'FIL', 5, '2024-04-02', '14:00:00', 'Completed', 'No issues reported', NULL, 'Negative feedback: Facilities were not clean'),
(10, 2, 'RCT', 2, '2024-04-03', '15:00:00', 'Completed', 'Needs rescheduling', 'Prescription for dental floss', 'Positive feedback: Easy booking process'),
(11, 1, 'BRA', 4, '2024-04-04', '11:00:00', 'Completed', 'Preparation required', NULL, 'Negative feedback: Dentist seemed rushed'),
(12, 3, 'OMS', 4, '2024-04-04', '09:00:00', 'Completed', 'Preparation required', 'Prescription for pain relief', 'Positive feedback: Painless procedure'),
(13, 6, 'FIL', 2, '2024-04-20', '10:00:00', 'Upcoming', NULL, NULL, NULL),
(14, 1, 'CON', 1, '2024-04-21', '11:00:00', 'Cancelled', NULL, NULL, NULL),
(15, 7, 'IMP', 3, '2024-04-21', '12:00:00', 'Upcoming', NULL, NULL, NULL),
(16, 2, 'CON', 1, '2024-04-28', '14:00:00', 'Cancelled', NULL, NULL, NULL);

--
-- Triggers `appointment`
--
DELIMITER $$
CREATE TRIGGER `Check_Appointment_Date` BEFORE INSERT ON `appointment` FOR EACH ROW BEGIN
    IF NEW.AppointmentDate < CURDATE() THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Appointment date must be today or a future date';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Check_Dentist_Service` BEFORE INSERT ON `appointment` FOR EACH ROW BEGIN
    DECLARE serviceOffered INT;

    -- Check if the dentist offers the service specified in the appointment
    SELECT COUNT(*) INTO serviceOffered
    FROM `servicesByDentist`
    WHERE `DentistID` = NEW.DentistID
    AND `ServiceCode` = NEW.ServiceCode;

    -- If the count is zero, it means the dentist does not offer the service
    IF serviceOffered = 0 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'The dentist does not offer the specified service';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Log_Missed_And_Cancelled_Appointments` AFTER UPDATE ON `appointment` FOR EACH ROW BEGIN
    IF OLD.AppointmentStatus <> 'Cancelled' AND NEW.AppointmentStatus = 'Cancelled' THEN
        -- Log cancelled appointment
        INSERT INTO `appointmentlog` (`ID`, `Action`, `ActionDateTime`)
        VALUES (NEW.AppointmentID, 'Cancelled', NOW());
    ELSEIF OLD.AppointmentStatus <> 'Missed' AND NEW.AppointmentStatus = 'Missed' THEN
        -- Log missed appointment
        INSERT INTO `appointmentlog` (`ID`, `Action`, `ActionDateTime`)
        VALUES (NEW.AppointmentID, 'Missed', NOW());
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Prevent_dentist_overbooking` BEFORE INSERT ON `appointment` FOR EACH ROW BEGIN
    DECLARE overlap INT;
    SELECT COUNT(*) INTO overlap
    FROM `appointment`
    WHERE `DentistID` = NEW.DentistID
    AND (
        (`AppointmentTime` = NEW.AppointmentTime)
        OR (
            `AppointmentTime` BETWEEN ADDTIME(NEW.AppointmentTime, '-1:00')
            AND ADDTIME(NEW.AppointmentTime, '1:00')
        )
    )
    AND `AppointmentStatus` NOT IN ('Missed', 'Cancelled');
    
    IF overlap > 0 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Appointment overlaps with another appointment for the dentist';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Prevent_duplicate_appointment` BEFORE INSERT ON `appointment` FOR EACH ROW BEGIN
    DECLARE duplicate_found INT;
    SELECT COUNT(*) INTO duplicate_found
    FROM appointment
    WHERE PatientID = NEW.PatientID
      AND DentistID = NEW.DentistID
      AND AppointmentDate = NEW.AppointmentDate
      AND AppointmentTime = NEW.AppointmentTime
      AND ServiceCode = NEW.ServiceCode;
    IF duplicate_found > 0 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Duplicate appointment found';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `appointmentlog`
--

CREATE TABLE `appointmentlog` (
  `ID` int(11) NOT NULL,
  `Action` varchar(10) NOT NULL,
  `ActionDateTime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointmentlog`
--

INSERT INTO `appointmentlog` (`ID`, `Action`, `ActionDateTime`) VALUES
(2, 'Missed', '2024-04-15 17:00:58'),
(4, 'Cancelled', '2024-04-15 16:59:34'),
(7, 'Cancelled', '2024-04-15 17:02:24'),
(14, 'Cancelled', '2024-04-16 23:05:12'),
(16, 'Cancelled', '2024-04-18 12:12:57');

-- --------------------------------------------------------

--
-- Table structure for table `dentist`
--

CREATE TABLE `dentist` (
  `DentistID` int(11) NOT NULL,
  `FirstName` varchar(30) NOT NULL,
  `LastName` varchar(30) NOT NULL,
  `Specialty` varchar(30) NOT NULL,
  `ContactNumber` char(10) NOT NULL,
  `Email` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dentist`
--

INSERT INTO `dentist` (`DentistID`, `FirstName`, `LastName`, `Specialty`, `ContactNumber`, `Email`) VALUES
(1, 'Andre', 'Smith', 'Dentistry', '9794567890', 'asmith@dentalclinic.com'),
(2, 'Marta', 'Diaz', 'Dentistry', '9794578930', 'mdiaz@dentalclinic.com'),
(3, 'Michael', 'Hoffman', 'Orthodontology', '9794678320', 'mhoffman@dentalclinic.com'),
(4, 'Emily', 'Johnson', 'Pediatric Dentistry', '9876543210', 'ejohnson@dentalclinic.com'),
(5, 'Daniel', 'Lee', 'Orthodontics', '9876543211', 'dlee@dentalclinic.com'),
(6, 'Samantha', 'Wilson', 'Oral Surgery', '9876543212', 'swilson@dentalclinic.com'),
(7, 'Kevin', 'Garcia', 'Periodontics', '9876543213', 'kgarcia@dentalclinic.com'),
(8, 'Jessica', 'Martinez', 'Endodontics', '9876543214', 'jmartinez@dentalclinic.com'),
(9, 'Brian', 'Wong', 'Cosmetic Dentistry', '9876543215', 'bwong@dentalclinic.com');

--
-- Triggers `dentist`
--
DELIMITER $$
CREATE TRIGGER `Prevent_duplicate_dentist` BEFORE INSERT ON `dentist` FOR EACH ROW BEGIN
    DECLARE duplicate_found INT;
    SELECT COUNT(*) INTO duplicate_found
    FROM dentist
    WHERE FirstName = NEW.FirstName
      AND LastName = NEW.LastName
      AND ContactNumber = NEW.ContactNumber;
    
    IF duplicate_found > 0 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Duplicate dentist found';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE `patient` (
  `PatientID` int(11) NOT NULL,
  `FirstName` varchar(30) NOT NULL,
  `LastName` varchar(30) NOT NULL,
  `DOB` date NOT NULL,
  `Gender` varchar(6) DEFAULT NULL CHECK (`Gender` in ('male','female')),
  `Email` varchar(30) NOT NULL,
  `PhoneNumber` char(10) NOT NULL,
  `Address` varchar(50) NOT NULL,
  `City` varchar(30) NOT NULL,
  `ZipCode` char(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`PatientID`, `FirstName`, `LastName`, `DOB`, `Gender`, `Email`, `PhoneNumber`, `Address`, `City`, `ZipCode`) VALUES
(1, 'Stephen', 'Anidi', '2001-04-23', 'male', 'stephena@yahoo.com', '8324567866', '702 Santee st', 'Prairie View', '77446'),
(2, 'Mark', 'James', '1998-05-05', 'male', 'marko@yahoo.com', '8324667866', '702 Santee st', 'Prairie View', '77446'),
(3, 'Luke', 'Waters', '2001-12-18', 'male', 'lukewat@gmail.com', '8324567800', '702 Santee st', 'Prairie View', '77446'),
(4, 'Jack', 'Reese', '1981-03-18', 'male', 'jackreese@outlook.com', '2814597166', '702 Santee st', 'Prairie View', '77446'),
(5, 'Sarah', 'Truce', '1991-03-20', 'female', 'sarahtruce98@yahoo.com', '8320007113', '702 Santee st', 'Prairie View', '77446'),
(6, 'Bill', 'Kent', '1983-06-14', 'male', 'founderbill@yahoo.com', '8321567866', '702 Santee st', 'Prairie View', '77446'),
(7, 'Tracy', 'Rogers', '1999-04-18', 'female', 'trayrogers@gmail.com', '8323261966', '702 Santee st', 'Prairie View', '77446'),
(8, 'Milly', 'Rogers', '2009-06-18', 'female', 'trayrogers@gmail.com', '8323261966', '702 Santee st', 'Prairie View', '77446'),
(9, 'Ben', 'Kent', '2008-04-06', 'male', 'founderbill@yahoo.com', '8321567866', '702 Santee st', 'Prairie View', '77446');

--
-- Triggers `patient`
--
DELIMITER $$
CREATE TRIGGER `Prevent_duplicate_patient` BEFORE INSERT ON `patient` FOR EACH ROW BEGIN
    DECLARE duplicate_found INT;
    SELECT COUNT(*) INTO duplicate_found
    FROM patient
    WHERE FirstName = NEW.FirstName
      AND LastName = NEW.LastName
      AND DOB = NEW.DOB;
    
    IF duplicate_found > 0 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Duplicate patient found';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `patientageandappointmentcount`
-- (See below for the actual view)
--
CREATE TABLE `patientageandappointmentcount` (
`AgeGroup` varchar(5)
,`PatientCount` bigint(21)
,`AppointmentCount` bigint(21)
);

-- --------------------------------------------------------

--
-- Table structure for table `service`
--

CREATE TABLE `service` (
  `ServiceCode` char(3) NOT NULL,
  `ServiceName` varchar(30) NOT NULL,
  `Cost` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service`
--

INSERT INTO `service` (`ServiceCode`, `ServiceName`, `Cost`) VALUES
('BRA', 'Braces', 4000.00),
('BRI', 'Dental Bridge', 2500.00),
('CON', 'Consultation', 90.00),
('CSU', 'Cosmetic Surgery', 6000.00),
('DBG', 'Dental Bone Grafts', 1525.00),
('DEC', 'Dental Cleaning', 120.00),
('FIL', 'Dental Filling', 200.00),
('IMP', 'Dental Implant', 3000.00),
('OMS', 'Oral and Maxillofacial Surgery', 6000.00),
('PSU', 'Periodontal Surgery', 5000.00),
('RCT', 'Root Canal Treatment', 1000.00),
('TEX', 'Tooth Extraction', 150.00);

--
-- Triggers `service`
--
DELIMITER $$
CREATE TRIGGER `Prevent_duplicate_service` BEFORE INSERT ON `service` FOR EACH ROW BEGIN
    DECLARE duplicate_found INT;
    SELECT COUNT(*) INTO duplicate_found
    FROM service
    WHERE ServiceCode = NEW.ServiceCode
    OR ServiceName = NEW.ServiceName;
    
    IF duplicate_found > 0 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Duplicate service found';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `servicesbydentist`
--

CREATE TABLE `servicesbydentist` (
  `ServiceCode` char(3) NOT NULL,
  `DentistID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `servicesbydentist`
--

INSERT INTO `servicesbydentist` (`ServiceCode`, `DentistID`) VALUES
('BRA', 4),
('BRA', 7),
('BRI', 3),
('BRI', 7),
('CON', 1),
('CON', 5),
('CON', 8),
('CSU', 4),
('CSU', 7),
('DBG', 1),
('DEC', 3),
('DEC', 6),
('FIL', 2),
('FIL', 5),
('FIL', 9),
('IMP', 3),
('IMP', 6),
('OMS', 4),
('OMS', 8),
('PSU', 1),
('RCT', 2),
('TEX', 2),
('TEX', 5),
('TEX', 9);

--
-- Triggers `servicesbydentist`
--
DELIMITER $$
CREATE TRIGGER `Prevent_duplicate_servicesByDentist` BEFORE INSERT ON `servicesbydentist` FOR EACH ROW BEGIN
    DECLARE duplicate_found INT;
    SELECT COUNT(*) INTO duplicate_found
    FROM servicesByDentist
    WHERE ServiceCode = NEW.ServiceCode AND
     DentistID = NEW.DentistID;
    
    IF duplicate_found > 0 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Duplicate service by Dentist found';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure for view `patientageandappointmentcount`
--
DROP TABLE IF EXISTS `patientageandappointmentcount`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `patientageandappointmentcount`  AS SELECT CASE WHEN timestampdiff(YEAR,`p`.`DOB`,curdate()) between 0 and 20 THEN '0-20' WHEN timestampdiff(YEAR,`p`.`DOB`,curdate()) between 21 and 40 THEN '21-40' WHEN timestampdiff(YEAR,`p`.`DOB`,curdate()) between 41 and 60 THEN '41-60' ELSE '61+' END AS `AgeGroup`, count(0) AS `PatientCount`, count(`a`.`AppointmentID`) AS `AppointmentCount` FROM (`patient` `p` left join `appointment` `a` on(`p`.`PatientID` = `a`.`PatientID`)) GROUP BY CASE WHEN timestampdiff(YEAR,`p`.`DOB`,curdate()) between 0 and 20 THEN '0-20' WHEN timestampdiff(YEAR,`p`.`DOB`,curdate()) between 21 and 40 THEN '21-40' WHEN timestampdiff(YEAR,`p`.`DOB`,curdate()) between 41 and 60 THEN '41-60' ELSE '61+' END ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`AppointmentID`),
  ADD KEY `fk_PatientID` (`PatientID`),
  ADD KEY `fk_DentistID_ServiceCode` (`DentistID`,`ServiceCode`);

--
-- Indexes for table `appointmentlog`
--
ALTER TABLE `appointmentlog`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `dentist`
--
ALTER TABLE `dentist`
  ADD PRIMARY KEY (`DentistID`);

--
-- Indexes for table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`PatientID`);

--
-- Indexes for table `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`ServiceCode`);

--
-- Indexes for table `servicesbydentist`
--
ALTER TABLE `servicesbydentist`
  ADD PRIMARY KEY (`ServiceCode`,`DentistID`),
  ADD KEY `fk_dentistID` (`DentistID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `AppointmentID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dentist`
--
ALTER TABLE `dentist`
  MODIFY `DentistID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `patient`
--
ALTER TABLE `patient`
  MODIFY `PatientID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointment`
--
ALTER TABLE `appointment`
  ADD CONSTRAINT `fk_DentistID_ServiceCode` FOREIGN KEY (`DentistID`,`ServiceCode`) REFERENCES `servicesbydentist` (`DentistID`, `ServiceCode`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_PatientID` FOREIGN KEY (`PatientID`) REFERENCES `patient` (`PatientID`);

--
-- Constraints for table `appointmentlog`
--
ALTER TABLE `appointmentlog`
  ADD CONSTRAINT `fk_dentistID_appointmentLog` FOREIGN KEY (`ID`) REFERENCES `appointment` (`AppointmentID`);

--
-- Constraints for table `servicesbydentist`
--
ALTER TABLE `servicesbydentist`
  ADD CONSTRAINT `fk_dentistID` FOREIGN KEY (`DentistID`) REFERENCES `dentist` (`DentistID`),
  ADD CONSTRAINT `fk_serviceCode` FOREIGN KEY (`ServiceCode`) REFERENCES `service` (`ServiceCode`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
