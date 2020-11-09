set foreign_key_checks=0;


#
# //Criação da Tabela : tb_categoria
#

CREATE TABLE `tb_categoria` (
  `cat_codigo` int NOT NULL AUTO_INCREMENT,
  `cat_descricao` varchar(30) NOT NULL,
  PRIMARY KEY (`cat_codigo`),
  UNIQUE KEY `cat_descricao` (`cat_descricao`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci ;

#
# //Dados a serem incluídos na tabela
#

INSERT INTO tb_categoria VALUES('2', 'Produtos')
,('1', 'Serviços')
;

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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci ;

#
# //Dados a serem incluídos na tabela
#

INSERT INTO tb_contatos VALUES('1', 'Celular', 'Vitor', '19996258494', '1')
,('2', 'Telefone', 'Casa', '1934588481', '1')
,('3', 'Telefone', 'Cauê', '1937112261', '2')
,('4', 'Celular', 'Cauê', '19981577745', '2')
,('5', 'Email', 'Kevin', 'kevinanthonyraulnascimento_@oliveiracontabil.com.br', '3')
,('6', 'Email', 'Vitor', 'vitorcesardtb1@gmail.com', '1')
,('7', 'Telefone', 'Marina', '9535323885', '4')
,('8', 'Celular', 'Marina', '95995955578', '4')
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
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci ;

#
# //Dados a serem incluídos na tabela
#

INSERT INTO tb_eventos VALUES('1', 'Realizar Orçamento', '#28A745', 'R', '2020-10-15 08:00:00', '2020-10-15 09:30:00', 'Ir de máscara', '1')
,('2', 'Realizar Orçamento', '#28A745', 'R', '2020-10-15 13:00:00', '2020-10-15 14:00:00', '', '2')
,('3', 'Realizar Orçamento', '#28A745', 'R', '2020-10-19 09:30:00', '2020-10-19 10:00:00', '', '3')
,('4', 'Realizar Orçamento', '', 'P', '2020-11-06 08:00:00', '2020-11-06 10:00:00', 'Colégio Politec, falar com Cláudio.', '4')
,('6', 'Voltar na Obra', '', 'P', '2020-11-09 08:30:00', '2020-11-09 11:30:00', '', '4')
,('7', 'Início de Obra', '#28A745', 'R', '2020-11-07 08:00:00', '2020-11-07 16:30:00', 'Obra em estágio inicial ', '1')
,('8', 'Realizar Orçamento', '', 'P', '2020-11-10 11:00:00', '2020-11-10 13:00:00', '', '6')
,('9', 'Realizar Orçamento', '#28A745', 'R', '2020-10-30 15:00:00', '2020-10-30 16:00:00', '', '7')
,('11', 'Voltar na Obra', '', 'P', '2020-11-11 08:00:00', '2020-11-11 09:00:00', '', '7')
,('12', 'Início de Obra', '', 'P', '2020-11-11 09:30:00', '2020-11-11 11:00:00', '', '4')
,('13', 'Realizar Orçamento', '', 'P', '2020-11-10 08:00:00', '2020-11-10 09:00:00', '', '8')
,('14', 'Realizar Orçamento', '', 'P', '2020-11-10 09:30:00', '2020-11-10 10:30:00', '', '9')
,('15', 'Realizar Orçamento', '', 'P', '2020-11-10 13:00:00', '2020-11-10 14:00:00', 'Levar trena', '10')
,('16', 'Início de Obra', '#28A745', 'R', '2020-10-28 08:00:00', '2020-10-28 09:00:00', '', '3')
,('17', 'Voltar na Obra', '#28A745', 'R', '2020-10-29 09:05:00', '2020-10-29 10:05:00', '', '2')
,('18', 'Realizar Orçamento', '', 'P', '2020-11-12 09:00:00', '2020-11-12 12:00:00', '', '11')
,('19', 'Realizar Orçamento', '', 'P', '2020-11-09 10:00:00', '2020-11-09 10:01:00', '', '12')
,('20', 'Início de Obra', '', 'P', '2020-11-09 15:00:00', '2020-11-09 17:00:00', '', '8')
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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci ;

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
,('8', 'Isabella', 'Sônia Nunes', '1637021301', '16996796870', 'iisabellasonianunes@caiuas.com.br', 'Rua Dom Carmine Rocco', '274', 'Dom Bernardo José Mielle', 'Ribeirão Preto', 'SP', '14057279', '', '', '', '', '')
,('9', 'Mariah', 'Julia Bianca Dias', '1938735972', '19994722310', 'mariahjuliabiancadias_@agenciaph.com', 'Rua Sarah Bernhardt', '790', 'Jardim Santa Mônica', 'Campinas', 'SP', '13082140', '', '', '', '', '')
,('10', 'Márcio', 'Vinicius Castro', '1925033486', '19996932275', 'marcioviniciuscastro__marcioviniciuscastro@publiconsult.com.br', 'Avenida Brasil Norte', '', 'Parque Residencial Nardini', 'Americana', 'SP', '13465810', 'Edifício Comercial Nova York', 'Impire', 'I290', '', '')
,('11', 'Caio', 'Vinicius Felipe Viana', '1139490132', '11983538375', '', 'Rua Coimbra', '91', 'Jardim Trípoli', 'Americana', 'SP', '13478883', '', '', '', 'Rua Coimbra', '')
,('12', 'Teresinha', 'Elaine Oliveira', '1125325341', '11993755218', 'teresinhaelaineoliveira@infolink.com.br', 'Estrada Santa Maria', '959', 'Estância São Francisco', 'Itapevi', 'SP', '06695465', '', '', '', '', '')
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
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci ;

#
# //Dados a serem incluídos na tabela
#

INSERT INTO tb_pessoas VALUES('1', 'F', 'C', 'Vitor', '', 'Cesar Lulio', '', '52268093875', '13454360', 'Rua Maceió', '678', 'Loteamento Planalto do Sol', 'Santa Bárbara D\'Oeste', 'SP', '', '', '', '', '', '2020-11-07 14:18:08.40')
,('2', 'F', 'C', 'Cauê', '', 'Mateus Marcos Costa', '', '76217653800', '13451073', 'Rua Nelson Teixeira de Miranda', '546', 'Vila Brasil', 'Santa Bárbara D\'Oeste', 'SP', '', '', '', '', '', '2020-11-07 14:23:05.29')
,('3', 'F', 'C', 'Kevin', '', 'Anthony Raul Nascimento', '', '89184962810', '13450197', 'Rua Peru', '344', 'Jardim Sartori', 'Santa Bárbara D\'Oeste', 'SP', '', '', '', '', '', '2020-11-07 14:38:16.80')
,('4', 'F', 'C', 'Marina', '', 'Eliane Mariah das Neves', '', '51278556230', '69310113', 'Rua José Carneiro Machado', '217', 'Aeroporto', 'Boa Vista', 'RR', '', '', '', '', '', '2020-11-07 14:44:57.34')
,('5', 'J', 'F', '', 'KNAUF ISOPOR LTDA', '', 'KNAUF ISOPOR LTDA', '01685556000121', '13035506', 'Avenida General Euclides de Figueiredo', '1000', 'Vila Industrial', 'Campinas', 'SP', '', '', '', '', '', '2020-11-08 16:51:27.67')
,('6', 'F', 'C', 'Kevin', '', 'Fernando Nascimento', '', '41410045889', '19912323', 'Alameda Lucilda Minucci', '368', 'Residencial Parque Gabriela', 'Ourinhos', 'SP', '', '', '', '', '', '2020-11-08 16:53:37.09')
,('7', 'F', 'C', 'Mariane', '', 'Patrícia Costa', '', '48252547800', '15995000', 'Avenida Ludwig Eckes', '597', 'Conjunto Residencial João Vital', 'Matão', 'SP', '', '', '', '', '', '2020-11-08 16:54:11.34')
,('8', 'F', 'C', 'Cláudio', '', 'Elias Luan Barbosa', '', '39858974841', '13479786', 'Rua Imperador Augusto', '987', 'Jardim Imperador', 'Americana', 'SP', '', '', '', 'Rua do Chá', 'R. Imperador Augusto - Jardim Imperador, Americana - SP, ', '2020-11-08 16:55:41.76')
,('9', 'F', 'C', 'Agatha', '', 'Maria Mariana Brito', '', '78144829840', '00000000', 'Rua da Agricultura', '', 'Loteamento Industrial', 'Santa Bárbara D\'Oeste', 'SP', 'Jóias de Santa Bárbara', 'B', 'B27', '', 'ENDEREÇO: 
R. Argeu Egídio dos Santos - Jóias de, Santa Bárbara d\'Oeste - SP, 13454

', '2020-11-08 16:59:29.24')
,('10', 'F', 'C', 'Luna', '', 'Helena Mariana Gonçalves', '', '38135558872', '13453881', 'Rua Argeu Egydio dos Santos', '', 'Joias de Santa Bárbara', 'Santa Bárbara D\'Oeste', 'SP', 'Joias de Santa Bárbara', 'F', 'F200', '', '', '2020-11-08 17:01:33.13')
,('11', 'F', 'C', 'Camila', '', 'Letícia Moura', '', '24341894820', '06767090', 'Rua Francisco Honorato de Medeiros', '145', 'Parque Pinheiros', 'Taboão da Serra', 'SP', '', '', '', '', '', '2020-11-08 18:00:19.57')
,('12', 'F', 'C', 'Marcelo', '', 'Luan Francisco Bernardes', '', '17302063877', '12946020', 'Rua Doutor Péricles de Toledo Piza', '351', 'Nova Gardênia', 'Atibaia', 'SP', '', '', '', '', '', '2020-11-08 18:02:18.09')
,('13', 'F', 'C', 'Leandro', '', 'César Marcos Caldeira', '', '26890690834', '13800535', 'Rua Presidente Venceslau Braz', '549', 'Vila Oceania', 'Mogi Mirim', 'SP', '', '', '', '', '', '2020-11-08 18:04:33.17')
,('14', 'J', 'C', '', 'ALLANA E NATHAN FERRAGENS ME', '', 'ALLANA E NATHAN FERRAGENS ME', '72075723000160', '08616770', 'Rua José Sanches Marin', '915', 'Vila Colorado', 'Suzano', 'SP', '', '', '', '', '', '2020-11-08 18:07:09.62')
,('15', 'J', 'F', '', 'WALSYWA INDUSTRIA E COMERCIO DE PRODUTOS METALURGICOS LTDA', '', 'WALSYWA', '05896435000503', '13290000', '', '198', '', 'Louveira', 'SP', '', '', '', '', '', '2020-11-08 18:08:25.14')
,('16', 'J', 'F', '', 'GYPSUM MINERACAO INDUSTRIA E COMERCIO LTDA', '', 'GYPSUM DRYWALL', '24443608001040', '13479786', 'Rua Imperador Augusto', '777', 'Jardim Imperador', 'Americana', 'SP', '', '', '', '', '', '2020-11-08 18:09:59.04')
,('17', 'F', 'C', 'Mariah', '', 'Patrícia Caldeira', '', '23445534870', '13479786', 'Rua Imperador Augusto', '911', 'Jardim Imperador', 'Americana', 'SP', '', '', '', '', '', '2020-11-08 18:14:06.11')
,('18', 'F', 'C', 'Isaac', '', 'Murilo Costa', '', '31060113864', '13485358', 'Rua Izabel de Godoy Bueno', '767', 'Jardim Porto Real', 'Limeira', 'SP', '', '', '', '', '', '2020-11-08 18:16:29.67')
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
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci ;

#
# //Dados a serem incluídos na tabela
#

INSERT INTO tb_receber_pagar VALUES('1', '1', '2020-11-07', '2020-12-07', '240.00', '', '', '1', '4', '34191.79001 01043.510047 91020.150008 7 84320026000', 'ABERTO', 'R', '1')
,('2', '2', '2020-11-07', '2021-01-07', '240.00', '', '', '1', '4', '34191.79001 01043.510047 91020.150008 7 84320026000', 'ABERTO', 'R', '1')
,('3', '3', '2020-11-07', '2021-02-07', '240.00', '', '', '1', '4', '34191.79001 01043.510047 91020.150008 7 84320026000', 'ABERTO', 'R', '1')
,('4', '4', '2020-11-07', '2021-03-07', '240.00', '', '', '1', '4', '34191.79001 01043.510047 91020.150008 7 84320026000', 'ABERTO', 'R', '1')
,('5', '5', '2020-11-07', '2021-04-07', '240.00', '', '', '1', '4', '34191.79001 01043.510047 91020.150008 7 84320026000', 'ABERTO', 'R', '1')
,('6', '1', '2020-11-09', '2020-11-09', '2400.00', '2020-11-09', 'Relação com orçamento 1, acréscimo de 120 reais de taxa do cartão de credito. 
1º Pagamento dia 09/11/2020 no dinheiro, combinado foi cartão', '3', '10', '1', 'PAGO', 'R', '1')
,('7', '2', '2020-11-09', '2020-12-09', '2400.00', '', 'Relação com orçamento 1, acréscimo de 120 reais de taxa do cartão de credito.', '1', '10', '1', 'ABERTO', 'R', '1')
,('8', '3', '2020-11-09', '2021-01-09', '2400.00', '', 'Relação com orçamento 1, acréscimo de 120 reais de taxa do cartão de credito.', '1', '10', '1', 'ABERTO', 'R', '1')
,('9', '4', '2020-11-09', '2021-02-09', '2400.00', '', 'Relação com orçamento 1, acréscimo de 120 reais de taxa do cartão de credito.', '1', '10', '1', 'ABERTO', 'R', '1')
,('10', '5', '2020-11-09', '2021-03-09', '2400.00', '', 'Relação com orçamento 1, acréscimo de 120 reais de taxa do cartão de credito.', '1', '10', '1', 'ABERTO', 'R', '1')
,('11', '1', '2020-11-08', '2020-11-08', '1000.00', '2020-11-08', '', '3', '9', '90177    837  53641  70775  38294   2474  35422  76239  76170', 'PAGO', 'R', '2')
,('12', '1', '2020-10-08', '2020-10-08', '1000.00', '', '', '6', '7', '0', 'ABERTO', 'R', '1')
,('13', '1', '2020-11-08', '2020-11-18', '3333.33', '', '', '6', '2', '12124124', 'ABERTO', 'R', '1')
,('14', '2', '2020-11-08', '2020-12-18', '3333.33', '', '', '6', '2', '12124124', 'ABERTO', 'R', '1')
,('15', '3', '2020-11-08', '2021-01-18', '3333.34', '', '', '6', '2', '12124124', 'ABERTO', 'R', '1')
,('16', '1', '2020-11-08', '2020-11-09', '11111.00', '2020-11-10', '', '2', '1', '1212936193610', 'PAGO', 'R', '2')
,('17', '1', '2020-11-08', '2020-11-27', '121533.00', '2020-11-30', '', '3', '3', '12319690', 'PAGO', 'R', '1')
,('18', '1', '2020-11-08', '2020-11-25', '70021.00', '2020-11-08', '', '3', '4', '3443342342344235', 'ABERTO', 'R', '2')
;

#
# //Criação da Tabela : tb_tentativas
#

CREATE TABLE `tb_tentativas` (
  `ten_id` int NOT NULL AUTO_INCREMENT,
  `ten_ip` varchar(20) NOT NULL,
  `ten_data` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ten_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci ;

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci ;

#
# //Dados a serem incluídos na tabela
#

INSERT INTO tb_tipo_pagamento VALUES('1', 'Cartão de Crédito 5x', '5', '')
,('2', 'Boleto bancário 1x', '1', 'Dependendo do banco existe uma taxa da TED')
,('3', 'Dinheiro 1x', '1', '')
,('4', 'Boleto bancário 10x', '10', 'Apenas compras acima de R$ 30.000,00 ')
,('5', 'Cartão de Crédito 2x', '2', 'Lembrando da taxa de juros')
,('6', 'Dinheiro 3x', '3', '')
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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci ;

#
# //Dados a serem incluídos na tabela
#

INSERT INTO tb_usuarios VALUES('1', 'ADMINISTRADOR', '$2y$10$/Kffih6QhscELDqO3dWBDOPy61VK1/3RZ1eWhN.Gsb.fYq7ydC5q.', '2020-11-05 22:16:52.00', 'Administrador', 'do Sistema', 'admin', 'A')
,('2', 'ROOT', '$2y$10$OwIXdzVYGL/k9uKCGbnbWuuozm/rbbS7w7gSDM7NObfLqn/uOmjpO', '2020-11-06 21:36:00.71', 'Administrador', 'do Sistema', 'admin', 'A')
,('3', 'JOAO', '$2y$10$115BxVvyiOq1/PRn70iF8eIkh8Q5BaT0BCSYjx4W5Gq05ab7PM4tK', '2020-11-07 09:05:11.18', 'João Marcos', 'Lopes', 'user', 'A')
,('4', 'VICTOR', '$2y$10$No55Z3MMrfYU6/yig3IcDeQzgsbdR7FJHaig/M//WfLSPnXRep4T2', '2020-11-07 09:29:14.51', 'Victor', 'Matheus', 'admin', 'A')
,('5', 'VICTORM', '$2y$10$/uopY2VHkr2zLcIQc1.4Z.Lrtjl0fLwMZwNNEj.NMQ8l738ya8016', '2020-11-07 09:30:31.14', 'Victor ', 'Silva', 'user', 'A')
,('6', 'MARCELO', '$2y$10$qzS5RjkypPdrB1YfDx1Sae73neg.3YLQmjBwhPF9WeGwSUaEiCEBy', '2020-11-07 09:55:27.78', 'Marcelo ', 'Ciarantola', 'admin', 'A')
,('7', 'MIRELA', '$2y$10$otSFBYHJekj7EbSuz/1mGuZisROVM5uq9HDQFOxRzK5PodHHNog7O', '2020-11-07 10:04:21.87', 'Mirela', 'Marques', 'admin', 'A')
,('8', 'VAGNER', '$2y$10$/wjuG.n4S8Neq/thtdHOv.rIyXu30wuC11kaBG.cX4f9oCG3t6PP.', '2020-11-07 10:29:10.41', 'Vagner', 'Faria', 'admin', 'A')
,('9', 'CLAUDIO', '$2y$10$UoiS9IJe9Kl849GrmHuefOPDYIiKUtLAaayZAhxiEZ0tBIVzGWyeW', '2020-11-08 18:21:38.31', 'Cláudio', 'Denardi', 'user', 'A')
,('10', 'ANDRE', '$2y$10$I37zWUV88rrZWYqaa0T7ruJXeaGET4O2N9QSz1dXFMIMFIwqXXBJO', '2020-11-08 18:21:58.68', 'Andre', 'Barreto', 'user', 'A')
;
