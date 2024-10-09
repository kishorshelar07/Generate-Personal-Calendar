-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 16, 2024 at 01:30 PM
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
-- Database: `dbcalendar`
--

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `usr_no` int(4) NOT NULL COMMENT 'PK,ZF,AI',
  `usr_id` char(10) CHARACTER SET utf16 COLLATE utf16_bin NOT NULL COMMENT 'mobile no',
  `usr_name` varchar(35) CHARACTER SET utf16 COLLATE utf16_bin NOT NULL COMMENT 'Fullname of user',
  `usr_pass` char(64) CHARACTER SET utf16 COLLATE utf16_bin NOT NULL COMMENT 'SHA256 hash of pass',
  `usr_status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1-Active, 0-InActive',
  `usr_type` varchar(15) CHARACTER SET utf16 COLLATE utf16_bin NOT NULL DEFAULT 'User' COMMENT 'eg - Admin, User',
  `usr_dob` date NOT NULL COMMENT 'Date of Birth',
  `usr_email` varchar(50) CHARACTER SET utf16 COLLATE utf16_bin NOT NULL,
  `usr_gender` char(10) CHARACTER SET utf16 COLLATE utf16_bin DEFAULT NULL,
  `usr_reg_date_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'Registration date time of user',
  `usr_temp_pass` char(64) CHARACTER SET utf16 COLLATE utf16_bin DEFAULT NULL COMMENT 'Temporary password to reset the password',
  `usr_remarks` varchar(160) CHARACTER SET utf16 COLLATE utf16_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`usr_no`, `usr_id`, `usr_name`, `usr_pass`, `usr_status`, `usr_type`, `usr_dob`, `usr_email`, `usr_gender`, `usr_reg_date_time`, `usr_temp_pass`, `usr_remarks`) VALUES
(116, '7350736569', 'Vaishnavi Tomar', '111', 1, 'Admin', '2023-01-31', 'vaish@gmail.com', '', '2024-06-27 05:54:12', '', ''),
(120, '8308516345', 'Kishor Shelar', 'Kishor', 1, 'User', '1998-10-16', 'kishorshelar560@gmail.com', '', '2024-08-12 12:22:49', '', ''),
(136, '6767676767', 'Kavita S', '123', 1, 'User', '2024-06-07', 'kishors@gmail.com', '', '2024-07-02 12:13:44', '', ''),
(137, '6666666666', 'Kishor Shelar', '123', 0, 'User', '2024-07-02', 'kishor99@gmail.com', '', '2024-07-11 12:02:22', '', ''),
(138, '5656565656', 'Vaish', '111', 0, 'User', '2000-10-10', 'kavita@gmail.com', '', '2024-07-03 06:34:03', '', ''),
(140, '3234323432', 'sdsdsdjhhgh', '111', 1, 'User', '2024-07-01', 'kishrs56@gmail.com', '', '2024-07-11 06:56:24', '0', '0'),
(141, '8007667835', 'AK Ajay', '8007667', 1, 'Admin', '2022-06-08', 'demo@gmail.com', '', '2024-07-11 08:09:34', '0', '0'),
(142, '8007667536', 'Ak Ajay', '8007667', 1, 'User', '2022-02-01', 'demo@gmail.com', '', '2024-07-11 08:09:44', '0', '0'),
(143, '8989008900', 'Batul Husain', '123', 1, 'User', '2024-07-01', 'batul@gmail.com', 'female', '2024-07-11 12:24:06', NULL, NULL),
(144, '7765655669', 'kishor', '111111', 1, 'User', '2024-07-08', 'aishwarya@gmail.com', NULL, '2024-07-24 12:29:31', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_calendar`
--

CREATE TABLE `user_calendar` (
  `uc_no` int(5) NOT NULL,
  `usr_id` char(10) CHARACTER SET utf16 COLLATE utf16_bin NOT NULL,
  `uc_msg` varchar(100) CHARACTER SET utf16 COLLATE utf16_bin NOT NULL,
  `uc_date_event_csv` varchar(250) CHARACTER SET utf16 COLLATE utf16_bin NOT NULL,
  `uc_event_details_csv` varchar(50) CHARACTER SET utf16 COLLATE utf16_bin NOT NULL,
  `uc_img_csv` varchar(500) CHARACTER SET utf16 COLLATE utf16_bin NOT NULL DEFAULT '0',
  `uc_num_page` int(2) NOT NULL,
  `uc_start_date` date NOT NULL,
  `uc_end_date` date NOT NULL,
  `uc_calendar_type` varchar(35) CHARACTER SET utf16 COLLATE utf16_bin NOT NULL,
  `uc_page_header` varchar(100) CHARACTER SET utf16 COLLATE utf16_bin NOT NULL,
  `uc_page_footer` varchar(100) CHARACTER SET utf16 COLLATE utf16_bin NOT NULL,
  `uc_remarks` varchar(100) CHARACTER SET utf16 COLLATE utf16_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_calendar`
--

INSERT INTO `user_calendar` (`uc_no`, `usr_id`, `uc_msg`, `uc_date_event_csv`, `uc_event_details_csv`, `uc_img_csv`, `uc_num_page`, `uc_start_date`, `uc_end_date`, `uc_calendar_type`, `uc_page_header`, `uc_page_footer`, `uc_remarks`) VALUES
(207, '8308516345', 'If you can dream it, you can do it.', '2024/05/18', 'My Birthday,Aniversary', 'Kishor_30ff.jpg, Kishor_493d.jpg, Kishor_4d9b.jpg, Kishor_50ae.jpg, Kishor_537e.jpg', 1, '2024-01-01', '2024-12-29', 'template_1', 'Reliance Industries Ltd', 'None', 'Good...'),
(208, '8007667835', 'Nearly all men can stand adversity but if you want to test a man\'s character, give him power.', '2024/09/11, 2024/06/06', 'Aniversary,My Birthday', 'AK Aja_2963.jpg, AK Aja_2d3a.jpg, AK Aja_3090.jpg, AK Aja_339d.jpg, AK Aja_3689.jpg, AK Aja_3936.jpg, AK Aja_3c0f.jpg, AK Aja_3ef1.jpg, AK Aja_4665.jpg, AK Aja_49b1.jpg, AK Aja_4d0b.jpg, AK Aja_50bb.jpg, AK Aja_5451.jpg, AK Aja_5849.jpg, AK Aja_5b77.jpg, AK Aja_5e12.jpg, AK Aja_60c4.jpg, AK Aja_6552.jpg, AK Aja_68b5.jpg, AK Aja_6c1d.jpg', 1, '2024-01-01', '2024-12-29', 'template_1', 'Tata Consultancy Services', 'None', 'Good'),
(210, '6767676767', 'Give me six hours to chop down a tree and I will spend the first four sharpening the axe.', '2024/08/16, 2024/04/09', 'Aniversary,My Birthdayggh', 'Kavita_551a.jpg, Kavita_5965.jpg, Kavita_5cd6.jpg, Kavita_60ce.jpg, Kavita_6400.jpg, Kavita_673c.jpg, Kavita_6aa0.jpg, Kavita_6e7a.jpg, Kavita_75ec.jpg, Kavita_7cb1.jpg, 676767_3aee.jpg, 676767_4980.jpg, 676767_556a.jpg, 676767_622e.jpg', 12, '2024-01-01', '2024-08-03', 'template_2', 'Larsen & Toubro', 'None', 'good '),
(214, '8007667536', 'Those who deny freedom to others, deserve it not for themselves.', '2024/07/01, 2024/07/13', 'Aniversary,My Birthday', 'Ak Aja_db91.jpg, Ak Aja_df0b.jpg, Ak Aja_e2c4.jpg, Ak Aja_e62f.jpg, Ak Aja_e989.jpg, Ak Aja_ed06.jpg, Ak Aja_f070.jpg, Ak Aja_f470.jpg, Ak Aja_f850.jpg, Ak Aja_fc2c.jpg, Ak Aja_634e.jpg, Ak Aja_72b5.jpg', 1, '2024-01-01', '2024-12-28', 'template_1', 'Hindustan Unilever Ltd', 'None', 'Good...'),
(225, '7350736569', 'It takes courage to grow up and become who you really are.', '2024/03/06, 2024/05/16', 'Aniversary,My Birthday', 'Vaishn_1fe8.jpg, Vaishn_2394.jpg, Vaishn_268c.jpg, Vaishn_29f7.jpg, Vaishn_2d7a.jpg, Vaishn_30ce.jpg, Vaishn_3518.jpg, Vaishn_385f.jpg, Vaishn_3bdb.jpg, Vaishn_3f5d.jpg, Vaishn_49e4.jpg, Vaishn_4e4d.jpg, Vaishn_51c2.jpg, Vaishn_5480.jpg, Vaishn_580d.jpg, Vaishn_5b99.jpg, Vaishn_5f19.jpg, Vaishn_628a.jpg', 3, '2024-01-01', '2024-12-31', 'template_3', 'CIT Pune', 'None', 'Good'),
(232, '8308516345', 'The greatest glory in living lies not in never falling, but in rising every time we fall. - Nelson M', '2024/05/14, 2024/07/17', 'Aniversary,My Birthday', 'Kishor_443d.jpg, Kishor_4853.jpg, Kishor_4bc6.jpg, Kishor_4f87.jpg, Kishor_52df.jpg, Kishor_5973.jpg, Kishor_5ec0.jpg, Kishor_6279.jpg, Kishor_6607.jpg, Kishor_69d3.jpg, Kishor_7055.jpg, Kishor_74e4.jpg, Kishor_785f.jpg, Kishor_7bbb.jpg, Kishor_7f48.jpg, Kishor_83b0.jpg, Kishor_86b8.jpg, Kishor_8a5b.jpg', 3, '2024-01-01', '2024-12-14', 'template_3', 'Amazon Pune', 'None...', 'good'),
(233, '8308516345', 'Character is like a tree and reputation like a shadow. The shadow is what we think of it; the tree i', '2024/07/19, 2024/07/03', 'My Birthday,Interview', 'Kishor_7247.jpg, Kishor_75f1.jpg, Kishor_7cda.jpg, Kishor_8063.jpg, Kishor_83de.jpg, Kishor_874d.jpg, Kishor_8ae7.jpg, Kishor_8e8b.jpg, Kishor_920a.jpg, Kishor_9574.jpg, Kishor_993e.jpg, Kishor_9d14.jpg, Kishor_a1f6.jpg, Kishor_a5ec.jpg, Kishor_a9aa.jpg, Kishor_ad5f.jpg', 12, '2024-01-01', '2024-12-27', 'template_2', 'Flipkart Pune', 'None', 'Good'),
(234, '8308516345', 'I do not think much of a man who is not wiser today than he was yesterday.', '2024/07/07, 2024/07/20', 'My Birthday,Aniversary', '830851_9a09.jpg, 830851_cd3d.jpg, 830851_d303.jpg, 830851_d71b.jpg, 830851_d9e6.jpg, 830851_dc65.jpg, 830851_df28.jpg, 830851_e1ad.jpg, 830851_e490.jpg, 830851_e7a2.jpg, 830851_ea56.jpg, 830851_ecd8.jpg, 830851_f3c7.jpg', 12, '2024-01-01', '2024-12-28', 'template_2', 'Tesla Pune', 'None', 'Good'),
(235, '7350736569', 'Learn from yesterday, live for today, hope for tomorrow. The important thing is not to stop question', '2024/07/07, 2024/07/26', 'My Birthday,Interview', '735073_35fb.jpg, 735073_3a3f.jpg, 735073_4004.jpg, 735073_439e.jpg, 735073_45fd.jpg, 735073_4857.jpg, 735073_4ae8.jpg, 735073_4d47.jpg, 735073_4fd0.jpg, 735073_527a.jpg, 735073_551e.jpg, 735073_5998.jpg', 3, '2024-01-01', '2024-12-28', 'template_3', 'C-IT Pune', 'None', 'good'),
(237, '8308516345', 'We cannot solve our problems with the same thinking we used when we created them.', '2024/07/08, 2024/07/27', 'Aniversary,My Birthday', '830851_4a67.jpg, 830851_4e78.jpg, 830851_519d.jpg, 830851_53e1.jpg, 830851_574b.jpg, 830851_59c0.jpg, 830851_5be7.jpg, 830851_5e07.jpg, 830851_60b5.jpg, 830851_62d0.jpg, 830851_6596.jpg, 830851_67db.jpg', 1, '2024-01-01', '2024-12-29', 'template_1', 'Happiness is the key', 'No Footer', 'Good'),
(238, '7350736569', 'The greatest glory in living lies not in never falling, but in rising every time we fall. - Nelson M', '2024-06-03, 2024-10-16', 'Aniversary,My Birthday', '735073_209a.jpg, 735073_3d30.jpg, 735073_41e8.jpg, 735073_449d.jpg, 735073_a085.jpg, 735073_c1a8.jpg, 735073_c4d6.jpg', 12, '2024-01-02', '2024-12-28', 'template_2', 'Flipkart Pune', 'None', 'good '),
(239, '6767676767', 'The greatest glory in living lies not in never falling, but in rising every time we fall. - Nelson M', '2024/08/05, 2024/08/10', 'My Birthday,Interview', '676767_f073.jpg, 676767_f6ea.jpg, 676767_fcd4.jpg, 676767_01ae.jpg, 676767_055c.jpg, 676767_092d.jpg, 676767_6cbe.jpg, 676767_75c9.jpg, 676767_79f2.jpg, 676767_8025.jpg, 676767_8447.jpg, 676767_87eb.jpg', 12, '2024-01-02', '2024-12-28', 'template_2', 'Amazon Pune', 'No Footer', 'Good'),
(241, '8308516345', 'Very Good Day', '2024/08/08, 2023/08/25', 'Good Day', '830851_610c.jpg, 830851_65ad.jpg, 830851_68b3.jpg, 830851_6c02.jpg, 830851_703b.jpg, 830851_750e.jpg, 830851_7841.jpg, 830851_7b57.jpg, 830851_7ec1.jpg, 830851_8139.jpg, 830851_5d50.jpg, 830851_6241.jpg, 830851_6503.jpg, 830851_6709.jpg, 830851_698d.jpg, 830851_6bb3.jpg, 830851_6dba.jpg, 830851_6fcf.jpg, 830851_71f7.jpg, 830851_73f3.jpg', 12, '2023-01-03', '2023-12-23', 'template_2', 'Hello.....New Chapter!', 'Be....Happy!', 'SKT');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`usr_no`),
  ADD UNIQUE KEY `usr_id` (`usr_id`);

--
-- Indexes for table `user_calendar`
--
ALTER TABLE `user_calendar`
  ADD PRIMARY KEY (`uc_no`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `usr_no` int(4) NOT NULL AUTO_INCREMENT COMMENT 'PK,ZF,AI', AUTO_INCREMENT=146;

--
-- AUTO_INCREMENT for table `user_calendar`
--
ALTER TABLE `user_calendar`
  MODIFY `uc_no` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=242;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
