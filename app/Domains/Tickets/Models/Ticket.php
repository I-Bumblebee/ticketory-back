<?php

namespace App\Domains\Tickets\Models;

use App\Domains\Tickets\Enums\TicketStatusEnum;
use App\Domains\Tickets\Observers\TicketObserver;
use App\Domains\Trips\Models\Trip;
use App\Domains\Users\Models\User;
use App\Domains\Vehicles\Enums\VehicleSeatClassEnum;
use App\Domains\Vehicles\Models\Seat;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperTicket
 */
#[ObservedBy([TicketObserver::class])]
class Ticket extends Model
{
    protected $fillable = [
        'trip_id',
        'seat_id',
        'user_id',
        'price',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'status' => TicketStatusEnum::class,
        ];
    }

    public function book(User $user): void
    {
        $this->update([
            'user_id' => $user->id,
            'status' => TicketStatusEnum::Booked,
        ]);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function seat(): BelongsTo
    {
        return $this->belongsTo(Seat::class);
    }

    public function trip(): BelongsTo
    {
        return $this->belongsTo(Trip::class);
    }

    public function scopeBooked(Builder $query): Builder
    {
        return $query->whereStatus(TicketStatusEnum::Booked);
    }

    public function scopeAvailable(Builder $query): Builder
    {
        return $query->whereStatus(TicketStatusEnum::Available);
    }

    public function scopeSeatClass(Builder $query, VehicleSeatClassEnum $class): Builder
    {
        return $query->whereHas('seat', function (Builder $seatQuery) use ($class) {
            $seatQuery->where('class', $class);
        });
    }
}
