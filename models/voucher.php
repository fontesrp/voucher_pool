<?php

declare(strict_types=1);

require_once __DIR__ . "/../db/database.php";

class Voucher {

    private $db;
    private $errors = [];

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

    function find(string $code, int $id = 0): bool {

        if ($code === "") {
            $column = "id";
            $type = "i";
            $value = $id;
        } else {
            $column = "code";
            $type = "s";
            $value = $code;
        }

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
            WHERE " . $column . " = ?");

        $this->db->setParams([
            ["type" => $type, "value" => $value]
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
        $this->errors = $this->db->getErrors();

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

        $result = $this->db->query();
        $this->errors = $this->db->getErrors();

        return $result;
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

    function getErrors(): array {
        return $this->errors;
    }

    function report(): array {

        $this->db->clear();

        $this->db->setSql("SELECT
                COUNT(1) AS total,
                SUM(CASE WHEN used_at IS NULL OR used_at = '' THEN 1 ELSE 0 END) AS unused
            FROM vouchers");

        $this->db->query();

        $report = [
            "generated" => 0,
            "unused" => 0,
            "used" => 0
        ];

        if ($row = $this->db->getRow()) {
            $report["generated"] = (int) $row["total"];
            $report["unused"] = (int) $row["unused"];
            $report["used"] = $report["generated"] - $report["unused"];
        }

        return $report;
    }

    function first(int $limit = 0, int $offset = 0): array {

        $sql = "SELECT
                id,
                recipient_id,
                special_offer_id,
                code,
                expiration_date,
                used_at,
                created_at,
                updated_at
            FROM vouchers";

        $params = [];

        if ($limit !== 0) {
            $sql .= " LIMIT ?, ?";
            $params = [
                ["type" => "i", "value" => $offset],
                ["type" => "i", "value" => $limit]
            ];
        }

        $this->db->clear();

        $this->db->setSql($sql);

        $this->db->setParams($params);

        $this->db->query();

        return $this->db->getAll();
    }

    function all(): array {
        return $this->first();
    }

    function allWithRecipient(): array {

        $this->db->clear();

        $this->db->setSql("SELECT
                vou.id,
                vou.recipient_id,
                vou.special_offer_id,
                vou.code,
                vou.expiration_date,
                vou.used_at,
                vou.created_at,
                vou.updated_at,
                rec.recipient_name,
                rec.email
            FROM
                vouchers vou
                INNER JOIN recipients rec ON vou.recipient_id = rec.id
            ORDER BY
                vou.created_at DESC,
                vou.used_at DESC,
                rec.email,
                vou.code");

        $this->db->query();

        return $this->db->getAll();
    }

    function findByCodeAndEmail(string $code, string $email) {

        $this->db->clear();

        $this->db->setSql("SELECT
                vou.id,
                sof.discount
            FROM
                vouchers vou
                INNER JOIN recipients rec ON vou.recipient_id = rec.id
                INNER JOIN special_offers sof ON vou.special_offer_id = sof.id
            WHERE
                vou.code = ?
                AND rec.email = ?");

        $this->db->setParams([
            ["type" => "s", "value" => $code],
            ["type" => "s", "value" => $email]
        ]);

        $this->db->query();

        return $this->db->getRow();
    }

    function searchByEmail(string $email): array {

        $this->db->clear();

        $this->db->setSql("SELECT
                vou.code,
                sof.name
            FROM
                vouchers vou
                INNER JOIN recipients rec ON vou.recipient_id = rec.id
                INNER JOIN special_offers sof ON vou.special_offer_id = sof.id
            WHERE
                rec.email = ?");

        $this->db->setParams([
            ["type" => "s", "value" => $email]
        ]);

        $this->db->query();

        return $this->db->getAll();
    }
}
