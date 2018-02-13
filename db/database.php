<?php

declare(strict_types=1);

class Database {

    private $connector = null;
    private $sql = "";
    private $params = [];
    private $response = null;

    function __contruct() {

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

    function query():void {

        $statement = $this->connector->prepare($this->sql);

        foreach ($this->params as $param) {
            $statement->bind_param($param["type"], $param["value"]);
        }

        $statement->execute();

        $this->response = $statement->get_result();

        $statement->close();
    }

    function getRow(): array {
        return $this->response->fetch_assoc();
    }
}
