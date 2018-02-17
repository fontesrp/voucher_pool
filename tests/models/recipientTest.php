<?php

declare(strict_types=1);

require_once __DIR__ . "/../../config/session.php";
require_once __DIR__ . "/../../db/database.php";
require __DIR__ . "/../../db/seed.php";

use PHPUnit\Framework\TestCase;

final class RecipientTest extends TestCase {

    public function testCanBeInitializedWithOnlyDb() {

        $db = new Database();

        $recipient = new Recipient($db);

        $this->assertInstanceOf(Recipient::class, $recipient);

        return $recipient;
    }

    public function testCanBeInitilizedWithDbAndEmail() {

        $db = new Database();

        $recipient = new Recipient($db, "jon.snow@winterfell.gov");

        $this->assertInstanceOf(Recipient::class, $recipient);

        return $recipient;
    }

    /**
     * @depends testCanBeInitilizedWithDbAndEmail
     */
    public function testInicializationWithEmailGetsTheRightPerson ($recipient) {

        $actual = [
            "name" => $recipient->getName(),
            "email" => $recipient->getEmail()
        ];

        $expected = [
            "name" => "Jon Snow",
            "email" => "jon.snow@winterfell.gov"
        ];

        $this->assertGreaterThan(0, $recipient->getId());
        $this->assertArraySubset($expected, $actual);
    }

    /**
     * @depends testCanBeInitializedWithOnlyDb
     */
    public function testCanFindEmail($recipient) {

        $recipient->find("jon.snow@winterfell.gov");

        $actual = [
            "name" => $recipient->getName(),
            "email" => $recipient->getEmail()
        ];

        $expected = [
            "name" => "Jon Snow",
            "email" => "jon.snow@winterfell.gov"
        ];

        $this->assertGreaterThan(0, $recipient->getId());
        $this->assertArraySubset($expected, $actual);

        return $recipient;
    }

    /**
     * @depends testCanBeInitializedWithOnlyDb
     */
    public function testCanCreate($recipient) {

        $recipient->create([
            "name" => "Daenerys Targaryen",
            "email" => "danny.targaryen@dragonstone.gov"
        ]);

        $this->assertGreaterThan(0, $recipient->getId());
        $this->assertEmpty($recipient->getErrors());

        return $recipient;
    }

    /**
     * @depends testCanCreate
     */
    public function testCanDelete($recipient) {

        $this->assertTrue($recipient->delete());
        $this->assertEmpty($recipient->getErrors());
    }

    /**
     * @depends testCanFindEmail
     */
    public function testCanSearchByEmail($recipient) {

        $expected = [
            "id" => $recipient->getId(),
            "email" => $recipient->getEmail()
        ];

        $actual = $recipient->searchByEmail("snow");

        $this->assertArraySubset($expected, $actual);
    }

    /**
     * @depends testCanBeInitializedWithOnlyDb
     */
    public function testCanSelectAll($recipient) {
        $this->assertNotEmpty($recipient->all());
        return $recipient;
    }

    /**
     * @depends testCanSelectAll
     */
    public function textCanDestroyAll($recipient) {

        $this->assertTrue($recipient->destroyAll());

        $this->assertEmpty($recipient->all());
    }
}
