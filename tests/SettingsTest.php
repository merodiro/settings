<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

class SettingsTest extends TestCase
{
    use RefreshDatabase;

    public function testSetSettings()
    {
        Settings::set('name', 'test value');

        $this->assertDatabaseHas('settings', [
            'key' => 'name',
            'value' => 'test value',
            'owner_id' => null
        ]);
    }

    public function testGetSettings()
    {
        Settings::set('name', 'test value');

        $this->assertEquals('test value', Settings::get('name'));
    }

    public function testSettingsAll()
    {
        Settings::set('name', 'value');
        Settings::set('another name', 'another value');
        Settings::set('one more name', 'one more value');

        $this->assertCount(3, Settings::all());
    }

    public function testSettingsFlush()
    {
        Settings::set('name', 'value');
        Settings::set('another name', 'another value');
        Settings::set('one more name', 'one more value');

        Cache::shouldReceive('forget')
            ->times(3)
            ->with(Mockery::type('string'));

        Settings::flush();

        $this->assertCount(0, Settings::all());
        $this->assertDatabaseMissing('settings', [
            'key' => 'name',
            'value' => 'test value'
        ]);
    }

    public function testGetDefaultSettings()
    {
        $this->assertEquals('test value', Settings::get('name', 'test value'));
    }

    public function testUpdateSettings()
    {
        Settings::set('name', 'test value');
        Settings::set('name', 'another value');

        $this->assertEquals('another value', Settings::get('name'));
    }

    public function testCacheOnSet()
    {
        Cache::shouldReceive('put')
        ->once()
        ->andReturn('test value');

        Settings::set('name', 'test value');
    }

    public function testForgetSettings()
    {
        Settings::set('name', 'test value');

        Cache::shouldReceive('forget')
            ->once()
            ->with('settings_name_global');

        Settings::forget('name');

        $this->assertDatabaseMissing('settings', [
            'key' => 'name',
            'value' => 'test value'
        ]);
    }

    public function testForgetSettingsOnUpdate()
    {
        Settings::set('name', 'test value');

        Cache::shouldReceive('put')
            ->once()
            ->with('settings_name_global', 'another value', 60);

        Settings::set('name', 'another value');
    }

    public function testSettingsCacheCommand()
    {
        Settings::set('name', 'value');
        Settings::set('another name', 'another value');
        Settings::set('one more name', 'one more value');

        Cache::shouldReceive('put')
            ->times(3)
            ->with(Mockery::type('string'), Mockery::type('string'), 60);

        $this->artisan('settings:cache');
    }

    public function testSettingsClearCommand()
    {
        Settings::set('name', 'value');
        Settings::set('another name', 'another value');
        Settings::set('one more name', 'one more value');

        Cache::shouldReceive('forget')
            ->times(3)
            ->with(Mockery::type('string'));

        $this->artisan('settings:clear');
    }
}
