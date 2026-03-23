\c postgres
DROP DATABASE IF EXISTS bd_contacts_multinumeros;

CREATE DATABASE bd_contacts_multinumeros;
\c bd_contacts_multinumeros

CREATE TABLE contact (
    nom VARCHAR(30),
    PRIMARY KEY (nom)
);

CREATE TABLE numero (
    id SERIAL,
    numero VARCHAR(14),
    libelle VARCHAR(50),
    nom VARCHAR(30) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (nom) REFERENCES contact(nom) ON DELETE CASCADE
);

DROP USER IF EXISTS uti_contacts;
CREATE USER uti_contacts LOGIN PASSWORD 'pz9,jC';
GRANT ALL ON contact, numero, numero_id_seq TO uti_contacts;

INSERT INTO contact (nom) VALUES ('Paul');
INSERT INTO contact (nom) VALUES ('Tom');
INSERT INTO numero (numero, libelle, nom) VALUES ('03.26.45.44.27', 'Domicile', 'Paul');
INSERT INTO numero (numero, libelle, nom) VALUES ('01.23.78.91.73', 'Travail', 'Paul');
INSERT INTO numero (numero, libelle, nom) VALUES ('06.74.68.41.49', 'Mobile', 'Tom');
