<?php

require_once __DIR__ . "/../db/database.php"

declare(strict_types=1);

class Voucher {

    private $db;

    private $id = 0;
    private $recipient_id = 0;
    private $special_offer_id = 0;
    private $code = "";
    private $expiration_date = "";
    private $used_at = null;
    private $created_at;
    private $updated_at;

    function __construct(Database $db, string $code = "") {

        $this->db = $db;

        if ($code !== "") {
            $this->find($code);
        }
    }

    private function setParams(array $params): void {

        $props = ["id", "recipient_id", "special_offer_id", "code",
                "expiration_date", "used_at", "created_at", "updated_at"];

        foreach ($props as $prop) {
            if (array_key_exists($prop, $params)) {
                $this->$prop = $params[$prop];
            }
        }
    }

    function find(string $code): bool {

        $this->db->clear();

        $this->db->setSql("SELECT
                id,
                recipient_id,
                special_offer_id,
                code,
                expiration_date,
                used_at,
                created_at,
                updated_at
            FROM vouchers
            WHERE code = ?");

        $this->db->setParams([
            ["type" => "s", "value" => $code]
        ]);

        $this->db->query();

        if ($row = $this->db->getRow()) {

            $this->setParams($row);

            return true;
        }

        return false;
    }

    function create(array $params): int {

        $this->setParams($params);

        $this->db->clear();

        $this->db->setSql("INSERT INTO vouchers (
                recipient_id,
                special_offer_id,
                code,
                expiration_date,
                used_at
            )
            VALUES (?, ?, ? ,? ,?)");

        $this->db->setParams([
            ["type" => "i", "value" => $this->recipient_id],
            ["type" => "i", "value" => $this->special_offer_id],
            ["type" => "s", "value" => $this->code],
            ["type" => "s", "value" => $this->expiration_date],
            ["type" => "s", "value" => $this->used_at]
        ]);

        $this->db->query();

        $this->id = $this->db->getInsertId();

        return $this->id;
    }

    function update(array $params): bool {

        $this->setParams($params);

        $this->db->clear();

        $this->db->setSql("UPDATE vouchers
            SET
                recipient_id = ?,
                special_offer_id = ?,
                code = ?,
                expiration_date = ?,
                used_at = ?
            WHERE id = ?");

        $this->db->setParams([
            ["type" => "i", "value" => $this->recipient_id],
            ["type" => "i", "value" => $this->special_offer_id],
            ["type" => "s", "value" => $this->code],
            ["type" => "s", "value" => $this->expiration_date],
            ["type" => "s", "value" => $this->used_at],
            ["type" => "i", "value" => $this->id]
        ]);

        return $this->db->query();
    }

    function delete(): bool {

        if ($this->id === 0) {
            return false;
        }

        $this->db->clear();

        $this->db->setSql("DELETE FROM vouchers WHERE id = ?");

        $this->db->setParams([
            ["type" => "i", "value" => $this->id]
        ]);

        return $this->db->query();
    }

    function getRecipientId(): int {
        return $this->recipient_id;
    }

    function getSpecialOfferId(): int {
        return $this->special_offer_id;
    }

    function getCode(): string {
        return $this->code;
    }

    function getExpirationDate(): string {
        return $this->expiration_date;
    }

    function getUsedAt() {
        return $this->used_at;
    }

    function getId(): int {
        return $this->id;
    }
}
