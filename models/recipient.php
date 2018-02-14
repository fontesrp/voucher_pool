<?php

require_once __DIR__ . "/../db/database.php"

declare(strict_types=1);

class Recipient {

    private $db;

    private $id = 0;
    private $recipient_name = "";
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

        $props = ["id", "recipient_name", "email", "created_at", "updated_at"];

        foreach ($props as $prop) {
            if (array_key_exists($prop, $params)) {
                $this->$prop = $params[$prop];
            }
        }
    }

    function find(string $email): bool {

        $this->db->clear();

        $this->db->setSql("SELECT
                id, recipient_name, email, created_at, updated_at
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

        $this->db->setSql("INSERT INTO recipients (recipient_name, email)
            VALUES (?, ?)");

        $this->db->setParams([
            ["type" => "s", "value" => $this->recipient_name],
            ["type" => "s", "value" => $this->email]
        ]);

        $this->db->query();

        $this->id = $this->db->getInsertId();

        return $this->id;
    }

    function update(array $params): bool {

        $this->setParams($params);

        $this->db->clear();

        $this->db->setSql("UPDATE recipients
            SET recipient_name = ?, email = ?
            WHERE id = ?");

        $this->db->setParams([
            ["type" => "s", "value" => $this->recipient_name],
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
        return $this->recipient_name;
    }

    function getEmail(): string {
        return $this->email;
    }

    function getId(): int {
        return $this->id;
    }
}
