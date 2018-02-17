<?php

/**
 * /db/seed.php
 *
 * Script for filling the database with random data for testing.
 *
 */

require_once __DIR__ . "/../config/session.php";
require_once __DIR__ . "/database.php";
require_once __DIR__ . "/../models/recipient.php";
require_once __DIR__ . "/../models/special_offer.php";
require_once __DIR__ . "/../models/voucher.php";
require_once __DIR__ . "/../vendor/php/fzaninotto/faker/src/autoload.php";

$faker = Faker\Factory::create();

$db = new Database();

$voucher = new Voucher($db);
$recipient = new Recipient($db);
$special_offer = new SpecialOffer($db);

$voucher->destroyAll();
$recipient->destroyAll();
$special_offer->destroyAll();

// Create root recipient
$root_rec = [
    "recipient_name" => "Jon Snow",
    "email" => "jon.snow@winterfell.gov"
];

$root_rec["id"] = $recipient->create($root_rec);

print "Created root recipient\n" . print_r($root_rec, true) . "\n";

// Create 15 recipients
$created_recs = [$root_rec];

for ($i = 0; $i < 15; $i++) {

    $first_name = $faker->firstName;
    $last_name = $faker->lastName;

    $rec = [
        "recipient_name" => $first_name . " " . $last_name,
        "email" => strtolower($first_name . "." . $last_name . "@example.com")
    ];

    $rec["id"] = $recipient->create($rec);

    if ($rec["id"] > 0) {
        $created_recs[] = $rec;
    }
}

$created_recs_qtt = count($created_recs);

print "Created " . $created_recs_qtt . " random recipients\n\n";

// Create root special offer
$root_offer = [
    "name" => "Winter Clearance",
    "discount" => 0.25
];

$root_offer["id"] = $special_offer->create($root_offer);

print "Created root special offer\n" . print_r($root_offer, true) . "\n";

// Create 20 special offers
$created_offers = [$root_offer];

for ($i = 0; $i < 20; $i++) {

    $so = [
        "name" => $faker->unique()->colorName,
        "discount" => random_int(1, 99) / 100
    ];

    $so["id"] = $special_offer->create($so);

    if ($so["id"] > 0) {
        $created_offers[] = $so;
    }
}

$created_offers_qtt = count($created_offers);

print "Created " . $created_offers_qtt . " random special offers\n\n";

// Create root voucher
$dt = new DateTime('+5 days');

$root_voucher = [
    "recipient_id" => $root_rec["id"],
    "special_offer_id" => $root_offer["id"],
    "code" => "CcyklA5I",
    "expiration_date" => $dt->format('Y-m-d'),
    "used_at" => null
];

$root_voucher["id"] = $voucher->create($root_voucher);

print "Created root voucher\n" . print_r($root_voucher, true) . "\n";

// Create at least 50 vouchers
$created_vou_qtt = 1;

for ($i = 0; $i < 50; $i++) {

    $vou = [
        "recipient_id" => $created_recs[random_int(0, $created_recs_qtt - 1)]["id"],
        "special_offer_id" => $created_offers[random_int(0, $created_offers_qtt - 1)]["id"]
    ];

    $qtt = random_int(0, 5);

    for ($j = 0; $j < $qtt; $j++) {

        $vou["code"] = $voucher->uniqueCode();
        $vou["expiration_date"] = $faker->dateTimeBetween("now", "+1 year")->format("Y-m-d");

        if (random_int(0, 10) > 5) {
            $vou["used_at"] = $faker->date();
        }

        $id = $voucher->create($vou);

        if ($id > 0) {
            $created_vou_qtt++;
        }
    }
}

print "Created " . $created_vou_qtt . " random vouchers\n\n";
