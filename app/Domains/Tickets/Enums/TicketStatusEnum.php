<?php

namespace App\Domains\Tickets\Enums;

enum TicketStatusEnum: string
{
    case Available = 'available';
    case Booked = 'booked';
    case Cancelled = 'cancelled';
    case Used = 'used';
}
