CREATE TABLE agency (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    agency_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone_number VARCHAR(20),
    state VARCHAR(100),
    address TEXT,
    personincharge VARCHAR(255),
    photo VARCHAR(255),
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    agency_id INT(11) NOT NULL
);
