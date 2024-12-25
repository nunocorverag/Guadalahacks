-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 19, 2024 at 05:00 AM
-- Server version: 5.7.24
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cookaidb`
--

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `pregunta` text NOT NULL,
  `dificultad` int(11) NOT NULL COMMENT '1. Easy\r\n2. Medium\r\n3. Hard',
  `topic_id` int(11) NOT NULL,
  `exp_ans` text NOT NULL,
  `score` int(11) NOT NULL,
  `alternative` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `pregunta`, `dificultad`, `topic_id`, `exp_ans`, `score`, `alternative`) VALUES
(1, '¿Cuál es la fórmula para calcular la velocidad promedio?', 1, 19, ': Velocidad promedio = distancia / tiempo', 0, 0),
(2, '¿Qué es la fuerza de gravedad?', 1, 19, ': Es la fuerza que atrae dos cuerpos con masa entre sí.', 0, 0),
(3, '¿Qué es la energía cinética?', 1, 19, ': Es la energía que un objeto posee debido a su movimiento.', 0, 0),
(4, '¿Qué es la ley de la inercia?', 1, 19, ': Un objeto en reposo tiende a permanecer en reposo y un objeto en movimiento tiende a permanecer en movimiento.', 0, 0),
(5, '¿Qué es la aceleración?', 1, 19, ': Es el cambio en la velocidad de un objeto en un determinado tiempo.', 0, 0),
(6, '¿Qué es la ley de la acción y reacción?', 2, 19, ': Por cada acción hay una reacción igual y opuesta.', 0, 0),
(7, '¿Cuál es la fórmula para calcular la fuerza?', 2, 19, ': Fuerza = masa x aceleración', 0, 0),
(8, '¿Qué es la energía potencial?', 2, 19, ': Es la energía almacenada en un objeto debido a su posición o configuración.', 0, 0),
(9, '¿Qué es la ley de la conservación de la energía?', 2, 19, ': La energía no se crea ni se destruye, solo se transforma de una forma a otra.', 0, 0),
(10, '¿Qué es la ley de la gravitación universal?', 2, 19, ': Todos los objetos en el universo se atraen entre sí con una fuerza que es directamente proporcional al producto de sus masas e inversamente proporcional al cuadrado de la distancia que los separa.', 0, 0),
(11, '¿Cuál es la fórmula para calcular el trabajo realizado por una fuerza constante?', 3, 19, ': Trabajo = fuerza x distancia x cos(θ)', 0, 0),
(12, '¿Qué es el momento de inercia?', 3, 19, ': Es una medida de la distribución de la masa de un objeto en relación con su eje de rotación.', 0, 0),
(13, '¿Qué es el impulso?', 3, 19, ': Es la variación de la cantidad de movimiento de un objeto en un intervalo de tiempo.', 0, 0),
(14, '¿Qué es la conservación del momento angular?', 3, 19, ': La cantidad de momento angular en un sistema aislado se mantiene constante a lo largo del tiempo.', 0, 0),
(15, '¿Qué es la ley de la termodinámica?', 3, 19, ': La energía no se puede crear ni destruir, solo se puede cambiar de una forma a otra.', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `sub_topics`
--

CREATE TABLE `sub_topics` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `info` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `topics`
--

CREATE TABLE `topics` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `progress` float NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `topics`
--

INSERT INTO `topics` (`id`, `name`, `progress`, `user_id`) VALUES
(1, '', 0, 2),
(2, '', 0, 2),
(3, 'name', 0, 2),
(4, '', 0, 2),
(5, '', 0, 2),
(6, '', 0, 2),
(7, '', 0, 2),
(8, 'Matematicas', 0, 2),
(9, 'Matematicas', 0, 2),
(10, 'Matematicas', 0, 2),
(11, 'Matematicas', 0, 2),
(12, 'Matematicas', 0, 2),
(13, 'Matematicas', 0, 2),
(14, 'Fisica', 0, 2),
(15, 'Fisica', 0, 2),
(16, 'Fisica', 0, 2),
(17, 'Fisica', 0, 2),
(18, 'Fisica', 0, 2),
(19, 'Fisica', 0, 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`) VALUES
(2, 'test2', 'test2@test.com', '$2y$10$jD5TVGyCJjrjDS.WjBkyCeLNHlNXlTW8MCg7alc1UsJuB0taRChhy');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `q_topic_id` (`topic_id`);

--
-- Indexes for table `sub_topics`
--
ALTER TABLE `sub_topics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `st_topic_id` (`topic_id`);

--
-- Indexes for table `topics`
--
ALTER TABLE `topics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `t_user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `sub_topics`
--
ALTER TABLE `sub_topics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `topics`
--
ALTER TABLE `topics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `q_topic_id` FOREIGN KEY (`topic_id`) REFERENCES `topics` (`id`);

--
-- Constraints for table `sub_topics`
--
ALTER TABLE `sub_topics`
  ADD CONSTRAINT `st_topic_id` FOREIGN KEY (`topic_id`) REFERENCES `topics` (`id`);

--
-- Constraints for table `topics`
--
ALTER TABLE `topics`
  ADD CONSTRAINT `t_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
