CREATE DATABASE MOVIEPASSDB;
USE MOVIEPASSDB;

#drop database MOVIEPASSDB

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
applies Date,
CONSTRAINT pk_idCXDP primary key (idCXDP),
CONSTRAINT fk_idCinemaCXDP foreign key (idCinema) references CINEMAS(idCinema),
CONSTRAINT fk_idPolicy foreign key (idPolicy) references DISCOUNT_POLICIES(idPolicy)
);

CREATE TABLE IF NOT EXISTS ROOMS(
idRoom int auto_increment,
roomName varchar(50) not null unique,
capacity int not null,
idCinema int not null,
price int not null,
CONSTRAINT pk_idRoom primary key (idRoom),
CONSTRAINT fk_idCinema foreign key (idCinema) references CINEMAS(idCinema),
CONSTRAINT chq_capacity CHECK (capacity > 0 AND capacity < 500)
);

CREATE TABLE IF NOT EXISTS ROOM_TYPE(
roomType varchar(20) not null,
typeDescription varchar(200),
CONSTRAINT pk_roomTypeName primary key (roomType)
CONSTRAINT chq_roomType2 CHECK (roomType = '2d' OR roomType = '3d' OR roomType ='Atmos')
);

CREATE TABLE IF NOT EXISTS SHOWS(
idShow int auto_increment,
dateSelected DateTime not null,
startsAt DateTime not null,
endsAt DateTime not null,
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
idMovie int not null unique,
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
username varchar(50),
pass varchar(50), 
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
transacctionDate DateTime,
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


INSERT INTO CINEMAS (cinemaName, adress, adressNumber, openning,  closing ) VALUES ("Ambasador", "Rivadavia", 4831, 08-00, 00-30);
INSERT INTO CINEMAS (cinemaName, adress, adressNumber, openning,  closing ) VALUES ("General", "Dorrego", 8741, 08-00, 22-30);
INSERT INTO CINEMAS (cinemaName, adress, adressNumber, openning,  closing ) VALUES ("Grande", "Dorrego", 8741, 08-00, 22-30);
UPDATE CINEMAS SET isActive=false WHERE idCinema=3;

INSERT INTO ROOMS (roomName, capacity, idCinema, price) VALUES ("SALA 1", "70", 1, 54);
INSERT INTO ROOMS (roomName, capacity, idCinema, price) VALUES ("SALA 2", "80", 2, 70);
INSERT INTO ROOMS (roomName, capacity, idCinema, price) VALUES ("SALA 3", "90", 1, 40);

INSERT INTO MOVIES (idMovie, duration, title, poster, releaseDate, movieDescription) VALUES (1234, 50-10, "Mulan", "poster mulan", 12/20/70, "Pelicula de Disney");
INSERT INTO MOVIES (idMovie, duration, title, poster, releaseDate, movieDescription) VALUES (4567, 40-10, "Dalmatas", "poster dalmatas", 11/10/20, "Pelicula de Disney");

INSERT INTO SHOWS (dateSelected, startsAt, endsAt, spectators, idRoom, idMovie) VALUES (12-10-2020, 10-30, 18-00, 50, 1, 1234);



