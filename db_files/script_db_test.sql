create table tb_pub(
	pub_id	integer primary key not null,
	pub_cnj_id integer,	
	pub_cnj	varchar(10),
	pub_numero_processo	varchar(64),
	pub_numerocnj varchar(256),
	pub_tj_id smallint,
	pub_tj_descricao varchar,
	pub_jor_id integer,	
	pub_jor_edicao smallint,	
	pub_jor_data_publicacao	date,
	pub_pagina smallint,	
	pub_orgao varchar(128),
	pub_vara smallint,
	pub_cidade varchar(64),
	pub_estado varchar(2),
	pub_hash varchar,
	pub_conteudo varchar,
	pub_conteudo_tsvector varchar,	
	language varchar(32),
	pub_data_processado date,
	pub_conteudo_tratado varchar,
	advogado_mapeado varchar(64),
	advogado_mapeado_erro varchar,
	pub_cnj_revisado boolean
);

insert into tb_pub 
values (526934655,	10146860,	'VERDADEIRO',	0011036352020826010000000000000000,
'{"ano": 2020, "digito": 35, "origem": 100, "justica": 8, "tribunal": 26, "sequencia": 11036}',
586,'', 978655, 3063, '2020-06-16' , 53, '', NULL, '', '',	'471BB7C520CD15F3F0F823F92B65E5BD57B32696A1E022502ECA881F1D78D744',
'F�runs Centrais


F�rum Jo�o Mendes J�nior


JU�ZO DE DIREITO DA 3� VARA C�VEL

JUIZ(A) DE DIREITO MONICA DI STASI GANTUS ENCINAS

ESCRIV�(O) JUDICIAL MARTA LUCIANA GUTIERREZ PUMAR

EDITAL DE INTIMA��O DE ADVOGADOS


RELA��O N� 0305/2020

Processo 0011036-35.2020.8.26.0100 (processo principal 0063683-85.2012.8.26.0100) - Cumprimento de senten�a

- Rescis�o / Resolu��o - SHOP TOUR TV LTDA - Canal 57 Rede de Televis�o Ltda - Recolha as custas pertinentes ao(s)

pedido(s). Ap�s, conclusos. - ADV: ELIAN PRADO CAETANO (OAB 19788/PR), PAULO SERGIO DE OLIVEIRA BORGES (OAB

56368/PR), BRUNO PUERTO CARLIN (OAB 194949/SP)',	
'0011036'':40 ''0063683'':48 ''0100'':45,53 ''0305'':37 ''194949'':98 ''19788'':84 ''2012'':50 ''2020'':38,42 ''26'':44,52 ''3'':11 ''35'':41 ''56368'':92 ''57'':64 ''8'':43,51 ''85'':49 ''adv'':79 ''advog'':34 ''apos'':77 ''borg'':90 ''brun'':94 ''caetan'':82 ''canal'':63 ''carlin'':96 ''centr'':2 ''civel'':13 ''conclus'':78 ''cumpriment'':54 ''cust'':71 ''di'':19 ''direit'':9,17 ''edital'':30 ''elian'':80 ''encin'':22 ''escriv'':23 ''forum'':3 ''foruns'':1 ''gantus'':21 ''gutierrez'':28 ''intimaca'':32 ''joa'':4 ''judicial'':25 ''juiz'':7,14 ''junior'':6 ''ltda'':62,68 ''lucian'':27 ''mart'':26 ''mend'':5 ''monic'':18 ''n'':36 ''oab'':83,91,97 ''oliveir'':89 ''paul'':86 ''ped'':75 ''pertinent'':72 ''pr'':85,93 ''prad'':81 ''principal'':47 ''process'':39,46 ''puert'':95 ''pum'':29 ''recolh'':69 ''red'':65 ''relaca'':35 ''rescisa'':57 ''resoluca'':58 ''s'':74,76 ''sentenc'':56 ''sergi'':87 ''shop'':59 ''sp'':99 ''stas'':20 ''televisa'':67 ''tour'':60 ''tv'':61 ''var'':12',
'portuguese',
'2020-07-12',
'foruns centrais forum joao mendes junior juizo de direito da 3 vara civel juiz a de direito monica di stasi gantus encinas escriva o judicial marta luciana gutierrez pumar edital de intimacao de advogados relacao n 0305 2020 processo 0011036 35 2020 8 26 0100 processo principal 0063683 85 2012 8 26 0100 cumprimento de sentenca rescisao resolucao shop tour tv ltda canal 57 rede de televisao ltda recolha as custas pertinentes ao s pedido s apos conclusos adv elian prado caetano oab 19788 pr paulo sergio de oliveira borges oab 56368 pr bruno puerto carlin oab 194949 sp'
);

select pub_id from tb_pub where pub_id = 526934655;