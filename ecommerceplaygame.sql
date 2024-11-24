-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 24/11/2024 às 17:04
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `ecommerceplaygame`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) DEFAULT NULL,
  `cep` varchar(8) DEFAULT NULL,
  `isAdmin` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `clients`
--

INSERT INTO `clients` (`id`, `name`, `email`, `password_hash`, `cep`, `isAdmin`) VALUES
(1, 'Samuel', 'samuel@gmail.com', '123', '66812420', 0),
(4, 'Samuel', 'samuel2@gmail.com', '123', '66812420', 0),
(5, 'Luis', 'luis@gmail.com', '123', '66055420', 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `id_client` int(11) DEFAULT NULL,
  `id_product` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `TOTAL` decimal(10,2) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `cep` varchar(10) NOT NULL,
  `frete` decimal(10,2) DEFAULT NULL,
  `desconto` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `orders`
--

INSERT INTO `orders` (`id`, `id_client`, `id_product`, `quantity`, `TOTAL`, `payment_method`, `cep`, `frete`, `desconto`) VALUES
(1, 1, 1, 1, 0.00, 'PIX', '', NULL, 0.00),
(2, 1, 2, 2, 65.98, 'PIX', '', NULL, 0.00),
(3, 1, 2, 2, 65.98, 'PIX', '', NULL, 0.00),
(4, 1, 1, 1, 0.00, 'PIX', '', NULL, 0.00),
(5, 1, 2, 1, 32.99, 'PIX', '66055420', 30.00, 0.00),
(6, 1, 2, 2, 65.98, 'PIX', '66055420', 30.00, 0.00),
(7, 1, 2, 4, 131.96, 'PIX', '66055420', 20.00, 0.00),
(8, 1, 2, 1, 32.99, 'PIX', '66055420', 30.00, NULL),
(9, 1, 2, 4, 131.96, 'PIX', '66055420', 20.00, NULL),
(10, 1, 2, 4, 131.96, 'PIX', '66055420', 10.00, NULL),
(11, 1, 2, 1, 32.99, 'PIX', '66055420', 20.00, NULL),
(12, 1, 2, 4, 131.96, 'PIX', '66055420', 10.00, NULL),
(13, 1, 2, 4, 131.96, 'PIX', '66055420', 10.00, NULL),
(14, 1, 2, 4, 131.96, 'PIX', '66812420', 15.00, NULL),
(15, 1, 2, 5, 164.95, 'PIX', '66812420', 15.00, 5.00),
(16, 1, 2, 5, 164.95, 'PIX', '66055420', 10.00, 10.00),
(17, 1, 2, 4, 131.96, 'PIX', '66055420', 10.00, 10.00);

-- --------------------------------------------------------

--
-- Estrutura para tabela `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `NAME` varchar(255) NOT NULL,
  `DESCRIPTION` text NOT NULL,
  `PRICE` decimal(10,2) NOT NULL,
  `IMAGE` varchar(255) DEFAULT NULL,
  `quantity` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `products`
--

INSERT INTO `products` (`id`, `NAME`, `DESCRIPTION`, `PRICE`, `IMAGE`, `quantity`) VALUES
(1, 'Once Human', 'Once Human é um jogo multiplayer de sobrevivência em mundo aberto ambientado em um futuro estranho e pós-apocalíptico. Una-se a amigos para lutar contra inimigos monstruosos, desvendar conspirações secretas, competir por recursos e construir seu próprio território.', 0.00, 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/2139460/header.jpg?t=1732272303', 1),
(2, 'The Coffin of Andy and Leyley', 'Walk-n-talk adventure with light puzzling. Brother and sister practice cannibalism after witnessing a botched satanic ritual.', 32.99, 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/2378900/header.jpg?t=1715511135', 1);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Índices de tabela `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_client` (`id_client`),
  ADD KEY `id_product` (`id_product`);

--
-- Índices de tabela `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `NAME` (`NAME`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de tabela `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `ORDERS_ibfk_1` FOREIGN KEY (`id_client`) REFERENCES `clients` (`id`),
  ADD CONSTRAINT `ORDERS_ibfk_2` FOREIGN KEY (`id_product`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
