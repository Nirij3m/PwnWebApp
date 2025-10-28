DROP TABLE IF EXISTS users;

CREATE TABLE users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT NOT NULL UNIQUE,
    password TEXT NOT NULL,
    is_admin INTEGER DEFAULT 0
);


INSERT INTO users (username, password, is_admin) VALUES
('alice',  '1234', 0), 
('bob',    'azerty', 0), 
('caroline','rockyou', 0),
('dave',   'iloveyou', 0),
('admin',  'Sup3rP@ss!', 1)

