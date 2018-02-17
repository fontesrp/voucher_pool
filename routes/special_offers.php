<?php

/**
 * routes/special_offers.php
 *
 * Matches the request method with the corresponding controller method
 *
 */

require_once __DIR__ . "/../controllers/special_offers.php";

function call_special_offer_method(string $name): void {

    $special_offer = new SpecialOffersController();

    call_user_func([$special_offer, $name]);
}

function special_offers_path(string $method): void {

    $routes = [
        "GET" => "index",
        "POST" => "create"
    ];

    call_special_offer_method($routes[$method]);
}

function search_special_offers_path(string $method): void {

    $routes = [
        "GET" => "search"
    ];

    call_special_offer_method($routes[$method]);
}
