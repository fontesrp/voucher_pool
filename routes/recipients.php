<?php

require_once __DIR__ . "/../controllers/recipients.php";

function call_recipient_method(string $name): void {

    $recipient = new RecipientsController();

    call_user_func([$recipient, $name]);
}

function recipients_path(string $method): void {

    $routes = [
        "GET" => "index",
        "POST" => "create"
    ];

    call_recipient_method($routes[$method]);
}

function search_recipients_path(string $method): void {

    $routes = [
        "GET" => "search"
    ];

    call_recipient_method($routes[$method]);
}
