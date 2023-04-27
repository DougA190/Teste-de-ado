create database 4tech;
use 4tech;

create table usuarios_backoffice(
id int(10) auto_increment not null primary key,
nome varchar(255) not null,
cpf varchar(15) not null,
email varchar(100) not null unique key,
senha varchar(200) not null,
status int (1),
grupo_usuario_id int(10)
);

create table grupos_de_usuario(
id int(10) auto_increment not null primary key,
nome varchar(255) not null,
status int (1)
);

alter table usuarios_backoffice add constraint fk_grupos_usuarios foreign key (grupo_usuario_id) references grupos_de_usuario(id);

INSERT INTO grupos_de_usuario(nome,status) values ('administrador',1);
INSERT INTO grupos_de_usuario(nome,status) values ('estoquista',1);
select * from usuarios_backoffice;
INSERT INTO usuarios_backoffice(nome,cpf,email,senha,status,grupo_usuario_id) values ('administrador','111.111.111-11','administrador@gmail.com',md5('12345678'),1,1);
INSERT INTO usuarios_backoffice(nome,cpf,email,senha,status,grupo_usuario_id) values ('estoquista','111.111.111-11','estoquista@gmail.com',md5('12345678'),1,1);

create table produto(
id int(10) auto_increment not null primary key,
codigo varchar(50) not null,
nome_produto varchar(100),
avaliacao varchar(10),
status int(1),
descricao varchar(2000),
preco varchar(100),
qtd_estoque varchar(100)
);

create table imagens_produtos(
id_img int auto_increment not null primary key,
imagem varchar(100) not null,
id_produto int(100) not null,
isprincipal int(1) not null
);


alter table imagens_produtos add constraint fk_imagens_produtos_id_produto foreign key (id_produto) references produto(id);

create table clientes(
id int(10) auto_increment not null primary key,
nome varchar(50) not null,
sobrenome varchar(200) not null,
cpf varchar(15) not null unique key,
dataNascimento varchar(11) not null,
genero varchar(20) not null,
ddd_celular varchar(2) not null,
num_celular varchar(10) not null,
ddd_telefone varchar(2) not null,
num_telefone varchar(9) not null
);

create table enderecos_de_cobranca(
id int(10) auto_increment not null primary key,
cep varchar(9) not null,
logradouro varchar(200) not null,
numero_endereco int(10) not null,
complemento varchar(50) not null,
bairro varchar(100) not null,
cidade varchar(50) not null,
uf varchar(2) not null,
cliente_id int(10)
);

alter table enderecos_de_cobranca add constraint fk_enderecos_de_cobranca_clientes foreign key(cliente_id) references clientes(id);

create table enderecos_de_entrega(
id int(10) auto_increment not null primary key,
cep varchar(9) not null,
logradouro varchar(200) not null,
numero_endereco int(10) not null,
complemento varchar(50),
bairro varchar(100) not null,
cidade varchar(50) not null,
uf varchar(2) not null,
cliente_id int(10)
);

alter table enderecos_de_entrega add constraint fk_enderecos_de_entrega_clientes foreign key(cliente_id) references clientes(id);

create table usuarios_clientes(
id int(10) auto_increment not null primary key,
email varchar(100) not null unique key,
senha varchar(200) not null,
cliente_id int(10)
);


alter table usuarios_clientes add constraint fk_usuarios_clientes foreign key(cliente_id) references clientes(id);
start transaction;
insert into clientes(nome,sobrenome,cpf,dataNascimento,genero,ddd_celular,num_celular,ddd_telefone,num_telefone) values ('João','Pablo Vilanir de Melo', '111.111.111-11','14/10/2002','Masculino','11','95355-3207','11','4245-8911');
SET @cliente_id = LAST_INSERT_ID();
insert into enderecos_de_cobranca(cep,logradouro,numero_endereco,complemento,bairro,cidade,uf,cliente_id) values ('00000-000','Rua Indefinida','11','Casa 2','Pedreira','São Paulo','SP',@cliente_id);
insert into enderecos_de_entrega(cep,logradouro,numero_endereco,complemento,bairro,cidade,uf,cliente_id) values ('00000-000','Rua Indefinida','11','Casa 2','Pedreira','São Paulo','SP',@cliente_id);
insert into usuarios_clientes(email,senha,cliente_id) values ('joao@gmail.com','12345678',@cliente_id);
commit;

select*from clientes;