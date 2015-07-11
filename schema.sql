create database inventiolite;
use inventiolite;

create table user(
	id int not null auto_increment primary key,
	name varchar(50) not null,
	lastname varchar(50) not null,
	username varchar(50),
	email varchar(255) not null,
	password varchar(60) not null,
	image varchar(255),
	is_active boolean not null default 1,
	is_admin boolean not null default 0,
	created_at datetime not null
);

insert into user(name,lastname,email,password,created_at) value ("Administrador", "","admin","90b9aa7e25f80cf4f64e990b78a9fc5ebd6cecad",NOW());
insert into user(name,lastname,email,password,created_at) value ("Ventas", "","user","90b9aa7e25f80cf4f64e990b78a9fc5ebd6cecad",NOW());

create table product(
	id int not null auto_increment primary key,
	name varchar(50) not null,
	price_in float not null,
	price_out float,
	unit varchar(255) not null,
	presentation varchar(255) not null,
	user_id int not null,
	foreign key (user_id) references user(id)
);

create table operation_type(
	id int not null auto_increment primary key,
	name varchar(50) not null
);

insert into operation_type (name) value ("entrada");
insert into operation_type (name) value ("salida");

create table sell(
	id int not null auto_increment primary key,
	created_at datetime not null
);

create table operation(
	id int not null auto_increment primary key,
	product_id int not null,
	q float not null,
	operation_type_id int not null,
	sell_id int,
	is_oficial boolean not null default 0,
	created_at datetime not null,
	foreign key (product_id) references product(id),
	foreign key (operation_type_id) references operation_type(id),
	foreign key (sell_id) references sell(id)
);

