<?php

/**
 * /view/vouchers/update_modal.php
 *
 * Inserts the update vouchers form in the modal frame
 *
 */

$modal_props = [
    "id" => "upd-voucher",
    "title" => "Update voucher",
    "body" => "vouchers/update.php",
    "save" => "Save"
];

require request_view("fractals/modal.php");
