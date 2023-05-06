<?php

use FireAZ\Location\Facades\Location;

if (!function_exists('location_json')) {
    function location_json()
    {
        return Location::GetJson();
    }
}
