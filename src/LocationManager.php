<?php

namespace FireAZ\Location;

use FireAZ\Location\Repositories\Interfaces\CountryInterface;
use FireAZ\Location\Repositories\Interfaces\DistrictInterface;
use FireAZ\Location\Repositories\Interfaces\ProvinceInterface;
use FireAZ\Location\Repositories\Interfaces\WardInterface;
use Illuminate\Support\Facades\Cache;

class LocationManager
{
    public function __construct(
        private CountryInterface $countryInterface,
        private ProvinceInterface $provinceInterface,
        private DistrictInterface $districtInterface,
        private WardInterface $wardInterface,
    ) {
    }
    public function GetCountry()
    {
        return $this->countryInterface->select(['parent_code', 'code', 'name_with_type'])->get();
    }
    public function GetProvince()
    {
        return $this->provinceInterface->select(['parent_code', 'code', 'name_with_type'])->get();
    }
    public function GetDistrict()
    {
        return $this->districtInterface->select(['parent_code', 'code', 'name_with_type'])->get();
    }

    public function GetWard()
    {
        return $this->wardInterface->select(['parent_code', 'code', 'name_with_type'])->get();
    }
    public function GetJson()
    {
        return Cache::rememberForever('location_json', function () {
            return [
                'country' => $this->GetCountry(),
                'province' => $this->GetProvince(),
                'district' => $this->GetDistrict(),
                'ward' => $this->GetWard()
            ];
        });
    }
}
