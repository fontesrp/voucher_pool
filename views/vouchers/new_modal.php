<?php

/**
 * /view/vouchers/new_modal.php
 *
 * Inserts the new vouchers form in the modal frame
 *
 */

$modal_props = [
    "id" => "add-voucher",
    "title" => "Add voucher",
    "body" => "vouchers/new.php",
    "save" => "Save"
];

require request_view("fractals/modal.php");
