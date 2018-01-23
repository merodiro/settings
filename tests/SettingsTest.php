<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

class SettingsTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateSettings()
    {
        Settings::set('name', 'test value');

        $this->assertDatabaseHas('settings', [
            'key' => 'name',
            'value' => 'test value'
        ]);
    }

    public function testGetSettings()
    {
        Settings::set('name', 'test value');

        $this->assertEquals('test value', Settings::get('name'));
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
    
    public function testCacheOnGet()
    {
        Settings::set('name', 'test value');
        
        Cache::shouldReceive('remember')
            ->once()
            ->andReturn('test value');
        
        Settings::get('name');
    }

    public function testForgetSettings()
    {
        Settings::set('name', 'test value');
        Cache::shouldReceive('forget')
            ->once()
            ->with('settings_name');

        Settings::forget('name');

        $this->assertDatabaseMissing('settings', [
            'key' => 'name',
            'value' => 'test value'
        ]);
    }

    public function testForgetSettingsOnUpdate()
    {
        Settings::set('name', 'test value');
        Cache::shouldReceive('forget')
            ->once()
            ->with('settings_name');

        Settings::set('name', 'another value');
    }
}
