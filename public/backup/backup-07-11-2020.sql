set foreign_key_checks=0;


#
# //Criação da Tabela : tb_categoria
#

CREATE TABLE `tb_categoria` (
  `cat_codigo` int NOT NULL AUTO_INCREMENT,
  `cat_descricao` varchar(30) NOT NULL,
  PRIMARY KEY (`cat_codigo`),
  UNIQUE KEY `cat_descricao` (`cat_descricao`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci ;

#
# //Dados a serem incluídos na tabela
#


#
# //Criação da Tabela : tb_contatos
#

CREATE TABLE `tb_contatos` (
  `cont_codigo` int NOT NULL AUTO_INCREMENT,
  `cont_tipo` varchar(30) NOT NULL,
  `cont_responsavel` varchar(30) NOT NULL,
  `cont_contato` varchar(80) NOT NULL,
  `pess_codigo` int NOT NULL,
  PRIMARY KEY (`cont_codigo`),
  KEY `fk_tb_contatos` (`pess_codigo`),
  CONSTRAINT `fk_tb_contatos` FOREIGN KEY (`pess_codigo`) REFERENCES `tb_pessoas` (`pess_codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci ;

#
# //Dados a serem incluídos na tabela
#

INSERT INTO tb_contatos VALUES('1', 'Celular', 'Vitor', '19996258494', '1')
,('2', 'Telefone', 'Casa', '1934588481', '1')
;

#
# //Criação da Tabela : tb_eventos
#

CREATE TABLE `tb_eventos` (
  `even_codigo` int NOT NULL AUTO_INCREMENT,
  `even_titulo` varchar(30) NOT NULL,
  `even_cor` char(7) DEFAULT NULL,
  `even_status` char(1) NOT NULL,
  `even_datahorai` datetime NOT NULL,
  `even_datahoraf` datetime NOT NULL,
  `even_observacao` varchar(510) DEFAULT NULL,
  `orca_numero` int NOT NULL,
  PRIMARY KEY (`even_codigo`),
  UNIQUE KEY `even_datahorai` (`even_datahorai`,`even_datahoraf`),
  KEY `fk_tb_eventos` (`orca_numero`),
  CONSTRAINT `fk_tb_eventos` FOREIGN KEY (`orca_numero`) REFERENCES `tb_orcamento` (`orca_numero`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci ;

#
# //Dados a serem incluídos na tabela
#

INSERT INTO tb_eventos VALUES('1', 'Realizar Orçamento', '', 'P', '2020-10-15 08:00:00', '2020-10-15 09:30:00', 'Ir de máscara', '1')
,('2', 'Realizar Orçamento', '', 'P', '2020-10-15 13:00:00', '2020-10-15 14:00:00', '', '2')
,('3', 'Realizar Orçamento', '', 'P', '2020-10-19 09:30:00', '2020-10-19 10:00:00', '', '3')
,('4', 'Realizar Orçamento', '', 'P', '2020-11-06 08:00:00', '2020-11-06 10:00:00', 'Colégio Politec, falar com Cláudio.', '4')
,('5', 'Realizar Orçamento', '#28A745', 'R', '2020-11-09 10:07:00', '2020-11-09 12:11:00', 'Checagem de  obra', '5')
,('6', 'Voltar na Obra', '', 'P', '2020-11-09 08:30:00', '2020-11-09 11:30:00', 'Cliente muito chato', '4')
,('7', 'Início de Obra', '#28A745', 'R', '2020-11-07 08:00:00', '2020-11-07 16:30:00', 'Obra em estágio inicial ', '1')
,('8', 'Realizar Orçamento', '', 'P', '2020-11-10 11:00:00', '2020-11-10 13:00:00', '', '6')
,('9', 'Realizar Orçamento', '', 'P', '2020-10-30 15:00:00', '2020-10-30 16:00:00', '', '7')
;

#
# //Criação da Tabela : tb_orcamento
#

CREATE TABLE `tb_orcamento` (
  `orca_numero` int NOT NULL AUTO_INCREMENT,
  `orca_nome` varchar(80) NOT NULL,
  `orca_sobrenome` varchar(80) NOT NULL,
  `orca_tel` varchar(15) DEFAULT NULL,
  `orca_cel` varchar(15) DEFAULT NULL,
  `orca_email` varchar(100) DEFAULT NULL,
  `orca_logradouro` varchar(80) DEFAULT NULL,
  `orca_log_numero` varchar(10) DEFAULT NULL,
  `orca_bairro` varchar(80) DEFAULT NULL,
  `orca_cidade` varchar(30) DEFAULT NULL,
  `orca_estado` char(2) DEFAULT NULL,
  `orca_cep` varchar(8) NOT NULL,
  `orca_edificio` varchar(80) DEFAULT NULL,
  `orca_bloco` varchar(30) DEFAULT NULL,
  `orca_apartamento` varchar(10) DEFAULT NULL,
  `orca_logradouro_condominio` varchar(80) DEFAULT NULL,
  `orca_observacao` varchar(510) DEFAULT NULL,
  PRIMARY KEY (`orca_numero`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci ;

#
# //Dados a serem incluídos na tabela
#

INSERT INTO tb_orcamento VALUES('1', 'Levi', 'Mateus Henrique Dias', '1926412152', '19994563759', 'levimateushenriquedias-97@gripoantonin.com', 'Rua da Lealdade', '118', 'Jardim Paz', 'Americana', 'SP', '13470471', '', '', '', '', '')
,('2', 'Calebe', 'Victor Renato da Silva', '1925422703', '19986918036', 'ccalebevictorrenatodasilva@unitau.com.br', 'Rua Luiz Mazoli', '825', 'Vila Mariana', 'Americana', 'SP', '13473381', '', '', '', '', '')
,('3', 'Rita', 'Bianca Peixoto', '1937643686', '19998175047', 'rritabiancapeixoto@cmfcequipamentos.com.br', 'Rua Arkansas', '352', 'Jardim Dona Judith', 'Americana', 'SP', '13469162', '', '', '', '', '')
,('4', 'Jaime', 'Alfredo Klava', '1934067273', '', 'compras@colegiopolitec.com.br', 'Avenida Brasil', '2000', 'Vila Santo Antônio', 'Americana', 'SP', '13465770', '', '', '', '', '')
,('5', 'João Cliente', 'Silva', '1934588081', '19999446148', 'Joaomarcoslopes12@gmail.com', 'Rua Ferdinando Mollon', '491', 'Vila Mollon IV', 'Santa Bárbara D\'Oeste', 'SP', '13456595', '', '', '', '', '')
,('6', 'João Marcos', 'Lopes', '1999944614', '19999446148', 'matheusvictor5019@gmail.com', 'Rua Gregório Sacoman', '1002', 'Parque São Jerônimo', 'Americana', 'SP', '13469660', '', '', '', 'Tora', '')
,('7', 'Raquel ', 'Livia Barros', '2726244984', '27994395113', 'raquelliviabarros-99@afujita.com.br', 'Rua Zilca Nunes Vieira Bermudes', '803', 'Centro', 'Aracruz', 'ES', '29190238', '', '', '', '', '')
;

#
# //Criação da Tabela : tb_pessoas
#

CREATE TABLE `tb_pessoas` (
  `pess_codigo` int NOT NULL AUTO_INCREMENT,
  `pess_tipo` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `pess_classificacao` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `pess_nome` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `pess_razao_social` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `pess_sobrenome` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `pess_nome_fantasia` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `pess_cpfcnpj` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `pess_cep` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `pess_logradouro` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `pess_log_numero` varchar(20) DEFAULT NULL,
  `pess_bairro` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `pess_cidade` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `pess_estado` char(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `pess_edificio` varchar(80) DEFAULT NULL,
  `pess_bloco` varchar(30) DEFAULT NULL,
  `pess_apartamento` varchar(10) DEFAULT NULL,
  `pess_logradouro_condominio` varchar(80) DEFAULT NULL,
  `pess_observacao` varchar(510) DEFAULT NULL,
  `pess_data_cadastro` timestamp(2) NULL DEFAULT CURRENT_TIMESTAMP(2),
  PRIMARY KEY (`pess_codigo`),
  UNIQUE KEY `pess_cpfcnpj` (`pess_cpfcnpj`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci ;

#
# //Dados a serem incluídos na tabela
#

INSERT INTO tb_pessoas VALUES('1', 'F', 'C', 'Vitor', '', 'Cesar Lulio', '', '52268093875', '13454360', 'Rua Maceió', '678', 'Loteamento Planalto do Sol', 'Santa Bárbara D\'Oeste', 'SP', '', '', '', '', '', '2020-11-07 14:18:08.40')
;

#
# //Criação da Tabela : tb_receber_pagar
#

CREATE TABLE `tb_receber_pagar` (
  `crp_numero` int NOT NULL AUTO_INCREMENT,
  `crp_parcela` int NOT NULL,
  `crp_emissao` date NOT NULL,
  `crp_vencimento` date NOT NULL,
  `crp_valor` decimal(15,2) NOT NULL,
  `crp_datapagto` date DEFAULT NULL,
  `crp_obs` varchar(255) DEFAULT NULL,
  `tpg_codigo` int NOT NULL,
  `pess_codigo` int NOT NULL,
  `crp_ndoc` varchar(80) NOT NULL,
  `crp_status` varchar(20) NOT NULL,
  `crp_tipo` char(1) NOT NULL,
  `cat_codigo` int NOT NULL,
  PRIMARY KEY (`crp_numero`),
  KEY `fk_tpg_codigo` (`tpg_codigo`),
  KEY `fk_pess_codigo` (`pess_codigo`),
  KEY `fk_cat_codigo` (`cat_codigo`),
  CONSTRAINT `fk_cat_codigo` FOREIGN KEY (`cat_codigo`) REFERENCES `tb_categoria` (`cat_codigo`),
  CONSTRAINT `fk_pess_codigo` FOREIGN KEY (`pess_codigo`) REFERENCES `tb_pessoas` (`pess_codigo`),
  CONSTRAINT `fk_tpg_codigo` FOREIGN KEY (`tpg_codigo`) REFERENCES `tb_tipo_pagamento` (`tpg_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci ;

#
# //Dados a serem incluídos na tabela
#


#
# //Criação da Tabela : tb_tentativas
#

CREATE TABLE `tb_tentativas` (
  `ten_id` int NOT NULL AUTO_INCREMENT,
  `ten_ip` varchar(20) NOT NULL,
  `ten_data` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ten_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci ;

#
# //Dados a serem incluídos na tabela
#


#
# //Criação da Tabela : tb_tipo_pagamento
#

CREATE TABLE `tb_tipo_pagamento` (
  `tpg_codigo` int NOT NULL AUTO_INCREMENT,
  `tpg_descricao` varchar(45) NOT NULL,
  `tpg_parcelas` int NOT NULL,
  `tpg_observacao` varchar(510) DEFAULT NULL,
  PRIMARY KEY (`tpg_codigo`),
  UNIQUE KEY `tpg_descricao` (`tpg_descricao`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci ;

#
# //Dados a serem incluídos na tabela
#


#
# //Criação da Tabela : tb_usuarios
#

CREATE TABLE `tb_usuarios` (
  `usu_codigo` int NOT NULL AUTO_INCREMENT,
  `usu_login` varchar(45) NOT NULL,
  `usu_senha` varchar(90) NOT NULL,
  `usu_data_cadastro` timestamp(2) NOT NULL DEFAULT CURRENT_TIMESTAMP(2),
  `usu_nome` varchar(80) DEFAULT NULL,
  `usu_sobrenome` varchar(80) DEFAULT NULL,
  `usu_permissoes` varchar(20) NOT NULL,
  `usu_status` char(1) NOT NULL,
  PRIMARY KEY (`usu_codigo`),
  UNIQUE KEY `usu_login` (`usu_login`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci ;

#
# //Dados a serem incluídos na tabela
#

INSERT INTO tb_usuarios VALUES('1', 'ADMINISTRADOR', '$2y$10$V5RTH8cwnpPB8nVcja3jweU7Z8EdVKhWly9nm6JMMqIQjxo9CFEym', '2020-11-05 22:16:52.00', 'Administrador', 'do Sistema', 'admin', 'A')
,('2', 'ROOT', '$2y$10$OwIXdzVYGL/k9uKCGbnbWuuozm/rbbS7w7gSDM7NObfLqn/uOmjpO', '2020-11-06 21:36:00.71', 'Administrador', 'do Sistema', 'admin', 'A')
,('3', 'JOAO', '$2y$10$115BxVvyiOq1/PRn70iF8eIkh8Q5BaT0BCSYjx4W5Gq05ab7PM4tK', '2020-11-07 09:05:11.18', 'João Marcos', 'Lopes', 'user', 'A')
,('4', 'VICTOR', '$2y$10$No55Z3MMrfYU6/yig3IcDeQzgsbdR7FJHaig/M//WfLSPnXRep4T2', '2020-11-07 09:29:14.51', 'Victor', 'Matheus', 'admin', 'A')
,('5', 'VICTORM', '$2y$10$/uopY2VHkr2zLcIQc1.4Z.Lrtjl0fLwMZwNNEj.NMQ8l738ya8016', '2020-11-07 09:30:31.14', 'Victor ', 'Silva', 'user', 'A')
,('6', 'MARCELO', '$2y$10$qzS5RjkypPdrB1YfDx1Sae73neg.3YLQmjBwhPF9WeGwSUaEiCEBy', '2020-11-07 09:55:27.78', 'Marcelo ', 'Ciarantola', 'admin', 'A')
,('7', 'MIRELA', '$2y$10$otSFBYHJekj7EbSuz/1mGuZisROVM5uq9HDQFOxRzK5PodHHNog7O', '2020-11-07 10:04:21.87', 'Mirela', 'Marques', 'admin', 'A')
,('8', 'VAGNER', '$2y$10$/wjuG.n4S8Neq/thtdHOv.rIyXu30wuC11kaBG.cX4f9oCG3t6PP.', '2020-11-07 10:29:10.41', 'Vagner', 'Faria', 'admin', 'A')
;
