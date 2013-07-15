-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 14, 2012 at 08:03 PM
-- Server version: 5.5.8
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `final_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

CREATE TABLE IF NOT EXISTS `book` (
  `id` int(2) DEFAULT NULL,
  `Book Title` varchar(45) DEFAULT NULL,
  `Book Author` varchar(19) DEFAULT NULL,
  `D` varchar(11) DEFAULT NULL,
  `Copies For Loan` varchar(15) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `book`
--

INSERT INTO `book` (`id`, `Book Title`, `Book Author`, `D`, `Copies For Loan`) VALUES
(1, 'All That I Am', 'Anna Funder', 'fiction', '2'),
(2, 'August', 'Bernard Beckett', 'fiction', '2'),
(3, 'Autumn Laing', 'Alex Miller', 'fiction', '2'),
(4, 'Before I Go to Sleep', 'S J Watson', 'fiction', '2'),
(5, 'Bereft', 'Chris Womersley', 'fiction', '2'),
(6, 'Black Jesus', 'Simone Felice', 'fiction', '2'),
(7, 'Catch - 22', 'Joseph Heller', 'fiction', '2'),
(8, 'Delirium', 'Lauren Oliver', 'fiction', '2'),
(9, 'Five Bells', 'Gail Jones', 'fiction', '2'),
(10, 'Great Expectations', 'Charles Dickens', 'fiction', '2'),
(11, 'Indelible Ink', 'Fiona McGregor', 'fiction', '2'),
(12, 'Middlesex', 'Jeffrey Eugenides', 'fiction', '2'),
(13, 'On Canaan’s Side', 'Sebastian Barry', 'fiction', '2'),
(14, 'Please Look After Mother', 'Kyung-Sook Shin', 'fiction', '2'),
(15, 'Sarah Thornhill', 'Kate Grenville', 'fiction', '2'),
(16, 'Sister', 'Rosamund Lupton', 'fiction', '2'),
(17, 'Snowdrops', 'Andrew Miller', 'fiction', '2'),
(18, 'State of Wonder', 'Ann Patchett', 'fiction', '2'),
(19, 'The Boundary', 'Nicole Watson', 'fiction', '2'),
(20, 'The Cat’s Table', 'Michael Ondaatje', 'fiction', '2'),
(21, 'The Chase', 'Christopher Kremmer', 'fiction', '2'),
(22, 'The Fix', 'Nick Earls', 'fiction', '2'),
(23, 'The Hand That First Held Mine', 'Maggie O’Farrell', 'fiction', '2'),
(24, 'The Hidden Child', 'Camilla Lackberg', 'fiction', '2'),
(25, 'The Language of Flowers', 'Vanessa Diffenbaugh', 'fiction', '2'),
(26, 'The Ottoman Motel', 'Christopher Currie', 'fiction', '2'),
(27, 'The Paris Wife', 'Paula McLain', 'fiction', '2'),
(28, 'The Pile of Stuff at the Bottom of the Stairs', 'Christina Hopkinson', 'fiction', '2'),
(29, 'The Stranger’s Child', 'Alan Hollinghurst', 'fiction', '2'),
(30, 'To Be Sung Underwater', 'Tom McNeal', 'fiction', '2'),
(31, 'Bligh : Master Mariner', 'Rob Mundle', 'non-fiction', '2'),
(32, 'Cocktail Hour Under the Tree of Forgetfulness', 'Alexandra Fuller', 'non-fiction', '2'),
(33, 'Hamlet’s Blackberry', 'William Powers', 'non-fiction', '2'),
(34, 'Her Father’s Daughter', 'Alice Pung', 'non-fiction', '2'),
(35, 'Kinglake - 350', 'Adrian Hyland', 'non-fiction', '2'),
(36, 'Life', 'Keith Richards', 'non-fiction', '2'),
(37, 'Notebooks', 'Betty Churcher', 'non-fiction', '2'),
(38, 'The Alice Behind Wonderland', 'Simon Winchester', 'non-fiction', '2'),
(39, 'The Hare with the Amber Eyes', 'Edmund de Waal', 'non-fiction', '2'),
(40, 'The Psychopath Test', 'Jon Ronson', 'non-fiction', '2');

-- --------------------------------------------------------

--
-- Table structure for table `colleges`
--

CREATE TABLE IF NOT EXISTS `colleges` (
  `collegeId` int(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  `dean` varchar(40) NOT NULL,
  PRIMARY KEY (`collegeId`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=103 ;

--
-- Dumping data for table `colleges`
--

INSERT INTO `colleges` (`collegeId`, `name`, `dean`) VALUES
(101, 'Natural and Applied Sciences (CONAS)', 'Dr, D'),
(102, 'Management and Social Sciences (COMAS)', 'Dr. Lalude');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE IF NOT EXISTS `courses` (
  `code` varchar(8) NOT NULL,
  `name` varchar(100) NOT NULL,
  `units` int(1) NOT NULL,
  `status` char(1) NOT NULL,
  `Level` int(4) NOT NULL,
  `semester` int(1) NOT NULL,
  `description` text NOT NULL,
  `lecturerId` int(4) NOT NULL,
  `programmeId` int(4) NOT NULL,
  `departmentId` int(4) DEFAULT NULL,
  `collegeId` int(4) DEFAULT NULL,
  `prerequisiteId` int(8) DEFAULT NULL,
  PRIMARY KEY (`code`,`programmeId`),
  KEY `course_lecturer` (`lecturerId`),
  KEY `course_programme` (`programmeId`),
  KEY `course_department` (`departmentId`),
  KEY `course_college` (`collegeId`),
  KEY `prerequisite` (`prerequisiteId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`code`, `name`, `units`, `status`, `Level`, `semester`, `description`, `lecturerId`, `programmeId`, `departmentId`, `collegeId`, `prerequisiteId`) VALUES
('CPS202', 'Computer programming II', 3, 'C', 200, 2, 'Programming in C', 11, 121, 113, 101, NULL),
('CPS208', 'Discrete Structures', 2, 'C', 200, 2, 'Discrete Mathematics', 11, 121, 113, 101, NULL),
('CPS301', 'Structured Programming', 2, 'C', 300, 1, 'Java', 11, 121, 113, 101, NULL),
('CPS307', 'Data Structures, Algorithms and Complexity Analysis', 2, 'C', 300, 1, 'big oh notation', 11, 121, 113, 101, NULL),
('CPS401', 'Compiler Construction', 3, 'C', 400, 1, 'Compiling...', 11, 121, 113, 101, NULL),
('CPS411', 'Artificial Intelligence', 3, 'C', 400, 1, 'Artificial..', 11, 121, 113, 101, NULL),
('CPS421', 'Software Engineering', 3, 'C', 400, 1, 'Software Engineering Practices', 11, 121, 113, 101, 1111),
('CPS433', 'Computer Graphics and Visualization', 3, 'E', 400, 1, 'ddddddddddddddddddd', 11, 121, 113, 101, 1112),
('CPS461', 'Information Technology Law', 3, 'E', 400, 1, 'dddddddffffffffffffff', 11, 121, 113, 101, NULL),
('PST101', 'Plant Diversity', 3, 'C', 100, 1, 'Plant Diversity', 11, 127, 117, 101, NULL),
('PST101', 'Plant Diversity', 3, 'C', 100, 1, 'Plant Diversity', 11, 128, 114, 101, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `coursestaken`
--

CREATE TABLE IF NOT EXISTS `coursestaken` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `studentId` int(4) NOT NULL,
  `courseCode` varchar(6) NOT NULL,
  `semester` int(4) NOT NULL,
  `session` int(5) NOT NULL,
  `CA` int(4) DEFAULT NULL,
  `exam` int(4) DEFAULT NULL,
  `finalScore` int(4) DEFAULT NULL,
  `grade` char(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `studentId` (`studentId`),
  KEY `coursecode` (`courseCode`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=107 ;

--
-- Dumping data for table `coursestaken`
--

INSERT INTO `coursestaken` (`id`, `studentId`, `courseCode`, `semester`, `session`, `CA`, `exam`, `finalScore`, `grade`) VALUES
(101, 1001, 'CPS307', 1, 2011, 10, 10, 20, 'F'),
(102, 1001, 'CPS301', 1, 2011, 10, 10, 20, 'F'),
(103, 1002, 'CPS301', 1, 2012, 10, 10, 20, 'F'),
(104, 1003, 'CPS202', 2, 2012, 0, 0, 0, 'n'),
(105, 1003, 'CPS208', 2, 2012, 0, 0, 0, 'n'),
(106, 1003, 'GNS201', 1, 2012, 0, 0, 0, 'n');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE IF NOT EXISTS `departments` (
  `deptId` int(4) NOT NULL AUTO_INCREMENT,
  `deptName` varchar(60) NOT NULL,
  `collegeId` int(4) NOT NULL,
  `HOD` varchar(40) NOT NULL,
  PRIMARY KEY (`deptId`),
  UNIQUE KEY `deptName` (`deptName`),
  KEY `collegeId` (`collegeId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=119 ;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`deptId`, `deptName`, `collegeId`, `HOD`) VALUES
(111, 'Department of Economic and Financial Studies', 102, 'Dr'),
(112, 'Department of Political Science and Public Administration', 102, 'Dr. '),
(113, 'Department of Mathematics and Computer-Sciences', 101, 'Dr. Akinola'),
(114, 'Department of Chemical Sciences', 101, 'Dr. '),
(115, 'Department of Sociology', 101, 'Dr. '),
(116, 'Department of Business Administration', 102, 'Dr. Omotayo'),
(117, 'Department of Biological Sciences', 101, 'Dr. '),
(118, 'Department of Physics and Earth Sciences', 101, 'Mr. Bolarinwa');

-- --------------------------------------------------------

--
-- Table structure for table `generalresult`
--

CREATE TABLE IF NOT EXISTS `generalresult` (
  `matricNo` varchar(13) NOT NULL,
  `resultId` int(6) NOT NULL AUTO_INCREMENT,
  `overallTCP` int(11) NOT NULL,
  `overallTNU` int(4) NOT NULL,
  `lastGPA` float NOT NULL,
  `CGPA` float NOT NULL,
  `currentSemester` int(2) NOT NULL,
  `currentSession` int(5) NOT NULL,
  PRIMARY KEY (`resultId`),
  UNIQUE KEY `matricNo` (`matricNo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `generalresult`
--


-- --------------------------------------------------------

--
-- Table structure for table `gns_courses`
--

CREATE TABLE IF NOT EXISTS `gns_courses` (
  `code` varchar(8) NOT NULL,
  `title` varchar(60) NOT NULL,
  `units` int(1) NOT NULL,
  `semester` int(1) NOT NULL,
  `level` int(4) NOT NULL,
  `lecturerId` int(4) NOT NULL,
  `status` char(1) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`code`),
  KEY `gns_lecturer` (`lecturerId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gns_courses`
--

INSERT INTO `gns_courses` (`code`, `title`, `units`, `semester`, `level`, `lecturerId`, `status`, `description`) VALUES
('GNS101', 'Use Of English', 2, 1, 100, 11, 'C', 'Basic English constucts..'),
('GNS102', 'Use of English II', 2, 2, 100, 11, 'C', 'Second English'),
('GNS103', 'Use of Library and InfoTech', 2, 1, 100, 11, 'C', 'Library and all...'),
('GNS106', 'Arabic', 2, 2, 100, 11, 'C', 'Arabic learning'),
('GNS201', 'Citizenship, Peace & Conflict Studies', 2, 1, 200, 11, 'C', 'Conflict');

-- --------------------------------------------------------

--
-- Table structure for table `lecturers`
--

CREATE TABLE IF NOT EXISTS `lecturers` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `fname` varchar(20) NOT NULL,
  `lname` varchar(20) NOT NULL,
  `onames` varchar(20) NOT NULL,
  `photograph` text NOT NULL,
  `deptId` int(4) NOT NULL,
  `collegeId` int(4) NOT NULL,
  `yearEnrolled` int(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `lecturer_department` (`deptId`),
  KEY `lecturer_college` (`collegeId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `lecturers`
--

INSERT INTO `lecturers` (`id`, `fname`, `lname`, `onames`, `photograph`, `deptId`, `collegeId`, `yearEnrolled`) VALUES
(11, 'Babatunde', 'Olorishade', 'Kazeem', 'Pictures/Allahu Akbar-2', 114, 101, 2009);

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE IF NOT EXISTS `login` (
  `loginId` int(5) NOT NULL AUTO_INCREMENT,
  `loginType` varchar(10) NOT NULL,
  `id` varchar(12) NOT NULL,
  `password` varchar(60) NOT NULL,
  PRIMARY KEY (`loginId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=104 ;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`loginId`, `loginType`, `id`, `password`) VALUES
(101, 'student', 'reich1', '6283841221888f971b274ddb6c8ee099'),
(102, 'student', 'harmedox', 'b8179081fe590f6fc3ca56d8752fc6f8'),
(103, 'student', 'ibro', '6283841221888f971b274ddb6c8ee099');

-- --------------------------------------------------------

--
-- Table structure for table `prerequisite`
--

CREATE TABLE IF NOT EXISTS `prerequisite` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `courseCode` varchar(8) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `course_pre` (`courseCode`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1113 ;

--
-- Dumping data for table `prerequisite`
--

INSERT INTO `prerequisite` (`id`, `courseCode`) VALUES
(1111, 'CPS301'),
(1112, 'CPS307');

-- --------------------------------------------------------

--
-- Table structure for table `programmes`
--

CREATE TABLE IF NOT EXISTS `programmes` (
  `programmeId` int(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  `duration` int(1) NOT NULL,
  `departmentId` int(4) NOT NULL,
  `collegeId` int(4) NOT NULL,
  `lastLevel` int(4) NOT NULL,
  PRIMARY KEY (`programmeId`),
  UNIQUE KEY `name` (`name`),
  KEY `college` (`collegeId`),
  KEY `departmentId` (`departmentId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=129 ;

--
-- Dumping data for table `programmes`
--

INSERT INTO `programmes` (`programmeId`, `name`, `duration`, `departmentId`, `collegeId`, `lastLevel`) VALUES
(121, 'Computer-Science', 4, 113, 101, 400),
(122, 'Economics', 4, 111, 102, 400),
(123, 'Accounting', 4, 111, 102, 400),
(124, 'Banking and Finance', 4, 111, 102, 400),
(126, 'Industrial Chemistry', 4, 114, 101, 400),
(127, 'Biochemistry and Nutrition', 4, 114, 101, 400),
(128, 'Microbiology', 4, 117, 101, 400);

-- --------------------------------------------------------

--
-- Table structure for table `reader`
--

CREATE TABLE IF NOT EXISTS `reader` (
  `id` int(2) NOT NULL DEFAULT '0',
  `name` varchar(21) DEFAULT NULL,
  `limit` int(5) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `reader`
--

INSERT INTO `reader` (`id`, `name`, `limit`) VALUES
(1, 'Dick Dastardly', 3),
(2, 'Professor Pat Pending', 3),
(3, 'Penelope Pitstop', 4),
(4, 'Sergeant Blast', 2),
(5, 'Private Meekly', 2),
(6, 'Peter Perfect', 4);

-- --------------------------------------------------------

--
-- Table structure for table `student_info`
--

CREATE TABLE IF NOT EXISTS `student_info` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `lname` varchar(30) NOT NULL,
  `fname` varchar(30) NOT NULL,
  `onames` varchar(30) NOT NULL,
  `matricNo` varchar(13) NOT NULL,
  `sex` varchar(6) NOT NULL,
  `level` int(4) NOT NULL,
  `entryLevel` int(4) NOT NULL,
  `modeOfEntry` varchar(8) NOT NULL,
  `entryYear` int(4) NOT NULL,
  `deptId` int(4) NOT NULL,
  `collegeId` int(4) NOT NULL,
  `programmeId` int(4) NOT NULL,
  `photograph` varchar(70) NOT NULL,
  `loginId` int(4) NOT NULL,
  `resultId` int(4) DEFAULT NULL,
  `currentSemester` int(4) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `matricNo` (`matricNo`,`loginId`,`resultId`),
  KEY `department` (`deptId`),
  KEY `student_college` (`collegeId`),
  KEY `student_programme` (`programmeId`),
  KEY `login` (`loginId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1004 ;

--
-- Dumping data for table `student_info`
--

INSERT INTO `student_info` (`id`, `lname`, `fname`, `onames`, `matricNo`, `sex`, `level`, `entryLevel`, `modeOfEntry`, `entryYear`, `deptId`, `collegeId`, `programmeId`, `photograph`, `loginId`, `resultId`, `currentSemester`) VALUES
(1001, 'Bolarinwa', 'Ibrahim', 'Olaoluwa', 'nas08016', 'male', 400, 100, 'UME', 100, 111, 101, 121, 'Pictures/IMG_0974.JPG', 101, NULL, 7),
(1002, 'Adebayo', 'AbdulHamid', 'Adebowale', 'MAS08001', 'male', 400, 100, 'ume', 2008, 111, 102, 122, 'Pictures/IMG_0974.JPG', 102, 0, 7),
(1003, 'Olayokun', 'Ibrahim', 'Ibro', 'NAS10092', 'M', 200, 100, 'UME', 2010, 113, 101, 121, 'Pictures/Allahu Akbar-2', 103, NULL, 4);

-- --------------------------------------------------------

--
-- Table structure for table `university`
--

CREATE TABLE IF NOT EXISTS `university` (
  `name` varchar(35) NOT NULL,
  `location` varchar(50) NOT NULL,
  `logo` text NOT NULL,
  `currentSemester` int(8) NOT NULL,
  `currentSession` int(8) NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `university`
--

INSERT INTO `university` (`name`, `location`, `logo`, `currentSemester`, `currentSession`) VALUES
('Fountain University Osogbo', 'Oke-Osun, Osogbo', 'Pictures/Allahu Akbar-2.JPG', 2, 2012);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `course_college` FOREIGN KEY (`collegeId`) REFERENCES `colleges` (`collegeId`),
  ADD CONSTRAINT `course_department` FOREIGN KEY (`departmentId`) REFERENCES `departments` (`deptId`),
  ADD CONSTRAINT `course_lecturer` FOREIGN KEY (`lecturerId`) REFERENCES `lecturers` (`id`),
  ADD CONSTRAINT `course_programme` FOREIGN KEY (`programmeId`) REFERENCES `programmes` (`programmeId`),
  ADD CONSTRAINT `prerequisite` FOREIGN KEY (`prerequisiteId`) REFERENCES `prerequisite` (`id`);

--
-- Constraints for table `coursestaken`
--
ALTER TABLE `coursestaken`
  ADD CONSTRAINT `studentId` FOREIGN KEY (`studentId`) REFERENCES `student_info` (`id`);

--
-- Constraints for table `departments`
--
ALTER TABLE `departments`
  ADD CONSTRAINT `collegeId` FOREIGN KEY (`collegeId`) REFERENCES `colleges` (`collegeId`);

--
-- Constraints for table `gns_courses`
--
ALTER TABLE `gns_courses`
  ADD CONSTRAINT `gns_lecturer` FOREIGN KEY (`lecturerId`) REFERENCES `lecturers` (`id`);

--
-- Constraints for table `lecturers`
--
ALTER TABLE `lecturers`
  ADD CONSTRAINT `lecturer_college` FOREIGN KEY (`collegeId`) REFERENCES `colleges` (`collegeId`),
  ADD CONSTRAINT `lecturer_department` FOREIGN KEY (`deptId`) REFERENCES `departments` (`deptId`);

--
-- Constraints for table `prerequisite`
--
ALTER TABLE `prerequisite`
  ADD CONSTRAINT `course_pre` FOREIGN KEY (`courseCode`) REFERENCES `courses` (`code`);

--
-- Constraints for table `programmes`
--
ALTER TABLE `programmes`
  ADD CONSTRAINT `college` FOREIGN KEY (`collegeId`) REFERENCES `colleges` (`collegeId`),
  ADD CONSTRAINT `departmentId` FOREIGN KEY (`departmentId`) REFERENCES `departments` (`deptId`);

--
-- Constraints for table `student_info`
--
ALTER TABLE `student_info`
  ADD CONSTRAINT `department` FOREIGN KEY (`deptId`) REFERENCES `departments` (`deptId`),
  ADD CONSTRAINT `login` FOREIGN KEY (`loginId`) REFERENCES `login` (`loginId`),
  ADD CONSTRAINT `student_college` FOREIGN KEY (`collegeId`) REFERENCES `colleges` (`collegeId`),
  ADD CONSTRAINT `student_programme` FOREIGN KEY (`programmeId`) REFERENCES `programmes` (`programmeId`);
