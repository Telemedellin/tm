CREATE TABLE url 
(
  id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
  slug varchar(255) NOT NULL,
  tipo_id INTEGER NOT NULL,
  creado timestamp NOT NULL,
  modificado timestamp NULL,
  estado INTEGER NOT NULL,
);