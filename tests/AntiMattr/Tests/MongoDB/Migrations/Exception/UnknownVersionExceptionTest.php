<?php
declare(strict_types = 1);

namespace AntiMattr\Tests\MongoDB\Migrations\Exception;

use AntiMattr\TestCase\AntiMattrTestCase;

class UnknownVersionExceptionTest extends AntiMattrTestCase
{
    private $exception;

    protected function setUp()
    {
        $this->exception = $this->buildMock('AntiMattr\MongoDB\Migrations\Exception\UnknownVersionException');
    }

    public function testConstructor()
    {
        $this->assertInstanceOf('\AntiMattr\MongoDB\Migrations\Exception\AbstractMigrationsException', $this->exception);
    }
}
