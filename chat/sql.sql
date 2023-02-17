create table posts (post_id int primary key AUTO_INCREMENT,parent_id int,post text,post_pic varchar(64), post_video varchar(64), sender varchar(64),date_posted int)

create table chat_messages (msg_id int primary key AUTO_INCREMENT,msg_sender varchar(64),msg_receiver varchar(64), message text,date_sent datetime)

create table chat_members (user_id int primary key AUTO_INCREMENT,firstname varchar(64),lastname varchar(64), username varchar(64), passwordX varchar(64), email varchar(64), gender varchar(6), dob varchar(10), date_joined date, propic varchar(64), home_address text, about_you text, Profession text, marital_status varchar(20)) 

create table group_members(g_id primary key AUTO_INCREMENT, group_name varchar(64), username varchar(64), admin int, fixed_id int)

create table group_name(group_name varchar(64), fixed_id int,propic varchar(64), date_created date)

create table group_messages(msg_id int primary key AUTO_INCREMENT, fixed_id int, username varchar(64), message text, media varchar(64), date_sent date)

create table notifications(username varchar(64),the_field varchar(64), id_val int)

create table user_pictures(p_id int primary key AUTO_INCREMENT, username varchar(64), picture text)