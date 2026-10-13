-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 31, 2026 at 06:17 PM
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
-- Database: `pet_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `adoptableanimals`
--

CREATE TABLE `adoptableanimals` (
  `animal_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `species` varchar(255) NOT NULL,
  `desc` text NOT NULL,
  `img` varchar(255) NOT NULL,
  `vet_id` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `adoptableanimals`
--

INSERT INTO `adoptableanimals` (`animal_id`, `name`, `species`, `desc`, `img`, `vet_id`) VALUES
(1, 'Buttercup', 'Golden Retriever', 'Buttercup is a friendly and playful pet who loves attention and outdoor activities.', 'buttercup.jpg', 1),
(2, 'Buddy', 'American Pit Bull Terrier', 'Buddy enjoys long walks and spending time with families and children.', 'buddy.jpg', 1),
(3, 'Vinnie', 'Caliby', 'Vinnie is calm and loyal, perfect for a quiet and loving home.', 'vinnie.jpg', 2),
(4, 'Cupcake', ' Orange Tabby', 'Cupcake is a cheerful cat who loves to play and explore. Perfect for an active family.', 'cupcake.jpg', 2),
(5, 'Galaxy Destroyer', ' Munchkin Cat', 'Despite the name, Galaxy Destroyer is a calm and affectionate cat who enjoys naps.', 'galaxy.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `animal_id` int(11) NOT NULL,
  `appointment_date` datetime NOT NULL,
  `status` varchar(50) DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `user_id`, `animal_id`, `appointment_date`, `status`) VALUES
(1, 2, 1, '2026-05-28 13:06:00', 'Pending'),
(2, 2, 1, '2026-06-23 20:42:00', 'Pending'),
(3, 2, 1, '2026-06-02 13:20:00', 'Pending'),
(4, 2, 1, '2026-06-10 13:20:00', 'Pending'),
(5, 4, 1, '2026-06-16 11:30:00', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `stray`
--

CREATE TABLE `stray` (
  `stray_id` int(10) UNSIGNED NOT NULL,
  `animal_type` varchar(255) NOT NULL,
  `additional_info` text DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `contact_info` varchar(255) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stray`
--

INSERT INTO `stray` (`stray_id`, `animal_type`, `additional_info`, `email`, `contact_info`, `user_id`) VALUES
(1, 'Dog (Golden Retriever)', 'Found wandering near Main Street park. Friendly.', 'jack@gmail.com', 'brick lane', 4),
(2, 'Cat', 'Found the cat infront of my yard wandering around my house.', 'susan@gmail.com', '94-96 street, London', 2),
(3, 'Dog (chihuahua)', 'Found him wondering around my yard, he seems scared so I gave him some snacks something to play with.', 'marilyn@gmail.com', 'The Bishops Avenue (North London)', 5),
(4, 'Dog', 'I found her wondering around the street and she seems scared so I went and gave her some snacks.', 'gigi@gmail.com', 'the bishops Avenue (North London)', 2),
(5, 'dog', 'Found her in front of my house wondering, please contact me for more information she doesn\'t have a collar.', 'gigi@gmail.com', 'the bishops Avenue (North London)', 2),
(6, 'Cat', 'Wondering around my yard with a collar around her neck. contact for more information about her.', 'nathanial@gmail.com', '19th street', 4);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) UNSIGNED NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(59) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `firstname`, `lastname`, `username`, `password`, `role`) VALUES
(1, 'admin', 'admin', 'admin', 'admin123', 'admin'),
(2, 'Gi', 'Gi', 'gigi', 'gigi123', 'user'),
(4, 'Nathaniel', 'Henderson', 'Nathaniel', 'nate123', 'user'),
(5, 'Marilyn', 'Aung', 'Marilyn', 'papa123', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `vets`
--

CREATE TABLE `vets` (
  `vet_id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `detail` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `qualification` varchar(255) NOT NULL,
  `experience` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vets`
--

INSERT INTO `vets` (`vet_id`, `name`, `detail`, `email`, `qualification`, `experience`, `img`) VALUES
(1, 'Dr. Emily Parker', 'Dr. Emily Parker is a caring and experienced veterinarian who focuses on dogs, cats, and small pets. She is passionate about preventive care, vaccinations, and nutrition. Her friendly personality helps pets feel calm and safe during treatment.', 'emilyparker@gmail.com', 'Doctor of Veterinary Medicine, Bachelor of Animal Science', '6+ years in veterinary practice, Specialized in small animal care', 'vet1.jpg'),
(2, 'Dr. Jane Foster', 'Dr. Jane Foster is a skilled veterinarian with strong experience in animal surgery and emergency treatment. She is dedicated to providing high-quality medical care and ensuring the well-being of every pet. She is known for her professionalism and attention to detail.', 'janefoster@gmail.com', 'Doctor of Veterinary Medicine, Diploma in Veterinary Surgery', '8+ years of experience, Expertise in surgical procedures and emergency care', 'vet2.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adoptableanimals`
--
ALTER TABLE `adoptableanimals`
  ADD PRIMARY KEY (`animal_id`),
  ADD KEY `fk_adoptableanimals_vets` (`vet_id`);

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `animal_id` (`animal_id`);

--
-- Indexes for table `stray`
--
ALTER TABLE `stray`
  ADD PRIMARY KEY (`stray_id`),
  ADD KEY `fk_stray_user` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `vets`
--
ALTER TABLE `vets`
  ADD PRIMARY KEY (`vet_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adoptableanimals`
--
ALTER TABLE `adoptableanimals`
  MODIFY `animal_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `stray`
--
ALTER TABLE `stray`
  MODIFY `stray_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `vets`
--
ALTER TABLE `vets`
  MODIFY `vet_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `adoptableanimals`
--
ALTER TABLE `adoptableanimals`
  ADD CONSTRAINT `fk_adoptableanimals_vets` FOREIGN KEY (`vet_id`) REFERENCES `vets` (`vet_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `appointments_ibfk_2` FOREIGN KEY (`animal_id`) REFERENCES `adoptableanimals` (`animal_id`) ON DELETE CASCADE;

--
-- Constraints for table `stray`
--
ALTER TABLE `stray`
  ADD CONSTRAINT `fk_stray_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
