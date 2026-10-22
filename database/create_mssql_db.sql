/*
In case I get round to adding MS SQL support, this creates and populates the tables.
*/

CREATE DATABASE dvwa;

USE dvwa;

CREATE TABLE users (user_id INT PRIMARY KEY,first_name VARCHAR(15),last_name VARCHAR(15), [user] VARCHAR(15), password VARCHAR(32),avatar VARCHAR(70), last_login DATETIME, failed_login INT);

-- The admin password is supplied at deployment time and must be generated uniquely per deployment, e.g.:
--   sqlcmd -i create_mssql_db.sql -v ADMIN_PASSWORD="a-random-value-generated-for-this-deployment"
-- sqlcmd aborts if ADMIN_PASSWORD is not defined, so no deployment can fall back to a known default.
-- Demo accounts (gordonb, 1337, pablo, smithy) are intentionally not seeded.
INSERT INTO users VALUES ('1','admin','admin','admin',CONVERT(NVARCHAR(32),HashBytes('MD5', '$(ADMIN_PASSWORD)'),2),'admin.jpg', GETUTCDATE(), '0');

CREATE TABLE guestbook (comment_id INT IDENTITY(1,1) PRIMARY KEY, comment VARCHAR(300), name VARCHAR(100),2);

INSERT INTO guestbook (comment, name) VALUES ('This is a test comment.','test');
