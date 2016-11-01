CREATE TABLE image (
	id       INTEGER PRIMARY KEY AUTOINCREMENT,
	path     VARCHAR(1024),
	category VARCHAR(64),
	comment  VARCHAR(1024)
);

CREATE TABLE user (
	pseudo    VARCHAR(1024) PRIMARY KEY,
	password  VARCHAR(1024) NOT NULL,
	privilege INT DEFAULT 0
);

CREATE TABLE album (
	id     INTEGER PRIMARY KEY AUTOINCREMENT,
	name   VARCHAR(1024) NOT NULL,
	owner  VARCHAR(1024) NOT NULL,
	images VARCHAR(1024)
);
