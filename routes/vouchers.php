<?php

require_once __DIR__ . "/../controllers/vouchers.php";

function call_voucher_method($name) {

    $voucher = new VouchersController();

    call_user_func([$voucher, $name]);
}

function vouchers_path($method) {

    $routes = [
        "GET" => "index",
        "POST" => "create"
    ];

    call_voucher_method($routes[$method]);
}

function new_voucher_path($method) {

    $routes = [
        "GET" => "new_form"
    ];

    call_voucher_method($routes[$method]);
}

function show_voucher_path($method) {

    $routes = [
        "GET" => "show"
    ];

    call_voucher_method($routes[$method]);
}

function update_voucher_path($method) {

    $routes = [
        "PATCH" => "update",
        "PUT" => "update"
    ];

    call_voucher_method($routes[$method]);
}

function destroy_voucher_path($method) {

    $routes = [
        "DELETE" => "delete"
    ];

    call_voucher_method($routes[$method]);
}

function gen_voucher_code_path($method) {

    $routes = [
        "GET" => "genCode"
    ];

    call_voucher_method($routes[$method]);
}

function vouchers_report_path($method) {

    $routes = [
        "GET" => "report"
    ];

    call_voucher_method($routes[$method]);
}

function vouchers_gen_path($method) {

    $routes = [
        "POST" => "generate"
    ];

    call_voucher_method($routes[$method]);
}

function voucher_validate_path($method) {

    $routes = [
        "PATCH" => "validate"
    ];

    call_voucher_method($routes[$method]);
}

function vouchers_search_path($method) {

    $routes = [
        "GET" => "searchByEmail"
    ];

    call_voucher_method($routes[$method]);
}
