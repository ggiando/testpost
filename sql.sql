CREATE TABLE sale(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(30) NOT NULL
);

CREATE TABLE vasche(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    lunghezza int NOT NULL,
    deep INT NOT NULL,
    larghezza INT NOT NULL,
    nome varchar(30) NOT NULL,
    idSala INT NOT NULL REFERENCES sale(id)
);

CREATE TABLE sensori(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    tipo varchar(30) NOT NULL,
    unitMeasure varchar(30) NOT NULL,
    min int NOT NULL,
    max int NOT NULL,
    idVasca INT NOT NULL REFERENCES vasca(id)
);

CREATE TABLE misure(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    valore float NOT NULL,
    data datetime DEFAULT CURRENT_TIMESTAMP,
    idSensore INT NOT NULL REFERENCES SENSORI(id)
);


INSERT INTO sale (nome) 
VALUES ('Mediterraneo'), ('Oceano Indiano'), ('Scogliere coralline');

INSERT INTO vasche (lunghezza, deep, larghezza, nome, idSala) 
VALUES (50, 50, 50, "Giorgio", 1), 
(50, 50, 50, "Giovanni", 2),
(50, 50, 50, "Nemo", 3),
(50, 50, 50, "Dory", 1),
(50, 50, 50, "Saetta McQueen", 2),
(50, 50, 50, "Cricchetto", 3);

INSERT INTO sensori (tipo, unitMeasure, min, max, idVasca)
VALUES ('PH', '', 20.5, 33, 1),
('temperatura', '', 10, 20, 2),
('ossigeno', '', 2, 15, 3);

INSERT INTO misure (valore, idSensore)
VALUES (22.5, 2),
(10.5, 3),
(2, 1),
(11, 2);