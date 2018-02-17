<?php

declare(strict_types=1);

require_once __DIR__ . "/../../config/session.php";
require_once __DIR__ . "/../../db/database.php";
require __DIR__ . "/../../db/seed.php";

use PHPUnit\Framework\TestCase;

final class VoucherTest extends TestCase {

    public function testCanBeInitializedWithOnlyDb() {

        $db = new Database();

        $voucher = new Voucher($db);

        $this->assertInstanceOf(Voucher::class, $voucher);

        return $voucher;
    }

    public function testCanBeInitilizedWithDbAndCode() {

        $db = new Database();

        $voucher = new Voucher($db, "CcyklA5I");

        $this->assertInstanceOf(Voucher::class, $voucher);

        return $voucher;
    }

    /**
     * @depends testCanBeInitilizedWithDbAndCode
     */
    public function testInicializationWithCodeGetsTheRightPerson ($voucher) {

        $this->assertGreaterThan(0, $voucher->getId());
        $this->assertEquals("CcyklA5I", $voucher->getCode());
    }

    /**
     * @depends testCanBeInitializedWithOnlyDb
     */
    public function testCanFindCode($voucher) {

        $voucher->find("CcyklA5I");

        $this->assertGreaterThan(0, $voucher->getId());
        $this->assertEquals("CcyklA5I", $voucher->getCode());

        return $voucher;
    }

    /**
     * @depends testCanFindCode
     */
    public function testCanDelete($voucher) {

        $this->assertTrue($voucher->delete());
        $this->assertEmpty($voucher->getErrors());
    }

    /**
     * @depends testCanBeInitializedWithOnlyDb
     */
    public function testCanSelectAll($voucher) {
        $this->assertNotEmpty($voucher->all());
    }

    /**
     * @depends testCanBeInitializedWithOnlyDb
     */
    public function textCanDestroyAll($voucher) {

        $this->assertTrue($voucher->destroyAll());

        $this->assertEmpty($voucher->all());
    }
}
