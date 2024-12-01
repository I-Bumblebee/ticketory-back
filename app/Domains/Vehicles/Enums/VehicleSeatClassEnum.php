<?php

namespace App\Domains\Vehicles\Enums;

enum VehicleSeatClassEnum: string
{
    case EconomyClass = 'economy';
    case PremiumEconomyClass = 'premium_economy';
    case BusinessClass = 'business';
    case FirstClass = 'first_class';
    case VipClass = 'vip';
    case SleeperClass = 'sleeper';
}
