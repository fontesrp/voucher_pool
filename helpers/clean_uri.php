<?php

function clean_uri(): string {

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
