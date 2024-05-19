CREATE DATABASE IF NOT EXISTS admin_team;
CREATE USER IF NOT EXISTS 'admin'@'localhost' IDENTIFIED BY 'Pa$$w0rd';
GRANT ALL ON admin_team.* TO 'admin'@'localhost';