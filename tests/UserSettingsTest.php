<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

class UserSettingsTest extends TestCase
{
    use RefreshDatabase;

    public function testSetSettings()
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

    public function testCacheOnSet()
    {
        $user = factory(User::class)->create();


        Cache::shouldReceive('put')
        ->once()
        ->andReturn('test value');

        $user->setSettings('name', 'test value');
    }

    public function testForgetSettings()
    {
        $user = factory(User::class)->create();

        $user->setSettings('name', 'test value');

        Cache::shouldReceive('forget')
            ->once()
            ->with($user->settingsCacheKey('name'));

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

        Cache::shouldReceive('put')
        ->once()
        ->with($user->settingsCacheKey('name'), 'another value', 60);

        $user->setSettings('name', 'another value');
    }

    public function testSettingsCacheCommand()
    {
        $user = factory(User::class)->create();

        $user->setSettings('name', 'value');
        $user->setSettings('another name', 'another value');
        $user->setSettings('one more name', 'one more value');

        Cache::shouldReceive('put')
            ->times(3)
            ->with(Mockery::type('string'), Mockery::type('string'), 60);

        $this->artisan('settings:cache', ['--model' => User::class]);
    }

    public function testSettingsClearCommand()
    {
        $user = factory(User::class)->create();

        $user->setSettings('name', 'value');
        $user->setSettings('another name', 'another value');
        $user->setSettings('one more name', 'one more value');

        Cache::shouldReceive('forget')
        ->times(3)
        ->with(Mockery::type('string'));

        $this->artisan('settings:clear', ['--model' => User::class]);
    }
}
