<?php

require_once __DIR__ . "/../config/session.php";
require_once __DIR__ . "/../db/database.php";
require_once __DIR__ . "/../models/recipient.php";

class RecipientsController {

    private $recipient;

    function __construct() {

        $db = new Database();

        $this->recipient = new Recipient($db);
    }

    function index() {
        print "Recipient index";
    }

    function create() {

        $this->recipient->create([
            "recipient_name" => $_POST["name"],
            "email" => $_POST["email"]
        ]);

        $id = $this->recipient->getId();

        $response = ($id > 0)
            ? ["id" => $id]
            : ["error" => $this->recipient->getErrors()];

        print json_encode($response);
    }

    function new_form() {
        print "Recipient new_form";
    }

    function show() {
        print "Recipient show";
    }

    function update() {
        print "Recipient update";
    }

    function delete() {
        print "Recipient delete";
    }

    function search() {
        print json_encode($this->recipient->searchByEmail($_GET["term"]));
    }
}
