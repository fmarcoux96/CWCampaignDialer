<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class HoursOptions extends Settings
{
    private static array $days = [
        'monday',
        'tuesday',
        'wednesday',
        'thursday',
        'friday',
        'saturday',
        'sunday',
    ];

    public string $timezone;

    public array $monday;

    public array $tuesday;

    public array $wednesday;

    public array $thursday;

    public array $friday;

    public array $saturday;

    public array $sunday;

    public function inHours(?string $day = null)
    {
        $day = $day ?? strtolower(now($this->timezone)->format('l'));

        $hours = $this->$day;

        if ($hours['state'] === 'closed') {
            return false;
        }

        $start = $hours['start'];
        $end = $hours['end'];

        $now = now($this->timezone);

        return $now->isBetween(
            $now->copy()->setTimeFromTimeString($start),
            $now->copy()->setTimeFromTimeString($end)
        );
    }

    public function nextRunTime()
    {
        $now = now($this->timezone);

        $day = strtolower($now->format('l'));

        $hours = $this->$day;

        if ($hours['state'] === 'closed') {
            return $now->copy()->setTimeFromTimeString($hours['start']);
        }

        $start = $hours['start'];
        $end = $hours['end'];

        if ($now->isBetween(
            $now->copy()->setTimeFromTimeString($start),
            $now->copy()->setTimeFromTimeString($end)
        )) {
            return $now->copy()->setTimeFromTimeString($end);
        }

        return $now->copy()->setTimeFromTimeString($start);
    }

    public function getHoursForDay(?string $day = null)
    {
        $day = $day ?? strtolower(now($this->timezone)->format('l'));

        $hours = $this->$day;

        if ($hours['state'] === 'closed') {
            return [];
        }

        return [$hours['start'], $hours['end']];
    }

    public static function getTimezones()
    {
        $timezones = [];

        foreach (timezone_identifiers_list() as $timezone) {
            $timezones[$timezone] = str_replace('_', ' ', $timezone);
        }

        return $timezones;
    }

    public static function getDays()
    {
        return self::$days;
    }

    public static function getLabels()
    {
        return collect(self::$days)
            ->map(fn ($day) => __(ucfirst($day)))
            ->toArray();
    }

    public static function getHours()
    {
        // Return every hour from 00:00 to 23:45 in 15 minute intervals.
        return collect(range(0, 23))
            ->map(fn ($hour) => str_pad($hour, 2, '0', STR_PAD_LEFT))
            ->flatMap(fn ($hour) => [
                "{$hour}:00" => "{$hour}:00",
                "{$hour}:15" => "{$hour}:15",
                "{$hour}:30" => "{$hour}:30",
                "{$hour}:45" => "{$hour}:45",
            ])
            ->toArray();
    }

    public static function group(): string
    {
        return 'hours';
    }
}
