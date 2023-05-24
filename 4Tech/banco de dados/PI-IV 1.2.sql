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

INSERT INTO grupo_usuario(nome,status) values ('administrador',1);
INSERT INTO grupo_usuario(nome,status) values ('estoquista',1);
select * from usuario;
INSERT INTO usuario(nome,cpf,email,senha,status,grupo_usuario) values ('administrador','111.111.111-11','administrador@gmail.com',md5('12345678'),1,1);
INSERT INTO usuario(nome,cpf,email,senha,status,grupo_usuario) values ('estoquista','111.111.111-11','estoquista@gmail.com',md5('12345678'),1,1);

create table produto(
id int(20) auto_increment not null primary key,
codigo varchar(50) not null,
nome_produto varchar(100),
avaliacao varchar(10),
status int(1),
descricao varchar(100),
preco varchar(100),
imagem varchar(100),
qtd_estoque varchar(100)
);
