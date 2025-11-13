-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 13-Nov-2025 às 06:13
-- Versão do servidor: 10.4.19-MariaDB
-- versão do PHP: 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `web_app`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `eventos`
--

CREATE TABLE `eventos` (
  `id_evento` int(11) NOT NULL,
  `nome` varchar(120) NOT NULL,
  `descricao` varchar(500) NOT NULL,
  `local` varchar(200) NOT NULL,
  `data` date NOT NULL,
  `hora` time NOT NULL,
  `capacidade` decimal(6,0) DEFAULT NULL,
  `imagem` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `eventos`
--

INSERT INTO `eventos` (`id_evento`, `nome`, `descricao`, `local`, `data`, `hora`, `capacidade`, `imagem`) VALUES
(1, 'Aniversário Daiane', 's5edrftugih', 'Rua Inocêncio Claudino Barbosa, Cidade Morumbi', '2026-05-12', '15:22:00', '55', '\\\"D:\\\\BKP PC ANA MADRINHA\\\\Meu Disco\\\\ana\\\\DSC02450.JPG\\\"');

-- --------------------------------------------------------

--
-- Estrutura da tabela `reservas`
--

CREATE TABLE `reservas` (
  `id_reserva` int(11) NOT NULL,
  `login` varchar(40) NOT NULL,
  `id_evento` int(11) NOT NULL,
  `status` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `reservas`
--

INSERT INTO `reservas` (`id_reserva`, `login`, `id_evento`, `status`) VALUES
(1, 'erik@gmail.com', 1, 'C');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `login` varchar(40) NOT NULL,
  `senha` varchar(100) NOT NULL,
  `nome` varchar(120) NOT NULL,
  `tipo` char(1) NOT NULL,
  `quant_acesso` int(11) NOT NULL,
  `status` char(1) NOT NULL,
  `primeiro_acesso` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`login`, `senha`, `nome`, `tipo`, `quant_acesso`, `status`, `primeiro_acesso`) VALUES
('ana@gmail.com', '123456789', 'Ana', '0', 5, 'A', 0),
('anderson@gmail.com', 'andersonroberto', 'Anderson', '1', 1, 'A', 0),
('arthurmigs@gmail.com', 'evpnd', 'Arthur', '0', 18, 'A', 0),
('bruna@gmail.com', '$2y$10$GNSIpZsWBO8pplSbP6GIdOG5tZDszo85yXXKncIHjfsvKVLJmlT2K', 'Bruna', '1', 0, 'A', 1),
('daianeksilva07@gmail.com', '123456', 'Daiane', '0', 5, 'A', 0),
('erik@gmail.com', '123456789', 'Erik', '1', 30, 'A', 0),
('larissa@gmail.com', '$2y$10$5.3jEgLCHXISFhXopGmreenyb9Dlh53oQomqRXMV/tJMPWjS/3aeu', 'Larissa', '1', 0, 'A', 1);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `eventos`
--
ALTER TABLE `eventos`
  ADD PRIMARY KEY (`id_evento`);

--
-- Índices para tabela `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`id_reserva`),
  ADD KEY `login` (`login`),
  ADD KEY `id_evento` (`id_evento`);

--
-- Índices para tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`login`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `eventos`
--
ALTER TABLE `eventos`
  MODIFY `id_evento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `reservas`
--
ALTER TABLE `reservas`
  MODIFY `id_reserva` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `reservas`
--
ALTER TABLE `reservas`
  ADD CONSTRAINT `reservas_ibfk_1` FOREIGN KEY (`login`) REFERENCES `usuarios` (`login`),
  ADD CONSTRAINT `reservas_ibfk_2` FOREIGN KEY (`id_evento`) REFERENCES `eventos` (`id_evento`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
