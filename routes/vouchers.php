<?php

require_once __DIR__ . "/../controllers/vouchers.php";

function call_voucher_method(string $name): void {

    $voucher = new VouchersController();

    call_user_func([$voucher, $name]);
}

function vouchers_path(string $method): void {

    $routes = [
        "GET" => "index",
        "POST" => "create"
    ];

    call_voucher_method($routes[$method]);
}

function show_voucher_path(string $method): void {

    $routes = [
        "GET" => "show"
    ];

    call_voucher_method($routes[$method]);
}

function update_voucher_path(string $method): void {

    $routes = [
        "PATCH" => "update",
        "PUT" => "update"
    ];

    call_voucher_method($routes[$method]);
}

function gen_voucher_code_path(string $method): void {

    $routes = [
        "GET" => "genCode"
    ];

    call_voucher_method($routes[$method]);
}

function vouchers_report_path(string $method): void {

    $routes = [
        "GET" => "report"
    ];

    call_voucher_method($routes[$method]);
}

function vouchers_gen_path(string $method): void {

    $routes = [
        "POST" => "generate"
    ];

    call_voucher_method($routes[$method]);
}

function voucher_validate_path(string $method): void {

    $routes = [
        "PATCH" => "validate"
    ];

    call_voucher_method($routes[$method]);
}

function vouchers_search_path(string $method): void {

    $routes = [
        "GET" => "searchByEmail"
    ];

    call_voucher_method($routes[$method]);
}
