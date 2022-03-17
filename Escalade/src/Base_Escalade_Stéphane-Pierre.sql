---------------
--ENTITE--
---------------

CREATE TABLE Cordee(
	numCordee serial PRIMARY KEY,
	nomCordee varchar(50) NOT NULL ,
	nivMinCordee varchar(2) NOT NULL 
);

CREATE TABLE Sortie(
	numS serial PRIMARY KEY,
	inviteMax int NOT NULL,
	nivMin char(5) NOT NULL,
	dateS date NOT NULL	--JJ.MM.AAAA
);

CREATE TABLE Difficulte(
	noteFR varchar(2) PRIMARY KEY,
	noteEN varchar(5) NOT NULL,
	noteUS varchar(4) NOT NULL
);

CREATE TABLE Guide(
	emailG varchar(100) PRIMARY KEY
);

CREATE TABLE Localite(
	region varchar(30) PRIMARY KEY
);

CREATE TABLE Adherent(
	emailA varchar(100) PRIMARY KEY,
	nomA char(30) NOT NULL,
	prenom char(30) NOT NULL,
	genre int NOT NULL,		-- 1(femme) ou 2(homme) --
	age int NOT NULL,
	mdp varchar(40) NOT NULL
);

CREATE TABLE Voie(
	idV serial PRIMARY KEY,
	nomv char(30) NOT NULL,
	longueur varchar(10) NOT NULL,
	typeV varchar(7) NOT NULL,	--falaise ou bloc
	est_situe varchar(30) NOT NULL,
	date_ouv date NOT NULL,
	FOREIGN KEY (est_situe) REFERENCES Localite(region)
	ON DELETE CASCADE ON UPDATE CASCADE,
	CONSTRAINT foub CHECK (typev = 'falaise' OR typev = 'bloc')
);

---------
--ASSOCIATIONS--
---------
CREATE TABLE rejoindre_sortie(
	emailA varchar(100),
	numS int,
	PRIMARY KEY (emailA, numS),
	FOREIGN KEY (emailA) REFERENCES Adherent(emailA)
	On UPDATE CASCADE,
	FOREIGN KEY (numS) REFERENCES Sortie(numS)
	ON UPDATE CASCADE
);

CREATE TABLE deja_esca(
	--Voie deja escaladé--
	emailA varchar(100),
	idV int,
	PRIMARY KEY (emailA, idV),
	FOREIGN KEY (emailA) REFERENCES Adherent(emailA)
	ON UPDATE CASCADE,
	FOREIGN KEY (idV) REFERENCES Voie(idV)
	ON UPDATE CASCADE	
);

CREATE TABLE voie_suivi(
	idVa int,
	idVb int,
	PRIMARY KEY (idVa, idVb),
	FOREIGN KEY (idVa) REFERENCES Voie(idV)
	ON UPDATE CASCADE,
	FOREIGN KEY (idVb) REFERENCES Voie(idV)
	ON UPDATE CASCADE
);

CREATE TABLE exercer(
	emailA varchar(100),
	noteFR varchar(2) default 1,
	PRIMARY KEY (emailA, noteFR),
	FOREIGN KEY (emailA) REFERENCES Adherent(emailA)
	ON UPDATE CASCADE,
	FOREIGN KEY (noteFR) REFERENCES Difficulte(noteFR)
	ON UPDATE CASCADE,
	CONSTRAINT uniqueAdherent UNIQUE (emailA)
);

CREATE TABLE encadrer(
	emailG varchar(100),
	noteFR varchar(2),
	PRIMARY KEY (emailG, noteFR),
	FOREIGN KEY (emailG) REFERENCES Guide(emailG)
	ON UPDATE CASCADE,
	FOREIGN KEY (noteFR) REFERENCES Difficulte(noteFR)
	ON UPDATE CASCADE,
	CONSTRAINT uniqueGuide UNIQUE (emailG)
);

CREATE TABLE pratiquer(
	emailG varchar(100),
	region varchar(30),
	PRIMARY KEY (emailG, region),
	FOREIGN KEY (emailG) REFERENCES Guide(emailG)
	ON UPDATE CASCADE,
	FOREIGN KEY (region) REFERENCES Localite(region)
	ON UPDATE CASCADE
);

CREATE TABLE avoir(
	idV int,
	noteFR varchar(2),
	PRIMARY KEY (idV, noteFR),
	FOREIGN KEY (idV) REFERENCES Voie(idV)
	ON UPDATE CASCADE,
	FOREIGN KEY (noteFR) REFERENCES Difficulte(noteFR)
	ON UPDATE CASCADE
);

CREATE TABLE contenir(
	idV int,
	numS int,
	PRIMARY KEY (idV, numS),
	FOREIGN KEY (idV) REFERENCES Voie(idV)
	ON UPDATE CASCADE,
	FOREIGN KEY (numS) REFERENCES Sortie(numS)
	ON UPDATE CASCADE
);

CREATE TABLE proposer(
	emailA varchar(100),
	numS int,
	description text,
	PRIMARY KEY (emailA, numS),
	FOREIGN KEY (emailA) REFERENCES Adherent(emailA)
	ON UPDATE CASCADE,
	FOREIGN KEY (numS) REFERENCES Sortie(numS)
	ON UPDATE CASCADE
);

CREATE TABLE appartenir(
	emailA varchar(100),
	numCordee int,
	PRIMARY KEY (emailA, numCordee),
	FOREIGN KEY (emailA) REFERENCES Adherent(emailA)
	ON UPDATE CASCADE,
	FOREIGN KEY (numCordee) REFERENCES Cordee(numCordee)
	ON UPDATE CASCADE
);

CREATE TABLE ascension(
	idV int,
	numCordee int,
	dateAscension date,
	styleEscalade varchar(21) NOT NULL,
	PRIMARY KEY (idV, numCordee, dateAscension),
	FOREIGN KEY (idV) REFERENCES Voie(idV)
	ON UPDATE CASCADE,
	FOREIGN KEY (numCordee) REFERENCES Cordee(numCordee)
	ON UPDATE CASCADE
);

---------
--AJOUT DE VALEUR--
---------

-----
--- Oublie
-----

------ Difficultés
INSERT INTO Difficulte VALUES ('1', '5.1', 'Easy');
INSERT INTO Difficulte VALUES ('2', '5.3', 'M');
INSERT INTO Difficulte VALUES ('3', '5.4', 'D');
INSERT INTO Difficulte VALUES ('4', '5.5', 'HVD');
INSERT INTO Difficulte VALUES ('5a', '5.6', 'MS');
INSERT INTO Difficulte VALUES ('5b', '5.7', 'VS');
INSERT INTO Difficulte VALUES ('5c', '5.8', 'HVS');
INSERT INTO Difficulte VALUES ('6a', '5.9', 'E1');
INSERT INTO Difficulte VALUES ('6b', '5.10c', 'E2');
INSERT INTO Difficulte VALUES ('6c', '5.11a', 'E3');
INSERT INTO Difficulte VALUES ('7a', '5.11d', 'E4');
INSERT INTO Difficulte VALUES ('7b', '5.12b', 'E5');
INSERT INTO Difficulte VALUES ('7c', '5.12d', 'E6');
INSERT INTO Difficulte VALUES ('8a', '5.13b', 'E7');
INSERT INTO Difficulte VALUES ('8b', '5.13d', 'E8');
INSERT INTO Difficulte VALUES ('8c', '5.14b', 'E9');
INSERT INTO Difficulte VALUES ('9a', '5.14d', 'E10');
INSERT INTO Difficulte VALUES ('9b', '5.15b', 'E11');
INSERT INTO Difficulte VALUES ('9c', '5.15d', 'E12');
------

INSERT INTO Localite VALUES ('AUVERGNE');
INSERT INTO Localite VALUES ('PARIS');
INSERT INTO Localite VALUES ('MONTCUQ');
INSERT INTO Localite VALUES ('LA SEINE');
INSERT INTO Voie(longueur, typev, nomv, est_situe, date_ouv) VALUES ('3000m', 'falaise', 'LA GRANDE AUVERGNE', 'AUVERGNE', '2000-08-31');
INSERT INTO Voie(longueur, typev, nomv, est_situe, date_ouv) VALUES ('9000m', 'bloc', 'ELYSEE', 'PARIS', '1999-01-20');
INSERT INTO Voie(longueur, typev, nomv, est_situe, date_ouv) VALUES ('300m', 'falaise', 'LA TOUR EIFFEL', 'PARIS', '2007-09-14');
INSERT INTO Voie(longueur, typev, nomv, est_situe, date_ouv) VALUES ('100m', 'bloc', 'MANOIR', 'MONTCUQ', '2016-03-09');
INSERT INTO Voie(longueur, typev, nomv, est_situe, date_ouv) VALUES ('777000m', 'falaise', 'SEINE-AH', 'LA SEINE', '2019-12-7');
INSERT INTO voie_suivi VALUES (2, 3);
INSERT INTO voie_suivi VALUES (3, 2);
INSERT INTO voie_suivi VALUES (2, 5);
INSERT INTO voie_suivi VALUES (5, 2);
INSERT INTO avoir VALUES (1, '5a');
INSERT INTO avoir VALUES (2, '8a');
INSERT INTO avoir VALUES (3, '3');
INSERT INTO avoir VALUES (4, '1');
INSERT INTO avoir VALUES (5, '9c');
------
------COMPTES TEST
INSERT INTO Adherent VALUES ('TEST_A@outlook.fr', 'VONG', 'Stéphane', 2, 19, md5('Stephane'));
INSERT INTO Adherent VALUES ('TEST_B@gmail.com', 'LE VEILLOT', 'Pierre', 2, 20, md5('Pierre'));
INSERT INTO Adherent VALUES ('TEST_C@hotmail.fr', 'BERTHEREAU', 'Thomas', 2, 19, md5('Thomas'));
INSERT INTO Adherent VALUES ('TEST_D@outlook.fr', 'BOU', 'Amine', 2, 21, md5('Amine'));
INSERT INTO Adherent VALUES ('TEST_E@outlook.fr', 'GUILLOIS', 'Abel', 2, 30, md5('Abel'));
INSERT INTO exercer VALUES ('TEST_A@outlook.fr', '9c');
INSERT INTO exercer VALUES ('TEST_B@gmail.com', '9c');
INSERT INTO exercer VALUES ('TEST_C@hotmail.fr', '5a');
INSERT INTO exercer VALUES ('TEST_D@outlook.fr', '1');
INSERT INTO exercer VALUES ('TEST_E@outlook.fr', '1');

-- INSERT INTO Sortie(inviteMax, nivMin, dateS) VALUES (20, '8a', '2019-12-19');
-- INSERT INTO Sortie(inviteMax, nivMin, dateS) VALUES (69, '6c', '2019-12-03');
-- INSERT INTO Sortie(inviteMax, nivMin, dateS) VALUES (30, '9c', '2019-12-01');
-- INSERT INTO proposer VALUES ('TEST_A@outlook.fr', 1, 'Une sortie qui n\`est que pour le test');
-- INSERT INTO proposer VALUES ('TEST_B@gmail.com', 2, 'Une sortie qui n\`est que pour le test aussi');
-- INSERT INTO proposer VALUES ('TEST_E@outlook.fr', 3, 'Si on le veut, on peut');