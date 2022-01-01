-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 31-Dez-2021 às 23:40
-- Versão do servidor: 5.7.33
-- versão do PHP: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `forms`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `prova`
--

CREATE TABLE `prova` (
  `prova_id` int(11) NOT NULL,
  `resposta1` varchar(1) COLLATE utf8_bin NOT NULL,
  `resposta2` varchar(1) COLLATE utf8_bin NOT NULL,
  `resposta3` varchar(1) COLLATE utf8_bin NOT NULL,
  `resposta4` varchar(1) COLLATE utf8_bin NOT NULL,
  `resposta5` varchar(1) COLLATE utf8_bin NOT NULL,
  `resposta6` varchar(1) COLLATE utf8_bin NOT NULL,
  `resposta7` varchar(1) COLLATE utf8_bin NOT NULL,
  `resposta8` varchar(1) COLLATE utf8_bin NOT NULL,
  `resposta9` varchar(1) COLLATE utf8_bin NOT NULL,
  `resposta10` varchar(1) COLLATE utf8_bin NOT NULL,
  `id_user` varchar(11) COLLATE utf8_bin NOT NULL,
  `data_prova` varchar(16) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `prova`
--

INSERT INTO `prova` (`prova_id`, `resposta1`, `resposta2`, `resposta3`, `resposta4`, `resposta5`, `resposta6`, `resposta7`, `resposta8`, `resposta9`, `resposta10`, `id_user`, `data_prova`) VALUES
(3, 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', '', ''),
(4, 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', '', ''),
(5, 'B', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', '', ''),
(6, 'B', 'C', 'D', 'A', 'A', 'C', 'C', 'B', 'A', 'D', '', ''),
(7, 'A', 'B', 'C', 'D', 'A', 'B', 'C', 'D', 'D', 'B', '', ''),
(8, 'A', 'B', 'C', '', 'A', 'B', 'C', 'D', 'D', 'A', '', ''),
(9, 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'D', 'D', 'A', '', ''),
(10, 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'D', 'D', 'A', '', ''),
(11, 'A', 'A', 'A', '', 'A', 'A', 'A', 'D', 'D', 'A', '', ''),
(12, 'A', 'B', 'C', 'D', 'C', 'A', 'C', 'B', 'C', 'A', '', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(32) COLLATE utf8_bin NOT NULL,
  `email` varchar(254) COLLATE utf8_bin NOT NULL,
  `senha` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`) VALUES
(54, 'VinÃ­cius', 'vinicius.nevesco@gmail.com', '$2y$10$E4kuB8cMalAzqPrMpB/5V.8Hgjax5i5CJYHqls/AwJze82Cr48W8i'),
(55, 'Leonardo Cavalcanti', 'wokgame@hotmail.com', '$2y$10$rPEsH9Dry6prauEpWSnEcOVBewrNiItGOOzYJkHRDGvREWz2p0QCW'),
(56, 'JoÃ£o Victor', 'kjb43072@gmail.com', '$2y$10$Ii2M52KINbj7yWLZSeelU./1a99h44iIhu30mkmKg1/sBVR89dClm'),
(57, 'Italo Gaspar', 'gasparitalo@gmail.com', '$2y$10$uEaZ0wSHmLhfGgqR5tjneuycj6/mUORLybbzE2F6sb2UgFJ/Gr8DK'),
(58, 'Leandro Eduardo', 'mirai@gmail.com', '$2y$10$p7N/UZSCT6MWA2xeHkVxB.zdPyYYEsTVREPvOmag9R.kfWIk0J3da');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `prova`
--
ALTER TABLE `prova`
  ADD PRIMARY KEY (`prova_id`);

--
-- Índices para tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `prova`
--
ALTER TABLE `prova`
  MODIFY `prova_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;