<?php

/**
 * /models/recipient.php
 *
 * This is the model for the recipients. It is responsible for every transaction
 * with the database in which the main table and object of concern are
 * recipients.
 *
 */

declare(strict_types=1);

require_once __DIR__ . "/../db/database.php";

class Recipient {

    private $db;
    private $errors = [];

    private $id = 0;
    private $name = "";
    private $email = "";
    private $created_at;
    private $updated_at;

    function __construct(Database $db, string $email = "") {

        $this->db = $db;

        if ($email !== "") {
            $this->find($email);
        }
    }

    private function setParams(array $params): void {

        $props = ["id", "name", "email", "created_at", "updated_at"];

        foreach ($props as $prop) {
            if (array_key_exists($prop, $params)) {
                $this->$prop = $params[$prop];
            }
        }
    }

    function find(string $email): bool {

        $this->db->clear();

        $this->db->setSql("SELECT
                id, name, email, created_at, updated_at
            FROM recipients
            WHERE email = ?");

        $this->db->setParams([
            ["type" => "s", "value" => $email]
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

        $this->db->setSql("INSERT INTO recipients (name, email)
            VALUES (?, ?)");

        $this->db->setParams([
            ["type" => "s", "value" => $this->name],
            ["type" => "s", "value" => $this->email]
        ]);

        $this->db->query();

        $this->id = $this->db->getInsertId();
        $this->errors = $this->db->getErrors();

        return $this->id;
    }

    function update(array $params): bool {

        $this->setParams($params);

        $this->db->clear();

        $this->db->setSql("UPDATE recipients
            SET name = ?, email = ?
            WHERE id = ?");

        $this->db->setParams([
            ["type" => "s", "value" => $this->name],
            ["type" => "s", "value" => $this->email],
            ["type" => "i", "value" => $this->id]
        ]);

        return $this->db->query();
    }

    function delete(): bool {

        if ($this->id === 0) {
            return false;
        }

        $this->db->clear();

        $this->db->setSql("DELETE FROM recipients WHERE id = ?");

        $this->db->setParams([
            ["type" => "i", "value" => $this->id]
        ]);

        return $this->db->query();
    }

    function getName(): string {
        return $this->name;
    }

    function getEmail(): string {
        return $this->email;
    }

    function getId(): int {
        return $this->id;
    }

    function getErrors(): array {
        return $this->errors;
    }

    function searchByEmail(string $email): array {

        $this->db->clear();

        $this->db->setSql("SELECT id, email FROM recipients WHERE email LIKE ?");

        $this->db->setParams([
            ["type" => "s", "value" => "%" . $email . "%"]
        ]);

        $this->db->query();

        return $this->db->getAll();
    }

    function all(): array {

        $this->db->clear();

        $this->db->setSql("SELECT id, name, email FROM recipients");

        $this->db->query();

        return $this->db->getAll();
    }

    function destroyAll(): bool {

        $this->db->clear();

        $this->db->setSql("DELETE FROM recipients");

        return $this->db->query();
    }
}
