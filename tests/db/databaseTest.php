<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

define("SESSION", "/var/www/html/voucher_pool/config/session.php");

final class DatabaseTest extends TestCase {

    public function testCannotBeCreatedWithoutSession() {

        $this->expectException(Exception::class);

        $db = new Database();
    }

    public function testCanBeCreatedWithSession() {

        require_once SESSION;

        $db = new Database();

        $this->assertInstanceOf(Database::class, $db);

        return $db;
    }

    /**
     * @depends testCanBeCreatedWithSession
     */
    public function testCanSelectHarcodedValues(Database $db) {

        $db->reset();
        $db->setSql("SELECT 123 AS num, 'abc' AS str");
        $db->query();

        $row = $db->getRow();

        $this->assertNotNull($row);
        $this->assertArraySubset(["num" => 123, "str" => "abc"], $row);

        return $db;
    }

    /**
     * @depends testCanBeCreatedWithSession
     */
    public function testCanSelectFromDual(Database $db) {

        $db->reset();
        $db->setSql("SELECT 123 AS num, 'abc' AS str FROM DUAL");
        $db->query();

        $row = $db->getRow();

        $this->assertNotNull($row);
        $this->assertArraySubset(["num" => 123, "str" => "abc"], $row);

        return $db;
    }

    /**
     * @depends testCanBeCreatedWithSession
     */
    public function testCanRunPreparedInsert(Database $db) {

        $db->reset();
        $db->setSql("INSERT INTO special_offers (name, discount) VALUES (?, ?)");
        $db->setParams([
            ["type" => "s", "value" => "Random Dude From Starwars"],
            ["type" => "d", "value" => 12.345]
        ]);

        $this->assertTrue($db->query());

        return $db;
    }

    /**
     * @depends testCanRunPreparedInsert
     */
    public function testCanRunPreparedSelect(Database $db) {

        $db->reset();
        $db->setSql("SELECT name, discount FROM special_offers WHERE name = ? AND discount > ?");
        $db->setParams([
            ["type" => "s", "value" => "Random Dude From Starwars"],
            ["type" => "d", "value" => 12]
        ]);
        $db->query();

        $row = $db->getRow();

        $this->assertNotNull($row);
        $this->assertArraySubset(["name" => "Random Dude From Starwars", "discount" => 12.345], $row);

        return $db;
    }

    /**
     * @depends testCanRunPreparedSelect
     */
    public function testCanRunPreparedUpdate(Database $db) {

        $db->reset();
        $db->setSql("UPDATE special_offers SET name = ?, discount = ? WHERE name = ? AND discount > ?");
        $db->setParams([
            ["type" => "s", "value" => "Another Random Dude"],
            ["type" => "d", "value" => 543.21],
            ["type" => "s", "value" => "Random Dude From Starwars"],
            ["type" => "d", "value" => 12]
        ]);

        $this->assertTrue($db->query());

        return $db;
    }

    /**
     * @depends testCanRunPreparedUpdate
     */
    public function testPreparedUpdateWorked(Database $db) {

        $db->reset();
        $db->setSql("SELECT name, discount FROM special_offers WHERE name = ? AND discount > ?");
        $db->setParams([
            ["type" => "s", "value" => "Another Random Dude"],
            ["type" => "d", "value" => 543]
        ]);
        $db->query();

        $row = $db->getRow();

        $this->assertNotNull($row);
        $this->assertArraySubset(["name" => "Another Random Dude", "discount" => 543.21], $row);

        return $db;
    }

    /**
     * @depends testPreparedUpdateWorked
     */
    public function testCanRunPreparedDelete(Database $db) {

        $db->reset();
        $db->setSql("DELETE FROM special_offers WHERE name = ? AND discount > ?");
        $db->setParams([
            ["type" => "s", "value" => "Another Random Dude"],
            ["type" => "d", "value" => 543]
        ]);

        $this->assertTrue($db->query());

        return $db;
    }

    /**
     * @depends testCanRunPreparedDelete
     */
    public function testPreparedDeleteWorked(Database $db) {

        $db->reset();
        $db->setSql("SELECT name, discount FROM special_offers WHERE name = ? AND discount > ?");
        $db->setParams([
            ["type" => "s", "value" => "Another Random Dude"],
            ["type" => "d", "value" => 543]
        ]);
        $db->query();

        $row = $db->getRow();

        $this->assertNull($row);

        return $db;
    }

    /**
     * @depends testCanBeCreatedWithSession
     */
    public function testCanInsert(Database $db) {

        $db->reset();
        $db->setSql("INSERT INTO special_offers (name, discount) VALUES ('Random Dude From Starwars 2', 12.345)");

        $this->assertTrue($db->query());

        return $db;
    }

    /**
     * @depends testCanInsert
     */
    public function testCanSelect(Database $db) {

        $db->reset();
        $db->setSql("SELECT name, discount FROM special_offers WHERE name = 'Random Dude From Starwars 2' AND discount > 12");
        $db->query();

        $row = $db->getRow();

        $this->assertNotNull($row);
        $this->assertArraySubset(["name" => "Random Dude From Starwars 2", "discount" => 12.345], $row);

        return $db;
    }

    /**
     * @depends testCanSelect
     */
    public function testCanUpdate(Database $db) {

        $db->reset();
        $db->setSql("UPDATE special_offers SET name = 'Another Random Dude 2', discount = 543.21 WHERE name = 'Random Dude From Starwars 2' AND discount > 12");

        $this->assertTrue($db->query());

        return $db;
    }

    /**
     * @depends testCanUpdate
     */
    public function testUpdateWorked(Database $db) {

        $db->reset();
        $db->setSql("SELECT name, discount FROM special_offers WHERE name = 'Another Random Dude 2' AND discount > 543");
        $db->query();

        $row = $db->getRow();

        $this->assertNotNull($row);
        $this->assertArraySubset(["name" => "Another Random Dude 2", "discount" => 543.21], $row);

        return $db;
    }

    /**
     * @depends testUpdateWorked
     */
    public function testCanDelete(Database $db) {

        $db->reset();
        $db->setSql("DELETE FROM special_offers WHERE name = 'Another Random Dude 2' AND discount > 543");

        $this->assertTrue($db->query());

        return $db;
    }

    /**
     * @depends testCanDelete
     */
    public function testDeleteWorked(Database $db) {

        $db->reset();
        $db->setSql("SELECT name, discount FROM special_offers WHERE name = 'Another Random Dude 2' AND discount > 543");
        $db->query();

        $row = $db->getRow();

        $this->assertNull($row);
    }
}
