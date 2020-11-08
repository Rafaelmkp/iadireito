--function para buscar publicacao nao classificada
drop function if exists processos.select_pub_nao_classif;

create function processos.select_pub_nao_classif() 
	returns table(pub_id bigint, 
				  pub_conteudo varchar)
	as $$ 
	begin
		return query select (pu.pub_id::bigint, 
				pu.pub_conteudo::text)
		from processos.publicacao_uniritter pu left join processos.leitura l
		on pu.pub_id = c.pub_n_classif_id
		where l.pub_n_classif_id is null
		and ;
	
	end; $$
language plpgsql;


select * from selec_pub_nao_classif();

drop procedure if exists processos.salva_pub_class;

--procedure definitiva
--procedure salva pub_classif
create procedure processos.salva_pub_class(
		pub_old_id in int,
		est_id IN int,
		pclas_num_processo IN varchar(32),
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

--procedure para salvar partes
	
	
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