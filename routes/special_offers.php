<?php

require_once __DIR__ . "/../controllers/special_offers.php";

function call_special_offer_method($name) {

    $special_offer = new SpecialOffersController();

    call_user_func([$special_offer, $name]);
}

function special_offers_path($method) {

    $routes = [
        "GET" => "index",
        "POST" => "create"
    ];

    call_special_offer_method($routes[$method]);
}

function new_special_offer_path($method) {

    $routes = [
        "GET" => "new_form"
    ];

    call_special_offer_method($routes[$method]);
}

function show_special_offer_path($method) {

    $routes = [
        "GET" => "show"
    ];

    call_special_offer_method($routes[$method]);
}

function update_special_offer_path($method) {

    $routes = [
        "PATCH" => "update",
        "PUT" => "update"
    ];

    call_special_offer_method($routes[$method]);
}

function destroy_special_offer_path($method) {

    $routes = [
        "DELETE" => "delete"
    ];

    call_special_offer_method($routes[$method]);
}

function search_special_offers_path($method) {

    $routes = [
        "GET" => "search"
    ];

    call_special_offer_method($routes[$method]);
}
