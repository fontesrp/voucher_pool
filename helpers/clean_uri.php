<?php

/**
 * /helpers/clean_uri.php
 *
 * In the case of a get request, the request URI can conatin a query, wich could
 * break the router functionality. Since the query is also stored in the $_SERVER
 * and $_GET superglobals, and will only be used by the controller, the URI is
 * stripped of it.
 *
 */

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
