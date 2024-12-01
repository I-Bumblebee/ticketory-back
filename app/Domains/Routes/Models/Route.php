<?php

namespace App\Domains\Routes\Models;

use App\Domains\Locations\Models\Location;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperRoute
 */
class Route extends Model
{
    protected $fillable = [
        'start_location_id',
        'end_location_id',
    ];

    public function startLocation(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'start_location_id');
    }

    public function endLocation(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'end_location_id');
    }
}
