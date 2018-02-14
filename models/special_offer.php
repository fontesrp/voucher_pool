<?php

require_once __DIR__ . "/../db/database.php"

declare(strict_types=1);

class SpecialOffer {

    private $db;

    private $id = 0;
    private $name = "";
    private $discount = 0.0;
    private $created_at;
    private $updated_at;

    function __construct(Database $db, string $name = "") {

        $this->db = $db;

        if ($name !== "") {
            $this->find($name);
        }
    }

    private function setParams(array $params): void {

        $props = ["id", "name", "discount", "created_at", "updated_at"];

        foreach ($props as $prop) {
            if (array_key_exists($prop, $params)) {
                $this->$prop = $params[$prop];
            }
        }
    }

    function find(string $name): bool {

        $this->db->clear();

        $this->db->setSql("SELECT
                id, name, discount, created_at, updated_at
            FROM special_offers
            WHERE name = ?");

        $this->db->setParams([
            ["type" => "s", "value" => $name]
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

        $this->db->setSql("INSERT INTO special_offers (name, discount)
            VALUES (?, ?)");

        $this->db->setParams([
            ["type" => "s", "value" => $this->name],
            ["type" => "d", "value" => $this->discount]
        ]);

        $this->db->query();

        $this->id = $this->db->getInsertId();

        return $this->id;
    }

    function update(array $params): bool {

        $this->setParams($params);

        $this->db->clear();

        $this->db->setSql("UPDATE special_offers
            SET name = ?, discount = ?
            WHERE id = ?");

        $this->db->setParams([
            ["type" => "s", "value" => $this->name],
            ["type" => "d", "value" => $this->discount],
            ["type" => "i", "value" => $this->id]
        ]);

        return $this->db->query();
    }

    function delete(): bool {

        if ($this->id === 0) {
            return false;
        }

        $this->db->clear();

        $this->db->setSql("DELETE FROM special_offers WHERE id = ?");

        $this->db->setParams([
            ["type" => "i", "value" => $this->id]
        ]);

        return $this->db->query();
    }

    function getName(): string {
        return $this->recipient_name;
    }

    function getDiscount(): float {
        return $this->discount;
    }

    function getId(): int {
        return $this->id;
    }
}
