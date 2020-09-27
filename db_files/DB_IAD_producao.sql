create database processos;

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

--table advogado
create table processos.advogado (
	adv_id serial not null,
	adv_nome varchar(64)not null,
	adv_oab varchar(32)null,	
	constraint pk_advogado primary key(adv_id)
);

--table publicacao advogado nxm
create table publicacao_advogado (
	pub_adv_id bigserial not null,
	adv_id int not null,
	pub_id bigint not null,
	constraint pk_publicacao_advogado primary key(pub_adv_id)
);

--table natureza processual
create table natureza_processual (
	nat_id serial not null,
	nat_descricao varchar(32) not null,
	constraint pk_natureza_processual primary key(nat_id)
);

--table tipo de decisao
create table decisao_tipo (
	dec_id serial not null,
	dec_descricao varchar(32) not null,
	constraint pk_decisao_tipo primary key(dec_id)
);

--table peça a produzir
create table peca_produzir (
	pec_id serial not null,
	pec_descricao varchar(32) not null,
	constraint pk_peca_produzir primary key(pec_id)
);

--table publicacoes classificadas


--procedure busca pub_nao_classif


--procedure salva pub_classif
