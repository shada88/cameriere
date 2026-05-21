-- Crear la base de datos
CREATE DATABASE restaurante_db;
USE restaurante_db;

-- =========================
-- TABLA ADMINISTRADORES
-- =========================
CREATE TABLE administradores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    restaurante VARCHAR(100) NOT NULL,
    correo VARCHAR(100) NOT NULL UNIQUE,
    contraseña VARCHAR(255) NOT NULL
);

-- =========================
-- TABLA ENCARGADO
-- =========================
CREATE TABLE encargado (
    idEncargado INT AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(45) NOT NULL,
    Contraseña VARCHAR(100) NOT NULL
);

-- =========================
-- TABLA MESA
-- =========================
CREATE TABLE came (
    idCame INT AUTO_INCREMENT PRIMARY KEY,
    Mesa VARCHAR(10) NOT NULL,
    idEncargado INT,
    
    CONSTRAINT fk_came_encargado
        FOREIGN KEY (idEncargado)
        REFERENCES encargado(idEncargado)
        ON DELETE SET NULL
        ON UPDATE CASCADE
);

-- =========================
-- TABLA CLIENTE
-- =========================
CREATE TABLE cliente (
    idCliente INT AUTO_INCREMENT PRIMARY KEY,
    CodCliente VARCHAR(45) NOT NULL,
    Calificacion TINYINT
);

-- =========================
-- TABLA PRODUCTOS
-- =========================
CREATE TABLE productos (
    idProductos INT AUTO_INCREMENT PRIMARY KEY,
    Producto VARCHAR(30) NOT NULL,
    Precio FLOAT NOT NULL
);

-- =========================
-- TABLA COMANDA
-- =========================
CREATE TABLE comanda (
    idComanda INT AUTO_INCREMENT PRIMARY KEY,
    CodOrden VARCHAR(50) NOT NULL,
    idCame INT,
    CantidadProductos INT,
    idCliente INT,

    CONSTRAINT fk_comanda_came
        FOREIGN KEY (idCame)
        REFERENCES came(idCame)
        ON DELETE SET NULL
        ON UPDATE CASCADE,

    CONSTRAINT fk_comanda_cliente
        FOREIGN KEY (idCliente)
        REFERENCES cliente(idCliente)
        ON DELETE SET NULL
        ON UPDATE CASCADE
);

-- =========================
-- TABLA DETALLE COMANDA
-- =========================
CREATE TABLE detalle_comanda (
    idDetalleComanda INT AUTO_INCREMENT PRIMARY KEY,
    idcomanda INT,
    idproductos INT,
    Cantidad INT NOT NULL,

    CONSTRAINT fk_detalle_comanda
        FOREIGN KEY (idcomanda)
        REFERENCES comanda(idComanda)
        ON DELETE CASCADE
        ON UPDATE CASCADE,

    CONSTRAINT fk_detalle_productos
        FOREIGN KEY (idproductos)
        REFERENCES productos(idProductos)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

-- =========================
-- RELACIÓN ADMINISTRADORES ↔️ ENCARGADO
-- =========================
ALTER TABLE encargado
ADD COLUMN idAdministrador INT;

ALTER TABLE encargado
ADD CONSTRAINT fk_encargado_admin
    FOREIGN KEY (idAdministrador)
    REFERENCES administradores(id)
    ON DELETE SET NULL
    ON UPDATE CASCADE;
