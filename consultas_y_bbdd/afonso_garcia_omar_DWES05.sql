-- Crear base de datos
CREATE DATABASE afonso_garcia_omar_DWES05;
USE afonso_garcia_omar_DWES05;

-- Crear tabla usuarios
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- Crear tabla productos
CREATE TABLE productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    marca VARCHAR(50) NOT NULL,
    precio DECIMAL(10, 2) NOT NULL,
    unidades INT NOT NULL CHECK (unidades >= 0)
);

-- Crear tabla pedidos (relación entre usuarios y productos)
CREATE TABLE pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    producto_id INT NOT NULL,
    cantidad INT NOT NULL CHECK (cantidad > 0),
    precio_total DECIMAL(10, 2) NOT NULL,
    fecha_pedido DATE NOT NULL,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (producto_id) REFERENCES productos(id) ON DELETE CASCADE
);

-- Insertar datos en la tabla usuarios
INSERT INTO usuarios (id, nombre, apellidos, email, password) VALUES
(1, 'Jon', 'Aurtenetxe Borde', 'jon@gmail.com', '123456'),
(2, 'Ander', 'Sastre Diaz', 'ander@gmail.com', '568912'),
(3, 'Idoia', 'Biel Sastre', 'idoia@gmail.com', '906423'),
(4, 'Xabi', 'Perez Sainz', 'xabi@gmail.com', '743801'),
(5, 'Erika', 'Aguirre Garcia', 'erika@gmail.com', '094723'),
(6, 'Alex', 'Calle', 'alex@gmail.com', '369423'),
(7, 'Ana', 'Lopez Martin', 'ana@gmail.com', '671856');

-- Insertar datos en la tabla productos
INSERT INTO productos (id, nombre, marca, precio, unidades) VALUES
(1, 'Leche Desnatada', 'Pascual', 1.00, 50),
(2, 'Pimientos Piquillo', 'Carretilla', 2.50, 45),
(3, 'Pan Integral', 'Bimbo', 1.99, 30),
(4, 'Chocolate con Leche', 'Nestle', 1.50, 65),
(5, 'Yogur Coco', 'Danone', 2.00, 80),
(6, 'Refresco Naranja', 'Fanta', 0.99, 64),
(7, 'Queso Fresco', 'Philadelphia', 2.99, 20);

-- Insertar datos en la tabla pedidos
INSERT INTO pedidos (id, usuario_id, producto_id, cantidad, precio_total, fecha_pedido) VALUES
(1, 3, 2, 7, 17.50, '2024-02-12'),
(2, 5, 6, 3, 2.97, '2024-04-08'),
(3, 2, 4, 10, 15.00, '2024-06-20'),
(4, 7, 1, 5, 5.00, '2024-08-25'),
(5, 4, 5, 12, 24.00, '2024-09-15'),
(6, 1, 3, 8, 15.92, '2024-10-18'),
(7, 6, 7, 6, 17.94, '2024-11-05');