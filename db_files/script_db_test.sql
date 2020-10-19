drop database if exists IADireito;

create database processos;

create schema processos;

--table publicacao nao-classificadas
CREATE TABLE processos.publicacao_unirriter (
	pub_id bigserial NOT NULL,
	pub_cnj_id int8 NOT NULL DEFAULT 1,
	pub_cnj bool NOT NULL DEFAULT false,
	pub_numero_processo varchar NULL,
	pub_numerocnj jsonb NULL,
	pub_tj_id int8 NULL,
	pub_tj_descricao varchar NULL,
	pub_jor_id int8 NULL,
	pub_jor_edicao int8 NULL,
	pub_jor_data_publicacao date NULL,
	pub_pagina int4 NULL,
	pub_orgao varchar NULL,
	pub_vara varchar NULL,
	pub_cidade varchar NULL,
	pub_estado varchar NULL,
	pub_hash varchar NOT NULL,
	pub_conteudo text NOT NULL,
	pub_conteudo_tsvector tsvector NULL,
	"language" text NOT NULL DEFAULT 'portuguese'::text,
	pub_data_processado timestamptz NULL DEFAULT now(),
	pub_conteudo_tratado text NULL,
	advogado_mapeado bool NULL,
	advogado_mapeado_erro bool NULL,
	pub_cnj_revisado bool NULL,
	CONSTRAINT pk_publicacao_unirriter PRIMARY KEY (pub_id)
);

--table publicacoes classificadas
create table processos.publicacoes_classificadas (
	pub_clas_id bigserial not null,
	estrutura varchar(32),
	numero_cnj int8,
	numero_processo varchar(32),
	natureza_processual varchar(32),
	vara varchar(32),
	estado char(2),
	comarca varchar(32),
	juiz varchar(32),
	decisao_tipo varchar(32),
	peca_produzir varchar(32),
	inicio_prazo date,
	prazo int,
	dias_corridos boolean,
	dias_uteis boolean,
	fim_prazo date,
	ha_custas boolean,
	constraint pk_publicacoes_classificadas primary key(pub_clas_id)
);

--table controle classificacao
create table processos.controle (
	controle_id bigserial not null,
	pub_n_classif_id bigint not null,
	leitura boolean default false,
	classificado boolean default false,
	constraint pk_controle primary key (controle_id),
	constraint fk_pub_n_classif 
		foreign key (pub_n_classif_id) 
			references processos.publicacao_unirriter(pub_id)
);

--table advogado
create table processos.advogado (
	adv_id serial not null,
	adv_nome varchar(64)not null,
	adv_oab varchar(32)null,
	adv_estado char(2)null,
	constraint pk_advogado primary key(adv_id)
);

--table publicacao advogado nxm
create table processos.publicacao_advogado (
	pub_adv_id bigserial not null,
	adv_id serial not null,
	pub_clas_id bigserial not null,
	constraint pk_publicacao_advogado primary key(pub_adv_id),
	constraint fk_advogado 
		foreign key(adv_id) 
			references processos.advogado(adv_id),
	constraint fk_publicacoes_classificadas 
		foreign key(pub_clas_id) 
			references processos.publicacoes_classificadas(pub_clas_id)
);

--table natureza processual
create table processos.natureza_processual (
	nat_id serial not null,
	nat_descricao varchar(32) not null,
	constraint pk_natureza_processual primary key(nat_id)
);

--table tipo de decisao
create table processos.decisao_tipo (
	dec_id serial not null,
	dec_descricao varchar(32) not null,
	constraint pk_decisao_tipo primary key(dec_id)
);

--table peca a produzir
create table processos.peca_produzir (
	pec_id serial not null,
	pec_descricao varchar(32) not null,
	constraint pk_peca_produzir primary key(pec_id)
);

--table partes autor ou reu
create table processos.partes (
	partes_id bigserial not null,
	nome varchar(32) not null,
	parte varchar(32) not null,
	pub_clas_id bigserial not null,
	constraint pk_partes primary key(partes_id),
	constraint fk_publicacoes_classificadas 
		foreign key(pub_clas_id) 
			references processos.publicacoes_classificadas(pub_clas_id)
);


insert into natureza 
values (default,'branco' ,''),
       (default,'administrativa' ,'Administrativa'),
       (default, 'bancaria','Bancária'),
       (default, 'civil', 'Civil'),
       (default, 'empresarial', 'Empresarial'),
       (default, 'familia', 'Família'),
       (default, 'penal', 'Penal'),
       (default, 'trabalhista', 'Trabalhista');
      
insert into tipo_decisao 
values (default, 'branco', ''),
       (default, 'acordao', 'Acórdão'),
       (default, 'interlocutoria', 'Descisão Interlocutória'),
       (default, 'despacho', 'Despacho'),
       (default, 'sentenca', 'Sentença');
      
insert into peca_produzir
values (default, 'branco', ''),
       (default, 'instrumento', 'Agravo de Instrumento'),
       (default, 'interno', 'Agravo Interno'),
       (default, 'agv_rec_especial', 'Agravo em Recurso Especial'),
       (default, 'agv_rec_extraordinario', 'Agravo em Recurso Extraordinário'),
       (default, 'regimental', 'Agravo Regimental'),
       (default, 'apelacao', 'Apelação'),
       (default, 'carta', 'Carta Testemunhável'),
       (default, 'declaratorios', 'Embargos declaratórios'),
       (default, 'divergencia', 'Embargos de divergência'),
       (default, 'infringentes', 'Embargos infringentes'),
       (default, 'corpus', 'Habeas Corpus'),
       (default, 'data', 'Habeas Data'),
       (default, 'seguranca', 'Mandado de Segurança'),
       (default, 'manifestacao', 'Manifestação'),
       (default, 'rec_adm', 'Recurso administrativo'),
       (default, 'estrito', 'Recurso em Sentido Estrito'),
       (default, 'rec_especial', 'Recurso Especial'),
       (default, 'extraordinario', 'Recurso Extraordinário'),
       (default, 'ordinario', 'Recurso Ordinário'),
       (default, 'revisao', 'Revisão Criminal'),
       (default, 'revista', 'Recurso de Revista');

insert into tb_pub 
values (526934655,	10146860,	'VERDADEIRO',	0011036352020826010000000000000000,
'{"ano": 2020, "digito": 35, "origem": 100, "justica": 8, "tribunal": 26, "sequencia": 11036}',
586,'', 978655, 3063, '2020-06-16' , 53, '', NULL, '', '',	'471BB7C520CD15F3F0F823F92B65E5BD57B32696A1E022502ECA881F1D78D744',
'Fóruns Centrais


Fórum João Mendes Júnior


JUÍZO DE DIREITO DA 3ª VARA CÍVEL

JUIZ(A) DE DIREITO MONICA DI STASI GANTUS ENCINAS

ESCRIVÃ(O) JUDICIAL MARTA LUCIANA GUTIERREZ PUMAR

EDITAL DE INTIMAÇÃO DE ADVOGADOS


RELAÇÃO Nº 0305/2020

Processo 0011036-35.2020.8.26.0100 (processo principal 0063683-85.2012.8.26.0100) - Cumprimento de sentença

- Rescisão / Resolução - SHOP TOUR TV LTDA - Canal 57 Rede de Televisão Ltda - Recolha as custas pertinentes ao(s)

pedido(s). Após, conclusos. - ADV: ELIAN PRADO CAETANO (OAB 19788/PR), PAULO SERGIO DE OLIVEIRA BORGES (OAB

56368/PR), BRUNO PUERTO CARLIN (OAB 194949/SP)',	
'0011036'':40 ''0063683'':48 ''0100'':45,53 ''0305'':37 ''194949'':98 ''19788'':84 ''2012'':50 ''2020'':38,42 ''26'':44,52 ''3'':11 ''35'':41 ''56368'':92 ''57'':64 ''8'':43,51 ''85'':49 ''adv'':79 ''advog'':34 ''apos'':77 ''borg'':90 ''brun'':94 ''caetan'':82 ''canal'':63 ''carlin'':96 ''centr'':2 ''civel'':13 ''conclus'':78 ''cumpriment'':54 ''cust'':71 ''di'':19 ''direit'':9,17 ''edital'':30 ''elian'':80 ''encin'':22 ''escriv'':23 ''forum'':3 ''foruns'':1 ''gantus'':21 ''gutierrez'':28 ''intimaca'':32 ''joa'':4 ''judicial'':25 ''juiz'':7,14 ''junior'':6 ''ltda'':62,68 ''lucian'':27 ''mart'':26 ''mend'':5 ''monic'':18 ''n'':36 ''oab'':83,91,97 ''oliveir'':89 ''paul'':86 ''ped'':75 ''pertinent'':72 ''pr'':85,93 ''prad'':81 ''principal'':47 ''process'':39,46 ''puert'':95 ''pum'':29 ''recolh'':69 ''red'':65 ''relaca'':35 ''rescisa'':57 ''resoluca'':58 ''s'':74,76 ''sentenc'':56 ''sergi'':87 ''shop'':59 ''sp'':99 ''stas'':20 ''televisa'':67 ''tour'':60 ''tv'':61 ''var'':12',
'portuguese',
'2020-07-12',
'foruns centrais forum joao mendes junior juizo de direito da 3 vara civel juiz a de direito monica di stasi gantus encinas escriva o judicial marta luciana gutierrez pumar edital de intimacao de advogados relacao n 0305 2020 processo 0011036 35 2020 8 26 0100 processo principal 0063683 85 2012 8 26 0100 cumprimento de sentenca rescisao resolucao shop tour tv ltda canal 57 rede de televisao ltda recolha as custas pertinentes ao s pedido s apos conclusos adv elian prado caetano oab 19788 pr paulo sergio de oliveira borges oab 56368 pr bruno puerto carlin oab 194949 sp'
);

select pub_id from tb_pub where pub_id = 526934655;


