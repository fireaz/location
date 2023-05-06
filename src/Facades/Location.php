<?php

namespace FireAZ\Location\Facades;

use FireAZ\Location\LocationManager;
use Illuminate\Support\Facades\Facade;

/**
 * 
 * @method static mix GetCountry()
 * @method static mix GetProvince()
 * @method static mix GetDistrict()
 * @method static mix GetWard()
 * @method static mix GetJson()
 * 
 *
 * @see \FireAZ\Location\Facades\Location
 */
class Location extends Facade
{
    protected static function getFacadeAccessor()
    {
        return LocationManager::class;
    }
}
