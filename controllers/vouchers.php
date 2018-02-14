<?php

require_once __DIR__ . "/../config/session.php";
require_once __DIR__ . "/../db/database.php";
require_once __DIR__ . "/../models/voucher.php";

class VouchersController {

    private $voucher;

    function __construct() {

        $db = new Database();

        $this->voucher = new Voucher($db);
    }

    function index() {
        print "Voucher index";
    }

    function create() {
        print "Voucher create";
    }

    function new_form() {
        print "Voucher new_form";
    }

    function show() {

        $report = $this->voucher->report();
        $vouchers = $this->voucher->first(10);

        require_once __DIR__ . "/../views/vouchers/show.php";
    }

    function update() {
        print "Voucher update";
    }

    function delete() {
        print "Voucher delete";
    }
}
