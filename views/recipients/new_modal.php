<?php

/**
 * /view/recipients/new_modal.php
 *
 * Inserts the new recipient form in the modal frame
 *
 */

$modal_props = [
    "id" => "add-recipient",
    "title" => "Add recipient",
    "body" => "recipients/new.php",
    "save" => "Save"
];

require request_view("fractals/modal.php");
