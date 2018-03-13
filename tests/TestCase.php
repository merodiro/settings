<?php

use Merodiro\Settings\SettingsServiceProvider;
use GrahamCampbell\TestBench\AbstractPackageTestCase;
use Merodiro\Settings\Facades\Settings;

abstract class TestCase extends AbstractPackageTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            SettingsServiceProvider::class
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Settings' => Settings::class
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);

        $app['config']->set('settings.cache_duration', 60);
        $app['config']->set('settings.cache_prefix', 'settings_');
    }

    protected function setUp()
    {
        parent::setUp();

        $this->loadLaravelMigrations();
        $this->withFactories(__DIR__.'/database/factories');
    }
}
