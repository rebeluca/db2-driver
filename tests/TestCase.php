<?php

namespace rebeluca\DB2Driver\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;
use rebeluca\DB2Driver\DB2DriverServiceProvider;

class TestCase extends Orchestra
{

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');
        /*
        $migration = include __DIR__.'/../database/migrations/create_db2-driver_table.php.stub';
        $migration->up();
        */
    }

    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn(string $modelName) => 'rebeluca\\DB2Driver\\Database\\Factories\\' . class_basename($modelName) . 'Factory',
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            DB2DriverServiceProvider::class,
        ];
    }

}
