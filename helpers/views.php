<?php

/**
 * /helpers/views.php
 *
 * This functions are used by the views for generating URLs and to simplify the
 * inclusion of libraries by requiring their components in blocks.
 *
 */

function request_absolute(string $path): string {
    return "/voucher_pool/" . $path;
}

function request_public(string $path): string {
    return request_absolute("public/" . $path);
}

function request_vendor(string $path): string {
    return request_absolute("vendor/" . $path);
}

function request_view(string $path): string {
    return __DIR__ . "/../views/" . $path;
}

function generate_request(string $file, bool $vendor = false): string {

    $tag = [
        "css" => "<link rel='stylesheet' type='text/css' href='FILE_PLACEHOLDER'>",
        "js" => "<script type='text/javascript' src='FILE_PLACEHOLDER'></script>"
    ];

    $type = substr($file, strrpos($file, ".") + 1);

    $path = ($vendor)
        ? request_vendor($file)
        : request_public($file);

    return str_replace("FILE_PLACEHOLDER", $path, $tag[$type]);
}

function include_files(array $files, bool $vendor = false): string {

    $include = "";

    foreach ($files as $file) {
        $include .= generate_request($file, $vendor);
    }

    return $include;
}

function include_bootstrap(): string {

    return include_files([
        "css/bootstrap.min.css",
        "js/jquery-3.3.1.min.js",
        "js/popper.min.js",
        "js/bootstrap.min.js"
    ], true);
}

function include_data_tables(): string {

    return include_files([
        "css/dataTables.bootstrap4.min.css",
        "js/jquery.dataTables.min.js",
        "js/dataTables.bootstrap4.min.js"
    ], true);
}

function include_jquery_ui(): string {

    return include_files([
        "css/jquery-ui.min.css",
        "js/jquery-ui.min.js"
    ], true);
}

function include_dependencies(): string {

    return include_bootstrap() . include_data_tables() . include_jquery_ui();
}

function include_application(): string {

    return include_files([
        "css/application.css",
        "js/util.js",
        "js/newVoucherModal.js",
        "js/updateVoucherModal.js",
        "js/newRecipientModal.js",
        "js/newSpecialOfferModal.js",
        "js/genVouchersModal.js",
        "js/showVouchers.js",
        "js/application.js"
    ]);
}
