create database vchat;

use vchat;

create table users(
    id int auto_increment not null,
    username varchar(100) not null,
    name varchar(50) not null,
    email varchar(100) not null,
    password varchar(100) not null,
    profile_image varchar(255) default "emptyPhoto.png",
    session_id varchar(255) not null,
    connection_id int,
    constraint pk_user primary key(id);
);