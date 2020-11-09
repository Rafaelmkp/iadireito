drop database if exists processos;

create database processos;

create schema processos;

--table publicacao nao-classificadas
CREATE TABLE processos.publicacao_uniritter (
	pub_id bigserial NOT NULL,
	pub_numero_processo varchar NULL,
	pub_numerocnj jsonb NULL,
	pub_tj_id int8 NULL,
	pub_tj_descricao varchar NULL,
	pub_jor_edicao int8 NULL,
	pub_jor_data_publicacao date NULL,
	pub_pagina int4 NULL,
	pub_hash varchar NOT NULL,
	pub_conteudo text NOT NULL,
	pub_conteudo_tsvector tsvector NULL,
	"language" text NOT NULL DEFAULT 'portuguese'::text,
	pub_conteudo_tratado text NULL,
	CONSTRAINT pk_publicacao_unirriter PRIMARY KEY (pub_id)
);

--table publicacoes classificadas
create table processos.publicacoes_classificadas (
	pclas_id bigserial not null,
	pub_id bigint not null,
	est_id int not null,
	cnj_id bigint null,
	pclas_num_processo varchar(32) null,
	nat_id int not null,
	pclas_vara varchar(32) null,
	pclas_estado char(2) null,
	pclas_comarca varchar(32) null,
	pclas_juiz varchar(32),
	dec_id int not null,
	pec_id int not null,
	pclas_inicio_prazo date null,
	pclas_prazo int null,
	pclas_dias_uteis boolean null,
	pclas_fim_prazo date null,
	pclas_ha_custas boolean null,
	user_id int not null,
	user2_id int null,
	constraint pk_publicacoes_classificadas primary key(pclas_id),
	constraint fk_publicacoes_nao_classificadas foreign key(pub_id)
		references processos.publicacao_uniritter(pub_id),
	constraint fk_estrutura foreign key(est_id)
		references processos.estrutura_jud(est_id),
	constraint fk_numero_cnj foreign key(cnj_id) 
		references processos.cnj(cnj_id),
	constraint fk_id_user foreign key(user_id) 
		references processos.usuario(user_id),
	constraint fk_id_user2 foreign key(user2_id) 
		references processos.usuario(user_id),
	constraint fk_natureza_processual foreign key(nat_id) 
		references processos.natureza_processual(nat_id),
	constraint fk_decisao_tipo foreign key(dec_id) 
		references processos.decisao_tipo(dec_id),
	constraint fk_peca_produzir foreign key(pec_id) 
		references processos.peca_produzir(pec_id)
);

alter table processos.publicacoes_classificadas
alter column nat_id type int;


--table usuario / fk na tabela nova ok
create table processos.usuario (
	user_id serial not null,
	user_login varchar not null,
	user_password varchar not null,
	constraint pk_user_id primary key(user_id)
);

--table cnj / fk na tabela nova ok
create table processos.cnj (
	cnj_id serial not null,
	cnj_num_proc varchar not null,
	cnj_num_cnj json not null,
	constraint pk_cnj_id primary key (cnj_id)
);


--table publicacao leitura
create table processos.publicacao_leitura (
	lec_id bigserial not null,
	pub_id bigserial not null,
	lec_date timestamptz NULL DEFAULT now(),
	constraint pk_lec_id primary key(lec_id),
	constraint fk_pub_id foreign key(pub_id) 
		references processos.publicacao_uniritter(pub_id)
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
	pclas_adv_id bigserial not null,
	adv_id serial not null,
	pclas_id bigserial not null,
	constraint pk_publicacao_advogado primary key(pclas_adv_id),
	constraint fk_advogado foreign key(adv_id) 
		references processos.advogado(adv_id),
	constraint fk_publicacoes_classificadas foreign key(pclas_id) 
		references processos.publicacoes_classificadas(pclas_id)
);


--table estrutura_jud / fk na tabela nova ok
create table processos.estrutura_jud (
	est_id serial not null,
	est_descricao varchar(32) not null,
	constraint pk_estrutura_jud primary key(est_id)
);

--table natureza processual / fk na tabela nova ok
create table processos.natureza_processual (
	nat_id serial not null,
	nat_descricao varchar(32) not null,
	constraint pk_natureza_processual primary key(nat_id)
);

--table tipo de decisao / fk na tabela nova ok
create table processos.decisao_tipo (
	dec_id serial not null,
	dec_descricao varchar(32) not null,
	constraint pk_decisao_tipo primary key(dec_id)
);

--table peca a produzir / fk na tabela nova ok
create table processos.peca_produzir (
	pec_id serial not null,
	pec_descricao varchar(32) not null,
	constraint pk_peca_produzir primary key(pec_id)
);

--table partes autor ou reu
create table processos.partes (
	partes_id bigserial not null,
	partes_nome varchar(64) not null,
	partes_is_reu boolean not null,
	pclas_id bigserial not null,
	constraint pk_partes primary key(partes_id),
	constraint fk_publicacoes_classificadas foreign key(pclas_id) 
		references processos.publicacoes_classificadas(pclas_id)
);

		
	
				