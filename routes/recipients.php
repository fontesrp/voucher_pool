<?php

require_once __DIR__ . "/../controllers/recipients.php";

function call_recipient_method($name) {

    $recipient = new RecipientsController();

    call_user_func([$recipient, $name]);
}

function recipients_path($method) {

    $routes = [
        "GET" => "index",
        "POST" => "create"
    ];

    call_recipient_method($routes[$method]);
}

function new_recipient_path($method) {

    $routes = [
        "GET" => "new_form"
    ];

    call_recipient_method($routes[$method]);
}

function show_recipient_path($method) {

    $routes = [
        "GET" => "show"
    ];

    call_recipient_method($routes[$method]);
}

function update_recipient_path($method) {

    $routes = [
        "PATCH" => "update",
        "PUT" => "update"
    ];

    call_recipient_method($routes[$method]);
}

function destroy_recipient_path($method) {

    $routes = [
        "DELETE" => "delete"
    ];

    call_recipient_method($routes[$method]);
}

function search_recipients_path($method) {

    $routes = [
        "GET" => "search"
    ];

    call_recipient_method($routes[$method]);
}
