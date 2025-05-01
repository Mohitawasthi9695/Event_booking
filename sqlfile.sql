-- Create the database
CREATE DATABASE IF NOT EXISTS ticket_booking CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE ticket_booking;

-- Create users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create events table
CREATE TABLE IF NOT EXISTS events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    date DATE NOT NULL,
    venue VARCHAR(255) NOT NULL,
    available_seats INT NOT NULL CHECK (available_seats >= 0)
);

-- Insert sample events
INSERT INTO events (name, date, venue, available_seats) VALUES
('Music Concert', '2025-06-15', 'City Auditorium', 100),
('Tech Conference', '2025-06-20', 'Tech Park Hall', 50),
('Art Exhibition', '2025-06-25', 'Modern Art Gallery', 70),
('Comedy Night', '2025-06-30', 'Laugh Arena', 80),
('Science Fair', '2025-07-05', 'Expo Center', 60);

-- Create bookings table
CREATE TABLE IF NOT EXISTS bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    event_id INT NOT NULL,
    booked_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE
);
