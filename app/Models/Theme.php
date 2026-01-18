<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    use HasFactory;

    protected $fillable = [
        'logo',
        'app_name',
        'primary_color',
        'secondary_color',
    ];

    /**
     * Get the current theme settings or create default
     */
    public static function getCurrent()
    {
        return static::first() ?? static::create([
            'logo' => null,
            'app_name' => 'MyShop',
            'primary_color' => '#3b82f6',
            'secondary_color' => '#8b5cf6',
        ]);
    }
}
