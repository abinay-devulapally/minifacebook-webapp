-- Drop existing tables
DROP TABLE IF EXISTS superusers;
DROP TABLE IF EXISTS comments;
DROP TABLE IF EXISTS posts;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS all_users;

-- Create the all_users table
CREATE TABLE all_users (
    username TEXT PRIMARY KEY,
    userType TEXT CHECK(userType IN ('user', 'superuser')) NOT NULL
);

-- Create the users table
CREATE TABLE users (
    username TEXT PRIMARY KEY,
    password TEXT NOT NULL,
    name TEXT,
    email TEXT,
    phone TEXT,
    isActive INTEGER DEFAULT 1,
    FOREIGN KEY (username) REFERENCES all_users(username) ON DELETE CASCADE
);

-- Create the superusers table
CREATE TABLE superusers (
    username TEXT PRIMARY KEY,
    password TEXT NOT NULL,
    name TEXT,
    email TEXT,
    phone TEXT,
    FOREIGN KEY (username) REFERENCES all_users(username) ON DELETE CASCADE
);

-- Create the posts table
CREATE TABLE posts (
    postID TEXT PRIMARY KEY,
    title TEXT NOT NULL,
    content TEXT,
    postTime TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    owner TEXT,
    FOREIGN KEY (owner) REFERENCES all_users(username) ON DELETE CASCADE
);

-- Create the comments table
CREATE TABLE comments (
    commentID INTEGER PRIMARY KEY AUTOINCREMENT,
    postID TEXT,
    username TEXT,
    content TEXT NOT NULL,
    commentTime TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (postID) REFERENCES posts(postID) ON DELETE CASCADE,
    FOREIGN KEY (username) REFERENCES all_users(username) ON DELETE CASCADE
);

-- Insert initial data into all_users table
INSERT INTO all_users(username, userType) VALUES ('team05', 'user'), ('test', 'user'), ('admin', 'superuser');

-- Insert initial data into users table
INSERT INTO users(username, password) VALUES ('team05', ''), ('test', 'test'); -- Remove MD5, handle password hashing in application

-- Insert initial data into superusers table
INSERT INTO superusers(username, password) VALUES ('admin', 'admin'); -- Remove MD5, handle password hashing in application

-- Insert initial data into posts table
INSERT INTO posts (postID, title, content, owner) VALUES
('1', 'First Post', 'This is the content of the first post.', 'team05'),
('2', 'Second Post', 'This is the content of the second post.', 'test');
