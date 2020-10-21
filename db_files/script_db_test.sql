drop database if exists IADireito;

create database processos;

create schema processos;

--table publicacao nao-classificadas
CREATE TABLE processos.publicacao_uniritter (
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

drop procedure save_pub_teste;

--procedure para teste
create procedure save_pub_teste(estrutura IN varchar(32),
								 numero_cnj IN int8,
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
								 vclass_id INOUT bigint
								)
LANGUAGE plpgsql
as $$
begin
	
	insert into processos.publicacoes_classificadas(estrutura,
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
	
	select pub_clas_id into vclass_id
	from processos.publicacoes_classsificadas
	where pub_clas_id = currval('pub_clas_id_pub_seq');


	select pub_clas_id, numero_processo from processos.publicacoes_classificadas
	where pub_clas_id = vclass_id;
	commit;
end; $$



--procedure definitiva
--procedure salva pub_classif
	--salvar publicacao
create procedure salva_pub_class(estrutura IN varchar(32),
								 numero_cnj IN int8,
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
	insert into processos.publicacoes_classificadas(estrutura,
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
   
	update processos.contole
	set leitura = false,
		classificado = true,
	where ------

	select into IDreturn from currval('pub_clas_id_pub_seq');
	commit;
end; $$



