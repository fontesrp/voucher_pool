<?php

require_once __DIR__ . "/recipients.php";
require_once __DIR__ . "/special_offers.php";
require_once __DIR__ . "/vouchers.php";

// voucher_pool/recipients/new
$uri = clean_uri();

// GET, POST, PUT, PATCH or DELETE
$method = $_SERVER["REQUEST_METHOD"];

$routes = [
    "voucher_pool" => [
        "index" => "root_path",
        "recipients" => [
            "index" => "recipients_path",
            "new" => "new_recipient_path",
            "show" => "show_recipient_path",
            "update" => "update_recipient_path",
            "destroy" => "destroy_recipient_path",
            "search" => "search_recipients_path"
        ],
        "special_offers" => [
            "index" => "special_offers_path",
            "new" => "new_special_offer_path",
            "show" => "show_special_offer_path",
            "update" => "update_special_offer_path",
            "destroy" => "destroy_special_offer_path",
            "search" => "search_special_offers_path"
        ],
        "vouchers" => [
            "index" => "vouchers_path",
            "new" => "new_voucher_path",
            "show" => "show_voucher_path",
            "update" => "update_voucher_path",
            "destroy" => "destroy_voucher_path",
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

function clean_uri() {

    // `/my/path?query`
    $uri = $_SERVER["REQUEST_URI"];

    // `my/path?query`
    $uri = substr($uri, 1);

    // `?query`
    $query = "?" . $_SERVER["QUERY_STRING"];

    // `my/path`
    $uri = str_replace($query, "", $uri);

    return $uri;
}
