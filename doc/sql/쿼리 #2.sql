-- CREATE DATABASE board;

-- USE board;

CREATE TABLE board_info(
	board_no INT(5) AUTO_INCREMENT PRIMARY KEY
	,board_title VARCHAR(100) NOT NULL
	,board_contents VARCHAR(1000)NOT NULL
	,board_write_date DATETIME NOT NULL
	,board_del_flg CHAR(1) DEFAULT('0')
	,board_del_date DATETIME
);

DESC board_info;