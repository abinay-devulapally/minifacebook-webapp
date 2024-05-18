DROP TABLE IF EXISTS `posts`;
CREATE TABLE `posts` (
    postID VARCHAR(100) PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    content VARCHAR(100),
    postTime TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    owner VARCHAR(100),
    -- FOREIGN KEY (user_id) REFERENCES users(user_id)
    FOREIGN KEY (`owner`) REFERENCES `users`(`username`) on DELETE CASCADE
);