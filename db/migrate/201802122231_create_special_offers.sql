/**
 * /db/migrate/201802122231_create_special_offers.sql
 *
 * Create special offers table
 *
 */

CREATE TABLE special_offers (
    id SERIAL PRIMARY KEY,
    name VARCHAR(250) NOT NULL,
    discount FLOAT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
