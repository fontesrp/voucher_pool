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
        print "Recipient create";
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
