CREATE TABLE vouchers (
    id SERIAL PRIMARY KEY,
    recipient_id BIGINT UNSIGNED,
    special_offer_id BIGINT UNSIGNED,
    code VARCHAR(8) NOT NULL UNIQUE,
    expiration_date DATE NOT NULL,
    used_at DATETIME,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT vouchers_recipient_fk FOREIGN KEY (recipient_id) REFERENCES recipients (id) ON DELETE SET NULL,
    CONSTRAINT vouchers_special_offer_fk FOREIGN KEY (special_offer_id) REFERENCES special_offers (id) ON DELETE SET NULL
);
