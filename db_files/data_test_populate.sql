set schema 'processos';

insert into processos.estrutura_jud
values (default, ' '),
	   (default, 'Federal'),
	   (default, 'Estadual');

insert into processos.natureza_processual 
values (default,' '),
       (default, 'Administrativa'),
       (default, 'Banc�ria'),
       (default, 'Civil'),
       (default, 'Empresarial'),
       (default, 'Fam�lia'),
       (default, 'Penal'),
       (default, 'Trabalhista');
      
insert into processos.decisao_tipo 
values (default, ''),
       (default, 'Ac�rd�o'),
       (default, 'Descis�o Interlocut�ria'),
       (default, 'Despacho'),
       (default, 'Senten�a');
      
insert into peca_produzir
values (default, ''),
       (default, 'Agravo de Instrumento'),
       (default, 'Agravo Interno'),
       (default, 'Agravo em Recurso Especial'),
       (default, 'Agravo em Recurso Extraordin�rio'),
       (default, 'Agravo Regimental'),
       (default, 'Apela��o'),
       (default, 'Carta Testemunh�vel'),
       (default, 'Embargos declarat�rios'),
       (default, 'Embargos de diverg�ncia'),
       (default, 'Embargos infringentes'),
       (default, 'Habeas Corpus'),
       (default, 'Habeas Data'),
       (default, 'Mandado de Seguran�a'),
       (default, 'Manifesta��o'),
       (default, 'Recurso administrativo'),
       (default, 'Recurso em Sentido Estrito'),
       (default, 'Recurso Especial'),
       (default, 'Recurso Extraordin�rio'),
       (default, 'Recurso Ordin�rio'),
       (default, 'Revis�o Criminal'),
       (default, 'Recurso de Revista');

insert into processos.publicacao_uniritter 
values (default, 'abc11122334455', null, 111, 
		'tj 111', null, null, null, 'hash 1234',
		'1111111111111111111111

PUBLICACAO EXEMPLO 1
PUBLICACAO EXEMPLO 1
PUBLICACAO EXEMPLO 1
PUBLICACAO EXEMPLO 1
PUBLICACAO EXEMPLO 1
PUBLICACAO EXEMPLO 1
PUBLICACAO EXEMPLO 1
PUBLICACAO EXEMPLO 1');

insert into processos.publicacao_uniritter 
values (default, 'cde9988776655', null, 222, 
		'tj 222', null, null, null, 'hash 2345',
		'22222222222222222222222

PUBLICACAO EXEMPLO 2
PUBLICACAO EXEMPLO 2
PUBLICACAO EXEMPLO 2
PUBLICACAO EXEMPLO 2
PUBLICACAO EXEMPLO 2
PUBLICACAO EXEMPLO 2
PUBLICACAO EXEMPLO 2
PUBLICACAO EXEMPLO 2');

insert into processos.publicacao_uniritter 
values (default, 'vfr9876543', null, 333, 
		'tj 333', null, null, null, 'hash 3456',
		'33333333333333333333333

PUBLICACAO EXEMPLO 3
PUBLICACAO EXEMPLO 3
PUBLICACAO EXEMPLO 3
PUBLICACAO EXEMPLO 3
PUBLICACAO EXEMPLO 3
PUBLICACAO EXEMPLO 3
PUBLICACAO EXEMPLO 3
PUBLICACAO EXEMPLO 3');

insert into processos.publicacao_uniritter 
values (default, 'vfr9876543', null, 444, 
		'tj 444', null, null, null, 'hash 4567',
		'44444444444444444444444

PUBLICACAO EXEMPLO 4
PUBLICACAO EXEMPLO 4
PUBLICACAO EXEMPLO 4
PUBLICACAO EXEMPLO 4
PUBLICACAO EXEMPLO 4
PUBLICACAO EXEMPLO 4
PUBLICACAO EXEMPLO 4
PUBLICACAO EXEMPLO 4');

insert into processos.publicacao_uniritter 
values (default, 'vfr9876543', null, 444, 
		'tj 444', null, null, null, 'hash 4567',
		'555555555555555555555555

PUBLICACAO EXEMPLO 5
PUBLICACAO EXEMPLO 5
PUBLICACAO EXEMPLO 5
PUBLICACAO EXEMPLO 5
PUBLICACAO EXEMPLO 5
PUBLICACAO EXEMPLO 5
PUBLICACAO EXEMPLO 5
PUBLICACAO EXEMPLO 5');

insert into processos.publicacao_uniritter 
values (default, 'vfr9876543', null, 444, 
		'tj 444', null, null, null, 'hash 4567',
		'666666666666666666666666

PUBLICACAO EXEMPLO 6
PUBLICACAO EXEMPLO 6
PUBLICACAO EXEMPLO 6
PUBLICACAO EXEMPLO 6
PUBLICACAO EXEMPLO 6
PUBLICACAO EXEMPLO 6
PUBLICACAO EXEMPLO 6
PUBLICACAO EXEMPLO 6');

select * from select_pub_nao_classif();

select * from processos.publicacao_leitura;

select * from processos.publicacao_uniritter;

select * from processos.publicacoes_classificadas;

delete from processos.publicacao_leitura;

delete from processos.publicacoes_classificadas;
