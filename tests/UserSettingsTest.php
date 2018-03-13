<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

class UserSettingsTest extends TestCase
{
    use RefreshDatabase;

    function testSetSettings()
    {
        $user = factory(User::class)->create();

        $user->setSettings('name', 'test value');

        $this->assertDatabaseHas('settings', [
            'key' => 'name',
            'value' => 'test value',
            'owner_id' => $user->id
        ]);
    }

    public function testGetSettings()
    {
        $user = factory(User::class)->create();

        $user->setSettings('name', 'test value');

        $this->assertEquals('test value', $user->getSettings('name'));
    }

    public function testSettingsAll()
    {
        $user = factory(User::class)->create();

        $user->setSettings('name', 'test value');
        $user->setSettings('another name', 'another value');
        $user->setSettings('one more name', 'one more value');


        $this->assertCount(3, $user->allSettings());
    }

    public function testSettingsFlush()
    {
        $user = factory(User::class)->create();

        $user->setSettings('name', 'test value');
        $user->setSettings('another name', 'another value');
        $user->setSettings('one more name', 'one more value');

        Cache::shouldReceive('forget')
            ->times(3)
            ->with(Mockery::type('string'));

        $user->flushSettings();

        $this->assertCount(0, $user->allSettings());
        $this->assertDatabaseMissing('settings', [
            'key' => 'name',
            'value' => 'test value',
            'owner_id' => $user->id
        ]);
    }

    public function testGetDefaultSettings()
    {
        $user = factory(User::class)->create();

        $this->assertEquals('test value', $user->getSettings('name', 'test value'));
    }

    public function testUpdateSettings()
    {
        $user = factory(User::class)->create();

        $user->setSettings('name', 'test value');
        $user->setSettings('name', 'another value');

        $this->assertEquals('another value', $user->getSettings('name'));
    }

    public function testCacheOnGet()
    {
        $user = factory(User::class)->create();

        $user->setSettings('name', 'test value');

        Cache::shouldReceive('remember')
            ->once()
            ->andReturn('test value');

        $user->getSettings('name');
    }

    public function testForgetSettings()
    {
        $user = factory(User::class)->create();

        $user->setSettings('name', 'test value');

        Cache::shouldReceive('forget')
            ->once()
            ->with('settings_name_' . $user->id);

        $user->forgetSettings('name');

        $this->assertDatabaseMissing('settings', [
            'key' => 'name',
            'value' => 'test value',
            'owner_id' => $user->id
        ]);
    }

    public function testForgetSettingsOnUpdate()
    {
        $user = factory(User::class)->create();

        $user->setSettings('name', 'test value');

        Cache::shouldReceive('forget')
            ->once()
            ->with('settings_name_' . $user->id);

        $user->setSettings('name', 'another value');
    }
}
