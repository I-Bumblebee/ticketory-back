<?php

namespace App\Domains\Tickets\Actions;

use App\Domains\Tickets\Resources\TicketResource;
use App\Domains\Users\Models\User;
use App\Domains\Users\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Lorisleiva\Actions\Concerns\AsAction;

class GetTicketsAction
{
    use AsAction;

    public function authorize(): bool
    {
        return Auth::user()->is_admin;
    }

    public function jsonResponse(Collection $userTicketsMap): JsonResponse
    {
        return response()->json([
            'data' => $userTicketsMap,
        ]);
    }

    public function handle(): Collection
    {
        $users = User::with([
            'tickets.trip.route.startLocation',
            'tickets.trip.route.endLocation',
            'tickets.trip.vehicle',
            'tickets.seat',
        ])->get();

        return $users->map(function ($user) {
            return [
                'user' => UserResource::make($user),
                'tickets' => TicketResource::collection($user->tickets),
            ];
        });
    }
}
