CREATE DATABASE IF NOT EXISTS waph_team;
CREATE USER IF NOT EXISTS 'waph_team05'@'localhost' IDENTIFIED BY 'Pa$$w0rd';
GRANT ALL ON waph_team.* TO 'waph_team05'@'localhost';