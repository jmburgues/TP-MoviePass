#CREATE DATABASE MOVIEPASSDB;
#DROP DATABASE MOVIEPASSDB;
#USE MOVIEPASSDB;

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
title varchar(200) not null,
poster varchar(200), 
releaseDate Date,
movieDescription varchar(1000),
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

#Adding users
INSERT INTO USERS(username,pass,email,birthdate,dni,userRole) VALUES ('admin','1234','admin@MoviePass.com','1988-01-01',34322111,'admin');
INSERT INTO USERS(username,pass,email,birthdate,dni,userRole) VALUES ('owner','1234','owner@MoviePass.com','1987-01-01',33322111,'owner');
INSERT INTO USERS(username,pass,email,birthdate,dni,userRole) VALUES ('Jaz','1234','briascojazmin@gmail.com','1987-01-01',32322111,'owner');
INSERT INTO USERS(username,pass,email,birthdate,dni,userRole) VALUES ('Juan','1234','juancito@hotmail.com','1987-01-01',32322111,'user');
INSERT INTO USERS(username,pass,email,birthdate,dni,userRole) VALUES ('user','1234','user@hotmail.com','1986-01-01',31322111,'user');

#Adding cinemas
INSERT INTO CINEMAS(cinemaName, adress, adressNumber, openning, closing, isActive) VALUES ('Ambassador','Cordoba',2400, 18-00-00,03-00-00,true);
INSERT INTO CINEMAS(cinemaName, adress, adressNumber, openning, closing, isActive) VALUES ('Cine Del Paseo','Diagonal Pueyrredon',3058,13-00-00,24-00-00,true);

#Adding rooms
INSERT INTO ROOMS(roomName, capacity, idCinema, price, isActive, roomType) VALUES('A', 100, 1, 200, 1, '3D');
INSERT INTO ROOMS(roomName, capacity, idCinema, price, isActive) VALUES('B', 200, 1, 180, 1);
INSERT INTO ROOMS(roomName, capacity, idCinema, price, isActive) VALUES('C', 150, 2, 150, 1);
INSERT INTO ROOMS(roomName, capacity, idCinema, price, isActive, roomType) VALUES('D', 80, 2, 100, 1, '3D');
INSERT INTO ROOMS(roomName, capacity, idCinema, price, isActive, roomType) VALUES('E', 120, 2, 130, 1, '4D');

#Adding shows
INSERT INTO SHOWS(dateSelected, startsAt, endsAt, spectators, idRoom, idMovie, isActive) VALUES ('2021-03-01 00:00:00', '2021-04-01 15:00:00', '2021-04-01 17:14:00', '0', '1', '694', '1');
INSERT INTO SHOWS(dateSelected, startsAt, endsAt, spectators, idRoom, idMovie, isActive) VALUES ('2021-03-01 00:00:00', '2021-04-10 16:00:00', '2021-04-11 18:10:00', '0', '2', '496243', '1');
INSERT INTO SHOWS(dateSelected, startsAt, endsAt, spectators, idRoom, idMovie, isActive) VALUES ('2021-03-01 00:00:00', '2021-04-15 17:00:00', '2021-04-15 19:30:00', '0', '3', '613504', '1');
INSERT INTO SHOWS(dateSelected, startsAt, endsAt, spectators, idRoom, idMovie, isActive) VALUES ('2021-03-01 00:00:00', '2021-04-20 13:00:00', '2021-04-20 15:10:00', '0', '4', '667141', '1');



