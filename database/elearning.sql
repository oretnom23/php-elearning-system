-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 28, 2021 at 04:01 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.2.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `elearning`
--

-- --------------------------------------------------------

--
-- Table structure for table `academic_year`
--

CREATE TABLE `academic_year` (
  `id` int(30) NOT NULL,
  `sy` varchar(150) NOT NULL,
  `status` tinyint(5) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `academic_year`
--

INSERT INTO `academic_year` (`id`, `sy`, `status`) VALUES
(1, '2020-2019', 1);

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `id` int(30) NOT NULL,
  `department_id` int(30) NOT NULL,
  `course_id` int(30) NOT NULL,
  `level` varchar(50) NOT NULL,
  `section` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`id`, `department_id`, `course_id`, `level`, `section`) VALUES
(1, 1, 1, '1', 'A'),
(2, 1, 1, '1', 'B');

-- --------------------------------------------------------

--
-- Table structure for table `class_subjects`
--

CREATE TABLE `class_subjects` (
  `academic_year_id` int(30) NOT NULL,
  `class_id` int(30) NOT NULL,
  `subject_id` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `class_subjects`
--

INSERT INTO `class_subjects` (`academic_year_id`, `class_id`, `subject_id`) VALUES
(1, 1, 1),
(1, 1, 2),
(1, 2, 1),
(1, 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `class_subjects_faculty`
--

CREATE TABLE `class_subjects_faculty` (
  `academic_year_id` int(30) NOT NULL,
  `faculty_id` varchar(50) NOT NULL,
  `class_id` int(30) NOT NULL,
  `subject_id` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `class_subjects_faculty`
--

INSERT INTO `class_subjects_faculty` (`academic_year_id`, `faculty_id`, `class_id`, `subject_id`) VALUES
(1, '12345', 1, 1),
(1, '12345', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `id` int(30) NOT NULL,
  `course` varchar(250) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`id`, `course`, `description`) VALUES
(1, 'BSIS', 'Bachelor of Science in Information Systems');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `id` int(30) NOT NULL,
  `department` varchar(250) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`id`, `department`, `description`) VALUES
(1, 'CIT', 'College of industrial Technology');

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE `faculty` (
  `id` int(30) NOT NULL,
  `faculty_id` varchar(50) NOT NULL,
  `department_id` int(30) NOT NULL,
  `firstname` varchar(150) NOT NULL,
  `middlename` varchar(150) NOT NULL,
  `lastname` varchar(150) NOT NULL,
  `email` varchar(250) NOT NULL,
  `contact` varchar(150) NOT NULL,
  `gender` varchar(20) NOT NULL,
  `address` text DEFAULT NULL,
  `password` text DEFAULT NULL,
  `dob` int(11) NOT NULL,
  `avatar` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`id`, `faculty_id`, `department_id`, `firstname`, `middlename`, `lastname`, `email`, `contact`, `gender`, `address`, `password`, `dob`, `avatar`) VALUES
(1, '12345', 1, 'George', 'C', 'Wilson', 'gwilson@sample.com', '+1234567899', 'Male', 'Sample Address', '827ccb0eea8a706c4c34a16891f84e7b', 1988, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `lessons`
--

CREATE TABLE `lessons` (
  `id` int(30) NOT NULL,
  `academic_year_id` int(30) NOT NULL,
  `subject_id` int(30) NOT NULL,
  `faculty_id` varchar(50) NOT NULL,
  `title` varchar(250) NOT NULL,
  `description` text DEFAULT NULL,
  `ppt_path` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lessons`
--

INSERT INTO `lessons` (`id`, `academic_year_id`, `subject_id`, `faculty_id`, `title`, `description`, `ppt_path`) VALUES
(1, 1, 2, '12345', 'Lesson 101 Test', '&lt;h2 style=&quot;margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: &quot; open=&quot;&quot; sans&quot;,=&quot;&quot; arial,=&quot;&quot; sans-serif;&quot;=&quot;&quot;&gt;&lt;b&gt;Sample Heading 1&lt;/b&gt;&lt;/h2&gt;&lt;h2 style=&quot;margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: &quot; open=&quot;&quot; sans&quot;,=&quot;&quot; arial,=&quot;&quot; sans-serif;&quot;=&quot;&quot;&gt;&lt;p style=&quot;margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; font-size: 14px;&quot;&gt;Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed enim ipsum, rutrum eu erat sed, lacinia hendrerit sapien. Ut viverra dapibus velit nec pellentesque. Morbi ac gravida tortor. Curabitur scelerisque nisl metus. Fusce diam dui, feugiat vel congue a, convallis pulvinar dui. Donec ut felis vel dolor vehicula tincidunt vitae id nibh. Mauris mollis leo pulvinar vehicula sagittis. Sed bibendum arcu at eros imperdiet pellentesque non non orci. Etiam accumsan pulvinar egestas. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Curabitur nec odio nec quam ultrices facilisis. Nam tempor a neque dapibus lacinia. Etiam porttitor at urna sed pellentesque. Phasellus rhoncus mi at lobortis semper. Vivamus tempus urna nec sagittis vehicula. Nam sagittis velit nec quam molestie volutpat quis et ex.&lt;/p&gt;&lt;/h2&gt;&lt;h2&gt;&lt;b&gt;Sample Heading 2&lt;/b&gt;&lt;/h2&gt;&lt;h2&gt;&lt;p style=&quot;margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; font-size: 14px;&quot;&gt;Sed in imperdiet nisi, non ultrices lectus. Donec auctor, ante sed vestibulum cursus, ex neque scelerisque augue, a faucibus libero lectus eu mauris. Morbi ac quam non felis malesuada lacinia vel laoreet tortor. Proin euismod risus sit amet scelerisque imperdiet. Phasellus ut neque mollis, porttitor velit a, congue libero. Ut cursus accumsan lectus, vitae congue mi pellentesque vitae. Integer pulvinar accumsan dignissim. Proin bibendum dapibus risus at accumsan. Donec a sapien sed arcu malesuada maximus. Integer eu feugiat eros.&lt;/p&gt;&lt;/h2&gt;', 'uploads/slides/lesson_1'),
(2, 1, 1, '12345', 'Sample 101', '&lt;p style=&quot;margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: &amp;quot;Open Sans&amp;quot;, Arial, sans-serif;&quot;&gt;Aliquam dictum ante at dapibus luctus. Maecenas semper pulvinar congue. Pellentesque semper, velit eget auctor euismod, ante sem vulputate augue, ut volutpat felis lorem nec ex. Praesent non porttitor nunc, non ullamcorper est. Donec eu arcu viverra augue tristique fermentum. Duis scelerisque bibendum augue, id laoreet massa tempor eu. Vivamus nec ante est. Fusce eu lacus sapien. Sed viverra lorem nec ante consequat tempor. Quisque ligula dolor, feugiat nec ligula porttitor, fermentum lacinia augue. Morbi fringilla vitae massa vitae tempus. Etiam ut vehicula lectus. Fusce cursus dolor vel dignissim volutpat. Etiam iaculis, justo vel fermentum varius, sem turpis hendrerit nulla, eget dapibus neque urna vitae arcu.&lt;/p&gt;&lt;p style=&quot;margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: &amp;quot;Open Sans&amp;quot;, Arial, sans-serif;&quot;&gt;Ut euismod tempor turpis, quis fringilla enim varius eget. Duis id neque blandit, vehicula purus eu, molestie dolor. Aliquam erat volutpat. Pellentesque quis dapibus elit. Curabitur ac lectus tortor. Phasellus et nibh nisl. Phasellus eu imperdiet nisi, tempor semper purus&lt;/p&gt;', 'uploads/slides/lesson_2');

-- --------------------------------------------------------

--
-- Table structure for table `lesson_class`
--

CREATE TABLE `lesson_class` (
  `lesson_id` int(30) NOT NULL,
  `class_id` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lesson_class`
--

INSERT INTO `lesson_class` (`lesson_id`, `class_id`) VALUES
(1, 1),
(1, 2),
(1, 1),
(1, 2),
(1, 1),
(1, 2),
(1, 1),
(1, 2),
(1, 1),
(1, 2),
(1, 1),
(1, 2),
(1, 1),
(1, 2),
(1, 1),
(1, 2),
(1, 1),
(1, 2),
(1, 1),
(1, 2),
(2, 1),
(2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(30) NOT NULL,
  `student_id` varchar(50) NOT NULL,
  `firstname` varchar(150) NOT NULL,
  `middlename` varchar(150) NOT NULL,
  `lastname` varchar(150) NOT NULL,
  `email` varchar(250) NOT NULL,
  `contact` varchar(150) NOT NULL,
  `gender` varchar(20) NOT NULL,
  `address` text DEFAULT NULL,
  `password` text DEFAULT NULL,
  `dob` int(11) NOT NULL,
  `avatar` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `student_id`, `firstname`, `middlename`, `lastname`, `email`, `contact`, `gender`, `address`, `password`, `dob`, `avatar`) VALUES
(1, '6231415', 'John', 'D', 'Smith', 'jsmith@sample.com', '+1234567899', 'Male', 'Sample address', '04e4ff14103f267c4b443362cefe9570', 2005, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `student_class`
--

CREATE TABLE `student_class` (
  `id` int(30) NOT NULL,
  `academic_year_id` int(30) NOT NULL,
  `student_id` int(30) NOT NULL,
  `class_id` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student_class`
--

INSERT INTO `student_class` (`id`, `academic_year_id`, `student_id`, `class_id`) VALUES
(1, 1, 6231415, 1);

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` int(30) NOT NULL,
  `subject_code` varchar(250) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `subject_code`, `description`) VALUES
(1, 'S101', 'Subject 101'),
(2, 'S102', 'Subject 102');

-- --------------------------------------------------------

--
-- Table structure for table `system_info`
--

CREATE TABLE `system_info` (
  `id` int(30) NOT NULL,
  `meta_field` text NOT NULL,
  `meta_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `system_info`
--

INSERT INTO `system_info` (`id`, `meta_field`, `meta_value`) VALUES
(1, 'name', 'Simple eLearning System'),
(2, 'address', 'Philippines'),
(3, 'contact', '+1234567890'),
(4, 'email', 'info@sample.com'),
(6, 'short_name', 'SES'),
(9, 'logo', 'uploads/1616118180_aclc.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(50) NOT NULL,
  `firstname` varchar(250) NOT NULL,
  `lastname` varchar(250) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `avatar` text DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `username`, `password`, `avatar`, `last_login`, `date_added`, `date_updated`) VALUES
(1, 'John', 'Smith', 'admin', '0192023a7bbd73250516f069df18b500', 'uploads/1619140500_avatar.png', NULL, '2021-01-20 14:02:37', '2021-04-23 15:14:05'),
(2, 'Georgee', 'Wilson', '', '', NULL, NULL, '2021-04-28 21:01:58', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `academic_year`
--
ALTER TABLE `academic_year`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faculty`
--
ALTER TABLE `faculty`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lessons`
--
ALTER TABLE `lessons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_class`
--
ALTER TABLE `student_class`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_info`
--
ALTER TABLE `system_info`
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
-- AUTO_INCREMENT for table `academic_year`
--
ALTER TABLE `academic_year`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `class`
--
ALTER TABLE `class`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `faculty`
--
ALTER TABLE `faculty`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `lessons`
--
ALTER TABLE `lessons`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `student_class`
--
ALTER TABLE `student_class`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `system_info`
--
ALTER TABLE `system_info`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
