CREATE DATABASE MOVIEPASSDB;
USE MOVIEPASSDB;

#drop database MOVIEPASSDB

CREATE TABLE IF NOT EXISTS CINEMAS(
idCinema int auto_increment,
cinemaName varchar(30) not null,
adress varchar(50) not null,
adressNumber int not null,
openning Time,
closing Time,
ticketValue float default 0,
isActive boolean,
CONSTRAINT pk_idCinema primary key (idCinema)
); 

CREATE TABLE IF NOT EXISTS DISCOUNT_POLICIES(
idPolicy int auto_increment,
discount float default 0,
policyDescripton varchar(200),
CONSTRAINT pk_idPolicy primary key (idPolicy)
);

CREATE TABLE IF NOT EXISTS CINEMAS_X_DISCOUNT_POLICIES(
idCXDP int auto_increment,
idCinema int not null,
idPolicy int not null,
applies Date, # COMO HACEMOS QUE APLIQUE EL DESCUENTO? (Referencia a SHOWS, dia de la funcion)
CONSTRAINT pk_idCXDP primary key (idCXDP),
CONSTRAINT fk_idCinemaCXDP foreign key (idCinema) references CINEMAS(idCinema),
CONSTRAINT fk_idPolicy foreign key (idPolicy) references DISCOUNT_POLICIES(idPolicy)
);

CREATE TABLE IF NOT EXISTS ROOMS(
idRoom int auto_increment,
capacity int not null,
idCinema int not null,
CONSTRAINT pk_idRoom primary key (idRoom),
CONSTRAINT fk_idCinema foreign key (idCinema) references CINEMAS(idCinema),
CONSTRAINT chq_capacity CHECK (capacity > 0 AND capacity < 500)
);

CREATE TABLE IF NOT EXISTS SHOWS(
idShow int auto_increment,
startsAt DateTime not null,
spectators int default 0,
idRoom int not null,
idMovie int not null,
CONSTRAINT pk_idShow primary key (idShow),
CONSTRAINT fk_idRoom foreign key (idRoom) references ROOMS(idRoom),
CONSTRAINT fk_idMovie foreign key (idMovie) references MOVIES(idMovie)
);

CREATE TABLE IF NOT EXISTS GENRES(
idGenre int not null,
genreName varchar(50),
CONSTRAINT pk_idGenre primary key (idGenre)
);

CREATE TABLE IF NOT EXISTS MOVIES(
idMovie int not null,
duration int not null,
title varchar(50) not null,
poster varchar(100) not null, #esto es una URL ??
releaseDate Date,
movieDescription varchar(400),
CONSTRAINT pk_idMovie primary key (idMovie)
);

CREATE TABLE IF NOT EXISTS GENRES_X_MOVIES(
idGenre int not null,
idMovie int not null,
genreName varchar(50),
CONSTRAINT pk_idGenre_idMovie primary key (idGenre, idMovie),
CONSTRAINT fk_idGenre foreign key (idGenre) references GENRES(idGenre),
CONSTRAINT fk_idMovie foreign key (idMovie) references MOVIES(idMovie)
);

CREATE TABLE IF NOT EXISTS USERS(
username varchar(50), # poner restriccion en backend para limite de caracteres??
pass varchar(50), #ver hashing
email varchar(50) unique,
birthdate Date,
dni int,
isAdmin boolean default false,
CONSTRAINT pk_username primary key (username)
);

CREATE TABLE IF NOT EXISTS TRANSACTIONS(
idTransaction int auto_increment,
username varchar(50),
idDiscountPolicy int default null,
CONSTRAINT pk_idTransaction primary key (idTransaction),
CONSTRAINT fk_username foreign key (username) references USERS(username),
CONSTRAINT fk_idDiscountPolicy foreign key (idDiscountPolicy) references DISCOUNT_POLICIES(idPolicy)
);

CREATE TABLE IF NOT EXISTS TICKETS(
idTicket int auto_increment,
qrCode varchar(200), # URL para el qrCode
idShow int not null,
idTransaction int not null,
CONSTRAINT pk_idTicket primary key (idTicket),
CONSTRAINT fk_idShowTicket foreign key (idShow) references SHOWS(idShow),
CONSTRAINT fk_idTransaction foreign key (idTransaction) references TRANSACTIONS(idTransaction)
);
