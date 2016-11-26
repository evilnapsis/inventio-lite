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

create table post (
	id int not null auto_increment primary key,
	title varchar(200) not null,
	content varchar(1000) not null,
	image varchar(255),	
	is_public boolean not null default 0,
	created_at datetime not null,
	user_id int not null,
	foreign key(user_id) references user(id)
);