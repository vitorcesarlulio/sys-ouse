set foreign_key_checks=0;


#
# //Criação da Tabela : tb_contatos
#

CREATE TABLE `tb_contatos` (
  `cont_codigo` int(11) NOT NULL AUTO_INCREMENT,
  `cont_tipo` varchar(30) NOT NULL,
  `cont_responsavel` varchar(30) NOT NULL,
  `cont_contato` varchar(80) NOT NULL,
  `pess_codigo` int(11) NOT NULL,
  PRIMARY KEY (`cont_codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 ;

#
# //Dados a serem incluídos na tabela
#


#
# //Criação da Tabela : tb_eventos
#

CREATE TABLE `tb_eventos` (
  `even_codigo` int(11) NOT NULL AUTO_INCREMENT,
  `even_titulo` varchar(30) NOT NULL,
  `even_cor` char(7) DEFAULT NULL,
  `even_status` char(1) NOT NULL,
  `even_datahorai` datetime NOT NULL,
  `even_datahoraf` datetime NOT NULL,
  `even_observacao` varchar(510) DEFAULT NULL,
  `orca_numero` int(11) NOT NULL,
  PRIMARY KEY (`even_codigo`),
  UNIQUE KEY `even_datahorai` (`even_datahorai`,`even_datahoraf`)
) ENGINE=InnoDB AUTO_INCREMENT=132 DEFAULT CHARSET=utf8mb4 ;

#
# //Dados a serem incluídos na tabela
#

INSERT INTO tb_eventos VALUES('56', 'Realizar Orçamento', '', 'P', '2020-09-17 08:00:00', '2020-09-17 08:00:00', '', '82')
,('59', 'Realizar Orçamento', '', 'P', '2020-09-24 07:30:00', '2020-09-24 07:31:00', '', '83')
,('61', 'Voltar na Obra', '', 'P', '2020-09-23 08:10:00', '2020-09-23 10:30:00', 'aP TERREO
', '83')
,('69', 'Realizar Orçamento', '', 'P', '2020-09-02 08:00:00', '2020-09-02 08:01:00', '', '82')
,('71', 'Voltar na Obra', '', 'P', '2020-09-23 08:00:00', '2020-09-23 10:30:00', 'aP TERREO
', '83')
,('72', 'Realizar Orçamento', '', 'P', '2020-09-18 08:00:00', '2020-09-18 08:00:00', '', '82')
,('73', 'Realizar Orçamento', '', 'P', '2020-09-19 07:30:00', '2020-09-19 07:31:00', '', '83')
,('74', 'Voltar na Obra', '', 'P', '2020-09-20 08:10:00', '2020-09-20 10:30:00', 'aP TERREO
', '83')
,('75', 'Realizar Orçamento', '', 'P', '2020-09-21 08:00:00', '2020-09-21 08:01:00', '', '82')
,('76', 'Realizar Orçamento', '', 'P', '2020-09-22 07:30:00', '2020-09-22 07:31:00', 'sdfsd', '83')
,('77', 'Voltar na Obra', '', 'P', '2020-09-23 08:01:00', '2020-09-23 10:40:00', 'aP TERREO
', '83')
,('79', 'Realizar Orçamento', '', 'P', '2020-10-24 07:30:00', '2020-10-24 07:31:00', '', '83')
,('84', 'Realizar Orçamento', '', 'P', '2020-10-18 08:00:00', '2020-10-18 08:00:00', '', '82')
,('85', 'Realizar Orçamento', '', 'P', '2020-10-19 07:30:00', '2020-10-19 07:31:00', '', '83')
,('86', 'Voltar na Obra', '', 'P', '2020-10-20 08:10:00', '2020-10-20 10:30:00', 'aP TERREO
', '83')
,('88', 'Realizar Orçamento', '', 'P', '2020-10-22 07:30:00', '2020-10-22 07:31:00', 'sdfsd', '83')
,('90', 'Realizar Orçamento', '', 'P', '2020-11-18 08:00:00', '2020-11-18 08:00:00', '', '82')
,('91', 'Realizar Orçamento', '', 'P', '2020-11-19 07:30:00', '2020-11-19 07:31:00', '', '83')
,('92', 'Voltar na Obra', '', 'P', '2020-11-20 08:10:00', '2020-11-20 10:30:00', 'aP TERREO
', '83')
,('94', 'Realizar Orçamento', '', 'P', '2020-11-22 07:30:00', '2020-11-22 07:31:00', 'sdfsd', '83')
,('95', 'Voltar na Obra', '', 'P', '2020-11-23 08:01:00', '2020-11-23 10:40:00', 'aP TERREO
', '83')
,('103', 'Realizar Orçamento', '', 'P', '2020-11-17 08:00:00', '2020-11-17 08:00:00', '', '82')
,('105', 'Voltar na Obra', '', 'P', '2020-11-23 08:10:00', '2020-11-23 10:30:00', 'aP TERREO
', '83')
,('106', 'Realizar Orçamento', '', 'P', '2020-11-02 08:00:00', '2020-11-02 08:01:00', '', '82')
,('108', 'Voltar na Obra', '', 'P', '2020-11-23 08:00:00', '2020-11-23 10:30:00', 'aP TERREO
', '83')
,('109', 'Realizar Orçamento', '', 'P', '2020-12-18 08:00:00', '2020-12-18 08:00:00', '', '82')
,('110', 'Voltar na Obra', '', 'P', '2021-09-23 08:01:00', '2021-09-23 10:40:00', 'aP TERREO
', '83')
,('111', 'Realizar Orçamento', '', 'P', '2021-10-17 08:00:00', '2021-10-17 08:00:00', '', '82')
,('113', 'Voltar na Obra', '', 'P', '2021-10-23 08:10:00', '2021-10-23 10:30:00', 'aP TERREO
', '83')
,('114', 'Realizar Orçamento', '', 'P', '2021-10-02 08:00:00', '2021-10-02 08:01:00', '', '82')
,('116', 'Voltar na Obra', '', 'P', '2021-10-23 08:00:00', '2021-10-23 10:30:00', 'aP TERREO
', '83')
,('117', 'Realizar Orçamento', '', 'P', '2021-10-18 08:00:00', '2021-10-18 08:00:00', '', '82')
,('118', 'Realizar Orçamento', '', 'P', '2021-10-19 07:30:00', '2021-10-19 07:31:00', '', '83')
,('119', 'Voltar na Obra', '', 'P', '2021-10-20 08:10:00', '2021-10-20 10:30:00', 'aP TERREO
', '83')
,('121', 'Realizar Orçamento', '', 'P', '2021-10-22 07:30:00', '2021-10-22 07:31:00', 'sdfsd', '83')
,('122', 'Voltar na Obra', '', 'P', '2021-10-23 08:01:00', '2021-10-23 10:40:00', 'aP TERREO
', '83')
,('123', 'Realizar Orçamento', '', 'P', '2021-11-18 08:00:00', '2021-11-18 08:00:00', '', '82')
,('131', 'Voltar na Obra', '#28A745', 'R', '2020-10-20 09:10:00', '2020-10-20 09:11:00', '', '90')
;

#
# //Criação da Tabela : tb_orcamento
#

CREATE TABLE `tb_orcamento` (
  `orca_numero` int(11) NOT NULL AUTO_INCREMENT,
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
) ENGINE=InnoDB AUTO_INCREMENT=92 DEFAULT CHARSET=utf8mb4 ;

#
# //Dados a serem incluídos na tabela
#

INSERT INTO tb_orcamento VALUES('1', 'Ivan ', 'Cesar ', '1934788481', '19996258494', 'ivan@gessocidadenova.com.br', 'Travessa Emílio Ribeiro', '1212', 'Nossa Senhora das Graças', 'Navegantes', 'SC', '88371278', '', '', '', '', '')
,('2', 'Ivan ', 'Cesar ', '1934788481', '19996258494', 'ivan@gessocidadenova.com.br', 'Travessa Emílio Ribeiro', '1212', 'Nossa Senhora das Graças', 'Navegantes', 'SC', '88371278', '', '', '', '', '')
,('3', 'CLAUDIAOOO', 'Cesar ', '1934788481', '19996258494', 'ivan@gessocidadenova.com.br', 'Travessa Emílio Ribeiro', '1212', 'Nossa Senhora das Graças', 'Navegantes', 'SC', '88371278', '', '', '', '', '')
,('4', 'Ivan ', 'Cesar ', '1934788481', '19996258494', 'ivan@gessocidadenova.com.br', 'Travessa Emílio Ribeiro', '1212', 'Nossa Senhora das Graças', 'Navegantes', 'SC', '88371278', '', '', '', '', '')
,('5', 'Ivan ', 'Cesar ', '1934788481', '19996258494', 'ivan@gessocidadenova.com.br', 'Travessa Emílio Ribeiro', '1212', 'Nossa Senhora das Graças', 'Navegantes', 'SC', '88371278', '', '', '', '', '')
,('6', 'Ivan ', 'Cesar ', '1934788481', '19996258494', 'ivan@gessocidadenova.com.br', 'Travessa Emílio Ribeiro', '1212', 'Nossa Senhora das Graças', 'Navegantes', 'SC', '88371278', '', '', '', '', '')
,('7', 'Ivan ', 'Cesar ', '1934788481', '19996258494', 'ivan@gessocidadenova.com.br', 'Travessa Emílio Ribeiro', '1212', 'Nossa Senhora das Graças', 'Navegantes', 'SC', '88371278', '', '', '', '', '')
,('8', 'Ivan ', 'Cesar ', '1934788481', '19996258494', 'ivan@gessocidadenova.com.br', 'Travessa Emílio Ribeiro', '1212', 'Nossa Senhora das Graças', 'Navegantes', 'SC', '88371278', '', '', '', '', '')
,('9', 'Ivan ', 'Cesar ', '1934788481', '19996258494', 'ivan@gessocidadenova.com.br', 'Travessa Emílio Ribeiro', '1212', 'Nossa Senhora das Graças', 'Navegantes', 'SC', '88371278', '', '', '', '', '')
,('10', 'Ivan ', 'Cesar ', '1934788481', '19996258494', 'ivan@gessocidadenova.com.br', 'Travessa Emílio Ribeiro', '1212', 'Nossa Senhora das Graças', 'Navegantes', 'SC', '88371278', '', '', '', '', '')
,('11', 'Ivan ', 'Cesar ', '1934788481', '19996258494', 'ivan@gessocidadenova.com.br', 'Travessa Emílio Ribeiro', '1212', 'Nossa Senhora das Graças', 'Navegantes', 'SC', '88371278', '', '', '', '', '')
,('12', 'Vitor
', 'Cesar ', '1934788481', '19996258494', 'ivan@gessocidadenova.com.br', 'Travessa Emílio Ribeiro', '1212', 'Nossa Senhora das Graças', 'Navegantes', 'SC', '88371278', '', '', '', '', '')
,('13', 'Vitor', 'Cesar Lulio', '', '23423234234', '', 'Rua Maceió', '234', 'Loteamento Planalto do Sol', 'Santa Bárbara D\'Oeste', 'SP', '13454360', '', '', '', '', '')
,('14', 'Teste', '2', '2222222222', '19996258494', '', 'Rua Maceió', '', 'Loteamento Planalto do Sol', 'Santa Bárbara D\'Oeste', 'SP', '13454360', 'Hilaris', 'B', 'B243', '', '')
,('15', 'Teste', '2', '2222222222', '19996258494', '', 'Rua Maceió', '', 'Loteamento Planalto do Sol', 'Santa Bárbara D\'Oeste', 'SP', '13454360', 'Hilaris', 'B', 'B243', '', '')
,('16', 'Paulo', 'Paulo', '3455678999', '19996259120', '', 'Rua Benoni Ferreira Tôrres', '', 'Ajuda', 'Macaé', 'RJ', '27971733', 'Solaris do RJ', 'B', 'B230', '', 'Nenhuma OBS')
,('17', 'Xavis', 'Alves', '1934733396', '', '', 'Rua Principal', '678', 'Mangabeira', 'Macaíba', 'RN', '59280974', '', '', '', 'Rua Prata ', '')
,('18', 'Teste AP', 'AP', '', '22222222222', '', 'Rua Argeu Egydio dos Santos', '1', 'Planalto do Sol II', 'Santa Bárbara D\'Oeste', 'SP', '13453842', 'ee', 'ee', 'ee', '', '')
,('19', 'MM', 'Rodrigues', '', '19888284623', '', 'Rua Maceió', '', 'Loteamento Planalto do Sol', 'Santa Bárbara D\'Oeste', 'SP', '13454360', 'Residencial Jóias de Santa Bárbara', 'B', 'B234', '', '')
,('20', 'Onicia', 'Lulio', '', '19981451678', '', 'Rua Argeu Egydio dos Santos', '', 'Planalto do Sol II', 'Santa Bárbara D\'Oeste', 'SP', '13453842', 'Residencial Jóias de Santa Bárbara', 'C', 'C345', '', '')
,('22', 'Vitor', 'Cesar Lulio', '1231231231', '123123123__', '', 'Rua Maceió', '234', 'Loteamento Planalto do Sol', 'Santa Bárbara D\'Oeste', 'SP', '13454360', '', '', '', '', '')
,('23', 'QWDQW', 'QDQW', '', '23112312312', '', 'Rua Maceió', '234', 'Loteamento Planalto do Sol', 'Santa Bárbara D\'Oeste', 'SP', '13454360', '', '', '', '', '')
,('24', 'qdqw', 'qwdqw', '123___1231', '21312313123', '', 'Rua Maceió', '678', 'Loteamento Planalto do Sol', 'Santa Bárbara D\'Oeste', 'SP', '13454360', '', '', '', '', '')
,('25', 'qwd', 'qwd', '____234234', '324234_____', '', 'Rua Maceió', '32', 'Loteamento Planalto do Sol', 'Santa Bárbara D\'Oeste', 'SP', '13454360', '', '', '', '', '')
,('26', 'ewfew', 'wefew', '23423_____', '234234_____', '', 'Rua Maceió', '324', 'Loteamento Planalto do Sol', 'Santa Bárbara D\'Oeste', 'SP', '13454360', '', '', '', '', '')
,('27', 'Vitor', 'Cesar Lulio', '1212121212', '21111111111', '', 'Rua Maceió', '123', 'Loteamento Planalto do Sol', 'Santa Bárbara D\'Oeste', 'SP', '13454360', '', '', '', '', '')
,('28', 'Vitor', 'Cesar Lulio', '3333333333', '23143333333', '', 'Rua Maceió', '234', 'Loteamento Planalto do Sol', 'Santa Bárbara D\'Oeste', 'SP', '13454360', '', '', '', '', '')
,('29', 'Vitor', 'Cesar Lulio', '1241241241', '21341212412', '', 'Rua Maceió', '2342', 'Loteamento Planalto do Sol', 'Santa Bárbara D\'Oeste', 'SP', '13454360', '', '', '', '', '')
,('30', 'qwedwq', 'qdqw', '1231231231', '21313131312', '', 'Rua Maceió', '123123', 'Loteamento Planalto do Sol', 'Santa Bárbara D\'Oeste', 'SP', '13454360', '', '', '', '', '')
,('31', 'qfqweadc', 'aasdasd', '1231231231', '12312312312', '', 'Rua Maceió', '12312312', 'Loteamento Planalto do Sol', 'Santa Bárbara D\'Oeste', 'SP', '13454360', '', '', '', '', '')
,('32', 'Jaime', 'Klava', '', '19996258494', '', 'Rua Maceió', '', 'Loteamento Planalto do Sol', 'Santa Bárbara D\'Oeste', 'SP', '13454360', 'eqfwf', 'w32', '23423', '', '')
,('33', 'htrh', 'rthtr', '4564564564', '54444444445', '', 'Rua Maceió', '2332', 'Loteamento Planalto do Sol', 'Santa Bárbara D\'Oeste', 'SP', '13454360', '', '', '', '', '')
,('34', 'qdqwd', 'qwdqw', '123_______', '_________12', '', 'Rua Maceió', '123', 'Loteamento Planalto do Sol', 'Santa Bárbara D\'Oeste', 'SP', '13454360', '', '', '', '', '')
,('35', '1e12e', 'wqeq', '123123____', '1231123____', '', 'Rua Maceió', 'qwddqd', 'Loteamento Planalto do Sol', 'Santa Bárbara D\'Oeste', 'SP', '13454360', '', '', '', '', '')
,('36', 'Ricardo', 'Rocetti', '', '19997097085', 'contato@metodomaisresultado.com.br', 'Avenida Brasil', '2000 ', 'Vila Santo Antônio', 'Americana', 'SP', '13465770', '', '', '', '', '')
,('37', 'qdqwd', 'qwdqwd', '1231231231', '12312313131', '', 'Rua Maceió', '312312', 'Loteamento Planalto do Sol', 'Santa Bárbara D\'Oeste', 'SP', '13454360', '', '', '', '', '')
,('38', 'Vitor', 'Cesar Lulio', '', '55555555555', '', 'Rua Maceió', '44', 'Loteamento Planalto do Sol', 'Santa Bárbara D\'Oeste', 'SP', '13454360', '', '', '', '', '')
,('39', 'Jaime ', 'Klava', '', '19996258494', '', 'Rua Maceió', '678', 'Loteamento Planalto do Sol', 'Santa Bárbara D\'Oeste', 'SP', '13454360', '', '', '', '', '')
,('40', 'Vitor', 'Cesar Lulio', '', '12312312312', '', 'Rua Maceió', '678', 'Loteamento Planalto do Sol', 'Santa Bárbara D\'Oeste', 'SP', '13454360', '', '', '', '', '')
,('41', 'Vitor', 'Cesar Lulio', '', '19996258494', '', 'Rua Maceió', '678', 'Loteamento Planalto do Sol', 'Santa Bárbara D\'Oeste', 'SP', '13454360', '', '', '', '', '')
,('42', 'Vitor', 'Cesar Lulio', '', '19996258494', '', 'Rua Maceió', '678', 'Loteamento Planalto do Sol', 'Santa Bárbara D\'Oeste', 'SP', '13454360', '', '', '', '', '')
,('43', 'Vitor', 'Cesar Lulio', '', '19996258494', '', 'Rua Maceió', '678', 'Loteamento Planalto do Sol', 'Santa Bárbara D\'Oeste', 'SP', '13454360', '', '', '', '', '')
,('44', 'Paulin', 'Pualo', '', '12312313131', '', 'Rua Maceió', '678', 'Loteamento Planalto do Sol', 'Santa Bárbara D\'Oeste', 'SP', '13454360', '', '', '', '', '')
,('45', 'Paulo', 'Paulo', '', '23423424232', '', 'Rua Maceió', '111', 'Loteamento Planalto do Sol', 'Santa Bárbara D\'Oeste', 'SP', '13454360', '', '', '', '', '')
,('46', 'PAULO', 'PAULO', '1231231231', '12313342342', '', 'Rua Maceió', '23423423', 'Loteamento Planalto do Sol', 'Santa Bárbara D\'Oeste', 'SP', '13454360', '', '', '', '', '')
,('47', 'fhwfbkjkwhe', 'kwbfhkewds', '', '23423423423', '', 'Rua Maceió', '23432', 'Loteamento Planalto do Sol', 'Santa Bárbara D\'Oeste', 'SP', '13454360', '', '', '', '', '')
,('48', 'dfkwsdfc', 'kwedbfwsd', '', '12312312312', '', 'Rua Maceió', '111', 'Loteamento Planalto do Sol', 'Santa Bárbara D\'Oeste', 'SP', '13454360', '', '', '', '', '')
,('49', '345345', '345345', '', '23423424324', '', 'Rua Maceió', '222', 'Loteamento Planalto do Sol', 'Santa Bárbara D\'Oeste', 'SP', '13454360', '', '', '', '', '')
,('50', 'Vitor', 'Cesar Lulio', '1988888888', '19996258494', '', 'Rua Maceió', '111', 'Loteamento Planalto do Sol', 'Santa Bárbara D\'Oeste', 'SP', '13454360', '', '', '', '', '')
,('51', 'Vitor', 'Cesar Lulio', '1988888888', '19996258494', '', 'Rua Maceió', '111', 'Loteamento Planalto do Sol', 'Santa Bárbara D\'Oeste', 'SP', '13454360', '', '', '', '', '')
,('52', 'Vitor', 'Cesar Lulio', '1231231231', '12312313131', '', 'Rua Maceió', '213123', 'Loteamento Planalto do Sol', 'Santa Bárbara D\'Oeste', 'SP', '13454360', '', '', '', '', '')
,('53', 'Vitoraqw', 'dqwe', '', '12312312312', '', 'Rua Maceió', '12312', 'Loteamento Planalto do Sol', 'Santa Bárbara D\'Oeste', 'SP', '13454360', '', '', '', '', '')
,('54', 'Vitor', 'Cesar Lulio', '', '12312313123', '', 'Rua Maceió', '435645', 'Loteamento Planalto do Sol', 'Santa Bárbara D\'Oeste', 'SP', '13454360', '', '', '', '', '')
,('55', 'Vitor', 'Cesar Lulio', '', '19222222222', '', 'Rua Maceió', '678', 'Loteamento Planalto do Sol', 'Santa Bárbara D\'Oeste', 'SP', '13454360', '', '', '', '', '')
,('56', 'Colégio ', 'Politec', '1934733396', '19996258494', '', 'Rua Maceió', '2000', 'Loteamento Planalto do Sol', 'Santa Bárbara D\'Oeste', 'SP', '13454360', '', '', '', '', '')
,('57', 'Vitor', 'Cesar', '', '1123123123_', '', 'Rua Maceió', '678', 'Loteamento Planalto do Sol', 'Santa Bárbara D\'Oeste', 'SP', '13454360', '', '', '', '', '')
,('58', 'asd', 'asdas', '', '32423423234', '', 'Rua Maceió', '45654', 'Loteamento Planalto do Sol', 'Santa Bárbara D\'Oeste', 'SP', '13454360', '', '', '', '', '')
,('59', 'qwdqwd', 'qdqwd', '', '213432423__', '', 'Rua Maceió', '132', 'Loteamento Planalto do Sol', 'Santa Bárbara D\'Oeste', 'SP', '13454360', '', '', '', '', '')
,('60', 'qwdqwd', 'qdqwd', '', '213432423__', '', 'Rua Maceió', '132', 'Loteamento Planalto do Sol', 'Santa Bárbara D\'Oeste', 'SP', '13454360', '', '', '', '', '')
,('61', 'wsedfw', 'weffwe', '', '23423423423', '', 'Rua Maceió', '32423', 'Loteamento Planalto do Sol', 'Santa Bárbara D\'Oeste', 'SP', '13454360', '', '', '', '', '')
,('62', 'Vitin', '019', '', '19777777777', '', 'Rua Maceió', '678', 'Loteamento Planalto do Sol', 'Santa Bárbara D\'Oeste', 'SP', '13454360', '', '', '', '', '')
,('63', 'vvv', 'vvv', '', '11111111111', '', 'Rua Maceió', '111', 'Loteamento Planalto do Sol', 'Santa Bárbara D\'Oeste', 'SP', '13454360', '', '', '', '', '')
,('64', 'dqw', 'qwdqw', '', '12312313131', '', 'Rua Maceió', '1231', 'Loteamento Planalto do Sol', 'Santa Bárbara D\'Oeste', 'SP', '13454360', '', '', '', '', '')
,('65', 'EDQWDFQW', 'DQWDQW', '', '12312312312', '', 'Rua Maceió', '12312', 'Loteamento Planalto do Sol', 'Santa Bárbara D\'Oeste', 'SP', '13454360', '', '', '', '', '')
,('66', 'sdfsdf', 'sdfsdf', '', '24234234234', '', 'Rua Maceió', '232', 'Loteamento Planalto do Sol', 'Santa Bárbara D\'Oeste', 'SP', '13454360', '', '', '', '', '')
,('67', 'r5tyrt', 'yrtyrt', '', '23432423423', '', 'Rua Maceió', '23423', 'Loteamento Planalto do Sol', 'Santa Bárbara D\'Oeste', 'SP', '13454360', '', '', '', '', '')
,('68', '12312sd', 'qwdqw', '', '12312312312', '', 'Rua Maceió', '312', 'Loteamento Planalto do Sol', 'Santa Bárbara D\'Oeste', 'SP', '13454360', '', '', '', '', '')
,('69', 'qwsdq', 'qwdqw', '', '12312312311', '', 'Rua Maceió', '123', 'Loteamento Planalto do Sol', 'Santa Bárbara D\'Oeste', 'SP', '13454360', '', '', '', '', '')
,('70', 'qwerqwe', 'qwdwq', '', '12312312123', '', 'Rua Maceió', 'qweqwe', 'Loteamento Planalto do Sol', 'Santa Bárbara D\'Oeste', 'SP', '13454360', '', '', '', '', '')
,('71', 'qwdq', 'qwdq', '', '12312312312', '', 'Rua Maceió', '123', 'Loteamento Planalto do Sol', 'Santa Bárbara D\'Oeste', 'SP', '13454360', '', '', '', '', '')
,('72', 'qweqwe', 'qweqw', '', '1231231312_', '', 'Rua Maceió', '123', 'Loteamento Planalto do Sol', 'Santa Bárbara D\'Oeste', 'SP', '13454360', '', '', '', '', '')
,('73', 'sfgs', 'gdfg', '', '21321312312', '', 'Rua Maceió', '123213', 'Loteamento Planalto do Sol', 'Santa Bárbara D\'Oeste', 'SP', '13454360', '', '', '', '', '')
,('74', 'fwe', 'wefew', '', '23424234234', '', 'Rua Maceió', '1231', 'Loteamento Planalto do Sol', 'Santa Bárbara D\'Oeste', 'SP', '13454360', '', '', '', '', '')
,('75', 'wserewrw', 'werwe', '', '23423432234', '', 'Rua Maceió', '12312', 'Loteamento Planalto do Sol', 'Santa Bárbara D\'Oeste', 'SP', '13454360', '', '', '', '', '')
,('76', 'qdqwd', 'qdqw', '1312312312', '12312312313', '', 'Rua Maceió', '12312', 'Loteamento Planalto do Sol', 'Santa Bárbara D\'Oeste', 'SP', '13454360', '', '', '', '', '')
,('77', 'qweqwdq', 'dqwadasd', '1231123123', '12312312312', '', 'Rua Maceió', '123', 'Loteamento Planalto do Sol', 'Santa Bárbara D\'Oeste', 'SP', '13454360', '', '', '', '', '')
,('78', 'Vitor', 'Cesar', '1934733396', '19996258494', '', 'Rua Maceió', '678', 'Loteamento Planalto do Sol', 'Santa Bárbara D\'Oeste', 'SP', '13454360', '', '', '', '', '')
,('79', 'qwdqw', 'qwdqw', '12________', '12312312312', '', 'Rua Maceió', '12312', 'Loteamento Planalto do Sol', 'Santa Bárbara D\'Oeste', 'SP', '13454360', '', '', '', '', '')
,('80', 'qwedqwd', 'qdqwd', '', '12312312313', '', 'Rua Maceió', '1231', 'Loteamento Planalto do Sol', 'Santa Bárbara D\'Oeste', 'SP', '13454360', '', '', '', '', '')
,('81', 'JU', 'JU', '1934588481', '19996258494', 'vitor@gmail.com', 'Rua 22 A', '234', 'Taquarussu', 'Palmas', 'TO', '77080116', '', '', '', '', '')
,('84', 'qwde', 'qwd', '', '31123131231', '', 'Rua Maceió', '123', 'Loteamento Planalto do Sol', 'Santa Bárbara D\'Oeste', 'SP', '13454360', '', '', '', '', '')
,('85', 'CONDOMINIO', 'CONDOMINIO', '', '11111111111', '', 'Rua Maceió', '123', 'Loteamento Planalto do Sol', 'Santa Bárbara D\'Oeste', 'SP', '13454360', 'ED', 'B', 'B1', 'CONDOMINIO', '')
,('90', 'Jose', 'Amarelis', '', '19876543222', '', 'Rua Maceió', '222', 'Loteamento Planalto do Sol', 'Santa Bárbara D\'Oeste', 'SP', '13454360', '', '', '', '', '')
;

#
# //Criação da Tabela : tb_pessoas
#

CREATE TABLE `tb_pessoas` (
  `pess_codigo` int(11) NOT NULL AUTO_INCREMENT,
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
  `pess_data_cadastro` timestamp(2) NOT NULL DEFAULT current_timestamp(2) ON UPDATE current_timestamp(2),
  PRIMARY KEY (`pess_codigo`),
  UNIQUE KEY `pess_cpfcnpj` (`pess_cpfcnpj`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 ;

#
# //Dados a serem incluídos na tabela
#

INSERT INTO tb_pessoas VALUES('28', 'F', 'C', 'v', '', 'd', '', '52268093875', '13454360', 'Rua Maceió', '123', 'Loteamento Planalto do Sol', 'Santa Bárbara D\'Oeste', 'SP', '', '', '', '', '', '2020-10-16 16:55:51.67')
;

#
# //Criação da Tabela : tb_receber_pagar
#

CREATE TABLE `tb_receber_pagar` (
  `crp_numero` int(11) NOT NULL AUTO_INCREMENT,
  `crp_parcela` int(11) NOT NULL,
  `crp_emissao` date NOT NULL,
  `crp_vencimento` date NOT NULL,
  `crp_valor` decimal(15,2) NOT NULL,
  `crp_datapagto` date DEFAULT NULL,
  `crp_pago` char(1) DEFAULT NULL,
  `crp_obs` varchar(255) DEFAULT NULL,
  `tpg_codigo` int(11) NOT NULL,
  `pess_codigo` int(11) NOT NULL,
  `orca_numero` int(11) NOT NULL,
  `crp_status` varchar(20) NOT NULL,
  `crp_tipo` char(1) NOT NULL,
  `crp_classificacao` varchar(80) NOT NULL,
  `crp_categoria` varchar(30) NOT NULL,
  PRIMARY KEY (`crp_numero`),
  KEY `fk_tpg_codigo` (`tpg_codigo`),
  CONSTRAINT `fk_tpg_codigo` FOREIGN KEY (`tpg_codigo`) REFERENCES `tb_tipo_pagamento` (`tpg_codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=89 DEFAULT CHARSET=utf8mb4 ;

#
# //Dados a serem incluídos na tabela
#

INSERT INTO tb_receber_pagar VALUES('73', '1', '2020-10-18', '2020-10-26', '333.33', '', '', '', '18', '28', '0', 'ABERTO', 'R', 'garantia', '')
,('74', '2', '2020-10-18', '2021-01-01', '333.33', '2020-10-28', '', '', '18', '28', '0', 'CANCELADO', 'R', 'garantia', '')
,('75', '3', '2020-10-18', '2021-02-01', '333.34', '', '', '', '18', '28', '0', 'CANCELADO', 'R', 'garantia', '')
,('76', '1', '2020-10-18', '2020-10-18', '10000.00', '', '', '', '17', '28', '0', 'CANCELADO', 'R', 'garantia', '')
,('77', '1', '2020-10-18', '2020-10-18', '2900.00', '', '', '', '17', '28', '0', 'PAGO', 'R', 'garantia', '')
,('78', '1', '2020-10-19', '2020-11-19', '46.67', '', '', '', '18', '28', '0', 'PAGO', 'R', 'Garantia', '')
,('79', '2', '2020-10-19', '2020-12-19', '46.67', '', '', '', '18', '28', '0', 'PAGO', 'R', 'Garantia', '')
,('80', '3', '2020-10-19', '2021-01-19', '46.66', '', '', '', '18', '28', '0', 'PAGO', 'R', 'Garantia', '')
,('81', '1', '2020-10-19', '2020-10-31', '333.33', '', '', '', '19', '28', '0', 'PAGO', 'R', 'Título', '')
,('82', '2', '2020-11-19', '2020-11-30', '333.33', '', '', '', '19', '28', '0', 'PAGO', 'R', 'Título', '')
,('83', '3', '2020-10-19', '2020-12-31', '333.34', '', '', '', '19', '28', '0', 'PROTESTADO', 'R', 'Título', '')
,('84', '1', '2020-10-19', '2021-01-31', '333.33', '', '', '', '19', '28', '0', 'ABERTO', 'R', 'Título', '')
,('85', '2', '2020-10-19', '2021-02-28', '333.33', '', '', '', '19', '28', '0', 'NEGOCIADO', 'R', 'Título', '')
,('86', '3', '2020-10-19', '2021-03-31', '333.34', '', '', '', '19', '28', '0', 'PAGO', 'R', 'Título', '')
,('87', '1', '2020-10-19', '2020-10-19', '1.00', '', '', '', '17', '28', '0', 'PAGO', 'R', '', '')
,('88', '1', '2020-10-29', '2020-11-05', '1000.00', '', '', 'PAGAR', '18', '28', '0', 'PAGO', 'P', 'Energia', 'Energia')
;

#
# //Criação da Tabela : tb_tentativas
#

CREATE TABLE `tb_tentativas` (
  `ten_id` int(11) NOT NULL AUTO_INCREMENT,
  `ten_ip` varchar(20) NOT NULL,
  `ten_data` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`ten_id`)
) ENGINE=InnoDB AUTO_INCREMENT=322 DEFAULT CHARSET=utf8mb4 ;

#
# //Dados a serem incluídos na tabela
#


#
# //Criação da Tabela : tb_tipo_pagamento
#

CREATE TABLE `tb_tipo_pagamento` (
  `tpg_codigo` int(11) NOT NULL AUTO_INCREMENT,
  `tpg_descricao` varchar(45) NOT NULL,
  `tpg_parcelas` int(10) NOT NULL,
  `tpg_observacao` varchar(510) DEFAULT NULL,
  PRIMARY KEY (`tpg_codigo`),
  UNIQUE KEY `tpg_descricao` (`tpg_descricao`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 ;

#
# //Dados a serem incluídos na tabela
#

INSERT INTO tb_tipo_pagamento VALUES('17', 'Cartão de Crédito 1x', '1', '')
,('18', 'Dinheiro 2x', '2', '')
,('19', 'Dinheiro 3x', '3', '')
;

#
# //Criação da Tabela : tb_usuarios
#

CREATE TABLE `tb_usuarios` (
  `usu_codigo` int(11) NOT NULL AUTO_INCREMENT,
  `usu_login` varchar(45) NOT NULL,
  `usu_senha` varchar(90) NOT NULL,
  `usu_data_cadastro` timestamp(2) NOT NULL DEFAULT current_timestamp(2),
  `usu_nome` varchar(80) DEFAULT NULL,
  `usu_sobrenome` varchar(80) DEFAULT NULL,
  `usu_permissoes` varchar(20) NOT NULL,
  `usu_status` char(1) NOT NULL,
  PRIMARY KEY (`usu_codigo`),
  UNIQUE KEY `usu_login` (`usu_login`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 ;

#
# //Dados a serem incluídos na tabela
#

INSERT INTO tb_usuarios VALUES('3', 'ADMINISTRADOR', '$2y$10$Ge4WNj4lDQKpxUvwAqo2lu67rxKDz3K20TqJPlufOB1QR1yQj7/Oe', '2020-08-30 20:09:21.12', 'Administrador', 'do Sitema', 'admin', 'A')
,('7', 'JOAOMARCELO', '$2y$10$/7hJFO1ODY7OF.IILzCaje/Ig.93cPz.EN9Rp9ZkRXgM6inJU81/u', '2020-08-30 20:09:24.47', 'Joao', 'Marcelo', 'user', 'A')
,('14', 'PERINI', '$2y$10$2SLTgm8p4LkYhL/Xp3cVROgvVmCC9UEwlrXi4wRlQocK2WX8Q0MWi', '2020-08-30 19:43:04.59', 'Vinicius', 'Perini', 'user', 'A')
,('17', 'SOUZA', '$2y$10$35yDsRLnszHGRS57T8zqhOYaTBoupwueBaJIVwhBNMV/XvUeS0..W', '2020-08-30 19:43:06.40', 'vinicius', 'souza', 'admin', 'A')
,('32', 'VITOR', '$2y$10$YFNMYp2wgzvdzGxSBchpUelOmbG8QU8f6Op.85hRv.RSnBF/5Bv8u', '2020-09-19 13:19:32.38', 'Vitor', 'Cesar', 'user', 'A')
;
