<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlatformSetting extends Model
{
    protected $fillable = [
        'key',
        'value',
    ];

    public static function getInt(string $key, int $default): int
    {
        $value = static::query()->where('key', $key)->value('value');

        if ($value === null || ! is_numeric($value)) {
            return $default;
        }

        return max(0, (int) $value);
    }

    public static function setInt(string $key, int $value): void
    {
        static::query()->updateOrCreate(
            ['key' => $key],
            ['value' => (string) max(0, $value)]
        );
    }
}
