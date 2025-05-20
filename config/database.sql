CREATE DATABASE IF NOT EXISTS desafio03;
USE desafio03;

-- Tabla de usuarios
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) NOT NULL UNIQUE,
    correo VARCHAR(100) NOT NULL UNIQUE,
    contrasena VARCHAR(255) NOT NULL
);

-- Tabla de libros
CREATE TABLE libros (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(100),
    autor VARCHAR(100)
);


INSERT INTO usuarios (usuario, correo, contrasena) VALUES
('edgar123', 'edgar@example.com', '$2y$10$kBL6.3KbLbPYqYzV4pBn1uklqL6uVnOZSOOeqxL0mHg6y7zMowZxK'),
('verito', 'verito@example.com', '$2y$10$EERtewzON12kLd4fVz/4TOqT1G7mTOx2pZpxcy3Z8KMFQGkWk5lgy');
-- edgar123 para usuario edgar123
-- verito para usuario verito