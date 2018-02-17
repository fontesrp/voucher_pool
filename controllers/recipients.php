<?php

/**
 * /controllers/recipients.php
 *
 * Controller responsible for handling requests for recipients. As there are no
 * views currently associated with recipients, this file will deal only with the
 * recipient model for handling HTTP requests.
 *
 */

require_once __DIR__ . "/../config/session.php";
require_once __DIR__ . "/../db/database.php";
require_once __DIR__ . "/../models/recipient.php";

class RecipientsController {

    private $recipient;

    function __construct() {

        $db = new Database();

        $this->recipient = new Recipient($db);
    }

    function index(): void {
        print json_encode($this->recipient->all());
    }

    function create(): void {

        $this->recipient->create([
            "name" => $_POST["name"],
            "email" => $_POST["email"]
        ]);

        $id = $this->recipient->getId();

        $response = ($id > 0)
            ? ["id" => $id]
            : ["error" => $this->recipient->getErrors()];

        print json_encode($response);
    }

    function search(): void {
        print json_encode($this->recipient->searchByEmail($_GET["term"]));
    }
}
