CREATE TABLE image (
	id       INT PRIMARY KEY AUTOINCREMENT,
	path     VARCHAR(1024),
	category VARCHAR(64),
	comment  VARCHAR(1024)
);

CREATE TABLE user (
	pseudo    VARCHAR(1024) PRIMARY KEY,
	password  VARCHAR(1024) NOT NULL,
	privilege INT DEFAULT 0
)
