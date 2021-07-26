create table users(
	user_id Int,
	username varchar(20),
	email varchar(60),
	password varchar(25),
	CONSTRAINT PK_userID Primary key (user_id)
);
create table Audio( 
	id Int,
	filesize float,
	filename varchar(100),
	extension varchar(10),
	user_id Int,
	security_code varchar(10),
	lifetime tinyint,
	uploaded_at date,
	CONSTRAINT PK_audioID Primary key (id) ,
	Foreign key (user_id) references users(user_id)
);

create table Compressed (
    id int PRIMARY KEY identity(1,1),
    user_id int,
    foreign key (user_id) references users(user_id),
    filename varchar(100),
    filesize float,
    extension varchar(10),
    security_code varchar(10),
    lifetime tinyint,
    uploaded_at date
);

create table lmage (
	id int ,
	filename varchar(100) ,
	filesize float , 
	extension varchar(10) ,
	user_id int , 
	security_code varchar(10),
	lifetime tinyint ,
	uploaded_at date ,
	CONSTRAINT PK_imageID Primary key (id),
	Foreign key (user_id) references users(user_id)
);

create table Admin(
	id int,
	username varchar(40),
	email varchar(50),
	password varchar(25),
	role int,
	CONSTRAINT PK_Admin Primary key (id)
);

create table Video (
	id int ,
	filename varchar(100) ,
	filesize float , 
	extension varchar(10) ,
	user_id int , 
	security_code varchar(10),
	lifetime tinyint ,
	uploaded_at date ,
	CONSTRAINT PK_videoID Primary key (id) ,
	Foreign key (user_id) references users(user_id)
);


create table Report(
	id int,
	user_id int,
	email varchar(30),
	subject varchar(60),
	type  tinyint,
	content varchar(25),
	sent_at date,
	CONSTRAINT PM_reportID Primary key (id),
	Foreign key (user_id) references users(user_id)
	);

create table Document(
	id int,
	filename varchar(100),
	filesize float,
	extension varchar(10),
	user_id int,
	security_code varchar(10),
	lifetime tinyint,
	uploaded_at date,
	CONSTRAINT PM_docID Primary key (id),
	Foreign key (user_id) references users(user_id)
);