<?php

namespace App\Domains\Locations\Models;

use App\Domains\Routes\Models\Route;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin IdeHelperLocation
 */
class Location extends Model
{
    protected $fillable = [
        'name',
        'city',
        'state',
        'country',
        'latitude',
        'longitude',
    ];

    /**
     * Get all routes that start from the current location.
     */
    public function routes(): HasMany
    {
        return $this->hasMany(Route::class, 'start_location_id');
    }
}
