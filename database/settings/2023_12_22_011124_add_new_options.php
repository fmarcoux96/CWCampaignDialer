<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('dialer.attempt_delay', 60);

        $this->migrator->add('tcx.dialer_extension', '');
        $this->migrator->add('tcx.dialing_prefix', '');
        $this->migrator->add('tcx.dialing_timeout', 30);

        $this->migrator->add('hours.timezone', 'UTC');
        $this->migrator->add('hours.monday', [
            'state' => 'open',
            'start' => '09:00',
            'end' => '17:00',
        ]);
        $this->migrator->add('hours.tuesday', [
            'state' => 'open',
            'start' => '09:00',
            'end' => '17:00',
        ]);
        $this->migrator->add('hours.wednesday', [
            'state' => 'open',
            'start' => '09:00',
            'end' => '17:00',
        ]);
        $this->migrator->add('hours.thursday', [
            'state' => 'open',
            'start' => '09:00',
            'end' => '17:00',
        ]);
        $this->migrator->add('hours.friday', [
            'state' => 'open',
            'start' => '09:00',
            'end' => '17:00',
        ]);
        $this->migrator->add('hours.saturday', [
            'state' => 'closed',
            'start' => '09:00',
            'end' => '17:00',
        ]);
        $this->migrator->add('hours.sunday', [
            'state' => 'closed',
            'start' => '09:00',
            'end' => '17:00',
        ]);
    }
};
