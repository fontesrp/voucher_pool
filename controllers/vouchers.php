<?php

require_once __DIR__ . "/../config/session.php";
require_once __DIR__ . "/../db/database.php";
require_once __DIR__ . "/../models/voucher.php";
require_once __DIR__ . "/../helpers/views.php";
require_once __DIR__ . "/../helpers/random_string.php";

class VouchersController {

    private $voucher;

    function __construct() {

        $db = new Database();

        $this->voucher = new Voucher($db);
    }

    function index() {

        $response = (array_key_exists("recipientInfo", $_GET) && $_GET["recipientInfo"] === "true")
            ? $this->voucher->allWithRecipient()
            : $this->voucher->all();

        print json_encode($response);
    }

    function create() {

        $this->voucher->create([
            "recipient_id" => $_POST["recipient-id"],
            "special_offer_id" => $_POST["special-offer-id"],
            "code" => $_POST["code"],
            "expiration_date" => $_POST["expiration-date"]
        ]);

        $id = $this->voucher->getId();

        $result = ($id > 0)
            ? ["id" => $id]
            : ["error" => $this->voucher->getErrors()];

        print json_encode($result);
    }

    function new_form() {
        print "Voucher new_form";
    }

    function show() {
        require_once __DIR__ . "/../views/vouchers/show.php";
    }

    function update() {

        parse_str(file_get_contents("php://input"), $_PATCH);

        $errors = [];
        $updQtt = 0;

        foreach (explode(",", $_PATCH["ids"]) as $id) {

            $this->voucher->find("", (int) $id);

            $success = $this->voucher->update([
                "used_at" => $_PATCH["used-at"]
            ]);

            if ($success) {
                $updQtt++;
            } else {
                $errors = array_merge($errors, $this->voucher->getErrors());
            }
        }

        $response = ["updated_qtt" => $updQtt];

        if (count($errors) !== 0) {
            $response["error"] = $errors;
        }

        print json_encode($response);
    }

    function delete() {
        print "Voucher delete";
    }

    function genCode() {

        do {
            $code = random_str(8);
        } while ($this->voucher->find($code));

        print json_encode(["code" => $code]);
    }

    function report() {
        print json_encode($this->voucher->report());
    }
}
