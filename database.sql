-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 10-Mar-2021 às 06:32
-- Versão do servidor: 10.4.17-MariaDB
-- versão do PHP: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `moviesinfo`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `request`
--

CREATE TABLE `request` (
  `RequestId` int(20) NOT NULL,
  `RequestUser` varchar(50) NOT NULL,
  `RequestTitle` varchar(100) NOT NULL,
  `RequestMessage` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `request`
--

INSERT INTO `request` (`RequestId`, `RequestUser`, `RequestTitle`, `RequestMessage`) VALUES
(3, 'andersonc96', 'Avengers: Endgame', 'Best Marvel film');

-- --------------------------------------------------------

--
-- Estrutura da tabela `userdata`
--

CREATE TABLE `userdata` (
  `UserId` int(50) NOT NULL,
  `Username` varchar(20) NOT NULL,
  `Pass` varchar(50) NOT NULL,
  `Fullname` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `userdata`
--

INSERT INTO `userdata` (`UserId`, `Username`, `Pass`, `Fullname`, `Email`, `status`) VALUES
(1, 'admin', 'admin', 'admin', 'admin@admin.com', 'admin'),
(23, 'AndersonC96', 'Batman', 'Anderson Cavalcante Barbosa', 'andersoncavalcantr96@hotmail.com', 'user');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `request`
--
ALTER TABLE `request`
  ADD PRIMARY KEY (`RequestId`);

--
-- Índices para tabela `userdata`
--
ALTER TABLE `userdata`
  ADD PRIMARY KEY (`UserId`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `request`
--
ALTER TABLE `request`
  MODIFY `RequestId` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `userdata`
--
ALTER TABLE `userdata`
  MODIFY `UserId` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
