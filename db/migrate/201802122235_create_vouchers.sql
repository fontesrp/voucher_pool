/**
 * /db/migrate/201802122235_create_vouchers.sql
 *
 * Create vouchers table
 *
 */

CREATE TABLE vouchers (
    id SERIAL PRIMARY KEY,
    recipient_id BIGINT UNSIGNED,
    special_offer_id BIGINT UNSIGNED,
    code VARCHAR(8) NOT NULL UNIQUE INDEX,
    expiration_date DATE NOT NULL,
    used_at DATETIME,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT vouchers_recipient_fk FOREIGN KEY (recipient_id) REFERENCES recipients (id) ON DELETE CASCADE,
    CONSTRAINT vouchers_special_offer_fk FOREIGN KEY (special_offer_id) REFERENCES special_offers (id) ON DELETE CASCADE
);
