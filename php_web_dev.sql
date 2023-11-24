-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 24, 2023 at 03:21 PM
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
-- Database: `php_web_dev`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_admin.clientes`
--

CREATE TABLE `tb_admin.clientes` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `tipo` varchar(15) NOT NULL,
  `inscricao` varchar(100) NOT NULL,
  `imagem` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_admin.clientes`
--

INSERT INTO `tb_admin.clientes` (`id`, `nome`, `email`, `tipo`, `inscricao`, `imagem`) VALUES
(1, 'WimFin', 'e-mail@gmail.com', 'fisico', '000.000.000-00', NULL),
(2, 'WimFin', 'e-mail@gmail.com', 'juridico', '00.000.000/0-00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_admin.clientes-financeiro`
--

CREATE TABLE `tb_admin.clientes-financeiro` (
  `id` int(11) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `valor` varchar(255) NOT NULL,
  `parcelas` int(10) NOT NULL,
  `vencimento` date NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_admin.clientes-financeiro`
--

INSERT INTO `tb_admin.clientes-financeiro` (`id`, `cliente_id`, `nome`, `valor`, `parcelas`, `vencimento`, `status`) VALUES
(1, 1, 'pagamento demo', '30.00', 3, '2023-11-30', 0),
(2, 1, 'pagamento demo', '30.00', 3, '2023-12-30', 0),
(3, 1, 'pagamento demo', '30.00', 3, '2024-01-30', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_admin.empreendimentos`
--

CREATE TABLE `tb_admin.empreendimentos` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `tipo` varchar(15) NOT NULL,
  `preco` varchar(25) NOT NULL,
  `imagem` varchar(255) NOT NULL,
  `order_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_admin.empreendimentos`
--

INSERT INTO `tb_admin.empreendimentos` (`id`, `nome`, `tipo`, `preco`, `imagem`, `order_id`) VALUES
(1, 'WimFin', 'residencial', '1.111.111,11', '655e0e2f181de.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_admin.estoque`
--

CREATE TABLE `tb_admin.estoque` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `descricao` text NOT NULL,
  `largura` varchar(20) NOT NULL,
  `altura` varchar(20) NOT NULL,
  `comprimento` varchar(20) NOT NULL,
  `peso` varchar(20) NOT NULL,
  `quantidade` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_admin.estoque`
--

INSERT INTO `tb_admin.estoque` (`id`, `nome`, `descricao`, `largura`, `altura`, `comprimento`, `peso`, `quantidade`) VALUES
(3, 'produto 1', '<p>produto 1</p>', '5', '10', '15', '20', 25),
(4, 'produto 1', '<p>produto 1</p>', '5', '10', '15', '20', 25);

-- --------------------------------------------------------

--
-- Table structure for table `tb_admin.estoque_imagens`
--

CREATE TABLE `tb_admin.estoque_imagens` (
  `id` int(11) NOT NULL,
  `produto_id` int(11) NOT NULL,
  `imagem` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_admin.estoque_imagens`
--

INSERT INTO `tb_admin.estoque_imagens` (`id`, `produto_id`, `imagem`) VALUES
(1, 3, '655e0bd3ebdf5.png'),
(2, 4, '655e0c1f0a00a.png'),
(3, 3, '655e0c63877dc.png');

-- --------------------------------------------------------

--
-- Table structure for table `tb_admin.imoveis`
--

CREATE TABLE `tb_admin.imoveis` (
  `id` int(11) NOT NULL,
  `empreendimento_id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `preco` varchar(20) NOT NULL,
  `area` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_admin.imoveis`
--

INSERT INTO `tb_admin.imoveis` (`id`, `empreendimento_id`, `nome`, `preco`, `area`) VALUES
(2, 1, 'produto 1', '111111111.11', '1111'),
(3, 1, 'produto 2', '22222.22', '222');

-- --------------------------------------------------------

--
-- Table structure for table `tb_admin.imoveis_imagens`
--

CREATE TABLE `tb_admin.imoveis_imagens` (
  `id` int(11) NOT NULL,
  `imovel_id` int(10) NOT NULL,
  `imagem` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_admin.imoveis_imagens`
--

INSERT INTO `tb_admin.imoveis_imagens` (`id`, `imovel_id`, `imagem`) VALUES
(1, 2, '655e0feb966c1.png'),
(2, 3, '655e10130cd80.png'),
(3, 3, '655f646dafc67.jpg'),
(4, 3, '655f646db02f2.jpg'),
(5, 3, '655f646db0727.png');

-- --------------------------------------------------------

--
-- Table structure for table `tb_admin.online`
--

CREATE TABLE `tb_admin.online` (
  `id` int(11) NOT NULL,
  `ip` varchar(30) NOT NULL,
  `ultima_acao` datetime NOT NULL,
  `token` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_admin.online`
--

INSERT INTO `tb_admin.online` (`id`, `ip`, `ultima_acao`, `token`) VALUES
(1, '::1', '2023-11-17 16:03:17', 655780),
(2, '::1', '2023-11-17 16:05:41', 65578145),
(3, '::1', '2023-11-23 20:47:06', 655),
(320, '::1', '2023-11-22 21:48:58', 2147483647),
(322, '::1', '2023-11-24 12:46:17', 65608),
(323, '::1', '2023-11-24 15:18:40', 6560),
(324, '::1', '2023-11-24 15:18:40', 6560);

-- --------------------------------------------------------

--
-- Table structure for table `tb_admin.users`
--

CREATE TABLE `tb_admin.users` (
  `id` int(11) NOT NULL,
  `user` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `avatar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_admin.users`
--

INSERT INTO `tb_admin.users` (`id`, `user`, `password`, `name`, `role`, `avatar`) VALUES
(1, 'admin', 'admin', 'Administrator', '2', '');

-- --------------------------------------------------------

--
-- Table structure for table `tb_admin.visits`
--

CREATE TABLE `tb_admin.visits` (
  `id` int(11) NOT NULL,
  `ip` varchar(30) NOT NULL,
  `day` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_admin.visits`
--

INSERT INTO `tb_admin.visits` (`id`, `ip`, `day`) VALUES
(1, '::1', '2023-11-19'),
(2, '::1', '2023-11-21'),
(3, '::1', '2023-11-21'),
(4, '::1', '2023-11-21'),
(5, '::1', '2023-11-21'),
(6, '::1', '2023-11-22'),
(7, '::1', '2023-11-22'),
(8, '::1', '2023-11-24');

-- --------------------------------------------------------

--
-- Table structure for table `tb_site.depoimentos`
--

CREATE TABLE `tb_site.depoimentos` (
  `id` int(11) NOT NULL,
  `autor` varchar(255) NOT NULL,
  `conteudo` text NOT NULL,
  `date` date NOT NULL,
  `order_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_site.depoimentos`
--

INSERT INTO `tb_site.depoimentos` (`id`, `autor`, `conteudo`, `date`, `order_id`) VALUES
(1, 'Depoimento 2', '<p>depoimento simples 2</p>', '2023-11-22', 2),
(2, 'Depoimento 1', '<p>depoimento simples</p>', '2023-11-22', 3),
(3, 'depoimento 3', '<p>depoimento simples 3</p>', '2023-11-23', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_site.home`
--

CREATE TABLE `tb_site.home` (
  `id` int(11) NOT NULL,
  `pagetitle` varchar(255) NOT NULL,
  `pagedescription` varchar(255) NOT NULL,
  `logotitle` varchar(255) NOT NULL,
  `mailtitle` varchar(255) NOT NULL,
  `authorname` varchar(255) NOT NULL,
  `authordescription` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_site.home`
--

INSERT INTO `tb_site.home` (`id`, `pagetitle`, `pagedescription`, `logotitle`, `mailtitle`, `authorname`, `authordescription`) VALUES
(1, 'PHP_Web_dev', '<p>Hello there</p>', '..', 'website Header', 'Adriaan Willem', '<p>Descri&ccedil;&atilde;o do author nada creativa.</p>');

-- --------------------------------------------------------

--
-- Table structure for table `tb_site.service`
--

CREATE TABLE `tb_site.service` (
  `id` int(11) NOT NULL,
  `service` text NOT NULL,
  `order_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_site.service`
--

INSERT INTO `tb_site.service` (`id`, `service`, `order_id`) VALUES
(1, '<p>servi&ccedil;o 1</p>', 3),
(2, '<p>serviço 2</p>', 2),
(3, '<p>Servi&ccedil;o 3</p>', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_site.slide`
--

CREATE TABLE `tb_site.slide` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `path` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `order_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_site.slide`
--

INSERT INTO `tb_site.slide` (`id`, `name`, `path`, `description`, `order_id`) VALUES
(3, '1 slide', '655e7127e8c0f.png', '1 slide', 1),
(4, 'slide 2', '655fa75860436.jpg', '2 slide', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_admin.clientes`
--
ALTER TABLE `tb_admin.clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_admin.clientes-financeiro`
--
ALTER TABLE `tb_admin.clientes-financeiro`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_admin.empreendimentos`
--
ALTER TABLE `tb_admin.empreendimentos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_admin.estoque`
--
ALTER TABLE `tb_admin.estoque`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_admin.estoque_imagens`
--
ALTER TABLE `tb_admin.estoque_imagens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_admin.imoveis`
--
ALTER TABLE `tb_admin.imoveis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_admin.imoveis_imagens`
--
ALTER TABLE `tb_admin.imoveis_imagens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_admin.online`
--
ALTER TABLE `tb_admin.online`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `tb_admin.users`
--
ALTER TABLE `tb_admin.users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_admin.visits`
--
ALTER TABLE `tb_admin.visits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_site.depoimentos`
--
ALTER TABLE `tb_site.depoimentos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_site.home`
--
ALTER TABLE `tb_site.home`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_site.service`
--
ALTER TABLE `tb_site.service`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_site.slide`
--
ALTER TABLE `tb_site.slide`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_admin.clientes`
--
ALTER TABLE `tb_admin.clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_admin.clientes-financeiro`
--
ALTER TABLE `tb_admin.clientes-financeiro`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tb_admin.empreendimentos`
--
ALTER TABLE `tb_admin.empreendimentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_admin.estoque`
--
ALTER TABLE `tb_admin.estoque`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tb_admin.estoque_imagens`
--
ALTER TABLE `tb_admin.estoque_imagens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_admin.imoveis`
--
ALTER TABLE `tb_admin.imoveis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_admin.imoveis_imagens`
--
ALTER TABLE `tb_admin.imoveis_imagens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tb_admin.online`
--
ALTER TABLE `tb_admin.online`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=325;

--
-- AUTO_INCREMENT for table `tb_admin.users`
--
ALTER TABLE `tb_admin.users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_admin.visits`
--
ALTER TABLE `tb_admin.visits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tb_site.depoimentos`
--
ALTER TABLE `tb_site.depoimentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_site.home`
--
ALTER TABLE `tb_site.home`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_site.service`
--
ALTER TABLE `tb_site.service`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_site.slide`
--
ALTER TABLE `tb_site.slide`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
