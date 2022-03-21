/* LUONTILAUSEET */

CREATE TABLE tuoteryhma (
    id int NOT NULL AUTO_INCREMENT,
    nimi NOT NULL varchar(40),
    PRIMARY KEY (id)
);

CREATE TABLE tuote (
    tuote_id int NOT NULL AUTO_INCREMENT,
    tuotenimi varchar(40) NOT NULL,
    hinta DECIMAL(10,2) NOT NULL,
    kuvaus varchar(250) NOT NULL,
    valmistaja varchar(40),
    PRIMARY KEY (tuote_id)
);

CREATE TABLE asiakas (
    asiakas_id int NOT NULL AUTO_INCREMENT,
    enimi varchar(40) NOT NULL,
    snimi varchar(40) NOT NULL,
    sahkoposti varchar(50),
    puhnro varchar(20),
    osoite varchar(50) NOT NULL,
    postinro int(5) NOT NULL,
    postitmp varchar(50) NOT NULL,
    rooli varchar(1),
    PRIMARY KEY (asiakas_id)
);

CREATE TABLE tilaus (
    tilausnro int(11) NOT NULL,
    asiakas_id int(11) NOT NULL,
    tilauspvm date,
    tila varchar(1),
    PRIMARY KEY(tilausnro),
    FOREIGN KEY (asiakas_id) REFERENCES asiakas(asiakas_id)
);

CREATE TABLE tilausrivi (
    tilausnro int(11) NOT NULL,
    rivinro int(11) NOT NULL,
    tuote_id int(11),
    kpl varchar(1),
    CONSTRAINT PRIMARYKEY PRIMARY KEY (tilausnro,rivinro),
    FOREIGN KEY (tuote_id) REFERENCES tuote(tuote_id)
);

/* INSERT LAUSEET */

INSERT INTO asiakas (enimi, snimi, sahkoposti, puhnro, osoite, postinro, postitmp, rooli)
VALUES ("Yee", "eeY", "YeeeeY@gmail.com", "733733733", "Saaristokatu 333 A3", "99999", "Kadotus", 1);

INSERT INTO asiakas (enimi, snimi, sahkoposti, puhnro, osoite, postinro, postitmp, rooli)
VALUES ("Joku", "Testi", "jokutesti@gmail.com", "0506632420", "Kauppakatu 67A", "92100", "Raahe", 1);

INSERT INTO tuoteryhma (nimi)
VALUES ("Kannettavat");

INSERT INTO tuoteryhma (nimi)
VALUES ("Komponentit");

INSERT INTO tuote (tuotenimi, hinta, kuvaus, valmistaja)
VALUES ("Peliläppäri", 199.99, "Aikansa elänyt peliläppäri jollekkin haluavalle, speksejä nyt ei jaksa ettiä", "Oisko acer???");

INSERT INTO tuote (tuotenimi, hinta, kuvaus, valmistaja)
VALUES ("ASUS GeForce GTX 1660 TI 6GB TUF EVO GAMING", 429, "ASUS TUF Gaming GeForce® GTX 1660 Ti EVO 6GB GDDR6 on kyllä ihan jees näyttis, suosittelen :D!.", "SUS");

