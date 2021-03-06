--FUNCTION BUSCAR PUBLICACAO NAO CLASSIFICADA
drop function if exists processos.select_pub_nao_classif;

create function processos.select_pub_nao_classif() 
	returns table(pub_id bigint, 
				  pub_conteudo varchar)
	as $$
	declare
		old_id bigint;
	begin
		select pu.pub_id::bigint into old_id
		from processos.publicacao_uniritter pu 
		left join processos.publicacoes_classificadas pc
		on pu.pub_id = pc.pub_id
		left join processos.publicacao_leitura l 
		on pu.pub_id = l.pub_id
		where l.pub_id is null
		and pc.pub_id is null
		order by pu.pub_id
		limit 1;
	insert into processos.publicacao_leitura(pub_id, lec_date)
			values (old_id, now());
	return query select pu.pub_id::bigint,
				     	pu.pub_conteudo::character varying
				 from processos.publicacao_uniritter pu
				 where pu.pub_id = old_id;
	end; 
$$ language plpgsql;

		select pu.pub_id, pu.pub_conteudo
		from processos.publicacao_uniritter pu 
		left join processos.publicacoes_classificadas pc
		on pu.pub_id = pc.pub_id
		left join processos.publicacao_leitura l 
		on pu.pub_id = l.pub_id
		where l.pub_id is null
		and pc.pub_id is null
		order by pu.pub_id
		limit 1;

delete from processos.publicacao_leitura;
delete from processos.publicacoes_classificadas;
--necessario criar trigger para exclusao de publicaca_leitura



--PROCEDURE SALVA CLASSIFICACAO
drop procedure if exists processos.salva_pub_class;

create procedure processos.salva_pub_class(
		ipub_old_id in int,
		iest_id IN int,
		ipclas_num_processo IN varchar(32),
		inat_id IN int,
		ipclas_vara IN varchar(32),
		ipclas_estado IN char(2),
		ipclas_comarca IN varchar(32),
		ipclas_juiz IN varchar(32),
		idec_id IN int,
		ipec_id IN int,
		ipclas_inicio_prazo IN date,
		ipclas_prazo IN int,
		ipclas_dias_uteis IN boolean,
		ipclas_fim_prazo IN date,
		ipclas_ha_custas IN boolean,
		ipclas_val_custas in numeric,
		iuser_id IN int,
		IDreturn INOUT bigint
		)
language plpgsql
as $$
begin
	insert into processos.publicacoes_classificadas(
		pub_id,
		est_id,
		pclas_num_processo,
		nat_id,
		pclas_vara,
		pclas_estado,
		pclas_comarca,
		pclas_juiz,
		dec_id,
		pec_id,
		pclas_inicio_prazo,
		pclas_prazo,
		pclas_dias_uteis,
		pclas_fim_prazo,
		pclas_ha_custas,
		pclas_val_custas,
		user_id
		)
	values (ipub_old_id,
		iest_id,
		ipclas_num_processo,
		inat_id,
		ipclas_vara,
		ipclas_estado,
		ipclas_comarca,
		ipclas_juiz,
		idec_id,
		ipec_id,
		ipclas_inicio_prazo,
		ipclas_prazo,
		ipclas_dias_uteis,
		ipclas_fim_prazo,
		ipclas_ha_custas,
		ipclas_val_custas,
		iuser_id
		   );
		  
	select currval into IDreturn from currval(pg_get_serial_sequence('processos.publicacoes_classificadas', 'pclas_id'));

	commit;
end; $$

--PROCEDURE PARA SALVAR ADVOGADO
drop procedure if exists salva_advogado; 

create procedure processos.salva_advogado(
	iadv_nome in varchar(64),
	iadv_oab in varchar(32),
	ipclas_id in int
	)	
	language plpgsql
	as $$
	begin
		
		insert into processos.advogado
		values(
			default,
			iadv_nome,
			iadv_oab
			);
		
		insert into processos.publicacao_advogado
		values(
			default,
			currval(pg_get_serial_sequence('processos.advogado', 'adv_id')),
			ipclas_id
		);
	
		commit;
	end $$

	
drop procedure if exists processos.salva_partes;

create procedure processos.salva_partes(	
	ipartes_nome in varchar(64),
	ipartes_is_reu in boolean,
	ipclas_id in int
	)	
	language plpgsql
	as $$
	begin
		
		insert into processos.partes
		values(
			default,
			ipartes_nome,
			ipartes_is_reu,
			ipclas_id
			);
	
		commit;
	end $$

delete from publicacoes_classificadas;

select * from publicacoes_classificadas;
	
--teste call procedure pub_class
call processos.salva_pub_class(
			4,
			3,
			'ddd',
			2,
			'ds',
			'AL',
			'Barra de Santo Antonio',
			'',
		1,
		1,
		'2020-12-20',
		0,
		true,
		'2020-12-20',
		true,
		0,
		3,
		0);

--teste call procedure adv
call salva_advogado(
		'dr fulano de tal',
		'oab123',
		'rs',
		1);	