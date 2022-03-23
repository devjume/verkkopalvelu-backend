/* LUONTILAUSEET */

DROP DATABASE IF EXISTS verkkopalvelu;

CREATE DATABASE verkkopalvelu;

USE verkkopalvelu;

CREATE TABLE tuoteryhma (
    id int NOT NULL AUTO_INCREMENT,
    nimi varchar(255) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE tuote (
    tuote_id int NOT NULL AUTO_INCREMENT,
    tuotenimi varchar(255) NOT NULL,
    hinta DECIMAL(10,2) NOT NULL,
    kuvaus varchar(255) NOT NULL,
    valmistaja varchar(40),
    tuoteryhma_id int NOT NULL,
    kuvatiedosto varchar(255),
    PRIMARY KEY (tuote_id),
    FOREIGN KEY (tuoteryhma_id) REFERENCES tuoteryhma(id)
);

CREATE TABLE asiakas (
    asiakas_id int NOT NULL AUTO_INCREMENT,
    etunimi varchar(40) NOT NULL,
    sukunimi varchar(40) NOT NULL,
    sahkoposti varchar(50),
    puhnro varchar(20),
    osoite varchar(50) NOT NULL,
    postinro varchar(5) NOT NULL,
    postitmp varchar(50) NOT NULL,
    rooli varchar(1),
    PRIMARY KEY (asiakas_id)
);

CREATE TABLE tilaus (
    tilausnro int(11) NOT NULL AUTO_INCREMENT,
    asiakas_id int(11) NOT NULL,
    tilauspvm datetime,
    tila varchar(1),
    PRIMARY KEY(tilausnro),
    FOREIGN KEY (asiakas_id) REFERENCES asiakas(asiakas_id)
);

CREATE TABLE tilausrivi (
    tilausnro int NOT NULL,
    rivinro int NOT NULL,
    tuote_id int NOT NULL,
    kpl int NOT NULL,
    CONSTRAINT PRIMARYKEY PRIMARY KEY (tilausnro, rivinro),
    FOREIGN KEY (tuote_id) REFERENCES tuote(tuote_id)
);

/* INSERT LAUSEET */

INSERT INTO asiakas (etunimi, sukunimi, sahkoposti, puhnro, osoite, postinro, postitmp, rooli)
VALUES  ("Samu", "Suomalainen", "ssuomalainen@gmail.com", "0404676431", "Saaristokatu 333 A3", "90500", "Tampere", 1),
        ("Eino", "Kivelä", "kiveläeikka@gmail.com", "0506632420", "Kauppakatu 67A", "92100", "Raahe", 1);

INSERT INTO tuoteryhma (nimi)
VALUES ("Kannettavat"), ("Komponentit");

INSERT INTO tuote (tuotenimi, hinta, kuvaus, valmistaja, tuoteryhma_id)
VALUES  ("Peliläppäri", 199.99, "Aikansa elänyt peliläppäri jollekkin haluavalle, speksejä nyt ei jaksa ettiä", "Acer", 1),
        ("ASUS GeForce GTX 1660 TI 6GB TUF EVO GAMING", 429, "ASUS TUF Gaming GeForce® GTX 1660 Ti EVO 6GB GDDR6 on kyllä ihan jees näyttis, suosittelen :D!.", "Asus", 2);

INSERT INTO tilaus (asiakas_id, tilauspvm, tila)
    VALUES (1, "2022-03-24 11:40:10", "A"), (2, "2022-03-24 21:36:47", "A");

INSERT INTO tilausrivi (tilausnro, rivinro, tuote_id, kpl)
    VALUES (1, 1, 1, 2), (1, 2, 2, 4), (2, 1, 2, 45);