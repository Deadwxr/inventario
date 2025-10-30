-- init.sql
CREATE DATABASE IF NOT EXISTS inventario_db CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE inventario_db;

-- Tabla usuarios
CREATE TABLE IF NOT EXISTS usuarios (
  cedula VARCHAR(50) PRIMARY KEY,
  nombre VARCHAR(150) NOT NULL,
  password VARCHAR(255) NOT NULL
);

-- Tabla articulos
CREATE TABLE IF NOT EXISTS articulos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(200) NOT NULL,
  unidades INT NOT NULL DEFAULT 0,
  tipo VARCHAR(50) NOT NULL, -- 'PC','teclado','disco duro','mouse'
  bodega VARCHAR(50) NOT NULL, -- 'norte','sur','oriente','occidente'
  creado_por VARCHAR(150) DEFAULT NULL,
  modificado_por VARCHAR(150) DEFAULT NULL,
  creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  actualizado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Datos iniciales: usuario administrador (sin password_hash por pedido)
INSERT IGNORE INTO usuarios (cedula, nombre, password) VALUES
('1111', 'Administrador', '1234'),
('2222', 'Usuario Demo', 'demo123');

-- Opcional: artículos de ejemplo
INSERT IGNORE INTO articulos (nombre, unidades, tipo, bodega, creado_por, modificado_por)
VALUES
('PC Oficina 01', 5, 'PC', 'norte', 'Administrador', 'Administrador'),
('Teclado Gaming', 10, 'teclado', 'sur', 'Usuario Demo', 'Usuario Demo');
