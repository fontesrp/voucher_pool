<?php

require_once __DIR__ . "/recipients.php";
require_once __DIR__ . "/special_offers.php";
require_once __DIR__ . "/vouchers.php";
require_once __DIR__ . "/../helpers/clean_uri.php";

// voucher_pool/recipients/new
$uri = clean_uri();

// GET, POST, PUT, PATCH or DELETE
$method = $_SERVER["REQUEST_METHOD"];

// Function to call for each route
$routes = [
    "voucher_pool" => [
        "index" => "vouchers_path",
        "recipients" => [
            "index" => "recipients_path",
            "search" => "search_recipients_path"
        ],
        "special_offers" => [
            "index" => "special_offers_path",
            "search" => "search_special_offers_path"
        ],
        "vouchers" => [
            "index" => "vouchers_path",
            "show" => "show_voucher_path",
            "update" => "update_voucher_path",
            "code_gen" => "gen_voucher_code_path",
            "report" => "vouchers_report_path",
            "gen" => "vouchers_gen_path",
            "validate" => "voucher_validate_path",
            "search" => "vouchers_search_path"
        ]
    ]
];

$call_stack = array_reverse(explode("/", $uri));

$rt = $routes;

while ($key = array_pop($call_stack)) {
    $rt = $rt[$key];
}

if (is_callable($rt)) {
    call_user_func($rt, $method);
} else {
    http_response_code(404);
    die("Page not found");
}
