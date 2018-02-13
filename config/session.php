<?php

$config = parse_ini_file("config.ini", true, INI_SCANNER_TYPED);

foreach ($config as $section => $params) {
    foreach ($params as $key => $value) {
        define(strtoupper($section . "_" . $key), $value);
    }
}
