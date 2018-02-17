<?php

/**
 * /view/vouchers/gen_modal.php
 *
 * Inserts the generate vouchers form in the modal frame
 *
 */

$modal_props = [
    "id" => "gen-voucher",
    "title" => "Generate vouchers",
    "body" => "vouchers/gen.php",
    "save" => "Generate"
];

require request_view("fractals/modal.php");
