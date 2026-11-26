CREATE DATABASE IF NOT EXISTS biblioteca_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE biblioteca_db;

CREATE TABLE usuarios (
 id INT AUTO_INCREMENT PRIMARY KEY,
 nombre VARCHAR(120) NOT NULL,
 usuario VARCHAR(50) NOT NULL UNIQUE,
 password_hash VARCHAR(255) NOT NULL,
 rol ENUM('Administrador','Bibliotecario') NOT NULL DEFAULT 'Bibliotecario',
 activo TINYINT(1) NOT NULL DEFAULT 1,
 creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE libros (
 id INT AUTO_INCREMENT PRIMARY KEY,
 titulo VARCHAR(180) NOT NULL,
 autor VARCHAR(150) NOT NULL,
 isbn VARCHAR(30),
 categoria VARCHAR(100),
 stock INT NOT NULL DEFAULT 0,
 creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE lectores (
 id INT AUTO_INCREMENT PRIMARY KEY,
 nombre VARCHAR(150) NOT NULL,
 documento VARCHAR(20) NOT NULL UNIQUE,
 correo VARCHAR(120),
 telefono VARCHAR(30),
 creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE prestamos (
 id INT AUTO_INCREMENT PRIMARY KEY,
 libro_id INT NOT NULL,
 lector_id INT NOT NULL,
 fecha_prestamo DATE NOT NULL,
 fecha_devolucion DATE NOT NULL,
 fecha_retorno DATE NULL,
 estado ENUM('Prestado','Devuelto') NOT NULL DEFAULT 'Prestado',
 creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 CONSTRAINT fk_prestamo_libro FOREIGN KEY(libro_id) REFERENCES libros(id),
 CONSTRAINT fk_prestamo_lector FOREIGN KEY(lector_id) REFERENCES lectores(id)
);

-- Usuario demo: admin / Admin123*
-- Hash generado con password_hash('Admin123*', PASSWORD_DEFAULT)
INSERT INTO usuarios(nombre,usuario,password_hash,rol) VALUES
('Administrador del Sistema','admin','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.a/5J2f1u.','Administrador');

INSERT INTO libros(titulo,autor,isbn,categoria,stock) VALUES
('Cien años de soledad','Gabriel García Márquez','9780307474728','Novela',5),
('El principito','Antoine de Saint-Exupéry','9780156012195','Literatura',8),
('Clean Code','Robert C. Martin','9780132350884','Informática',4),
('La ciudad y los perros','Mario Vargas Llosa','9788437602662','Novela',3),
('Introducción a las bases de datos','Abraham Silberschatz','9780078022159','Informática',6),
('Don Quijote de la Mancha','Miguel de Cervantes','9788420412146','Clásicos',2);

INSERT INTO lectores(nombre,documento,correo,telefono) VALUES
('María Fernanda López','70123456','maria@example.com','987654321'),
('Carlos Alberto Rojas','71234567','carlos@example.com','986123456'),
('Ana Lucía Torres','72345678','ana@example.com','985222333'),
('José Miguel Salazar','73456789','jose@example.com','984111222');

INSERT INTO prestamos(libro_id,lector_id,fecha_prestamo,fecha_devolucion,estado) VALUES
(1,1,CURDATE()-INTERVAL 2 DAY,CURDATE()+INTERVAL 5 DAY,'Prestado'),
(3,2,CURDATE()-INTERVAL 12 DAY,CURDATE()-INTERVAL 5 DAY,'Prestado'),
(2,3,CURDATE()-INTERVAL 20 DAY,CURDATE()-INTERVAL 13 DAY,'Devuelto');
UPDATE libros SET stock=stock-1 WHERE id IN (1,3);
