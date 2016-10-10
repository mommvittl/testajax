use staff_info;
create table staff_inform 
(
	id_staff int unsigned not null AUTO_INCREMENT primary key,
	name char(50) not null,
	surname char(50) not null,
	birth_day date not null,
	adress char(100) not null,
	email char(100),
	telephon char(50),
	resume char(100)
);
create table departament
(
	id_dep int unsigned not null AUTO_INCREMENT primary key,
	title char(50),
	description char(255),
	director int unsigned not null references staff_inform(id_staff)	
);
create table staff_working
(
	id_worker int unsigned not null references staff_inform(id_staff),
	departament int unsigned not null references departament(id_dep),
	position char(100),
	enrolment_data date,
	discharge_data date,
	reference text
);
create table hiererchy
(
	id_section int unsigned not null references departament(id_dep),
	subjection int unsigned not null references departament(id_dep)
);