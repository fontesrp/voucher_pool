/**
 * /db/migrate/201802122221_create_user_and_database.sql
 *
 * Setup database
 *
 */

CREATE USER voucher_app
    IDENTIFIED BY '********';

CREATE DATABASE voucher_pool
    DEFAULT CHARACTER SET utf8
    DEFAULT COLLATE utf8_general_ci;

GRANT ALL
    ON voucher_pool.*
    TO 'voucher_app';
