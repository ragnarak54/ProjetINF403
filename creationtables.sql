drop table LesLocataires;
drop table LesBillets;
drop table LesInscriptions;
drop table LesEpreuves;
drop table LesResultats;
drop table lesDossiers_base;
drop table LesDisciplines;
drop table LesLogements;
drop table lesbatiments;
drop table LesEquipes;
drop table LesSportifs;
drop view LesDossiers;


create table LesSportifs(
	nSportif integer,
	nomS varchar(30),
	prenomS varchar(30),
	pays varchar(30),
	categorie varchar(30),
	dateNais date,
	constraint pK_nsportif primary key (nSportif),
	constraint ch_nsportif check (nsportif > 0),
	constraint ch_categorie check (categorie in ('feminin', 'masculin')),
	constraint ch_unique unique (nomS, prenomS)
);

create table LesEquipes(
	nEquipe integer check(nEquipe > 0),
	nSportif integer references LesSportifs(nSportif),
	constraint pk_eq primary key (nSportif, nEquipe)
);

create table LesDisciplines(
	discipline varchar(30),
	constraint c4 primary key (discipline)
);

create table LesEpreuves(
	nEpreuve integer primary key,
	nomE varchar(30),
	forme varchar(30) check (forme in ('par equipe','individuelle','par couple')),
	discipline varchar(30) references LesDisciplines(discipline),
	categorie varchar(30) check (categorie in ('feminin','masculin','mixte')),
	nbs integer check (nbs>0),
	dateEpreuve date,
	prix integer check (prix > 0)
);

create table LesBatiments(
	nomBat varchar(30) primary key,
	numero integer check(numero>0),
	rue varchar(30),
	ville varchar(30)
);

create table LesInscriptions(
	nInscrit integer,
	nEpreuve integer references LesEpreuves(nEpreuve),
	constraint c1 primary key (nInscrit, nEpreuve)
);

create table LesResultats(
	nEpreuve integer,
	gold integer,
	silver integer,
	bronze integer,
	constraint pk_lesres primary key (nEpreuve),
	constraint ch_epreuve check (nEpreuve > 0),
	constraint ch_gold check (gold > 0),
	constraint ch_silver check (silver > 0),
	constraint ch_bronze check (bronze > 0)
);

create table LesLogements(
	nLogement integer check(nLogement>0),
	capacite integer check (capacite > 0),
	nomBat varchar(30) references LesBatiments(nomBat),
	constraint pk_log primary key(nLogement, nomBat)
);

create table LesLocataires(
	nSportif integer references LesSportifs(nSportif),
	nLogement integer,
	nomBat varchar(30),
	constraint pk_loc primary key(nSportif),
	foreign key (nlogement, nombat) references leslogements(nlogement, nombat)
);



create table LesDossiers_base(
	nDossier integer check(nDossier>0),
	nUtil varchar(30),
	dateEmission date,
	constraint pk_dos primary key(nDossier)
);

create table LesBillets(
	nBillet integer check(nBillet>0),
	nDossier integer,
	nEpreuve integer references LesEpreuves(nEpreuve),
	foreign key (nDossier) references LesDossiers_base(nDossier),
	constraint pk_bil primary key(nBillet, nDossier)
);

create view lesdossiers as
	select nDossier, nUtil, dateEmission, sum(prix) prix from JO_INF245.LesDossiers_base
	natural join JO_INF245.LesBillets natural join JO_INF245.LesEpreuves 
	group by nDossier, nUtil, dateEmission;

insert into lessportifs select * from JO_INF245.lessportifs;
insert into lesbatiments select * from JO_INF245.lesbatiments;
insert into lesequipes select * from JO_INF245.lesequipes;
insert into leslogements select * from JO_INF245.leslogements;
insert into lesDisciplines select * from JO_INF245.lesDisciplines;
insert into lesDossiers_base select * from JO_INF245.lesDossiers_base;
insert into lesResultats select * from JO_INF245.lesResultats;
insert into lesEpreuves select * from JO_INF245.lesEpreuves;
insert into lesInscriptions select * from JO_INF245.lesInscriptions;
insert into lesBillets select * from JO_INF245.lesBillets;
insert into lesLocataires select * from JO_INF245.lesLocataires;
commit;

