<?php
declare(strict_types = 1);

namespace AntiMattr\Tests\MongoDB\Migrations\Configuration;

use AntiMattr\TestCase\AntiMattrTestCase;

/**
 * @codeCoverageIgnore
 */
abstract class AbstractConfigurationTest extends AntiMattrTestCase
{
    public function getConnection()
    {
        return $this->buildMock('Doctrine\MongoDB\Connection');
    }

    /**
     * @var AntiMattr\MongoDB\Migrations\Configuration\Configuration
     */
    abstract public function loadConfiguration();

    public function testMigrationsDirectory()
    {
        $config = $this->loadConfiguration();
        $path = realpath(__DIR__ . '/../Resources/fixtures');
        $this->assertEquals($path, $config->getMigrationsDirectory());
    }

    public function testMigrationsNamespace()
    {
        $config = $this->loadConfiguration();
        $this->assertEquals('AntiMattrMigrationsTest', $config->getMigrationsNamespace());
    }

    public function testMigrationName()
    {
        $config = $this->loadConfiguration();
        $this->assertEquals('AntiMattr Sandbox Migrations', $config->getName());
    }

    public function testMigrationsCollection()
    {
        $config = $this->loadConfiguration();
        $this->assertEquals('antimattr_migration_versions_test', $config->getMigrationsCollectionName());
    }

    public function testMigrationsDatabaseName()
    {
        $config = $this->loadConfiguration();
        $this->assertEquals('test_antimattr_migrations', $config->getMigrationsDatabaseName());
    }

    public function testMigrationsScriptDirectory()
    {
        $config = $this->loadConfiguration();
        $path = realpath(__DIR__ . '/../Resources/fixtures');
        $this->assertEquals($path, $config->getMigrationsScriptDirectory());
    }
}
