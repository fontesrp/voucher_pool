<?php

/**
 * /view/special_offers/new_modal.php
 *
 * Inserts the new special offer form in the modal frame
 *
 */

$modal_props = [
    "id" => "add-special-offer",
    "title" => "Add special offer",
    "body" => "special_offers/new.php",
    "save" => "Save"
];

require request_view("fractals/modal.php");
