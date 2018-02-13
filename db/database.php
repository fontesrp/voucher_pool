<?php

declare(strict_types=1);

class Database {

    private $connector = null;
    private $sql = "";
    private $params = [];
    private $response = null;

    function __construct() {

        if (
            !defined("DB_HOST")
            || !defined("DB_USERNAME")
            || !defined("DB_PASSWORD")
            || !defined("DB_DBNAME")
        ) {
            throw new Exception("Failed to connect to MySQL: invalid session constants", 1);
        }

        $this->connector = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DBNAME);

        if ($this->connector->connect_errno) {
            throw new Exception("Failed to connect to MySQL: (" . $this->connector . ") " . $this->connector->connect_error, 1);
        }
    }

    function setSql(string $sql): void {
        $this->sql = $sql;
    }

    function getSql(): string {
        return $this->sql;
    }

    function setParams(array $params): void {
        $this->params = $params;
    }

    function getParams(): array {
        return $this->params;
    }

    function query(): bool {

        $statement = $this->connector->prepare($this->sql);

        if (!empty($this->params)) {
            $params = $this->parseParams();
            $statement->bind_param($params["types"], ...$params["values"]);
        }

        $result = $statement->execute();

        $this->response = $statement->get_result();

        $statement->close();

        return $result;
    }

    private function parseParams(): array {

        $parse = [
            "types" => "",
            "values" => []
        ];

        foreach ($this->params as $param) {
            $parse["types"] .= $param["type"];
            $parse["values"][] = $param["value"];
        }

        return $parse;
    }

    function getRow() {
        return $this->response->fetch_assoc();
    }

    function reset() {
        $this->sql = "";
        $this->params = [];
        $this->response = null;
    }
}
