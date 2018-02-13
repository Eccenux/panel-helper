CREATE DATABASE panel_helper_db;
GRANT ALL ON panel_helper_db.* 
	TO panel_helper_user@localhost IDENTIFIED BY 'some password for MySQL user';
/*
SET PASSWORD FOR
	panel_helper_user@localhost = OLD_PASSWORD('some password for MySQL user');
*/
USE panel_helper_db
