CREATE DATABASE IF NOT EXISTS ecoroute_manager;
USE ecoroute_manager;

CREATE TABLE rubros (
    id_rubro INT AUTO_INCREMENT PRIMARY KEY,
    nombre_rubro VARCHAR(255) NOT NULL,
    detalle_rubro VARCHAR(255) NOT NULL,
    fecha_registro DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO rubros
(nombre_rubro, detalle_rubro, fecha_registro)
VALUES
('Repuestos','Equipos para el hogar','2021-09-12 00:00:00'),
('Herramientas','Herramientas de construcción','2021-09-20 15:53:23'),
('Accesorios','Accesorios Stihl','2021-09-12 21:06:39');



CREATE TABLE articulos (
    id_articulo INT AUTO_INCREMENT PRIMARY KEY,
    codigo_articulo VARCHAR(20) NOT NULL UNIQUE,
    nombre_articulo VARCHAR(255) NOT NULL,
    fecha_registro DATETIME NOT NULL,
    valor_unitario DOUBLE NOT NULL,
    existencias INT NOT NULL,
    id_rubro INT NOT NULL,

    CONSTRAINT fk_articulo_rubro
    FOREIGN KEY(id_rubro)
    REFERENCES rubros(id_rubro)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO articulos
(codigo_articulo,nombre_articulo,fecha_registro,valor_unitario,existencias,id_rubro)
VALUES
('M001','Martillo','2021-09-20 15:53:56',5990,10,2);



CREATE TABLE empleados(
    id_empleado INT AUTO_INCREMENT PRIMARY KEY,
    nombres VARCHAR(20) NOT NULL,
    apellidos VARCHAR(20) NOT NULL,
    usuario VARCHAR(64) NOT NULL UNIQUE,
    clave_hash VARCHAR(255) NOT NULL,
    correo VARCHAR(64) NOT NULL UNIQUE,
    fecha_registro DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO empleados
(nombres,apellidos,usuario,clave_hash,correo,fecha_registro)
VALUES
(
'Duoc',
'UC',
'admin',
'$2y$10$MPVHzZ2ZPOWmtUUGCq3RXu31OTB.jo7M9LZ7PmPQYmgETSNn19ejO',
'admin@admin.com',
'2021-09-12 15:06:00'
);



CREATE TABLE movimientos_inventario(
    id_movimiento INT AUTO_INCREMENT PRIMARY KEY,
    id_articulo INT NOT NULL,
    id_empleado INT NOT NULL,
    fecha_movimiento DATETIME NOT NULL,
    descripcion VARCHAR(255) NOT NULL,
    codigo_referencia VARCHAR(100) NOT NULL,
    cantidad_movida INT NOT NULL,

    CONSTRAINT fk_movimiento_articulo
        FOREIGN KEY(id_articulo)
        REFERENCES articulos(id_articulo)
        ON DELETE CASCADE,

    CONSTRAINT fk_movimiento_empleado
        FOREIGN KEY(id_empleado)
        REFERENCES empleados(id_empleado)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO movimientos_inventario
(id_articulo,id_empleado,fecha_movimiento,descripcion,codigo_referencia,cantidad_movida)
VALUES
(
1,
1,
'2021-09-20 15:53:56',
'Duoc agregó 10 unidades al inventario',
'M001',
10
);