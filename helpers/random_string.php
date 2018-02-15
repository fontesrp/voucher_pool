<?php

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
