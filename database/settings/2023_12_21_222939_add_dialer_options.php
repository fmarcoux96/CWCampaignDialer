<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('dialer.dialer_enabled', true);
        $this->migrator->add('dialer.dialer_last_run', null);
        $this->migrator->add('dialer.default_campaign_destination', '');
        $this->migrator->add('dialer.max_call_attempts', 3);
    }
};
