CREATE USER 'cityswap'@'%' IDENTIFIED BY 'cityswap';
GRANT ALL PRIVILEGES ON `cityswap`.* TO 'cityswap'@'%';

CREATE USER 'cityswap'@'localhost' IDENTIFIED BY 'cityswap';
GRANT ALL PRIVILEGES ON `cityswap`.* TO 'cityswap'@'localhost';



create table if not exists Usuario (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre_usuario varchar(100),
    apellido varchar(100),
    email varchar(100),
    contrasena varchar(255)
)ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

create table if not exists Empresa (
    id_empresa INT AUTO_INCREMENT PRIMARY KEY,
    nombre_empresa varchar(100),
    email varchar(100),
    contrasena varchar(255)
)ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS Alquiler (
    id_alquiler INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT,
    id_empresa INT,
    ciudad_origen VARCHAR(100),
    ciudad_destino VARCHAR(100),
    fecha_inicio DATE NOT NULL,
    fecha_final DATE NOT NULL,
    FOREIGN KEY (id_usuario) REFERENCES Usuario(id_usuario),
    FOREIGN KEY (id_empresa) REFERENCES Empresa(id_empresa)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

create table if not exists Facturacion (
    id_factura INT AUTO_INCREMENT PRIMARY KEY,
    id_alquiler INT,
    monto INT,
    fecha DATE NOT NULL,
    FOREIGN KEY (id_alquiler) REFERENCES Alquiler(id_alquiler)
)ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO Usuario (nombre_usuario, apellido, email, contrasena) 
VALUES 
('azul', 'noguera', 'azul@learnique.edu','$2y$10$Mtto4mZ.kRwCfMvPpDYDBOzco7ekMLJiKO35GZRFvBf6SuPRLbtAe'),
('rocio', 'gonzalez', 'rocio@learnique.edu','$2y$10$ZvpimRSX9aMCkdXg/bNzmuQCQpNdPdrgfcIV.HHaLWnmDiVXKuVTO'),
('patricio', 'guledjian', 'patricio@learnique.edu','$2y$10$Hu2/dTjTJZO4jpO1fe1LjOXXgYG0Wq.XeqEBESGJ1VVwK4u5aEURy'),
('gabriel', 'zamy', 'gabriel@learnique.edu','$2y$10$6I7tVnuOZr50QAzFhMJAvez6YXt9PLVJRDWNdCcOPghPLSziPi71q');

INSERT INTO Empresa (nombre_empresa, email, contrasena)
VALUES 
('avis', 'avis@cityswap.com','avis1'),
('europcar', 'europcar@cityswap.com','europcar1');

-- GRANT ALL PRIVILEGES ON `cityswap`.* TO 'avis'@'%'; porque hacer eso?
-- GRANT ALL PRIVILEGES ON `cityswap`.* TO 'europcar'@'%';

INSERT INTO Alquiler (id_empresa, ciudad_origen, ciudad_destino, fecha_inicio, fecha_final) 
VALUES 
(1, 'Ciudad A', 'Ciudad B', '2024-05-01', '2024-05-05'),
(2, 'Ciudad C', 'Ciudad D', '2024-05-03', '2024-05-08'),
(1, 'Ciudad E', 'Ciudad F', '2024-05-07', '2024-05-10');

INSERT INTO Facturacion (id_alquiler, monto, fecha) 
VALUES 
(1, 150, '2024-05-01'),
(2, 200, '2024-05-03'),
(3, 180, '2024-05-07');