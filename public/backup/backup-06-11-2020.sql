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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci ;

#
# //Dados a serem incluídos na tabela
#


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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci ;

#
# //Dados a serem incluídos na tabela
#

INSERT INTO tb_eventos VALUES('1', 'Realizar Orçamento', '', 'P', '2020-10-15 08:00:00', '2020-10-15 09:30:00', 'Ir de máscara', '1')
,('2', 'Realizar Orçamento', '', 'P', '2020-10-15 13:00:00', '2020-10-15 14:00:00', '', '2')
,('3', 'Realizar Orçamento', '', 'P', '2020-10-19 09:30:00', '2020-10-19 10:00:00', '', '3')
,('4', 'Realizar Orçamento', '', 'P', '2020-11-06 08:00:00', '2020-11-06 10:00:00', 'Colégio Politec, falar com Cláudio.', '4')
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci ;

#
# //Dados a serem incluídos na tabela
#

INSERT INTO tb_orcamento VALUES('1', 'Levi', 'Mateus Henrique Dias', '1926412152', '19991008564', 'levimateushenriquedias-97@gripoantonin.com', 'Rua José Zanetti', '813', 'Vila Dainese', 'Americana', 'SP', '13469262', '', '', '', '', '')
,('2', 'Calebe', 'Victor Renato da Silva', '1925422703', '19986918036', 'ccalebevictorrenatodasilva@unitau.com.br', 'Rua Luiz Mazoli', '825', 'Vila Mariana', 'Americana', 'SP', '13473381', '', '', '', '', '')
,('3', 'Rita', 'Bianca Peixoto', '1937643686', '19998175047', 'rritabiancapeixoto@cmfcequipamentos.com.br', 'Rua Arkansas', '352', 'Jardim Dona Judith', 'Americana', 'SP', '13469162', '', '', '', '', '')
,('4', 'Jaime', 'Alfredo Klava', '1934067273', '', 'compras@colegiopolitec.com.br', 'Avenida Brasil', '2000', 'Vila Santo Antônio', 'Americana', 'SP', '13465770', '', '', '', '', '')
;

#
# //Criação da Tabela : tb_pessoas
#

CREATE TABLE `tb_pessoas` (
  `pess_codigo` int NOT NULL AUTO_INCREMENT,
  `pess_tipo` varchar(11) NOT NULL,
  `pess_classificacao` char(1) NOT NULL,
  `pess_nome` varchar(30) NOT NULL,
  `pess_razao_social` varchar(80) NOT NULL,
  `pess_sobrenome` varchar(30) NOT NULL,
  `pess_nome_fantasia` varchar(80) NOT NULL,
  `pess_cpfcnpj` varchar(16) NOT NULL,
  `pess_cep` varchar(8) NOT NULL,
  `pess_logradouro` varchar(80) NOT NULL,
  `pess_log_numero` varchar(20) DEFAULT NULL,
  `pess_bairro` varchar(50) NOT NULL,
  `pess_cidade` varchar(50) NOT NULL,
  `pess_estado` char(2) NOT NULL,
  `pess_edificio` varchar(80) DEFAULT NULL,
  `pess_bloco` varchar(30) DEFAULT NULL,
  `pess_apartamento` varchar(10) DEFAULT NULL,
  `pess_logradouro_condominio` varchar(80) DEFAULT NULL,
  `pess_observacao` varchar(510) DEFAULT NULL,
  `pess_data_cadastro` timestamp(2) NOT NULL DEFAULT CURRENT_TIMESTAMP(2) ON UPDATE CURRENT_TIMESTAMP(2),
  PRIMARY KEY (`pess_codigo`),
  UNIQUE KEY `pess_cpfcnpj` (`pess_cpfcnpj`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci ;

#
# //Dados a serem incluídos na tabela
#


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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci ;

#
# //Dados a serem incluídos na tabela
#

INSERT INTO tb_tentativas VALUES('2', '187.183.40.244', '2020-11-07 00:51:09')
,('3', '187.183.40.244', '2020-11-07 00:51:10')
,('4', '187.183.40.244', '2020-11-07 00:51:10')
;

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci ;

#
# //Dados a serem incluídos na tabela
#

INSERT INTO tb_tipo_pagamento VALUES('1', 'Dinheiro 1x', '1', 'Dinheiro em 1x apenas para pagamentos a vista.')
;

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci ;

#
# //Dados a serem incluídos na tabela
#

INSERT INTO tb_usuarios VALUES('1', 'ADMINISTRADOR', '$2y$10$V5RTH8cwnpPB8nVcja3jweU7Z8EdVKhWly9nm6JMMqIQjxo9CFEym', '2020-11-06 01:16:52.00', 'Administrador', 'do Sistema', 'admin', 'A')
,('2', 'ROOT', '$2y$10$OwIXdzVYGL/k9uKCGbnbWuuozm/rbbS7w7gSDM7NObfLqn/uOmjpO', '2020-11-07 00:36:00.71', 'Administrador', 'do Sistema', 'admin', 'A')
;
