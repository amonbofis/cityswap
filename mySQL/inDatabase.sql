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

CREATE TABLE IF NOT EXISTS Viaje (
    id_viaje INT AUTO_INCREMENT PRIMARY KEY,
    id_empresa INT,
    ciudad_origen VARCHAR(100),
    ciudad_destino VARCHAR(100),
    fecha_inicio DATE NOT NULL,
    fecha_final DATE NOT NULL,
    precio INT,
    free INT,
    FOREIGN KEY (id_empresa) REFERENCES Empresa(id_empresa)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

create TABLE IF NOT EXISTS Alquiler (
    id_alquiler INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT,
    id_viaje INT,
    FOREIGN KEY (id_usuario) REFERENCES Usuario(id_usuario),
    FOREIGN KEY (id_viaje) REFERENCES Viaje(id_viaje)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

create table if not exists Facturacion (
    id_alquiler INT PRIMARY KEY,
    monto INT,
    fecha DATE NOT NULL,
    FOREIGN KEY (id_alquiler) REFERENCES Alquiler(id_alquiler)
)ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO Usuario (nombre_usuario, apellido, email, contrasena) 
VALUES 
('azul', 'noguera', 'azul@cityswap.edu','$2y$10$Mtto4mZ.kRwCfMvPpDYDBOzco7ekMLJiKO35GZRFvBf6SuPRLbtAe'),
('rocio', 'gonzalez', 'rocio@cityswap.edu','$2y$10$ZvpimRSX9aMCkdXg/bNzmuQCQpNdPdrgfcIV.HHaLWnmDiVXKuVTO'),
('patricio', 'guledjian', 'patricio@cityswap.edu','$2y$10$Hu2/dTjTJZO4jpO1fe1LjOXXgYG0Wq.XeqEBESGJ1VVwK4u5aEURy'),
('gabriel', 'zamy', 'gabriel@cityswap.edu','$2y$10$6I7tVnuOZr50QAzFhMJAvez6YXt9PLVJRDWNdCcOPghPLSziPi71q');

INSERT INTO Empresa (nombre_empresa, email, contrasena)
VALUES 
('avis', 'avis@cityswap.com','$2y$10$vIGQEg9O1bG9VvfT.bCeOetlwLAywuo2R6..eQe78UlDdD0/Y1CqW'),
('europcar', 'europcar@cityswap.com','$2y$10$yiPsZuY2ZpKnFtQ1Zox47.Pp5peTxXGwoW4dWDfy7z//4K2xKFjwm');

-- GRANT ALL PRIVILEGES ON `cityswap`.* TO 'avis'@'%'; porque hacer eso?
-- GRANT ALL PRIVILEGES ON `cityswap`.* TO 'europcar'@'%';

INSERT INTO Viaje (id_empresa, ciudad_origen, ciudad_destino, fecha_inicio, fecha_final) 
VALUES 
(1, 'Madrid', 'Barcelona', '2024-05-20', '2024-05-24'),
(2, 'Roma', 'Milan', '2024-05-17', '2024-05-21'),
(1, 'Berlin', 'Munich', '2024-05-25', '2024-05-30');

INSERT INTO Alquiler (id_usuario, id_viaje)
VALUES 
(1, 1),
(2, 2),
(3, 3);

INSERT INTO Facturacion (id_alquiler, monto, fecha) 
VALUES 
(1, 150, '2024-05-01'),
(2, 200, '2024-05-03'),
(3, 180, '2024-05-07');