<?php
declare(strict_types = 1);

namespace AntiMattr\Tests\MongoDB\Migrations\Exception;

use AntiMattr\TestCase\AntiMattrTestCase;

class AbortExceptionTest extends AntiMattrTestCase
{
    private $exception;

    protected function setUp()
    {
        $this->exception = $this->buildMock('AntiMattr\MongoDB\Migrations\Exception\AbortException');
    }

    public function testConstructor()
    {
        $this->assertInstanceOf('\AntiMattr\MongoDB\Migrations\Exception\AbstractMigrationsException', $this->exception);
    }
}
