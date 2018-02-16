<?php

require_once __DIR__ . "/../config/session.php";
require_once __DIR__ . "/../db/database.php";
require_once __DIR__ . "/../models/recipient.php";
require_once __DIR__ . "/../models/special_offer.php";

function gen_validate(): bool {

    return (
        array_key_exists("expiration-date", $_POST)
        && (
            array_key_exists("special-offer-id", $_POST)
            || array_key_exists("special-offer-name", $_POST)
        )
    );
}

function gen_list_recipients(): array {

    $db = new Database();
    $recipient = new Recipient($db);

    return $recipient->all();
}

function gen_get_special_offer_id(): int {

    if (array_key_exists("special-offer-id", $_POST)) {
        return (int) $_POST["special-offer-id"];
    }

    $db = new Database();
    $so = new SpecialOffer($db, $_POST["special-offer-name"]);

    return $so->getId();
}
