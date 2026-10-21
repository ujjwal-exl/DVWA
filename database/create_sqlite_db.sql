CREATE TABLE `users` (
`user_id` int NOT NULL,
`first_name` text DEFAULT NULL,
`last_name` text DEFAULT NULL,
`user` text DEFAULT NULL,
`password` text DEFAULT NULL,
`avatar` text DEFAULT NULL,
`last_login` datetime,
`failed_login` int,
PRIMARY KEY (`user_id`)
);

CREATE TABLE `guestbook` (
`comment_id` int,
`comment` text default null,
`name` text DEFAULT NULL,
PRIMARY KEY (`comment_id`)
);


insert into users values ('1','admin','admin','admin','5f4dcc3b5aa765d61d8327deb882cf99','admin.jpg', DATE(), '0');
insert into users values ('2','Gordon','Brown','gordonb','e99a18c4428cb38d5f260853678922e3','gordonb.jpg', DATE(), '0');
insert into users values ('3','Hack','Me','1337','8d3533d75ae2c3966d7e0d4fcc69216b','1337.jpg', DATE(), '0');
insert into users values ('4','Pablo','Picasso','pablo','0d107d09f5bbe40cade3de5c71e9e9b7','pablo.jpg', DATE(), '0');
insert into users values ('5','Bob','Smith','smithy','5f4dcc3b5aa765d61d8327deb882cf99','smithy.jpg', DATE(), '0');;

insert into guestbook values ('1', 'What a brilliant app!', 'Marcel Marceau');
