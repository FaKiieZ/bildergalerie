DROP DATABASE IF EXISTS `bilderdb`;
CREATE DATABASE IF NOT EXISTS `bilderdb` DEFAULT CHARACTER SET utf8 COLLATE utf8_german2_ci;
CREATE TABLE Kunde (kid INT NOT NULL AUTO_INCREMENT PRIMARY KEY, email varchar(50) NOT NULL, benutzername varchar(50) NOT NULL, passwort varchar(255) not null);
ALTER TABLE Kunde ADD UNIQUE (`email`);
ALTER TABLE Kunde ADD UNIQUE (`benutzername`);
CREATE TABLE Bild (bid INT NOT NULL AUTO_INCREMENT PRIMARY KEY, name varchar(64) NOT NULL, kid int not null, FOREIGN KEY (kid) REFERENCES Kunde(kid));
CREATE TABLE Galerie (gid INT NOT NULL AUTO_INCREMENT PRIMARY KEY, kid int NOT NULL, beschreibung varchar(255), publiziert bit not null, FOREIGN KEY (kid) REFERENCES Kunde(kid));
ALTER TABLE `galerie` CHANGE `publiziert` `publiziert` BIT(1) NOT NULL DEFAULT b'0';