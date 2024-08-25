-- create database
create database final_project;


-- users
CREATE TABLE users (
    id bigint PRIMARY KEY auto_increment,
    name varchar(255) not null,
    surname varchar(255) not null,
    gender int not null, --1 - male, 0 - female
    dob date not null,
    profile varchar(255) default null,
    email varchar(255) unique not null,
    password varchar(255) not null,
    active int default 1, --1 active, 0 deactive
    role int default 0, --0 client , 1 admin
    otp int default null,
    created_at timestamp default current_timestamp,
    updated_at timestamp default current_timestamp
);

-- blog
CREATE TABLE blogs (
       id bigint PRIMARY KEY auto_increment,
       user_id bigint,
       category_id bigint,
       title varchar(1000) not null,
       description mediumtext not null,
       profile varchar(255) not null,
       is_publish boolean default 0, --paylasilmayib, 1 - paylasilib
       view_count int default 0, 
       created_at timestamp default current_timestamp,
       updated_at timestamp default current_timestamp,
       foreign key (user_id) references users(id),
       foreign key (category_id) references catigories(id)
);

-- catigory
CREATE TABLE categories (
       id bigint PRIMARY KEY auto_increment,
       name varchar(255) not null,
       created_at timestamp default current_timestamp,
       updated_at timestamp default current_timestamp
)