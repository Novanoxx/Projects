---------------
--ENTITE--
---------------

CREATE TABLE Cordee(
	numCordee int PRIMARY KEY
);

CREATE TABLE Sortie(
	numS serial PRIMARY KEY,
	inviteMax int,
	nivMin char(5) NOT NULL,
	dateS char(10) NOT NULL	--JJ.MM.AAAA
);

CREATE TABLE Difficulte(
	noteFR varchar(2) PRIMARY KEY,
	noteUS varchar(5) NOT NULL,
	noteEN varchar(4) NOT NULL
);

CREATE TABLE Guide(
	emailG varchar(100) PRIMARY KEY,
	nomG varchar(30) NOT NULL
);

CREATE TABLE Localite(
	region varchar(30)PRIMARY KEY
);

CREATE TABLE Adherent(
	emailA varchar(100) PRIMARY KEY,
	nomA char(30) NOT NULL,
	prenom char(30) NOT NULL,
	escaladee int, --Voie déjà escaladé
	joindre_sortie int,
	FOREIGN KEY (joindre_sortie) REFERENCES Sortie(numS)
);

CREATE TABLE Voie(
	idV serial PRIMARY KEY,
	longueur char(6) NOT NULL,
	typeV varchar(7) NOT NULL,	--falaise ou bloc
	est_situe varchar(30),
	est_suivi int,
	FOREIGN KEY (est_situe) REFERENCES Localite(region),
	FOREIGN KEY (est_suivi) REFERENCES Voie(idV)
);

---------
--ASSOCIATIONS--
---------

CREATE TABLE exercer(
	emailA varchar(100),
	noteFR varchar(2),
	PRIMARY KEY (emailA, noteFR),
	FOREIGN KEY (emailA) REFERENCES Adherent(emailA),
	FOREIGN KEY (noteFR) REFERENCES Difficulte(noteFR)
);

CREATE TABLE encadrer(
	emailG varchar(100),
	noteFR varchar(2),
	PRIMARY KEY (emailG, noteFR),
	FOREIGN KEY (emailG) REFERENCES Guide(emailG),
	FOREIGN KEY (noteFR) REFERENCES Difficulte(noteFR)
);

CREATE TABLE pratiquer(
	emailG varchar(100),
	noteFR varchar(2),
	PRIMARY KEY (emailG, noteFR),
	FOREIGN KEY (emailG) REFERENCES Guide(emailG),
	FOREIGN KEY (noteFR) REFERENCES Difficulte(noteFR)
);

CREATE TABLE avoir(
	idV int,
	noteFR varchar(2),
	PRIMARY KEY (idV, noteFR),
	FOREIGN KEY (idV) REFERENCES Voie(idV),
	FOREIGN KEY (noteFR) REFERENCES Difficulte(noteFR)
);

CREATE TABLE contenir(
	idV int,
	numS int,
	PRIMARY KEY (idV, numS),
	FOREIGN KEY (idV) REFERENCES Voie(idV),
	FOREIGN KEY (numS) REFERENCES Sortie(numS)
);

CREATE TABLE proposer(
	emailA varchar(100),
	numS int,
	description text,
	PRIMARY KEY (emailA, numS),
	FOREIGN KEY (emailA) REFERENCES Adherent(emailA),
	FOREIGN KEY (numS) REFERENCES Sortie(numS)
);

CREATE TABLE appartenir(
	emailA varchar(100),
	numCordee int,
	PRIMARY KEY (emailA, numCordee),
	FOREIGN KEY (emailA) REFERENCES Adherent(emailA),
	FOREIGN KEY (numCordee) REFERENCES Cordee(numCordee)
);

CREATE TABLE ascension(
	idV int,
	numCordee int,
	dateAscension char(10),
	styleEscalade varchar(21) NOT NULL,
	PRIMARY KEY (idV, numCordee, dateAscension),
	FOREIGN KEY (idV) REFERENCES Voie(idV),
	FOREIGN KEY (numCordee) REFERENCES Cordee(numCordee)
);