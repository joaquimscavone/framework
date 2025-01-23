-- Active: 1728497077532@@127.0.0.1@3306
-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 16-Dez-2023 às 20:35
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
-- Banco de dados: `pweb_restaurante`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `atendimentos`
--
DROP DATABASE IF EXISTS restaurante;
CREATE SCHEMA restaurante;
USE restaurante;
CREATE TABLE `atendimentos` (
  `id` int(10) UNSIGNED NOT NULL,
  `cliente_id` int(10) UNSIGNED DEFAULT NULL,
  `mesa` int(11) DEFAULT NULL COMMENT 'caso o antedimento seja presencial informe o número da mesa.',
  `pagamento_data` datetime DEFAULT NULL,
  `valor_desconto` float DEFAULT 0 COMMENT 'Será a soma de todos pedidos no momento do pagamento - a soma de todos os pagamentos. o dado será amarazenado para confirmar a ciência do operador de caixa que os valores não são correspondentes.',
  `taxa_servico` float DEFAULT 0,
  `criacao_data` datetime NOT NULL DEFAULT current_timestamp(),
  `alteracao_data` datetime DEFAULT NULL,
  `exclusao_data` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `atendimentos`
--


--
-- Estrutura da tabela `configs`
--

CREATE TABLE `configs` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `value` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='Armazena as constantes do sistema, exemplo: no da lanchonete, valor da taxa de serviço, se vai utilizar o modo de preparo.';

--
-- Extraindo dados da tabela `configs`
--

INSERT INTO `configs` (`id`, `name`, `value`) VALUES
(1, 'APPLICATION_URL', 'http://restaurante.test'),
(2, 'APPLICATION_NAME', 'RestauranteIF');

-- --------------------------------------------------------

--
-- Estrutura da tabela `logs`
--

CREATE TABLE `logs` (
  `id` bigint(19) UNSIGNED NOT NULL,
  `funcionario_id` int(10) UNSIGNED NULL,
  `tabela` varchar(100) NOT NULL COMMENT 'tabela que sofreu a alteração',
  `registro_id` bigint(20) NOT NULL COMMENT 'ID do registro que foi alterado nesta ação',
  `tipo_alteracao` enum('Insert','Update','Delete') NOT NULL,
  `dados_originais` text DEFAULT NULL,
  `novos_dados` text DEFAULT NULL,
  `exec_data` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `pagamentos`
--

CREATE TABLE `pagamentos` (
  `id` int(11) NOT NULL,
  `atendimento_id` int(10) UNSIGNED NOT NULL,
  `pagamento_tipo_id` int(11) NOT NULL,
  `valor` float NOT NULL,
  `observacao` varchar(200) DEFAULT NULL COMMENT 'Possível observação sobre o pagamento.',
  `criacao_data` datetime NOT NULL DEFAULT current_timestamp(),
  `alteracao_data` datetime DEFAULT NULL,
  `exclusao_data` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `pagamentos`


-- --------------------------------------------------------

--
-- Estrutura da tabela `pagamentos_tipos`
--

CREATE TABLE `pagamentos_tipos` (
  `id` int(11) NOT NULL,
  `descricao` varchar(100) NOT NULL,
  `criacao_data` datetime NOT NULL DEFAULT current_timestamp(),
  `alteracao_data` datetime DEFAULT NULL,
  `exclusao_data` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `pagamentos_tipos`
--

INSERT INTO `pagamentos_tipos` (`id`, `descricao`, `criacao_data`, `alteracao_data`, `exclusao_data`) VALUES
(1, 'Dinheiro', '2023-11-01 13:44:03', NULL, NULL),
(2, 'Cartão de Débito', '2023-11-01 13:44:03', NULL, NULL),
(3, 'Cartão de Crédito', '2023-11-01 13:44:03', NULL, NULL),
(4, 'PIX', '2023-11-01 13:44:03', NULL, NULL),
(5, 'Promoção da Loja', '2023-11-01 13:44:03', NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `atendimento_id` int(10) UNSIGNED NOT NULL,
  `produto_id` int(10) UNSIGNED NOT NULL,
  `quantidade` float NOT NULL DEFAULT 1,
  `valor_un` float NOT NULL COMMENT 'Valor do produto pedido no momento do pedido.',
  `situacao` enum('Pedido','Produção','Entrega','Entregue') NOT NULL DEFAULT 'Entregue' COMMENT 'enum(''Pedido'',''Produção'',''Entrega'',''Entregue'')\n',
  `saida_data` datetime DEFAULT NULL COMMENT 'Hora da saída do pedido da produção.',
  `entrega_data` datetime DEFAULT NULL COMMENT 'momento de recebimento do pedido pelo cliente',
  `criacao_data` datetime NOT NULL DEFAULT current_timestamp(),
  `alteracao_data` datetime DEFAULT NULL,
  `exclusao_data` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `pedidos`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `clientes`
--

CREATE TABLE `clientes` (
  `id` int(10) UNSIGNED NOT NULL,
  `nome` varchar(125) NOT NULL,
  `telefone` varchar(15) NOT NULL COMMENT '+5563984848484',
  `cpf` varchar(11) DEFAULT NULL,
  `rg` varchar(20) DEFAULT NULL,
  `rg_expedidor` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `criacao_data` datetime NOT NULL DEFAULT current_timestamp(),
  `alteracao_data` datetime DEFAULT NULL,
  `exclusao_data` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `clientes`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos`
--

CREATE TABLE `produtos` (
  `id` int(10) UNSIGNED NOT NULL,
  `nome` varchar(100) NOT NULL,
  `descricao` text NOT NULL,
  `valor_un` float NOT NULL COMMENT 'Armazena o valor de uma unidade do produto no momento atual.',
  `unidade_medida` enum('Unidade','Quilo','Grama') NOT NULL COMMENT 'unidade;\nQuilo;\ngrama;\n',
  `disponivel` tinyint(1) NOT NULL DEFAULT 1,
  `criacao_data` datetime NOT NULL DEFAULT current_timestamp(),
  `alteracao_data` datetime DEFAULT NULL,
  `exclusao_data` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `produtos`
--
-- --------------------------------------------------------

--
-- Estrutura da tabela `funcionarios`
--

CREATE TABLE `funcionarios` (
  `id` int(10) UNSIGNED NOT NULL,
  `nome` VARCHAR(125) NOT NULL,
  `telefone` VARCHAR(15) NULL DEFAULT NULL,
  `cpf` VARCHAR(11) NOT NULL,
  `rg` VARCHAR(20) NULL DEFAULT NULL,
  `rg_expedidor` VARCHAR(20) NULL DEFAULT NULL,
  `login` varchar(100) NOT NULL COMMENT 'Campo de login do nosso sistema.',
  `password` varchar(255) NOT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT 1,
  `email_confirmacao` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Armazena se o e-mail do usuário já foi confirmado.',
  `criacao_data` datetime DEFAULT current_timestamp(),
  `alteracao_data` datetime DEFAULT NULL,
  `exclusao_data` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `funcionarios`
--

INSERT INTO `funcionarios` (`id`,`nome`, `login`, `password`, `ativo`, `email_confirmacao`) VALUES
(1, 'root', 'root', '$2y$10$CGC6Z9qVN6SEJ0dSkenqju.EWW95B0VKnO3aUpa.FoBVad6tKojMW', 1, 0);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `atendimentos`
--
ALTER TABLE `atendimentos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_atendimentos_clientes1_idx` (`cliente_id`);

--
-- Índices para tabela `configs`
--
ALTER TABLE `configs`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_logs_funcionarios1_idx` (`funcionario_id`);

--
-- Índices para tabela `pagamentos`
--
ALTER TABLE `pagamentos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_lanchonete_forma_pagamento1_idx` (`pagamento_tipo_id`),
  ADD KEY `fk_lanchonete_atendimentos1_idx` (`atendimento_id`);

--
-- Índices para tabela `pagamentos_tipos`
--
ALTER TABLE `pagamentos_tipos`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pedidos_atendimentos1_idx` (`atendimento_id`),
  ADD KEY `fk_pedidos_produtos1_idx` (`produto_id`);

--
-- Índices para tabela `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `funcionarios`
--
ALTER TABLE `funcionarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cpf_UNIQUE` (`login`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `atendimentos`
--
ALTER TABLE `atendimentos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=202;

--
-- AUTO_INCREMENT de tabela `configs`
--
ALTER TABLE `configs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `logs`
--
ALTER TABLE `logs`
  MODIFY `id` bigint(19) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `pagamentos`
--
ALTER TABLE `pagamentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=231;

--
-- AUTO_INCREMENT de tabela `pagamentos_tipos`
--
ALTER TABLE `pagamentos_tipos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1001;

--
-- AUTO_INCREMENT de tabela `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=207;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT de tabela `funcionarios`
--
ALTER TABLE `funcionarios`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `atendimentos`
--
ALTER TABLE `atendimentos`
  ADD CONSTRAINT `fk_atendimentos_clientes1` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `logs`
--
ALTER TABLE `logs`
  ADD CONSTRAINT `fk_logs_funcionarios1` FOREIGN KEY (`funcionario_id`) REFERENCES `funcionarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `pagamentos`
--
ALTER TABLE `pagamentos`
  ADD CONSTRAINT `fk_lanchonete_atendimentos1` FOREIGN KEY (`atendimento_id`) REFERENCES `atendimentos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_lanchonete_forma_pagamento1` FOREIGN KEY (`pagamento_tipo_id`) REFERENCES `pagamentos_tipos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `fk_pedidos_atendimentos1` FOREIGN KEY (`atendimento_id`) REFERENCES `atendimentos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_pedidos_produtos1` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `funcionarios`
--

create view consumos as
select at.id as atendimento_id, 
    (select round(sum(ped.valor_un * ped.quantidade),2)
    from pedidos as ped where ped.atendimento_id = at.id) 
    as valor_pedidos,
at.taxa_servico, 
at.valor_desconto,
(select round(sum(pag.valor),2) 
from pagamentos as pag where pag.atendimento_id = at.id) as valor_pago,
at.pagamento_data
from atendimentos as at;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
