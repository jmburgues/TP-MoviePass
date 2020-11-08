USE MOVIEPASSDB;

CREATE TABLE IF NOT EXISTS CINEMAS(
idCinema int auto_increment,
cinemaName varchar(30) not null unique,
adress varchar(50) not null,
adressNumber int not null,
openning Time,
closing Time,
isActive boolean default true,
CONSTRAINT pk_idCinema primary key (idCinema)
); 

CREATE TABLE IF NOT EXISTS ROOMS(
idRoom int auto_increment,
roomName varchar(50) not null unique,
capacity int not null,
idCinema int not null,
price int not null,
isActive boolean default true,
roomType varchar(10) default "2d",
CONSTRAINT pk_idRoom primary key (idRoom),
CONSTRAINT fk_idCinema foreign key (idCinema) references CINEMAS(idCinema),
CONSTRAINT chq_capacity CHECK (capacity > 0 AND capacity < 500)
);

CREATE TABLE IF NOT EXISTS MOVIES(
idMovie int not null unique,
duration int not null,
title varchar(50) not null,
poster varchar(100), 
releaseDate Date,
movieDescription varchar(400),
CONSTRAINT pk_idMovie primary key (idMovie)
);

CREATE TABLE IF NOT EXISTS GENRES(
idGenre int not null,
genreName varchar(50),
CONSTRAINT pk_idGenre primary key (idGenre)
);

CREATE TABLE IF NOT EXISTS GENRES_X_MOVIES(
idGenre int not null,
idMovie int not null,
genreName varchar(50),
CONSTRAINT pk_idGenre_idMovie primary key (idGenre, idMovie),
CONSTRAINT fk_idMovie2 foreign key (idMovie) references MOVIES(idMovie),
CONSTRAINT fk_idGenre2 foreign key (idGenre) references GENRES(idGenre)
);

CREATE TABLE IF NOT EXISTS SHOWS(
idShow int auto_increment,
dateSelected DateTime not null,
startsAt DateTime not null,
endsAt DateTime not null,
spectators int default 0,
idRoom int not null,
idMovie int not null,
isActive bool default 1,
CONSTRAINT pk_idShow primary key (idShow),
CONSTRAINT fk_idRoom foreign key (idRoom) references ROOMS(idRoom),
CONSTRAINT fk_idMovie foreign key (idMovie) references MOVIES(idMovie)
);

CREATE TABLE IF NOT EXISTS USERS(
username varchar(50),
pass varchar(50), 
email varchar(50) unique,
birthdate Date,
dni int,
userRole varchar(10) default 'user',
CONSTRAINT pk_username primary key (username)
);


CREATE TABLE IF NOT EXISTS TRANSACTIONS(
idTransaction int auto_increment,
username varchar(100),
transacctionDate DateTime,
ticketAmount int not null,
costPerTicket int not null, 
CONSTRAINT pk_idTransaction primary key (idTransaction),
CONSTRAINT fk_username foreign key (username) references USERS(username)
);

CREATE TABLE IF NOT EXISTS TICKETS(
idTicket int auto_increment,
qrCode varchar(500), 
idShow int not null,
idTransaction int not null,
CONSTRAINT pk_idTicket primary key (idTicket),
CONSTRAINT fk_idShowTicket foreign key (idShow) references SHOWS(idShow),
CONSTRAINT fk_idTransaction foreign key (idTransaction) references TRANSACTIONS(idTransaction)
);

DROP PROCEDURE IF EXISTS p_add_transaction;
DELIMITER $$

CREATE PROCEDURE p_add_transaction (username VARCHAR(20), datetrans DateTime, OUT p_idTransaction INT)
BEGIN
	INSERT INTO TRANSACTIONS (username, transacctionDate) VALUES (username, datetrans);
	SET p_idTransaction = LAST_INSERT_ID();
END;
$$
