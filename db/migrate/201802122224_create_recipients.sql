CREATE TABLE recipients (
    id SERIAL PRIMARY KEY,
    recipient_name VARCHAR(250) NOT NULL,
    email VARCHAR(250) NOT NULL UNIQUE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME ON UPDATE CURRENT_TIMESTAMP
);