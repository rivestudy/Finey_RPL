CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255)
);

CREATE TABLE incomes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    amount DECIMAL(10, 2),
    description VARCHAR(255),
    category VARCHAR(255),
    date DATE,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE expenses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    amount DECIMAL(10, 2),
    description VARCHAR(255),
    category VARCHAR(255),
    date DATE,
    FOREIGN KEY (user_id) REFERENCES users(id)
);
