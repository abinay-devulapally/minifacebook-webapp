DROP TABLE IF EXISTS `superusers`;
DROP TABLE IF EXISTS `comments`;
DROP TABLE IF EXISTS `posts`;
DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `all_users`; 

CREATE TABLE `all_users` (
    username VARCHAR(100) PRIMARY KEY,
    userType ENUM('user', 'superuser') NOT NULL
);

CREATE TABLE `users` (
    username VARCHAR(100) PRIMARY KEY,
    password VARCHAR(100) NOT NULL,
    name VARCHAR(100),
    email VARCHAR(100),
    phone VARCHAR(10),
    isActive BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (username) REFERENCES all_users(username) ON DELETE CASCADE
);

CREATE TABLE `superusers` (
    username VARCHAR(100) PRIMARY KEY,
    password VARCHAR(100) NOT NULL,
    name VARCHAR(100),
    email VARCHAR(100),
    phone VARCHAR(10),
    FOREIGN KEY (username) REFERENCES all_users(username) ON DELETE CASCADE
);

CREATE TABLE `posts` (
    postID VARCHAR(100) PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    content VARCHAR(100),
    postTime TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    owner VARCHAR(100),
    FOREIGN KEY (`owner`) REFERENCES `all_users`(`username`) ON DELETE CASCADE
);

CREATE TABLE `comments` (
    commentID INT AUTO_INCREMENT PRIMARY KEY,
    postID VARCHAR(100),
    username VARCHAR(100),
    content TEXT NOT NULL,
    commentTime TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (postID) REFERENCES posts(postID) ON DELETE CASCADE,
    FOREIGN KEY (username) REFERENCES all_users(username) ON DELETE CASCADE
);


LOCK TABLES `all_users` WRITE, `users` WRITE, `superusers` WRITE;
INSERT INTO all_users(username, userType) VALUES ('team05', 'user'), ('test', 'user'), ('admin', 'superuser');
INSERT INTO users(username,password) VALUES ('team05', MD5('')), ('test', MD5('test'));
INSERT INTO superusers(username,password) VALUES ('admin', MD5('admin'));
UNLOCK TABLES;

INSERT INTO posts (postID, title, content, owner) VALUES
('1', 'First Post', 'This is the content of the first post.', 'team05'),
('2', 'Second Post', 'This is the content of the second post.', 'test');
