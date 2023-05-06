<?php

namespace FireAZ\Location\Commands;

use FireAZ\Location\Repositories\Interfaces\CountryInterface;
use FireAZ\Location\Repositories\Interfaces\DistrictInterface;
use FireAZ\Location\Repositories\Interfaces\ProvinceInterface;
use FireAZ\Location\Repositories\Interfaces\WardInterface;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Illuminate\Support\Str;

class UpdateLocation extends Command
{
    protected $name = 'local:update';

    public function __construct(
        private CountryInterface $countryInterface,
        private ProvinceInterface $provinceInterface,
        private DistrictInterface $districtInterface,
        private WardInterface $wardInterface,
    ) {
        parent::__construct();
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['type', 't', InputOption::VALUE_OPTIONAL, 'Recreate existing symbolic targets.', 'module'],
        ];
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        ($this->countryInterface->getModel())->query()->truncate();
        ($this->provinceInterface->getModel())->query()->truncate();
        ($this->districtInterface->getModel())->query()->truncate();
        ($this->wardInterface->getModel())->query()->truncate();
        $data = json_decode(file_get_contents(__DIR__ . '/vn.json'), true, 512, JSON_OBJECT_AS_ARRAY);
        $countryVN = $this->countryInterface->create([
            'parent_id' => null,
            'code' => '84',
            'parent_code' => null,
            'name' => 'Viêt Nam',
            'type' => 'Quốc gia',
            'slug' => 'viet-nam',
            'slug_path' => 'viet-nam',
            'slug_path_with_type' => 'quoc-gia-quoc-gia',
            'name_with_type' => 'Quốc gia việt nam',
            'path' => 'việt nam',
            'path_with_type' => 'Quốc Gia Việt Nam',
        ]);

        foreach ($data as $key => $value) {
            $province = $this->provinceInterface->create([
                'parent_id' => $countryVN->id,
                'code' => $value['code'],
                'parent_code' => $countryVN->code,
                'name' => $value['name'],
                'type' => $value['type'],
                'slug' => $value['slug'],
                'slug_path' => isset($value['path']) ? Str::slug($value['path']) : null,
                'slug_path_with_type' => isset($value['path_with_type']) ? Str::slug($value['path_with_type']) : null,
                'name_with_type' => $value['name_with_type'],
                'path' => isset($value['path']) ? $value['path'] : null,
                'path_with_type' => isset($value['path_with_type']) ? $value['path_with_type'] : null,
            ]);
            foreach ($value['quan-huyen'] as $key1 => $value1) {
                $district = $this->districtInterface->create([
                    'parent_id' => $province->id,
                    'code' => $value1['code'],
                    'parent_code' => $province->code,
                    'name' => $value1['name'],
                    'type' => $value1['type'],
                    'slug' => $value1['slug'],
                    'slug_path' => Str::slug($value1['path']),
                    'slug_path_with_type' => Str::slug($value1['path_with_type']),
                    'name_with_type' => $value1['name_with_type'],
                    'path' => $value1['path'],
                    'path_with_type' => $value1['path_with_type'],
                ]);
                foreach ($value1['xa-phuong'] as $key2 => $value2) {
                    $ward = $this->wardInterface->create([
                        'parent_id' => $district->id,
                        'code' => $value2['code'],
                        'parent_code' => $district->code,
                        'name' => $value2['name'],
                        'type' => $value2['type'],
                        'slug' => $value2['slug'],
                        'slug_path' => Str::slug($value2['path']),
                        'slug_path_with_type' => Str::slug($value2['path_with_type']),
                        'name_with_type' => $value2['name_with_type'],
                        'path' => $value2['path'],
                        'path_with_type' => $value2['path_with_type'],
                    ]);
                }
            }

            $this->info($key);
        }
        return 0;
    }
}
