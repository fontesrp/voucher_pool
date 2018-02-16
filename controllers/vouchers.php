<?php

require_once __DIR__ . "/../config/session.php";
require_once __DIR__ . "/../db/database.php";
require_once __DIR__ . "/../models/voucher.php";
require_once __DIR__ . "/../helpers/views.php";
require_once __DIR__ . "/../helpers/random_string.php";
require_once __DIR__ . "/../helpers/voucher_gen.php";

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
        $upd_qtt = 0;

        foreach (explode(",", $_PATCH["ids"]) as $id) {

            $this->voucher->find("", (int) $id);

            $success = $this->voucher->update([
                "used_at" => $_PATCH["used-at"]
            ]);

            if ($success) {
                $upd_qtt++;
            } else {
                $errors = array_merge($errors, $this->voucher->getErrors());
            }
        }

        $response = ["updated_qtt" => $upd_qtt];

        if (count($errors) !== 0) {
            $response["error"] = $errors;
        }

        print json_encode($response);
    }

    function delete() {
        print "Voucher delete";
    }

    private function uniqueCode() {

        do {
            $code = random_str(8);
        } while ($this->voucher->find($code));

        return $code;
    }

    function genCode() {
        print json_encode(["code" => $this->uniqueCode()]);
    }

    function report() {
        print json_encode($this->voucher->report());
    }

    function generate() {

        if (!gen_validate()) {

            $response = ["error" => "invalid request"];

            print json_encode($response);

            return;
        }

        $all_recipients = gen_list_recipients();
        $so_id = gen_get_special_offer_id();

        if (!($so_id > 0)) {

            $response = ["error" => "invalid special offer"];

            print json_encode($response);

            return;
        }

        $errors = [];
        $created_qtt = 0;

        foreach ($all_recipients as $rec) {

            $id = $this->voucher->create([
                "recipient_id" => $rec["id"],
                "special_offer_id" => $so_id,
                "code" => $this->uniqueCode(),
                "expiration_date" => $_POST["expiration-date"]
            ]);

            if ($id > 0) {
                $created_qtt++;
            } else {
                $errors = array_merge($errors, $this->voucher->getErrors());
            }
        }

        $response = ["created_qtt" => $created_qtt];

        if (count($errors) !== 0) {
            $response["error"] = $errors;
        }

        print json_encode($response);
    }

    function validate() {

        parse_str(file_get_contents("php://input"), $_PATCH);

        if (!array_key_exists("code", $_PATCH) || !array_key_exists("email", $_PATCH)) {

            $response = ["error" => "invalid request"];

            print json_encode($_PATCH);

            return;
        }

        $result = $this->voucher->findByCodeAndEmail($_PATCH["code"], $_PATCH["email"]);

        if ($result === null) {
            $response = ["error" => "invalid voucher"];
        } else {

            $response = ["discount" => $result["discount"]];

            $this->voucher->find("", (int) $result["id"]);
            $this->voucher->update([
                "used_at" => gmdate("Y-m-d H:i:s")
            ]);
        }

        print json_encode($response);
    }

    function searchByEmail() {

        if (!array_key_exists("email", $_GET)) {

            $response = ["error" => "invalid request"];

            print json_encode($response);

            return;
        }

        print json_encode($this->voucher->searchByEmail($_GET["email"]));
    }
}
