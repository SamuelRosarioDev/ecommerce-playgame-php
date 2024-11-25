-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 25/11/2024 às 20:24
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
(1, 'Black Myth: Wukong', 'O jogo reimagina a história de Sun Wukong, explorando novos aspectos de sua jornada e apresentando personagens e criaturas míticas familiares aos fãs da obra original. A narrativa é rica e envolvente, mesclando elementos da mitologia chinesa com elementos de fantasia e ação.', 229.99, 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/2358720/header.jpg?t=1732286900', 1),
(2, 'The Coffin of Andy and Leyley', 'The Coffin of Andy and Leyley é um jogo de terror psicológico e comédia desenvolvido pela Nemlei e publicado pela Kit9 Studio. O jogo segue a história dos irmãos gêmeos Andrew “Andy” Graves e Ashley “Leyley” Graves, que estão confinados em um apartamento imundo devido a um aviso de quarentena do governo sobre uma infecção transmitida pela água.', 32.99, 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/2378900/header.jpg?t=1715511135', 1),
(3, 'Grand Theft Auto V', 'A história de GTA V gira em torno de três protagonistas: Michael, Trevor e Franklin, cada um com suas próprias personalidades e motivações. O jogo alterna entre as perspectivas desses personagens, permitindo que você experimente diferentes estilos de jogo e explore a história sob ângulos variados.\r\n\r\n', 82.41, 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/271590/header.jpg?t=1726606628', 1),
(4, 'ELDEN RING', 'Ambientado em um mundo aberto e vasto chamado Terras Intermédias, Elden Ring conta a história de um mundo quebrado após a fragmentação do Anel Elden. O jogador assume o papel de um Tarnished, um exilado que retorna para as Terras Intermédias com o objetivo de se tornar o Elden Lord, reunindo os fragmentos do Anel Elden e restaurando a ordem ao mundo.', 229.90, 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/1245620/header.jpg?t=1726158298', 1),
(5, 'Buckshot Roulette', 'Buckshot Roulette é um jogo que te transporta para o selvagem oeste, onde a adrenalina e o perigo caminham lado a lado. A premissa do jogo é simples, mas viciante: você precisa girar um revólver carregado com uma única bala e puxar o gatilho, tudo em um ambiente caótico e cheio de desafios.', 9.99, 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/2835570/header_alt_assets_0_brazilian.jpg?t=1731742454', 1),
(6, 'Fobia - St. Dinfna Hotel', 'Fobia - St. Dinfna Hotel é um jogo de terror psicológico em primeira pessoa que te leva para uma jornada arrepiante em um hotel abandonado no Brasil. A trama gira em torno de Roberto Leite Lopes, um jornalista amador que viaja até Santa Catarina para investigar rumores sobre desaparecimentos misteriosos e atividades paranormais no Hotel St. Dinfna.', 57.99, 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/1298140/header.jpg?t=1725487910', 1),
(7, 'Call of Duty®: Black Ops 6\r\n', 'Call of Duty®: Black Ops 6 é a mais recente adição à aclamada franquia Black Ops, trazendo a ação frenética e a narrativa envolvente que os fãs amam. Desenvolvido pela Treyarch e Raven Software, o jogo promete uma experiência épica, com uma campanha solo emocionante, um multijogador competitivo e o retorno do popular modo Zumbis.', 339.00, 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/2933620/header.jpg?t=1731604753', 1),
(8, 'Watch Dogs®: Legion\r\n', 'Watch Dogs: Legion é um jogo de mundo aberto que te coloca no controle de uma resistência digital em uma Londres pós-Brexit, onde a vigilância é extrema e a liberdade individual está em risco. Uma das características mais marcantes do jogo é a possibilidade de recrutar praticamente qualquer pessoa que você encontrar nas ruas para se juntar à sua causa.\r\n\r\n', 249.99, 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/2239550/header.jpg?t=1716280027', 1);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

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
