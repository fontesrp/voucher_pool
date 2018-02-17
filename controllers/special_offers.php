<?php

/**
 * /controllers/special_offers.php
 *
 * Controller responsible for handling requests for special offers. As there are
 * no views currently associated with special offers, this file will deal only
 * with the special_offer model for handling HTTP requests.
 *
 */

require_once __DIR__ . "/../config/session.php";
require_once __DIR__ . "/../db/database.php";
require_once __DIR__ . "/../models/special_offer.php";

class SpecialOffersController {

    private $special_offer;

    function __construct() {

        $db = new Database();

        $this->special_offer = new SpecialOffer($db);
    }

    function index(): void {
        print json_encode($this->special_offer->all());
    }

    function create(): void {

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

    function search(): void {
        print json_encode($this->special_offer->searchByName($_GET["term"]));
    }
}
