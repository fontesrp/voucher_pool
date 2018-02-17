<?php

/**
 * /helpers/random_string.php
 *
 * Uses the cryptographically secure pseudo-random integers generator random_int
 * to generate a pseudo-random string. Very useful for generating voucher codes.
 *
 */

function random_str(int $length, string $keyspace = ""): string {

    if ($keyspace === "") {
        $keyspace = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    }

    $str = "";

    $max = strlen($keyspace) - 1;

    for ($i = 0; $i < $length; $i++) {
        $str .= $keyspace[random_int(0, $max)];
    }

    return $str;
}
