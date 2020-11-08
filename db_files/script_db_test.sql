drop database if exists IADireito;

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
	pub_clas_id bigserial not null,
	pub_id bigserial not null,
	conteudo varchar,
	estrutura varchar(32),
	numero_cnj serial not null,
	numero_processo varchar(32),
	natureza_processual serial not null,
	vara varchar(32),
	estado char(2),
	comarca varchar(32),
	juiz varchar(32),
	decisao_tipo serial not null,
	peca_produzir serial not null,
	inicio_prazo date,
	prazo int,
	dias_uteis boolean,
	fim_prazo date,
	ha_custas boolean,
	id_user serial not null,
	id_user2 serial not null,
	constraint pk_publicacoes_classificadas primary key(pub_clas_id),
	constraint fk_publicacoes_nao_classificadas foreign key(pub_id)
		references processos.publicacao_uniritter(pub_id),
	constraint fk_numero_cnj foreign key(numero_cnj) 
		references processos.cnj(cnj_id),
	constraint fk_id_user foreign key(id_user) 
		references processos.usuario(user_id),
	constraint fk_id_user2 foreign key(id_user) 
		references processos.usuario(user_id),
	constraint fk_natureza_processual foreign key(natureza_processual) 
		references processos.natureza_processual(nat_id),
	constraint fk_decisao_tipo foreign key(decisao_tipo) 
		references processos.decisao_tipo(dec_id),
	constraint fk_peca_produzir foreign key(peca_produzir) 
		references processos.peca_produzir(pec_id)
);

--removendo coluna conteudo da tabela nova
alter table processos.publicacoes_classificadas
drop column if exists conteudo;

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
	num_proc varchar not null,
	num_cnj json not null,
	constraint pk_cnj_id primary key (cnj_id)
);

drop table if exists processos.controle;

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
	pub_adv_id bigserial not null,
	adv_id serial not null,
	pub_clas_id bigserial not null,
	constraint pk_publicacao_advogado primary key(pub_adv_id),
	constraint fk_advogado foreign key(adv_id) 
		references processos.advogado(adv_id),
	constraint fk_publicacoes_classificadas foreign key(pub_clas_id) 
		references processos.publicacoes_classificadas(pub_clas_id)
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
	nome varchar(32) not null,
	parte varchar(32) not null,
	pub_clas_id bigserial not null,
	constraint pk_partes primary key(partes_id),
	constraint fk_publicacoes_classificadas foreign key(pub_clas_id) 
		references processos.publicacoes_classificadas(pub_clas_id)
);

--procedure para salvar partes

drop function processos.selec_pub_nao_classif;

create function processos.selec_pub_nao_classif() 
	returns table(pub_id bigint, 
				  pub_numero_processo varchar,
				  pub_conteudo varchar)
	as $$ 
	begin
		return query select (pu.pub_id::bigint, 
				pu.pub_numero_processo::text,
				pu.pub_conteudo::text)
		from processos.publicacao_uniritter pu left join processos.controle c
		on pu.pub_id = c.pub_n_classif_id
		where c.pub_n_classif_id is null;
	
	end; $$
language plpgsql;


select * from selec_pub_nao_classif();
		
drop procedure if exists processos.salva_pub_class;

--procedure definitiva
--procedure salva pub_classif
create procedure processos.salva_pub_class(
		pub_old_id in int,
		conteudo IN varchar,
		estrutura IN varchar(32),
		numero_cnj IN int,
		numero_processo IN varchar(32),
		natureza_processual IN varchar(32),
		vara IN varchar(32),
		estado IN char(2),
		comarca IN varchar(32),
		juiz IN varchar(32),
		decisao_tipo IN varchar(32),
		peca_produzir IN varchar(32),
		inicio_prazo IN date,
		prazo IN int,
		dias_uteis IN boolean,
		fim_prazo IN date,
		ha_custas IN boolean,
		IDreturn INOUT bigint
		)
language plpgsql
as $$
begin
	insert into processos.publicacoes_classificadas(
		estrutura,
		numero_cnj,
		numero_processo,
		natureza_processual,
		vara,
		estado,
		comarca,
		juiz,
		decisao_tipo,
		peca_produzir,
		inicio_prazo,
		prazo,
		dias_uteis,
		fim_prazo,
		ha_custas
		)
	values (estrutura,
			numero_cnj,
			numero_processo,
			natureza_processual,
			vara,
			estado,
			comarca,
			juiz,
			decisao_tipo,
			peca_produzir,
			inicio_prazo,
			prazo,
			dias_uteis,
			fim_prazo,
			ha_custas
		   );
		  
	select currval into IDreturn from currval(pg_get_serial_sequence('processos.publicacoes_classificadas', 'pub_clas_id'));

	insert into processos.controle
	values(
		default,
		pub_old_id,
		IDreturn
		);
	
	commit;
end; $$

drop procedure if exists salva_advogado; 

create procedure processos.salva_advogado(
	adv_nome in varchar(64),
	adv_oab in varchar(32),
	adv_estado in char(2),
	pub_id in int
	)	
	language plpgsql
	as $$
	begin
		
		insert into processos.advogado
		values(
			default,
			adv_nome,
			adv_oab,
			adv_estado
			);
		
		insert into processos.publicacao_advogado
		values(
			default,
			currval(pg_get_serial_sequence('processos.advogado', 'adv_id')),
			pub_id
		);
	
		commit;
	end $$

--teste call procedure pub_class
call processos.salva_pub_class(
				526934655,
				'conteudo',
				'abc',  
				123, 
				'123br',
				'natureza',
				'vara' ,
				'rs', 
				'comarca', 
				'juiz', 
				'decisao', 
				'peca',
				'2020-10-10', 
				12, 
				true, 
				NULL, 
				true,
				0);
			

--teste call procedure adv
call salva_advogado(
		'dr fulano de tal',
		'oab123',
		'rs',
		1);	
	
				