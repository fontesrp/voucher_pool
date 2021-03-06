<?php

/**
 * /models/special_offer.php
 *
 * This is the model for the special offers. It is responsible for every
 * transaction with the database in which the main table and object of concern
 * are special offers.
 *
 */

declare(strict_types=1);

require_once __DIR__ . "/../db/database.php";

class SpecialOffer {

    private $db;
    private $errors = [];

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
        $this->errors = $this->db->getErrors();

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
        return $this->name;
    }

    function getDiscount(): float {
        return $this->discount;
    }

    function getId(): int {
        return $this->id;
    }

    function getErrors(): array {
        return $this->errors;
    }

    function searchByName(string $name): array {

        $this->db->clear();

        $this->db->setSql("SELECT id, name, discount FROM special_offers WHERE name LIKE ?");

        $this->db->setParams([
            ["type" => "s", "value" => "%" . $name . "%"]
        ]);

        $this->db->query();

        return $this->db->getAll();
    }

    function destroyAll(): bool {

        $this->db->clear();

        $this->db->setSql("DELETE FROM special_offers");

        return $this->db->query();
    }

    function all(): array {

        $this->db->clear();

        $this->db->setSql("SELECT id, name, discount FROM special_offers");

        $this->db->query();

        return $this->db->getAll();
    }
}
