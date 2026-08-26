/**
 * Update 2023
 * Powered by Evilnapsis
 * **/
create database inventiolite;
use inventiolite;
set sql_mode='';

create table user(
	id int not null auto_increment primary key,
	name varchar(50),
	lastname varchar(50),
	username varchar(50),
	email varchar(255),
	password varchar(60),
	image varchar(255),
	is_active boolean not null default 1,
	is_admin boolean not null default 0,
	created_at datetime
);

insert into user(name,lastname,email,password,is_active,is_admin,created_at) value ("Administrador", "","admin","90b9aa7e25f80cf4f64e990b78a9fc5ebd6cecad",1,1,NOW());

create table category(
	id int not null auto_increment primary key,
	image varchar(255),
	name varchar(50),
	description text,
	created_at datetime
);

create table product(
	id int not null auto_increment primary key,
	image varchar(255),
	barcode varchar(50),
	name varchar(50),
	description text,
	inventary_min int default 10,
	price_in float,
	price_out float,
	unit varchar(255),
	presentation varchar(255),
	user_id int,
	category_id int,
	created_at datetime,
	is_active boolean default 1,
	foreign key (category_id) references category(id),
	foreign key (user_id) references user(id)
);

/*
person kind
1.- Client
2.- Provider
*/
create table person(
	id int not null auto_increment primary key,
	image varchar(255),
	name varchar(255),
	lastname varchar(50),
	company varchar(50),
	address1 varchar(50),
	address2 varchar(50),
	phone1 varchar(50),
	phone2 varchar(50),
	email1 varchar(50),
	email2 varchar(50),
	kind int,
	created_at datetime
);


create table operation_type(
	id int not null auto_increment primary key,
	name varchar(50)
);

insert into operation_type (name) value ("entrada");
insert into operation_type (name) value ("salida");

create table box(
	id int not null auto_increment primary key,
	created_at datetime
);


create table sell(
	id int not null auto_increment primary key,
	person_id int ,
	user_id int ,
	operation_type_id int default 2,
	box_id int,

	total double,
	cash double,
	discount double,

	foreign key (box_id) references box(id),
	foreign key (operation_type_id) references operation_type(id),
	foreign key (user_id) references user(id),
	foreign key (person_id) references person(id),
	created_at datetime
);

create table operation(
	id int not null auto_increment primary key,
	product_id int,
	q float,
	operation_type_id int,
	sell_id int,
	created_at datetime,
	foreign key (product_id) references product(id),
	foreign key (operation_type_id) references operation_type(id),
	foreign key (sell_id) references sell(id)
);

/*
configuration kind
1.- Boolean
2.- Text
3.- Number
*/
create table configuration(
	id int not null auto_increment primary key,
	short varchar(200) unique,
	name varchar(200) unique,
	kind int,
	val varchar(255)
);
insert into configuration(short,name,kind,val) value("title","Titulo del Sistema",2,"Inventio Lite");


/*
-- ==============================================================================
-- DATOS DEMO (OPCIONALES)
-- Para cargar los datos demo en la base de datos, descomente el bloque siguiente.
-- ==============================================================================

-- Categorías (10)
INSERT INTO category (id, name, description, created_at) VALUES
(1, 'Electrónica', 'Dispositivos y accesorios electrónicos', NOW()),
(2, 'Papelería', 'Artículos de oficina y papelería', NOW()),
(3, 'Abarrotes', 'Productos alimenticios y víveres', NOW()),
(4, 'Lácteos', 'Leche, quesos y derivados lácteos', NOW()),
(5, 'Bebidas', 'Refrescos, jugos y aguas', NOW()),
(6, 'Limpieza', 'Productos para aseo y limpieza del hogar', NOW()),
(7, 'Ferretería', 'Herramientas y materiales de ferretería', NOW()),
(8, 'Ropa y Calzado', 'Prendas de vestir y calzado', NOW()),
(9, 'Farmacia', 'Medicamentos y cuidado personal', NOW()),
(10, 'Hogar y Jardín', 'Artículos para el hogar y jardinería', NOW());

-- Usuarios (10)
INSERT INTO user (id, name, lastname, username, email, password, is_active, is_admin, created_at) VALUES
(2, 'Juan', 'Pérez', 'juanperez', 'juan@example.com', '90b9aa7e25f80cf4f64e990b78a9fc5ebd6cecad', 1, 0, NOW()),
(3, 'María', 'Gómez', 'mgomez', 'maria@example.com', '90b9aa7e25f80cf4f64e990b78a9fc5ebd6cecad', 1, 0, NOW()),
(4, 'Carlos', 'López', 'clopez', 'carlos@example.com', '90b9aa7e25f80cf4f64e990b78a9fc5ebd6cecad', 1, 0, NOW()),
(5, 'Ana', 'Martínez', 'amartinez', 'ana@example.com', '90b9aa7e25f80cf4f64e990b78a9fc5ebd6cecad', 1, 0, NOW()),
(6, 'Luis', 'Hernández', 'lhernandez', 'luis@example.com', '90b9aa7e25f80cf4f64e990b78a9fc5ebd6cecad', 1, 0, NOW()),
(7, 'Sofia', 'Díaz', 'sdiaz', 'sofia@example.com', '90b9aa7e25f80cf4f64e990b78a9fc5ebd6cecad', 1, 0, NOW()),
(8, 'Pedro', 'Torres', 'ptorres', 'pedro@example.com', '90b9aa7e25f80cf4f64e990b78a9fc5ebd6cecad', 1, 0, NOW()),
(9, 'Laura', 'Ramírez', 'lramirez', 'laura@example.com', '90b9aa7e25f80cf4f64e990b78a9fc5ebd6cecad', 1, 0, NOW()),
(10, 'Diego', 'Flores', 'dflores', 'diego@example.com', '90b9aa7e25f80cf4f64e990b78a9fc5ebd6cecad', 1, 0, NOW()),
(11, 'Elena', 'Morales', 'emorales', 'elena@example.com', '90b9aa7e25f80cf4f64e990b78a9fc5ebd6cecad', 1, 0, NOW());

-- Personas: Clientes (kind=1) y Proveedores (kind=2) - 10 de cada uno
INSERT INTO person (id, name, lastname, company, address1, phone1, email1, kind, created_at) VALUES
-- Clientes
(1, 'Roberto', 'García', 'Distribuidora García', 'Av. Central 123', '555-0101', 'roberto@garcia.com', 1, NOW()),
(2, 'Patricia', 'Sánchez', 'Comercial Sánchez', 'Calle Norte 45', '555-0102', 'patricia@sanchez.com', 1, NOW()),
(3, 'Fernando', 'Romero', 'Servicios Romero', 'Calle Sur 78', '555-0103', 'fernando@romero.com', 1, NOW()),
(4, 'Claudia', 'Vargas', 'Importaciones Vargas', 'Av. Principal 500', '555-0104', 'claudia@vargas.com', 1, NOW()),
(5, 'Jorge', 'Castro', 'Mendoza & Castro', 'Calle 10 # 25', '555-0105', 'jorge@castro.com', 1, NOW()),
(6, 'Lucía', 'Mendoza', 'Tienda Mendoza', 'Av. Reforma 88', '555-0106', 'lucia@mendoza.com', 1, NOW()),
(7, 'Gabriel', 'Ortega', 'Grupo Ortega', 'Calle Hidalgo 12', '555-0107', 'gabriel@ortega.com', 1, NOW()),
(8, 'Carmen', 'Ríos', 'Ríos Express', 'Av. Juárez 304', '555-0108', 'carmen@rios.com', 1, NOW()),
(9, 'Adrian', 'Silva', 'Silva Trading', 'Calle Olmo 5', '555-0109', 'adrian@silva.com', 1, NOW()),
(10, 'Valeria', 'Núñez', 'Soluciones Núñez', 'Av. Insurgentes 99', '555-0110', 'valeria@nunez.com', 1, NOW()),
-- Proveedores
(11, 'Proveedor', 'Alfa', 'Proveedor Alfa S.A.', 'Industrial Park 1', '555-0201', 'contacto@alfa.com', 2, NOW()),
(12, 'Proveedor', 'Beta', 'Suministros Beta', 'Zona Industrial 4', '555-0202', 'ventas@beta.com', 2, NOW()),
(13, 'Proveedor', 'Gamma', 'Distribuidora Gamma', 'Calle Fabril 12', '555-0203', 'info@gamma.com', 2, NOW()),
(14, 'Proveedor', 'Delta', 'Delta Logística', 'Av. Comercio 888', '555-0204', 'contacto@delta.com', 2, NOW()),
(15, 'Proveedor', 'Epsilon', 'Epsilon Importaciones', 'Parque Tecnológico 3', '555-0205', 'servicio@epsilon.com', 2, NOW()),
(16, 'Proveedor', 'Zeta', 'Zeta Distribuciones', 'Calle Almacenes 45', '555-0206', 'ventas@zeta.com', 2, NOW()),
(17, 'Proveedor', 'Eta', 'Eta Comercial', 'Av. Central 900', '555-0207', 'pedidos@eta.com', 2, NOW()),
(18, 'Proveedor', 'Theta', 'Theta Global', 'Zona Franca 12', '555-0208', 'info@theta.com', 2, NOW()),
(19, 'Proveedor', 'Iota', 'Iota Suministros', 'Calle Comercio 77', '555-0209', 'contacto@iota.com', 2, NOW()),
(20, 'Proveedor', 'Kappa', 'Kappa Corp', 'Av. Industrial 55', '555-0210', 'ventas@kappa.com', 2, NOW());

-- Productos (10)
INSERT INTO product (id, barcode, name, description, inventary_min, price_in, price_out, unit, presentation, user_id, category_id, is_active, created_at) VALUES
(1, '750100000001', 'Laptop HP 15"', 'Intel Core i5 8GB RAM 256GB SSD', 5, 450.00, 650.00, 'Pieza', 'Caja', 1, 1, 1, NOW()),
(2, '750100000002', 'Mouse Inalámbrico Logitech', 'Mouse óptico ergonómico USB', 10, 12.00, 25.00, 'Pieza', 'Empaque', 1, 1, 1, NOW()),
(3, '750100000003', 'Cuaderno Profesional 100 Hojas', 'Cuaderno de raya espiral doble', 20, 1.50, 3.50, 'Pieza', 'Paquete', 1, 2, 1, NOW()),
(4, '750100000004', 'Bolígrafo Gel Negro 0.7mm', 'Caja con 12 bolígrafos de gel', 15, 4.00, 8.50, 'Caja', 'Caja', 1, 2, 1, NOW()),
(5, '750100000005', 'Café Tostado en Grano 1kg', 'Café 100% Arábica de altura', 10, 8.00, 15.00, 'Kg', 'Bolsa', 1, 3, 1, NOW()),
(6, '750100000006', 'Leche Entera 1 Litro', 'Leche pasteurizada adicionada con vitaminas', 30, 0.80, 1.40, 'Litro', 'Envase', 1, 4, 1, NOW()),
(7, '750100000007', 'Jugo de Naranja 1L', 'Jugo 100% natural sin azúcar añadida', 25, 1.20, 2.20, 'Litro', 'Botella', 1, 5, 1, NOW()),
(8, '750100000008', 'Detergente Multiusos 2kg', 'Detergente en polvo biodegradable', 15, 3.50, 6.00, 'Bolsa', 'Bolsa', 1, 6, 1, NOW()),
(9, '750100000009', 'Juego de Destornilladores 6 pzs', 'Destornilladores de cruz y planos en acero', 5, 7.50, 14.00, 'Juego', 'Estuche', 1, 7, 1, NOW()),
(10, '750100000010', 'Camiseta Algodón Talla M', 'Camiseta 100% algodón cuello redondo', 10, 5.00, 11.00, 'Pieza', 'Bolsa', 1, 8, 1, NOW());

-- Cajas (10)
INSERT INTO box (id, created_at) VALUES
(1, NOW()),
(2, NOW()),
(3, NOW()),
(4, NOW()),
(5, NOW()),
(6, NOW()),
(7, NOW()),
(8, NOW()),
(9, NOW()),
(10, NOW());

-- Ventas / Compras (10)
INSERT INTO sell (id, person_id, user_id, operation_type_id, box_id, total, cash, discount, created_at) VALUES
(1, 1, 1, 2, 1, 675.00, 700.00, 0.00, NOW()),
(2, 2, 1, 2, 1, 50.00, 50.00, 0.00, NOW()),
(3, 3, 1, 2, 1, 25.50, 30.00, 0.00, NOW()),
(4, 4, 1, 2, 2, 100.00, 100.00, 0.00, NOW()),
(5, 5, 1, 2, 2, 45.00, 50.00, 5.00, NOW()),
(6, 11, 1, 1, NULL, 4500.00, 4500.00, 0.00, NOW()),
(7, 12, 1, 1, NULL, 240.00, 240.00, 0.00, NOW()),
(8, 6, 1, 2, 3, 14.00, 14.00, 0.00, NOW()),
(9, 7, 1, 2, 3, 60.00, 100.00, 0.00, NOW()),
(10, 8, 1, 2, 4, 33.00, 40.00, 0.00, NOW());

-- Operaciones de Inventario (10)
INSERT INTO operation (id, product_id, q, operation_type_id, sell_id, created_at) VALUES
(1, 1, 1, 2, 1, NOW()),
(2, 2, 2, 2, 2, NOW()),
(3, 3, 5, 2, 3, NOW()),
(4, 4, 2, 2, 3, NOW()),
(5, 5, 3, 2, 4, NOW()),
(6, 1, 10, 1, 6, NOW()),
(7, 2, 20, 1, 7, NOW()),
(8, 6, 10, 2, 8, NOW()),
(9, 8, 10, 2, 9, NOW()),
(10, 10, 3, 2, 10, NOW());
*/


