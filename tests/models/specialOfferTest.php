<?php

declare(strict_types=1);

require_once __DIR__ . "/../../config/session.php";
require_once __DIR__ . "/../../db/database.php";
require __DIR__ . "/../../db/seed.php";

use PHPUnit\Framework\TestCase;

final class SpecialOfferTest extends TestCase {

    public function testCanBeInitializedWithOnlyDb() {

        $db = new Database();

        $special_offer = new SpecialOffer($db);

        $this->assertInstanceOf(SpecialOffer::class, $special_offer);

        return $special_offer;
    }

    public function testCanBeInitilizedWithDbAndName() {

        $db = new Database();

        $special_offer = new SpecialOffer($db, "Winter Clearance");

        $this->assertInstanceOf(SpecialOffer::class, $special_offer);

        return $special_offer;
    }

    /**
     * @depends testCanBeInitilizedWithDbAndName
     */
    public function testInicializationWithNameGetsTheRightPerson ($special_offer) {

        $actual = [
            "name" => $special_offer->getName(),
            "discount" => $special_offer->getDiscount()
        ];

        $expected = [
            "name" => "Winter Clearance",
            "discount" => 0.25
        ];

        $this->assertGreaterThan(0, $special_offer->getId());
        $this->assertArraySubset($expected, $actual);
    }

    /**
     * @depends testCanBeInitializedWithOnlyDb
     */
    public function testCanFindName($special_offer) {

        $special_offer->find("Winter Clearance");

        $actual = [
            "name" => $special_offer->getName(),
            "discount" => $special_offer->getDiscount()
        ];

        $expected = [
            "name" => "Winter Clearance",
            "discount" => 0.25
        ];

        $this->assertGreaterThan(0, $special_offer->getId());
        $this->assertArraySubset($expected, $actual);

        return $special_offer;
    }

    /**
     * @depends testCanBeInitializedWithOnlyDb
     */
    public function testCanCreate($special_offer) {

        $special_offer->create([
            "name" => "Summer Clearance",
            "discount" => 0.5
        ]);

        $this->assertGreaterThan(0, $special_offer->getId());
        $this->assertEmpty($special_offer->getErrors());

        return $special_offer;
    }

    /**
     * @depends testCanCreate
     */
    public function testCanDelete($special_offer) {

        $this->assertTrue($special_offer->delete());
        $this->assertEmpty($special_offer->getErrors());
    }

    /**
     * @depends testCanFindName
     */
    public function testCanSearchByName($special_offer) {

        $expected = [
            "id" => $special_offer->getId(),
            "name" => $special_offer->getName(),
            "discount" => $special_offer->getDiscount()
        ];

        $actual = $special_offer->searchByName("Summer");

        $this->assertArraySubset($expected, $actual);
    }

    /**
     * @depends testCanBeInitializedWithOnlyDb
     */
    public function testCanSelectAll($special_offer) {
        $this->assertNotEmpty($special_offer->all());
    }

    /**
     * @depends testCanBeInitializedWithOnlyDb
     */
    public function textCanDestroyAll($special_offer) {

        $this->assertTrue($special_offer->destroyAll());

        $this->assertEmpty($special_offer->all());
    }
}
