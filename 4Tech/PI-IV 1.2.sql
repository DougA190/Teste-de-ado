

create database 4tech;
use 4tech;

create table usuario(
id int(20) auto_increment not null primary key,
nome varchar(255) not null,
cpf varchar(15) not null,
email varchar(100) not null unique key,
senha varchar(200) not null,
status int (1),
grupo_usuario int(20)
);

create table grupo_usuario(
id int(20) auto_increment not null primary key,
nome varchar(255) not null,
status int (1)
);



alter table usuario add constraint fk_grupo_usuario foreign key (grupo_usuario) references grupo_usuario(id);

select * from grupo_usuario;


INSERT INTO grupo_usuario(nome,status) values ('administrador',1);
INSERT INTO grupo_usuario(nome,status) values ('estoquista',1);
select * from usuario;
INSERT INTO usuario(nome,cpf,email,senha,status,grupo_usuario) values ('administrador','323.856.450-17','joaopablo778@gmail.com','12345678',1,1);
INSERT INTO usuario(nome,cpf,email,senha,status,grupo_usuario) values ('estoquista','436.041.718-73','igor@igor.com',md5('12345678'),1,2);

select * from usuario inner join grupo_usuario on usuario.grupo_usuario = grupo_usuario.id where usuario.grupo_usuario=2;

select id,nome from usuario where email = 'igor@igor.com' and senha = md5('12345678');

create table produto(
id int auto_increment not null primary key,
nome_produto varchar(100),
avaliacao varchar(10),
status varchar(20),
descricao varchar(100),
preco varchar(100),
imagem varchar(100),
qtd_estoque varchar(100)
);

select * from produto;