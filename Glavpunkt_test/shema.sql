CREATE DATABASE IF NOT EXISTS baserecord;
USE baserecord;

CREATE TABLE posts (            
	id       INT NOT NULL  PRIMARY KEY UNIQUE,
	userId   INT NOT NULL,
	title    CHAR(150) NOT NULL,
	body     TEXT NOT NULL         
);

CREATE TABLE comments (            
	id       INT NOT NULL PRIMARY KEY UNIQUE,
	postId   INT NOT NULL,
	name    CHAR(150) NOT NULL,
	email    CHAR(50) NOT NULL,
	body     TEXT NOT NULL,
	FOREIGN KEY (postId) REFERENCES posts(id)         
);