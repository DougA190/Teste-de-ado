-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 12-Maio-2023 às 05:59
-- Versão do servidor: 10.4.27-MariaDB
-- versão do PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `4tech`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `clientes`
--

CREATE TABLE `clientes` (
  `id` int(10) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `sobrenome` varchar(200) NOT NULL,
  `cpf` varchar(15) NOT NULL,
  `dataNascimento` varchar(11) NOT NULL,
  `genero` varchar(20) NOT NULL,
  `ddd_celular` varchar(2) NOT NULL,
  `num_celular` varchar(10) NOT NULL,
  `ddd_telefone` varchar(2) NOT NULL,
  `num_telefone` varchar(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `clientes`
--

INSERT INTO `clientes` (`id`, `nome`, `sobrenome`, `cpf`, `dataNascimento`, `genero`, `ddd_celular`, `num_celular`, `ddd_telefone`, `num_telefone`) VALUES
(1, 'João gomes', 'Vilanir de Melo', '111.111.111-11', '2001-10-05', 'Masculino', '11', '95355-3207', '11', '4245-8911');

-- --------------------------------------------------------

--
-- Estrutura da tabela `enderecos_de_cobranca`
--

CREATE TABLE `enderecos_de_cobranca` (
  `id` int(10) NOT NULL,
  `cep` varchar(9) NOT NULL,
  `logradouro` varchar(200) NOT NULL,
  `numero_endereco` int(10) NOT NULL,
  `complemento` varchar(50) NOT NULL,
  `bairro` varchar(100) NOT NULL,
  `cidade` varchar(50) NOT NULL,
  `uf` varchar(2) NOT NULL,
  `cliente_id` int(10) DEFAULT NULL,
  `status` enum('principal','secundario','inativo') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `enderecos_de_cobranca`
--

INSERT INTO `enderecos_de_cobranca` (`id`, `cep`, `logradouro`, `numero_endereco`, `complemento`, `bairro`, `cidade`, `uf`, `cliente_id`, `status`) VALUES
(1, '00000-000', 'Rua Indefinida', 11, 'Casa 2', 'Pedreira', 'São Paulo', 'SP', 1, 'secundario'),
(3, '06824-240', 'Rua erval seco', 25, 'Casa 1', 'Jardim da luz', 'Embu das Artes', 'PB', 1, 'principal'),
(4, '06824-241', 'Rua seca', 250, 'Casa 1', 'Jardim da luz', 'São paulo', 'PE', 1, 'secundario');

-- --------------------------------------------------------

--
-- Estrutura da tabela `enderecos_de_entrega`
--

CREATE TABLE `enderecos_de_entrega` (
  `id` int(10) NOT NULL,
  `cep` varchar(9) NOT NULL,
  `logradouro` varchar(200) NOT NULL,
  `numero_endereco` int(10) NOT NULL,
  `complemento` varchar(50) DEFAULT NULL,
  `bairro` varchar(100) NOT NULL,
  `cidade` varchar(50) NOT NULL,
  `uf` varchar(2) NOT NULL,
  `cliente_id` int(10) DEFAULT NULL,
  `status` enum('principal','secundario','inativo') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `enderecos_de_entrega`
--

INSERT INTO `enderecos_de_entrega` (`id`, `cep`, `logradouro`, `numero_endereco`, `complemento`, `bairro`, `cidade`, `uf`, `cliente_id`, `status`) VALUES
(1, '00000-000', 'Rua Indefinida', 12, 'Casa 2', 'Pedreira', 'São Paulo', 'SP', 1, 'principal'),
(20, '06824-240', 'Rua erval seco', 25, 'Casa 1', 'Jardim da luz', 'Embu das Artes', 'SP', 1, 'secundario'),
(21, '00000-00', 'Rua muller', 12, 'Casa 1', 'Jardim da luz', 'Embu das Artes', 'CE', 1, 'secundario'),
(24, '00000-000', 'rua carazinho', 110, 'Casa 1', 'Jardim da luz', 'São paulo', 'SP', 1, 'secundario');

-- --------------------------------------------------------

--
-- Estrutura da tabela `grupos_de_usuario`
--

CREATE TABLE `grupos_de_usuario` (
  `id` int(10) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `status` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `grupos_de_usuario`
--

INSERT INTO `grupos_de_usuario` (`id`, `nome`, `status`) VALUES
(1, 'administrador', 1),
(2, 'estoquista', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `imagens_produtos`
--

CREATE TABLE `imagens_produtos` (
  `id_img` int(11) NOT NULL,
  `imagem` varchar(100) NOT NULL,
  `id_produto` int(100) NOT NULL,
  `isprincipal` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `imagens_produtos`
--

INSERT INTO `imagens_produtos` (`id_img`, `imagem`, `id_produto`, `isprincipal`) VALUES
(1, 'celular-motorola-moto-g22-xt2231-1-128gb-azul-5157.jpg', 1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `produto`
--

CREATE TABLE `produto` (
  `id` int(10) NOT NULL,
  `codigo` varchar(50) NOT NULL,
  `nome_produto` varchar(100) DEFAULT NULL,
  `avaliacao` varchar(10) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `descricao` varchar(2000) DEFAULT NULL,
  `preco` varchar(100) DEFAULT NULL,
  `qtd_estoque` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `produto`
--

INSERT INTO `produto` (`id`, `codigo`, `nome_produto`, `avaliacao`, `status`, `descricao`, `preco`, `qtd_estoque`) VALUES
(1, '845215', 'sadfsfddsfds', '3.5', 1, '\'dfsfsd', '2000', '215415');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios_backoffice`
--

CREATE TABLE `usuarios_backoffice` (
  `id` int(10) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `cpf` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(200) NOT NULL,
  `status` int(1) DEFAULT NULL,
  `grupo_usuario_id` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `usuarios_backoffice`
--

INSERT INTO `usuarios_backoffice` (`id`, `nome`, `cpf`, `email`, `senha`, `status`, `grupo_usuario_id`) VALUES
(1, 'administrador', '111.111.111-11', 'administrador@gmail.com', '25d55ad283aa400af464c76d713c07ad', 1, 1),
(2, 'estoquista', '111.111.111-11', 'estoquista@gmail.com', '25d55ad283aa400af464c76d713c07ad', 1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios_clientes`
--

CREATE TABLE `usuarios_clientes` (
  `id` int(10) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(200) NOT NULL,
  `cliente_id` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `usuarios_clientes`
--

INSERT INTO `usuarios_clientes` (`id`, `email`, `senha`, `cliente_id`) VALUES
(1, 'joao@gmail.com.br', '25d55ad283aa400af464c76d713c07ad', 1);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cpf` (`cpf`);

--
-- Índices para tabela `enderecos_de_cobranca`
--
ALTER TABLE `enderecos_de_cobranca`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_enderecos_de_cobranca_clientes` (`cliente_id`);

--
-- Índices para tabela `enderecos_de_entrega`
--
ALTER TABLE `enderecos_de_entrega`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_enderecos_de_entrega_clientes` (`cliente_id`);

--
-- Índices para tabela `grupos_de_usuario`
--
ALTER TABLE `grupos_de_usuario`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `imagens_produtos`
--
ALTER TABLE `imagens_produtos`
  ADD PRIMARY KEY (`id_img`),
  ADD KEY `fk_imagens_produtos_id_produto` (`id_produto`);

--
-- Índices para tabela `produto`
--
ALTER TABLE `produto`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `usuarios_backoffice`
--
ALTER TABLE `usuarios_backoffice`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_grupos_usuarios` (`grupo_usuario_id`);

--
-- Índices para tabela `usuarios_clientes`
--
ALTER TABLE `usuarios_clientes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_usuarios_clientes` (`cliente_id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `enderecos_de_cobranca`
--
ALTER TABLE `enderecos_de_cobranca`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `enderecos_de_entrega`
--
ALTER TABLE `enderecos_de_entrega`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de tabela `grupos_de_usuario`
--
ALTER TABLE `grupos_de_usuario`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `imagens_produtos`
--
ALTER TABLE `imagens_produtos`
  MODIFY `id_img` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `produto`
--
ALTER TABLE `produto`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `usuarios_backoffice`
--
ALTER TABLE `usuarios_backoffice`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `usuarios_clientes`
--
ALTER TABLE `usuarios_clientes`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `enderecos_de_cobranca`
--
ALTER TABLE `enderecos_de_cobranca`
  ADD CONSTRAINT `fk_enderecos_de_cobranca_clientes` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`);

--
-- Limitadores para a tabela `enderecos_de_entrega`
--
ALTER TABLE `enderecos_de_entrega`
  ADD CONSTRAINT `fk_enderecos_de_entrega_clientes` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`);

--
-- Limitadores para a tabela `imagens_produtos`
--
ALTER TABLE `imagens_produtos`
  ADD CONSTRAINT `fk_imagens_produtos_id_produto` FOREIGN KEY (`id_produto`) REFERENCES `produto` (`id`);

--
-- Limitadores para a tabela `usuarios_backoffice`
--
ALTER TABLE `usuarios_backoffice`
  ADD CONSTRAINT `fk_grupos_usuarios` FOREIGN KEY (`grupo_usuario_id`) REFERENCES `grupos_de_usuario` (`id`);

--
-- Limitadores para a tabela `usuarios_clientes`
--
ALTER TABLE `usuarios_clientes`
  ADD CONSTRAINT `fk_usuarios_clientes` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
