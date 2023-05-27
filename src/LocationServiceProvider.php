<?php

namespace FireAZ\Location;

use Illuminate\Support\ServiceProvider;
use FireAZ\LaravelPackage\ServicePackage;
use FireAZ\Location\Models\Area;
use FireAZ\Location\Models\Country;
use FireAZ\Location\Models\District;
use FireAZ\Location\Models\Province;
use FireAZ\Location\Models\Ward;
use FireAZ\Location\Repositories\Caches\AreaCacheDecorator;
use FireAZ\Location\Repositories\Caches\CountryCacheDecorator;
use FireAZ\Location\Repositories\Caches\DistrictCacheDecorator;
use FireAZ\Location\Repositories\Caches\ProvinceCacheDecorator;
use FireAZ\Location\Repositories\Caches\WardCacheDecorator;
use FireAZ\Location\Repositories\Eloquent\AreaRepositories;
use FireAZ\Location\Repositories\Eloquent\CountryRepositories;
use FireAZ\Location\Repositories\Eloquent\DistrictRepositories;
use FireAZ\Location\Repositories\Eloquent\ProvinceRepositories;
use FireAZ\Location\Repositories\Eloquent\WardRepositories;
use FireAZ\Location\Repositories\Interfaces\AreaInterface;
use FireAZ\Location\Repositories\Interfaces\CountryInterface;
use FireAZ\Location\Repositories\Interfaces\DistrictInterface;
use FireAZ\Location\Repositories\Interfaces\ProvinceInterface;
use FireAZ\Location\Repositories\Interfaces\WardInterface;
use FireAZ\Platform\Traits\WithServiceProvider;

class LocationServiceProvider extends ServiceProvider
{
    use WithServiceProvider;

    public function configurePackage(ServicePackage $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         */
        $package
            ->name('location')
            ->hasConfigFile()
            ->hasViews()
            ->hasHelpers()
            ->hasAssets()
            ->hasTranslations()
            ->runsMigrations()
            ->RouteWeb()
            ->runsSeeds();
    }
    public function packageRegistered()
    {

        $this->app->bind(AreaInterface::class, function () {
            return new AreaCacheDecorator(new AreaRepositories(new Area()));
        });
        $this->app->bind(CountryInterface::class, function () {
            return new CountryCacheDecorator(new CountryRepositories(new Country()));
        });
        $this->app->bind(DistrictInterface::class, function () {
            return new DistrictCacheDecorator(new DistrictRepositories(new District()));
        });
        $this->app->bind(ProvinceInterface::class, function () {
            return new ProvinceCacheDecorator(new ProvinceRepositories(new Province()));
        });
        $this->app->bind(WardInterface::class, function () {
            return new WardCacheDecorator(new WardRepositories(new Ward()));
        });
        add_filter(PLATFORM_CONFIG_JS, function ($params) {
            $params['locations'] = location_json();
            return $params;
        });
    }
}
