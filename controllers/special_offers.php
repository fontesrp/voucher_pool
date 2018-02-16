<?php

require_once __DIR__ . "/../config/session.php";
require_once __DIR__ . "/../db/database.php";
require_once __DIR__ . "/../models/special_offer.php";

class SpecialOffersController {

    private $special_offer;

    function __construct() {

        $db = new Database();

        $this->special_offer = new SpecialOffer($db);
    }

    function index() {
        print "Special Offer index";
    }

    function create() {

        $this->special_offer->create([
            "name" => $_POST["name"],
            "discount" => $_POST["discount"]
        ]);

        $id = $this->special_offer->getId();

        $response = ($id > 0)
            ? ["id" => $id]
            : ["error" => $this->special_offer->getErrors()];

        print json_encode($response);
    }

    function new_form() {
        print "Special Offer new_form";
    }

    function show() {
        print "Special Offer show";
    }

    function update() {
        print "Special Offer update";
    }

    function delete() {
        print "Special Offer delete";
    }

    function search() {
        print json_encode($this->special_offer->searchByName($_GET["term"]));
    }
}
