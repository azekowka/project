-- Create database
CREATE DATABASE IF NOT EXISTS movie_mood_matcher;
USE movie_mood_matcher;

-- Drop tables if they exist (in correct order due to foreign key constraints)
DROP TABLE IF EXISTS movies;
DROP TABLE IF EXISTS moods;
DROP TABLE IF EXISTS users;

-- Create users table first
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create moods table
CREATE TABLE moods (
    id INT PRIMARY KEY AUTO_INCREMENT,
    mood_name VARCHAR(50) NOT NULL UNIQUE
);

-- Create movies table with foreign keys
CREATE TABLE movies (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    mood_id INT,
    image_url VARCHAR(255),
    user_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (mood_id) REFERENCES moods(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Insert default moods
INSERT INTO moods (mood_name) VALUES 
('Happy'),
('Sad'),
('Inspired'),
('Excited'),
('Relaxed'),
('Romantic')
ON DUPLICATE KEY UPDATE mood_name=mood_name;

-- Insert a test user (password: test123)
INSERT INTO users (username, email, password) VALUES
('test_user', 'test@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi')
ON DUPLICATE KEY UPDATE username=username;

-- Insert some sample movies (after both users and moods exist)
INSERT INTO movies (title, description, mood_id, image_url, user_id) VALUES
('The Pursuit of Happyness', 'An inspiring story of a father and son.', 3, 'default.jpg', 1),
('La La Land', 'A musical romance that will lift your spirits.', 1, 'default.jpg', 1),
('The Notebook', 'A timeless romantic tale.', 6, 'default.jpg', 1),
('Up', 'An adventurous animated film about love and dreams.', 1, 'default.jpg', 1),
('Dead Poets Society', 'An inspiring tale of breaking conventions.', 3, 'default.jpg', 1); 